<?php
/**
 * Created by PhpStorm.
 * User: jarne
 * Date: 13.11.16
 * Time: 09:39
 */

require_once "vendor/autoload.php";

use jarne\getword\GetWord;

$getText = new GetWord();

echo $getText->process($_SERVER);