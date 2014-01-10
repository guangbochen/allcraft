<?php
require_once 'models/Files.php';
/**
 * This class is a service that will be used to handle file
 * uploads of backbone upload manager.
 *
 * @see https://github.com/sroze/backbone-upload-manager
 *
 */
class UploadedFiles
{
    /**
     * Handle an upload request.
     *
     * @throws Exception
     * @param  array $options
     * @return array
     */
    public static function handle (array $options)
    {
       UploadedFiles::_checkOptions($options);

        // Get the upload value
        $upload = isset($_FILES[$options['param_name']]) ? $_FILES[$options['param_name']] : null;
        if ($upload == null) {
            throw new Exception(sprintf('No "%s" file parameter found', $options['param_name']));
        }
        // If it's not an array, passed value isn't correct
        if (!is_array($upload['tmp_name'])) {
            throw new Exception("Parameter value isn't an array");
        }

        // For each file, handle it
        $files = array();
        foreach ($upload['tmp_name'] as $index => $value) {
            $file = array(
                'tmp_name' => $upload['tmp_name'][$index],
                'name' => $upload['name'][$index],
                'size' => $upload['size'][$index],
                'type' => $upload['type'][$index],
                'error' => $upload['error'][$index],
                'index' => $index
            );

            if ($file['error'] != UPLOAD_ERR_OK) {
                switch ((int) $file['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                        throw new Exception("File size exceed 'upload_max_filesize' ini parameter");
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new Exception("File size exceed 'MAX_FILE_SIZE' form parameter");
                    case UPLOAD_ERR_CANT_WRITE:
                        throw new Exception("Can write file");
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new Exception(sprintf("Unknown error (%d)", $file['error']));
                }
            } else {
                UploadedFiles::handleFile($file, $options);
                //save file info into db
                Files::addFile($file, $options);
            }
        }

        return $files;
    }

    /**
     * Handle a unique file upload.
     *
     * Move the uploaded file in the root_path folder.
     *
     * @throws Exception\SRozeIO\UploadHandlerBundle\Exception\
     * @param  array $file
     * @param  array $options
     * @return array
     */
    public static function handleFile (array $file, array $options)
    {
        UploadedFiles::_checkOptions($options);

        $file_path = $options['root_path'].$file['name'];
        $append_file = is_file($file_path) && $file['size'] > filesize($file_path);

        clearstatcache();
        if ($file['tmp_name'] && is_uploaded_file($file['tmp_name'])) {
            // multipart/formdata uploads (POST method uploads)
            if ($append_file) {
                file_put_contents(
                    $file_path,
                    fopen($file['tmp_name'], 'r'),
                    FILE_APPEND
                );
                $file['method'] = 'append';
            } else {
                move_uploaded_file($file['tmp_name'], $file_path);
                $file['method'] = 'move';
            }
        } else {
            // Non-multipart uploads (PUT method support)
            file_put_contents(
                $file_path,
                fopen('php://input', 'r'),
                $append_file ? FILE_APPEND : 0
            );
            $file['method'] = 'put'.($append_file ? ' append' : '');
        }

        // Set file path in array
        $file['path'] = $file_path;

        return $file;
    }

    /**
     * Check that needed options are here.
     *
     * @throws Exception\SRozeIO\UploadHandlerBundle\Exception\
     * @param  array $options
     */
    private static function _checkOptions (array $options)
    {
        if (!array_key_exists('root_path', $options)) {
            throw new Exception("The 'root_path' option must be set");
        } elseif (!array_key_exists('param_name', $options)) {
            throw new Exception("The 'param_name' option must be set");
        }
    }
}
