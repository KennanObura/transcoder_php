<?php


namespace Fmpeg;




use Fmpeg\Base\FFMPEGProcess;

class Split extends FFMPEGProcess
{
    private $start;
    private $end;

    function generate()
    {
        $command = "ffmpeg -t "
            . $this->end . " -i "
            . $this->getFileDir() . " -async 1 -ss "
            . $this->start
            . $this->getOutputFileDir();

        return exec($command);;

    }

    /**
     * @param string $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @param string $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }


}