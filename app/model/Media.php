<?php

namespace app\model;

class Media
{

    private $master_dir;
    private $file_dir; // dir to existing mp3 or mp4
    private $output_file_dir; //mp3 or mp4
    private $file_name;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getFileDir()
    {
        return $this->file_dir;
    }

    /**
     * @param mixed $file_dir
     */
    public function setFileDir($file_dir)
    {
        $this->file_dir = $file_dir;
    }

    /**
     * @return mixed
     */
    public function getOutputFileDir()
    {
        return $this->output_file_dir;
    }

    /**
     * @param mixed $output_file_dir
     */
    public function setOutputFileDir($output_file_dir)
    {
        $this->output_file_dir = $output_file_dir;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @param mixed $file_name
     */
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * @return mixed
     */
    public function getMasterDir()
    {
        return $this->master_dir;
    }

    /**
     * @param mixed $master_dir
     */
    public function setMasterDir($master_dir)
    {
        $this->master_dir = $master_dir;
    }


}