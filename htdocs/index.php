<?php
error_reporting(E_ALL & ~E_NOTICE);
$app_dir = dirname(dirname(__FILE__));
require_once($app_dir . DIRECTORY_SEPARATOR . "src/ranking_controller.php");
require_once(CONF_DIR . DIRECTORY_SEPARATOR . "web_conf.php");
require_once(SRC_DIR . DIRECTORY_SEPARATOR . "web_base_controller.php");
require_once(LIB_DIR . DIRECTORY_SEPARATOR . "smarty_util.php");
require_once(LIB_DIR . DIRECTORY_SEPARATOR . "date_util.php");
require_once(LIB_DIR . DIRECTORY_SEPARATOR . "ranking_util.php");

// var_dump($_SERVER);exit;

if (strpos($_SERVER['REQUEST_URI'], '?') !== false) {
    $workRequest = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '?') + 1);
    $workRequest = explode('&', $workRequest);

    $_REQUEST = array();
    if (is_array($workRequest)) {
        foreach ($workRequest as $value) {
            $arrRequest = explode('=', $value);
            $_REQUEST[$arrRequest[0]] = $arrRequest[1];
        }
    }
    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
}
$arrExecController = explode('/', $_SERVER['REQUEST_URI']);
if (count($arrExecController) < 2 || empty($arrExecController[1])) {
    echo "Not Found<br /><br />The requested URL " . $_SERVER['REQUEST_URI'] . " was not found on this server.";
    var_dump($arrExecController);
    exit;
} elseif (count($arrExecController) == 2) {
    $arrExecController[] = "index";
}

$objRankingController = new RankingController();
$result = $objRankingController->execute($arrExecController[1] . "." . $arrExecController[2]);

if ($result === false) {
    echo "Not Found<br /><br />The requested URL " . $_SERVER['REQUEST_URI'] . " was not found on this server.";
    exit;
}

