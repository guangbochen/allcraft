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
                //retertive the form order_number
                $post = $request->post();
                $order_number = $post['order_number'];

                //create dir for each order if does not exist
                FilesImpl::createDir($order_number);

                // Handle file uploads
                $files = UploadedFiles::handle(array(
                    /* 'root_path' => $this->container->getParameter(Configuration::PARAMETER_UPLOAD_ROOT_DIR), */
                    'root_path' => $this->root_files . $order_number . '/',
                    'param_name' => 'files',
                    'order_number' => $order_number
                ));
                // Return successfull response
                response_json_data($files);
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
     * @Route("/files", name="file_list")
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
     * List all uploaded files.
     *
     * @Route("/files/:id", name="file_list")
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
     * Set allow origin header in response.
     *
     * @param  Response $response
     * @return Response
     */
    private function setAllowOriginHeader (Response $response)
    {
        // Set the cross domain header
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * Create a Finder instance to fetch the upload directory.
     *
     * @return Finder
     */
    private function getFinder ()
    {
        /* $root = $this->container->getParameter(Configuration::PARAMETER_UPLOAD_ROOT_DIR); */
        $root = 'documents/';
        /* $finder = new Finder(); */
        /* $finder->in($root); */
        /* if($dir = opendir($root)) $finder = readdir($dir); */
        $finder = scandir($root);

        return $finder;
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

