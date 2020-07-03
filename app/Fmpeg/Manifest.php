<?php

namespace Fmpeg;


use Fmpeg\Base\FFMPEGProcess;


class Manifest extends FFMPEGProcess
{

    function generate()
    {
        $media = $this->getMedia();

        $this->generateMasterManifest($media);
    }


    private function generateMasterManifest($media)
    {


        $directories = scandir($media->getMasterDir()); // scan current directory if has sub dirs

        $manifest = '#EXTM3U' . "\r\n" . "\r\n";


        foreach ($directories as $language_dir) {
            $code = "";


            if (ctype_alpha($language_dir)) {

                switch ($language_dir) {
                    case 'English':
                        $code = "eng";
                        break;
                    case 'French':
                        $code = "fr";
                        break;
                    case 'Dutch':
                        $code = "nl";
                        break;
                    case 'Spanish':
                        $code = "es";
                        break;
                    case 'German':
                        $code = "de";
                        break;
                    case 'Swahili':
                        $code = "sw";
                        break;
                }


                $files = glob($media->getMasterDir() . $language_dir . "/*");


                if ($files) {
                    $file_count = count($files);
                    if ($file_count > 0)
                        $manifest .= '#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID="audio",LANGUAGE="' . $code . '",NAME="' . $language_dir . '", AUTOSELECT=YES, DEFAULT=NO,URI="audio/' . $language_dir . '/index.m3u8"' . "\r\n";
                }
            } // char is string
        }

        $manifest .= '#EXT-X-STREAM-INF:BANDWIDTH=240000,RESOLUTION=416x234,CODECS="avc1.42e00a,mp4a.40.2", AUDIO="audio" ' . "\r\n";
        $manifest .= 'chunks/default/index.m3u8' . "\r\n" . "\r\n";

        $manifest .= '#EXT-X-STREAM-INF:BANDWIDTH=915905,RESOLUTION=960x540,CODECS="avc1.42e00a,mp4a.40.2", AUDIO="audio" ' . "\r\n";
        $manifest .= 'chunks/hifi/index.m3u8' . "\r\n";

        return $this->writeManifest($media, $manifest);
    }


    private function writeManifest($media, $manifest)
    {
        if (is_dir($media->getOutputFileDir()))
            if (file_put_contents($media->getOutputFileDir() . "/" . "manifest.m3u", $manifest))
                return true;
        return false;
    }


}