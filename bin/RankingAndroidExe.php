<?php
$app_dir = dirname(dirname(__FILE__));
require_once($app_dir . DIRECTORY_SEPARATOR . "src/ranking_controller.php");

$objRankingController = new RankingController();
$objRankingController->execute("Proxy.execute");
$objRankingController->execute("Ranking.execute_android");