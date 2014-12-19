<?php

/**
 * Simple class to manage files from $_FILES
 * 
 * @author Louis Hatier
 */
class UploadedFile 
{
    const SIZE_KO = 1;
    const SIZE_MO = 2;

    public $name;
    public $type;
    public $tmp_name;
    public $error;
    public $size;

    /**
     * Need the 5 usual values
     * 
     * @param string $name
     * @param string $type
     * @param string $tmp_name
     * @param integer $error
     * @param integer $size
     */
    public function __construct($name, $type, $tmp_name, $error, $size)
    {
        $this->name = $name;
        $this->type = $type;
        $this->tmp_name = $tmp_name;
        $this->error = $error;
        $this->size = $size;
    }

    /**
     * Return the size (Ko or Mo)
     * 
     * @param integer $code
     * @return string
     */
    public function getSize($code)
    {
        switch ($code) {
            case self::SIZE_KO:
                return number_format($this->size / 1024, 2, '.', ' ') . ' Ko';
            case self::SIZE_MO:
                return number_format($this->size / 1024 / 1024, 2, '.', ' ') . ' Mo';
            default:
                throw new InvalidArgumentException('Wrong size mode: ' . $code);
        }
    }

    /**
     * Return if an error occurred
     * 
     * @return bool
     */
    public function hasError()
    {
        return $this->error === UPLOAD_ERR_OK;
    }

    /**
     * Return the error message
     * 
     * @return string
     */
    public function getErrorMessage()
    {
        switch ($this->error) {
            case UPLOAD_ERR_OK:
                return 'There is no error, the file uploaded with success';
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'File upload stopped by extension';
            default:
                return 'Unknown upload error';
        }
    }

    /**
     * Move the file to the precised location
     *
     * @param string $location
     * @return bool
     * @throws Exception
     */
    public function move($location)
    {
        if (is_writable($location)) {
            return move_uploaded_file($this->tmp_name, $location . $this->name);
        } else {
            throw new Exception('Can\'t write in this folder: ' . $location);
        }
    }

    /**
     * Return the file's extension
     * 
     * @return string
     */
    public function getExtension()
    {
        $extension = explode('.', $this->name);
        return strtolower(end($extension));
    }

    /**
     * Return the file's type
     * 
     * @return string
     */
    public function getType()
    {
        if (class_exists('finfo', false) === true) {
            $finfo = new finfo(FILEINFO_MIME);
            return $finfo->file($this->tmp_name);
        } else {
            return mime_content_type($this->tmp_name);
        }
    }
}
