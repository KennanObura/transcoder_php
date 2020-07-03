<?php


namespace Fmpeg;


use Fmpeg\Base\FFMPEGProcess;


class Thumbnail extends FFMPEGProcess
{


    public function generate()
    {
        $media = $this->getMedia();



        $this->createDirectory($media->getOutputFileDir());



        $sprinted_thumbnail_cmd = sprintf(
            '%sffmpeg -i %s -vf fps=1 -s 192x108  %s',
            $this->getFfmpegPath(),
            $media->getFileDir(),
            $media->getOutputFileDir() . '/pic%d.jpg'
        );




        $high_dim_thumbnail_cmd = sprintf(
            '%sffmpeg -i %s -vframes 1 -ss 00:00:20.000 -s 1280x720  %s',
            $this->getFfmpegPath(),
            $media->getFileDir(),
            $media->getOutputFileDir() . '/thumbnail_main.jpg'
        );



//        $high_dim_thumbnail_cmd = sprintf(
//           'ffmpeg -i '. $media->getFileDir(). ' -ss 00:00:01.000 -vframes 1 '. $media->getOutputFileDir() . '/thumbnail_main.jpg -report'
//        );




         self::isGenerated($sprinted_thumbnail_cmd, 0);
         self::isGenerated($high_dim_thumbnail_cmd, 1);
    }




    private static function isGenerated($command, $i)
    {
        $type = array("SPRINT_THUMBNAIL", "HIGHDEF_THUMBNAIL");
        return self::generateThumbnails($command, $type[$i]);
    }





    private static function generateThumbnails($cmd, $type)
    {
        $errors = self::$ERRORS;



        if (!isset($cmd) || empty($cmd)) {
            array_push($errors, "Command of type " . $type . " is empty or  ot set");
            return false;
        }



        $output = array();


        if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN'))
            $cmd = str_replace('/', DIRECTORY_SEPARATOR, $cmd);
        else
            $cmd = str_replace('\\', DIRECTORY_SEPARATOR, $cmd);

        exec($cmd, $output, $retval);



        if ($retval) {
            array_push($errors, "Error in generating " . $type);
            return false;
        }
        return true;
    }
}