<?php
namespace app\model;

//Prevent access to this page
defined("ROOTPATH") OR exit("Access Denied");

class Download
{

    public function download($folder)
    {
        $filename = isset($_GET["file"]) ? $_GET["file"] : "";
        $path = $folder.DIRECTORY_SEPARATOR.$filename;

        if(file_exists($path)) {
            $mime_type = mime_content_type($filename);
            header("Content-type: ".$mime_type);
            header("Content-Disposition: attachment; filename=$filename");

            readfile("file/$filename");
        } else {
            echo "file not found";
        }
    }

}