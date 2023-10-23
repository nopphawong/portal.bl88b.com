<?php

namespace App\Libraries;

use Exception;

class Base64fileUploads
{

    function is_base64($s)
    {
        try {
            $s = explode("base64,", $s)[1];
            // Check if there are valid base64 characters
            // if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;
            // Decode the string in strict mode and check the results
            $decoded = base64_decode($s, true);
            if (false === $decoded) return false;
            // Encode the string again
            if (base64_encode($decoded) != $s) return false;
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function du_uploads($base64string, $path, $name = null)
    {
        if ($this->is_base64($base64string) == true) {
            $this->check_size($base64string);
            $this->check_dir($path);
            $this->check_file_type($base64string);

            /*=================uploads=================*/
            list($type, $base64string)  = explode(';', $base64string);
            list(, $extension)          = explode('/', $type);
            list(, $base64string)       = explode(',', $base64string);
            if ($name) $fileName         = $name . '.' . $extension;
            else $fileName              = uniqid() . date('Y_m_d') . '.' . $extension;
            $base64string               = base64_decode($base64string);
            $filePath = "{$path}/{$fileName}";
            file_put_contents($filePath, $base64string);
            return (object) array('status' => true, 'message' => 'successfully upload !', 'file_name' => $fileName, 'file_path' => $filePath);
        } else {
            print_r(json_encode(array('status' => false, 'message' => 'This Base64 String not allowed !')));
            exit;
        }
    }

    public function check_size($base64string)
    {
        $file_size = 50000;
        $size = @getimagesize($base64string);

        if ($size['bits'] >= $file_size) {
            print_r(json_encode(array('status' => false, 'message' => 'file size not allowed !')));
            exit;
        }
        return true;
    }

    public function check_dir($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            return true;
        }
        return true;
    }

    public function check_file_type($base64string)
    {
        $mime_type = @mime_content_type($base64string);
        $allowed_file_types = ['image/png', 'image/jpeg', 'application/pdf'];
        if (!in_array($mime_type, $allowed_file_types)) {
            // File type is NOT allowed
            // print_r(json_encode(array('status' => false, 'message' => 'File type is NOT allowed !')));
            // exit;
        }
        return true;
    }
}
