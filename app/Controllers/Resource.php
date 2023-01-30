<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Resource extends BaseController
{
    public function index($fileName)
    {
        $filePath = WRITEPATH . 'uploads/' . $fileName;
        if(file_exists($filePath)){
            $mime = mime_content_type($filePath);
            header('Content-Length: ' . filesize($filePath));
            header("Content-Type: $mime");
            header('Content-Disposition: inline; filename="' . $fileName . '";');
            readfile($filePath);
            exit();
        } else {
            echo "File Not Exists!!";
        }
        
    }
}
?>