<?php


spl_autoload_register(function ($class) {
    include $class . ".php";
});

//include_once ("app/Fmpeg/Base/FFMPEGProcess.php");
//include_once ("app/model/Media.php");