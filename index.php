<?php
/**
 * GetWord | loader file
 */

require "vendor/autoload.php";

use jarne\getword\GetWord;

$getWord = new GetWord();

echo $getWord->process($_SERVER);
