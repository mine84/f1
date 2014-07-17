<?php
// 各種ファイル読み込み
require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'conf' .  DIRECTORY_SEPARATOR . 'conf.php');
require_once(CONF_DIR . DIRECTORY_SEPARATOR . 'ranking_conf.php');
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'dao_pdo_util.php');
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'file_util.php');
require_once(MODEL_DIR . DIRECTORY_SEPARATOR . 'BaseModel.php');

// 簡易コントローラ
class F1Controller
{

    // コンストラクタ
    function __construct ()
    {
        // http通信時は自動でクラスの新スタンス化 + Functionの実行を行う。
        // ランキング画面を作成する際に追記する
    }

    // デストラクタ
    function __destruct ()
    {

    }

    // 実行
    // strClassFuncName : クラス名.function名
    function execute ($strClassFuncName, $params = null)
    {
        if (strpos($strClassFuncName, ".") === false) {
            return false;
        }

        $listClassFuncName = explode(".", $strClassFuncName);
        $strClass  = $listClassFuncName[0];
        $strMethod = $listClassFuncName[1];
        // var_dump($strClass);
        // var_dump($strMethod);

        if (!$this->load_class($strClass)) {
            return false;
        }

        $objClass = new $strClass();
        if (!method_exists($objClass, $strMethod)) {
            return false;
        }
        if ($params == null) {
            if (method_exists($objClass, 'init')) {
                $objClass->init();
            }
            $objClass->$strMethod();
        } else {
            $objClass->$strMethod($params);
        }
    }

    // モデルクラスをロードする
    function load_model ($objModel)
    {
        if (is_array($objModel)) {
            foreach ($objModel as $key => $value) {
                // $this->load_class($value);
                RankingController::load_class($value);
            }
        } elseif (is_string($objModel)) {
            // $this->load_class($value);
            RankingController::load_class($objModel);
        } else {
            return false;
        }
        return true;
    }

    // src or model ディレクトリのソースをロードする
    function load_class ($strClass)
    {
        $strClassDir = "";
        if (!file_exists(SRC_DIR . DIRECTORY_SEPARATOR . $strClass . ".php")) {
            if (!file_exists(MODEL_DIR . DIRECTORY_SEPARATOR . $strClass . ".php")) {
                return false;
            } else {
                $strClassDir = MODEL_DIR;
            }
        } else {
            $strClassDir = SRC_DIR;
        }
        require_once($strClassDir . DIRECTORY_SEPARATOR . $strClass . ".php");
        if (!class_exists($strClass)) {
            return false;
        }
        return true;
    }

    function logger ($data)
    {
        FileUtil::logger($data, LOG_DIR . DIRECTORY_SEPARATOR . "app_". date('Ymd') . ".log");
    }
}