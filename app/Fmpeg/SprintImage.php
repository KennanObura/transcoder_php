<?php

namespace Fmpeg;


use Fmpeg\Base\FFMPEGProcess;

class SprintImage extends FFMPEGProcess
{
    const TILE_HEIGHT = 0;
    const INTERVAL = 0;


    function generate()
    {
        $media = $this->getMedia();
        $this->createDirectory($media->getFileDir() . "/sprint");
        $this->putDirectoryFileToMap($media);
    }


    private function putDirectoryFileToMap($media)
    {

        if (!is_dir($media->getFileDir()))
            die();

        $directory = $media->getFileDir();

        $handle = opendir($directory);

        $smallThumbsModulusOne = array();

        $smallThumbsModulusOne[0] = $directory . '/pic1.jpg';


        while ($file = readdir($handle)) {

            if ($file !== '.' && $file !== '..' && $file != "thumbnail_main.jpg") {
                $thumbIndex = (int)filter_var($file, FILTER_SANITIZE_NUMBER_INT);
                $smallThumbsModulusOne[$thumbIndex] = $directory . "/" . $file;
            }
        }

        ksort($smallThumbsModulusOne);

        return $this->mergeThumbnailsIntoSprint($media, $smallThumbsModulusOne);
    }


    private function mergeThumbnailsIntoSprint($media, $bucket)
    {
        /**
         * configure dimention and create temp image with desired height and width.
         *      dim = width* size of the bucket , height of single item
         */
        list($width, $height) = array(192, 108);

        $temp_image = imagecreatetruecolor($width, $height * sizeof($bucket));
        $bgColor = imagecolorallocate($temp_image, 50, 40, 0);
        imagefill($temp_image, 0, 0, $bgColor);


        for ($i = 0; $i < sizeof($bucket); $i++) {
            if (isset($bucket[$i])) {

                list($destination_x, $destination_y) = self::indexToCoords($i, $height);

                $to_merge_image = imagecreatefromjpeg($bucket[$i]);
                imagecopy($temp_image, $to_merge_image, $destination_x, $destination_y, 0, 0, $width, $height);
                imagedestroy($to_merge_image);
            }
        }

        return $this->write($media, $temp_image);
    }


    private function write($media, $image)
    {
        imagepng($image, $media->getOutputFileDir() . '/sprite.jpg');
        return imagedestroy($image);
    }


    private static function indexToCoords($index, $height)
    {
        $y = ($height + 1) * ($index - 1);
        return array(0, $y);
    }


    private static function directoryFileCount($directory)
    {
        $files = glob($directory . "/*");
        if ($files)
            return count($files);
        return 0;
    }
}


