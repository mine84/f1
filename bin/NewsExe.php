<?php
$app_dir = dirname(dirname(__FILE__));
require_once($app_dir . DIRECTORY_SEPARATOR . "src/f1_controller.php");

$objF1Controller = new F1Controller();
$objF1Controller->execute("News.execute");
