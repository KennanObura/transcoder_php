<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use app\model\Media;
use Fmpeg\Manifest;
use Fmpeg\Split;
use Fmpeg\SprintImage;
use Fmpeg\Stream;
use Fmpeg\Thumbnail;




include_once("app/app_autoload.php");


//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



/**
 * configure Media object
 */

$ROOT_DIR = "uploads/p010444_agriculture/";

$thumbnailObject = new Media();
$thumbnailObject->setMasterDir($ROOT_DIR);
$thumbnailObject->setFileDir($ROOT_DIR."p010444_agriculture_1.mp4");
$thumbnailObject->setOutputFileDir($ROOT_DIR."thumbnails");
$thumbnailObject->setFileName("pic");



$thumbnailGenerator = new Thumbnail($thumbnailObject);
$thumbnailGenerator->generate();



$thumbnailObject->setFileDir($ROOT_DIR."thumbnails");
$thumbnailObject->setOutputFileDir($ROOT_DIR."thumbnails/sprint");
$sprintImageGenerator = new SprintImage($thumbnailObject);
$sprintImageGenerator->generate();




$hslObject = new Media();
$hslObject->setMasterDir($ROOT_DIR);
$hslObject->setFileDir($ROOT_DIR."p010444_agriculture_1.mp4");
$hslObject->setOutputFileDir($ROOT_DIR."hsl");

$hslStreamGenerator = new Stream($hslObject);
$hslStreamGenerator->generate();

/**
 * DO NOT PUT INTO OWN THREAD
 *      :: Waits for hls
 * Generate manifest Should run sequentially after hsl generator.
 *
 */

$manifestGenerator = new Manifest($hslObject);
$manifestGenerator->generate();


//$media->setOutputFileDir();
//$mediaSplitGenerator = new Split($media);
//$mediaSplitGenerator->setStart("00:02");
//$mediaSplitGenerator->setEnd("00:06");
//$mediaSplitGenerator->generate();

