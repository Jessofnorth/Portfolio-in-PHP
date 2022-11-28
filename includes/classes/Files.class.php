<?php
/* @author Jessica Ejelöv - jeej2100@student.miun.se 
Project for DT093G at Mid Sweden University
Class based on code from: Mattias Dahlgren, 2021 - Mittuniversitetet - Email: mattias.dahlgren@miun.se
Git: https://github.com/matdah/upload-avif-webp.git
*/

// class for uploading converting images and creating thumbnails of images. 
// JPEG, WEBP formats available.
class Files
{
    // propertys
    private $directorypath;
    private $directorypathpdf;
    private $width_thumbnail;
    private $height_thumbnail;
    private $jpeg_quality;
    private $webp_quality;
 


    public function __construct(
        // set values on propertys
        $directorypath = 'images/',
        $directorypathpdf = 'pdf/',
        $width_thumbnail = 500,
        $height_thumbnail = 500,
        $jpeg_quality = 75,
        $webp_quality = 60
    ) {
        $this->directorypath = $directorypath;
        $this->directorypathpdf = $directorypathpdf;
        $this->width_thumbnail = $width_thumbnail;
        $this->height_thumbnail = $height_thumbnail;
        $this->jpeg_quality = $jpeg_quality;
        $this->webp_quality = $webp_quality;

    }

    // check image is the right type and size
    public function checkImage($image): bool
    {
        $type = $image['type'];
        if ($type != "image/jpeg") {
            return false;
        } else {
            if ($image['size'] > 2000000) {
                return false;
            } else {
                return true;
            }
        }
    }


    // save image to catalouge, set unique name and convert format and sizes. 
    public function saveImage(array $image) : string
    {
        // if image is uploaded store, if not set standard image
        if ($image['name'] != "") {
            // check image format and size
            if (!$this->checkImage($image)) return false;
            // create random name for the file
            $filename = $this->randomFilename();
            $filename = $filename . ".jpg";
            // move the file to the cataloge
            move_uploaded_file($image["tmp_name"], $this->directorypath . $filename);

            // save original and thumbnail variables
            $savedfile = $filename;
            $thumbnail = "thumb_" . $filename;
            $width_thumbnail = $this->width_thumbnail;
            $height_thumbnail = $this->height_thumbnail;

            // get origina image size and calculate ratio and set dimentions for thumbnail
            list($width_thumbnail_orig, $height_thumbnail_orig) = getimagesize($this->directorypath . $savedfile);
            $ratio_orig = $width_thumbnail_orig / $height_thumbnail_orig;
            // calculate for portrait or landscape orientation of image
            if ($width_thumbnail / $height_thumbnail > $ratio_orig) {
                $width_thumbnail = $height_thumbnail * $ratio_orig;
                $height_thumbnail = $width_thumbnail / $ratio_orig;
            } else {
                $height_thumbnail = $width_thumbnail / $ratio_orig;
                $width_thumbnail = $height_thumbnail * $ratio_orig;
            }

            // convert to ints
            $width_thumbnail = intval($width_thumbnail);
            $height_thumbnail = intval($height_thumbnail);

            // create the thumbnail
            $image_p = imagecreatetruecolor($width_thumbnail, $height_thumbnail);
            $image = imagecreatefromjpeg($this->directorypath . $savedfile);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_thumbnail, $height_thumbnail, $width_thumbnail_orig, $height_thumbnail_orig);
            imagejpeg($image_p, $this->directorypath . $thumbnail, $this->jpeg_quality);

            // create a WEBP version of image and a thumbnail - if supported
            if (function_exists("imagewebp")) {
                $image_webp = imagecreatefromjpeg($this->directorypath . $savedfile);
                $filename_webp = pathinfo($savedfile)['filename'] . '.webp';
                imagewebp($image_webp, $this->directorypath . $filename_webp, $this->webp_quality);
            }
            if (function_exists("imagewebp")) {
                $filename_webp = pathinfo($thumbnail)['filename'] . '.webp';
                imagewebp($image_p, $this->directorypath . $filename_webp, $this->webp_quality);
            }
    
            // return only file nmae and not ".jpeg"
            return substr($filename, 0, 10);
        } else {
            // return filename for standard picture if no picture is uploaded
            return $filename = "standard";
        }
    }
    // create random filename and check agains cataloge for unique names
    public function randomFilename(): string
    {
        do {
            $random_filename = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10);
        } while (!$this->filenameIsUnique(($random_filename)));
        return $random_filename;
    }

    // check for random filename in img catalog 
    public function filenameIsUnique($filename): bool
    {
        if (file_exists($this->directorypath . $filename . ".jpg")) {
            return false;
        } else {
            if (file_exists($this->directorypathpdf . $filename . ".pdf")) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function deleteImage(string $image_name){
        $image_name = $image_name;
        $delete = glob($this->directorypath . $image_name . ".jpg");
        $thumb = glob($this->directorypath . "thumb_" . $image_name . ".jpg");
        $deletewebp = glob($this->directorypath . $image_name . ".webp");
        $thumbwebp = glob($this->directorypath . "thumb_" . $image_name . ".webp");
        foreach($delete as $delete){
            if(is_file($delete)){
                unlink($delete);
            }
        }
        foreach($thumb as $thumb){
            if(is_file($thumb)){
                unlink($thumb);
            }
        }
        foreach($deletewebp as $deletewebp){
            if(is_file($deletewebp)){
                unlink($deletewebp);
            }
        }
        foreach($thumbwebp as $thumbwebp){
            if(is_file($thumbwebp)){
                unlink($thumbwebp);
            }
        }
    }


    // PDF
    // save PDF
    public function savePDF(array $pdf) : string
    {
        // if image is uploaded store, if not set standard image
        if ($pdf['name'] != "") {

            // check image format and size
            if (!$this->checkPDF($pdf)) return false;
            // create random name for the file
            $filenamepdf = $this->randomFilename();
            $filenamepdf = $filenamepdf . ".pdf";
            // move the file to the cataloge
            move_uploaded_file($pdf["tmp_name"], $this->directorypathpdf . $filenamepdf);

            // return only file nmae and not ".jpeg"
            return $filenamepdf;
        } else {
            // return filename for standard picture if no picture is uploaded
            return $filenamepdf = "null";
        }
    }
     // check pdf is the right type and size
     public function checkPDF($pdf): bool
     {
         $type = $pdf['type'];
         if ($type != "application/pdf") {
             return false;
         } else {
             if ($pdf['size'] > 2000000) {
                 return false;
             } else {
                 return true;
             }
         }
     }

    //  delete pdf
    public function deletePDF(string $pdf){
        $pdf = $pdf;
        $delete = glob($this->directorypathpdf . $pdf);
        foreach($delete as $delete){
            if(is_file($delete)){
                unlink($delete);
            }
        }
    }

}
