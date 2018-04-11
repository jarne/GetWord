<?php
/**
 * Created by PhpStorm.
 * User: jarne
 * Date: 13.11.16
 * Time: 09:39
 */

require "vendor/autoload.php";

use jarne\getword\GetWord;

$getWord = new GetWord();

echo $getWord->process($_SERVER);
