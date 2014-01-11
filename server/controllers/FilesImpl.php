<?php
require_once 'helpers/json_helper.php';
require_once 'models/UploadedFiles.php';
require_once 'models/Files.php';
/* require_once 'models/UploadHandler.php'; */

/**
 * this class implement methods that is related to users
 */
class FilesImpl 
{
    private $app;
    private $root_files = 'documents/';

    /* constructor */
    public function __construct() 
    {
        $this->app = \Slim\Slim::getInstance();
    }

    /**
     * Upload a new file.
     *
     * @Route("/upload", name="file_upload")
     * @Method({"POST", "OPTIONS"})
     */
    public function uploadFiles() 
    {
        // Get request
        $request = $this->app->request();
        if ($request->isPost()) 
        {
            try 
            {
                //retertive the order_number from post form
                $post = $request->post();
                $order_number = $post['order_number'];

                //create dir for each order if does not exist
                FilesImpl::createDir($order_number);

                // Handle file uploads
                UploadedFiles::handle(array(
                    'root_path' => $this->root_files . $order_number . '/',
                    'param_name' => 'files',
                    'order_number' => $order_number
                ));

                // Return updated file list
                FilesImpl::getFilesBy($order_number);
            } 
            catch (Exception $e) {
                response_json_error($this->app, 500, $e->getMessage());
            }
        } 
        else {
            response_json_data(array('message' => 'OK'));
        }
    }

    /**
     * List all uploaded files.
     *
     * @Route("/files")
     * @Method("GET")
     */
    public function getAllFiles ()
    {
        try 
        {
            $files = Files::findAll();
            response_json_data($files);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /**
     * List a list of uploaded files for specific orders.
     *
     * @Route("/files/:id")
     * @Method("GET")
     */
    public function getFilesBy ($id)
    {
        try 
        {
            $files = Files::findFilesBy($id);
            response_json_data($files);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /**
     * Download an uploaded file.
     *
     * @Route("/file/{name}/download", name="file_download")
     * @Method("GET")
     * @param string $name
     */
    public function downloadAction ($name)
    {
        $root = $this->container->getParameter(Configuration::PARAMETER_UPLOAD_ROOT_DIR);
        $path = $root.$name;

        if (!file_exists($path)) {
            throw new NotFoundHttpException(sprintf('No file found with name "%s"', $name));
        }

        $stream = @fopen($path, 'r');

        // Create Response object
        $response = new StreamedResponse(function() use ($stream) {
            if ($stream == false) {
                throw new ServiceUnavailableHttpException(60, 'Unable to open file');
            }

            while (!feof($stream)) {
                $buffer = fread($stream, 2048);
                echo $buffer;
                flush();
            }

            fclose($stream);
        });

        // Set headers
        $response->headers->set('Content-disposition', 'attachment; filename='.$name);
        $response->headers->set('Content-length', filesize($path));
        $response->headers->set('Content-Type', mime_content_type($path));

        return $response;
    }

    /**
     * this function create an dir upon order number
     * @param Order number $order_number
     */
    private function createDir($order_number)
    {
        $dir = $this->root_files . $order_number . '/';
        if (!file_exists($dir) and !is_dir($dir)) 
        {
            mkdir($dir, 0777);
        }
    }

}

