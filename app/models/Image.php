<?php 

/**
 * Image manipulation class
 * Resizes Images
 */

namespace app\model;


defined("ROOTPATH") OR exit("Access Denied");

class Image
{
    public $errors = [];

    public function resize($filename, $max_size = 700):mixed 
    {
        if (file_exists($filename)) {
            
            //Check Image Type
            $type = mime_content_type($filename);

            //
            switch ($type) {
                case 'image/jpeg':
                    $originalImage = imagecreatefromjpeg($filename);
                    break;
                case "image/png":
                    $originalImage = imagecreatefrompng($filename);
                    break;
                case "image/gif": 
                    $originalImage = imagecreatefromgif($filename);
                    break;
                case "image/webp": 
                    $originalImage = imagecreatefromwebp($filename);
                    break;
                default:
                    $this->errors["not_img"] = "This $filename is not an image";
                    break;
            }

            //
            $original_width = imagesx($originalImage);
            $original_height = imagesy($originalImage);

            //try width first
            if ($original_width > $original_height) {
                $new_height = ($original_height / $original_width) * $max_size;
                $new_width = $original_width;
                if ($original_width > $max_size) {
                    $new_width = $max_size;     
                }
            } else {
                $new_width = ($original_width / $original_height) * $max_size;
                $new_height = $original_height;
                if ($original_height > $max_size) {
                    $new_height = $max_size;
                }
            }

            /**
             * Resize Image
             */
            // Create An Empty Image Object, so that we can work on it
            $newImage = imagecreatetruecolor($new_width, $new_height);

            //Work on the Transparent Image (PNG Images)
            if ($type == "image/png") {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
            }

            //Copy the source image into the empty image
            imagecopyresampled(
                $newImage, $originalImage,
                0,0,0,0,
                $new_width, $new_height,
                $original_width, $original_height
            );

            //Destroy original image
            imagedestroy($originalImage);

            //Save Image into the $filenamename based on it's type
            switch ($type) {
                case 'image/jpeg':
                    imagejpeg($newImage, $filename, 90);
                    break;
                case "image/png":
                    imagepng($newImage, $filename, 8);
                    break;
                case "image/gif": 
                    imagegif($newImage, $filename);
                    break;
                case "image/webp": 
                    imagewebp($newImage, $filename, 90);
                    break;
                default:
                    imagejpeg($newImage, $filename, 90);
                    break;
            }

            //Destroy the resized Image
            imagedestroy($newImage);

            //Return the $filename
            return $filename;

        }
    }

    public function crop($filename, $max_width = 700, $max_height = 700):mixed
    {
        /** check what kind of file type it is */
        $type = mime_content_type($filename);

        if (file_exists($filename)) {

            $imagefunc = "imagecreatefromjpeg";
            switch ($type) {
                case 'image/png':
                    $image = imagecreatefrompng($filename);
                    $imagefunc = "imagecreatefrompng";
                    break;
                case "image/gif":
                    $image = imagecreatefromgif($filename);
                    $imagefunc = "imagecreatefromgif";               
                    break;
                case "image/jpeg":
                    $image = imagecreatefromjpeg($filename);
                    $imagefunc = "imagecreatefromjpeg";
                    break;
                case "image/webp":
                    $image = imagecreatefromwebp($filename);
                    $imagefunc = "imagecreatefrowebp";
                    break;
                default:
                    return $filename;
                    break;
            }
            $src_W = imagesx($image);
            $src_H = imagesy($image);

            if ($max_width > $max_height) {
                if($src_W > $src_H) {
                    $max = $max_width;
                } else {
                    $max = ($src_H / $src_W) * $max_width;
                }
            } else {
                if($src_W > $src_H) {
                    $max = ($src_W / $src_H) * $max_height;
                } else {
                    $max = $max_height;   
                }
            }
            
            $this->resize($filename, $max);

            //you can pass a variable as a function
            $image = $imagefunc($filename);

            $src_W = imagesx($image);
            $src_H = imagesy($image);

            // $src_X = 0;
            // $src_Y = 0;

            // if ($max_width > $max_height) {
            //     if($src_W > $src_H) {
            //         $src_Y = round(($src_H - $max_height)/2);
            //     } else {
            //         $src_Y = round(($src_H - $max_height)/2);
            //     }
            // } else {
            //     if($src_W > $src_H) {
            //         $src_X = round(($src_W - $max_width)/2);
            //     } else {
            //         $src_X = round(($src_W - $max_width)/2);
            //     }
            // }
            
            $dst_image = imagecreatetruecolor($max_width, $max_height);

            if ($type == "image/png") {
                imagealphablending($dst_image, false);
                imagesavealpha($dst_image, true);
            }

            // imagecopyresampled($dst_image, $image, 0, 0, $src_X, $src_Y, $max_width, $max_height, $src_W, $src_H);
            imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $max_width, $max_height, $src_W, $src_H);

            imagedestroy($image);

            switch ($type) {
                case 'image/png':
                    imagepng($dst_image, $filename, 8);
                    break;
                case 'image/gif':
                    imagegif($dst_image, $filename);
                    break;
                case 'image/jpeg':
                    imagejpeg($dst_image, $filename, 90);
                    break;
                case 'image/webp':
                    imagewebp($dst_image, $filename, 90);
                    break;
                default:
                    imagejpeg($dst_image, $filename, 90);
                    break;
            }
            imagedestroy($dst_image);
             
        }

        return $filename;
    }
    public function getThumbnail($filename, $max_width = 700, $max_height = 700):mixed
    {
        if (file_exists($filename)) {
            $ext = explode(".",$filename);
            $ext = end($ext);

            $dest = preg_replace("/\.{$ext}$/", "_thumbnail.$ext", $filename);
            if(file_exists($dest)){
                return $dest;
            }
            copy($filename, $dest);
            
            $this->crop($dest, $max_width, $max_height);
            $filename = $dest;
        }
        return $filename; 
    }
}