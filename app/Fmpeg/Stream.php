<?php

namespace Fmpeg;


use Fmpeg\Base\FFMPEGProcess;

/**
 * Class Stream used to generate HSL containers from an existing mp3 or mp4;
 */
class Stream extends FFMPEGProcess
{


    function generate()
    {
        $media = $this->getMedia();

        $this->createDirectory($media->getOutputFileDir());
        $this->createDirectory($media->getOutputFileDir() . "/chunks");
        $this->createDirectory($media->getOutputFileDir() . "/chunks/hifi");
        $this->createDirectory($media->getOutputFileDir() . "/chunks/default");

        $this->generateHls($media);

    }


    private function generateHls($media){
        $commandDefault = sprintf(
            'ffmpeg  -i '
            . $media->getFileDir() . ' -profile:v baseline -level 3.0 -s 640x360 -start_number 0 -hls_time 10 -hls_list_size 0 -f hls '
            . $media->getOutputFileDir() . '/chunks/default/index.m3u8   -report'
        );

        $commandHighFi = sprintf(
            'ffmpeg  -i '
            . $media->getFileDir() . ' -profile:v baseline -level 3.0  -start_number 0 -hls_time 10 -hls_list_size 0 -f hls '
            . $media->getOutputFileDir() . '/chunks/hifi/index.m3u8 -report'
        );

        self::runCommand($commandDefault);
        self::runCommand($commandHighFi);
    }





    private static function runCommand($command)
    {


        $output = array();

        if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN'))
            $cmd = str_replace('/', DIRECTORY_SEPARATOR, $command);
        else
            $cmd = str_replace('\\', DIRECTORY_SEPARATOR, $command);

        exec($cmd, $output, $retval);

        if ($retval)
            return false;

        return true;

    }
}