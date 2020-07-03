<?php

namespace Fmpeg\Base;

abstract class FFMPEGProcess
{
    private $media;
    private $manifestFile;
    public static $ERRORS = array();

    private $ffmpeg_path = 'C:\\ffmpeg\\bin\\';


    public function __construct($media)
    {

        $this->media = $media;
        $this->manifestFile = "manifest.m3u";
    }

    public function run()
    {
        return $this->generate();

    }


    public function createDirectory($dir)
    {
        if (!is_dir($dir))
            if(mkdir($dir, 0700))

        return true;
    }


    abstract function generate();

    /**
     * @return Media object
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @return string
     */
    public function getFfmpegPath()
    {
        return $this->ffmpeg_path;
    }

}