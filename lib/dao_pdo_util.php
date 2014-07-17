<?php

class DaoPdoUtil {
    var $objDaoPdo = null;
    var $objDaoPdoException = null;
    var $objResultset = null;
    var $strWhere = null;
    var $boolTransactionFlg = false;

    // コンストラクタ
    function __construct ()
    {

    }

    // デストラクタ
    function __destruct ()
    {

    }

    function connect ($strHost, $strDB, $strUser, $strPass) {
        try {
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            );
            $this->objDaoPdo = new PDO("mysql:host=$strHost; dbname=$strDB", $strUser, $strPass, $options);
            // var_dump($this->objDaoPdo);
            // foreach($this->objDaoPdo->query('show tables') as $row) {
            //     print_r($row);
            // }
            $this->objDaoPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $objDaoPdoException = null;
            return true;
        } catch (PDOException $e) {
            $this->objDaoPdoException = $e;
            var_dump($e);
            $this->objDaoPdo = null;
            return false;
        }
    }

    function close () {
        $this->objDaoPdo            = null;
        //$this->objDaoPdoException   = null;
        $this->objResultset         = null;
        $this->strSQL               = null;
        $this->strWhere             = null;
        $this->boolTransactionFlg   = false;
    }

    function clear () {
        $this->objResultset         = null;
        $this->strSQL               = null;
        $this->strWhere             = null;
        //$this->boolTransactionFlg   = false;
    }

    function begin_trans () {
        if ($this->objDaoPdo->beginTransaction()) {
            $this->boolTransactionFlg = true;
            return true;
        }
        return false;
    }

    function last_insert_id () {
        return $this->objDaoPdo->lastInsertId();
    }

    function rollback () {
        if ($this->boolTransactionFlg && $this->objDaoPdo->rollBack()) {
            $this->boolTransactionFlg = false;
            return true;
        }
        return false;
    }

    function exec_select ($strSQL, $arrParams = null) {
        if (empty($arrParams)) {
            $this->query($strSQL . $this->strWhere);
        } else {
//            var_dump($strSQL . $this->strWhere);
//            var_dump($arrParams);
            $this->prepare($strSQL . $this->strWhere, $arrParams);
        }
        return $this->objResultset->fetchAll(PDO::FETCH_ASSOC);
    }

    function prepare ($strSQL, $arrParams) {
        try {
            $this->objResultset = $this->objDaoPdo->prepare($strSQL);
            $this->objResultset->execute($arrParams);
            $this->strWhere = null;
            return true;
        } catch (PDOException $e) {
            var_dump($strSQL);
            var_dump($e);
            $this->set_exception($e);
            return false;
        }
    }

    function array_prepare ($strSQL, $arrParamsList)
    {
        try {
            // $strSQL .= $this->strWhere;
            foreach ($arrParamsList as $arrParams) {
                $arrSQLParams = array();
                foreach ($arrParams as $value) {
                    $arrSQLParams[] = $value;
                }
                // var_dump($strSQL . $this->strWhere);
                // var_dump($arrSQLParams);
                $this->objResultset = $this->objDaoPdo->prepare($strSQL . $this->strWhere);
                $this->objResultset->execute($arrSQLParams);
            }
            $this->strWhere = null;
            return true;
        } catch (PDOException $e) {
            $this->logger(array($strSQL . $this->strWhere, $e));
            var_dump($strSQL);
            var_dump($e);
            $this->set_exception($e);
            return false;
        }
    }

    function exec ($strSQL) {
        try {
            $this->objResultset = $this->objDaoPdo->exec($strSQL);
            $this->strWhere = null;
        } catch (PDOException $e) {
            $this->logger(array($strSQL . $this->strWhere, $e));
            $this->set_exception($e);
            return false;
        }
    }

    function query ($strSQL) {
        try {
            $this->objResultset = $this->objDaoPdo->query($strSQL);
            $this->strWhere = null;
        } catch (PDOException $e) {
            $this->logger(array($strSQL . $this->strWhere, $e));
//            var_dump($e);
            $this->set_exception($e);
            return false;
        }
    }

    function commit () {
        if ($this->boolTransactionFlg && $this->objDaoPdo->commit()) {
           $this->boolTransactionFlg = false;
           return true;
        }
        return false;
    }

    function get_error_code () {
        if (!empty($this->objDaoPdoException)) {
            return $this->objDaoPdoException->getCode();
        }
        return "";
    }

    function get_error_info () {
        if (!empty($this->objDaoPdoException)) {
            return $this->objDaoPdoException->getInfo();
        }
        return "";
    }

    function get_error_message () {
        if (!empty($this->objDaoPdoException)) {
            return $this->objDaoPdoException->getMessage();
        }
        return "";
    }

    function set_exception ($exception) {
        $this->objDaoPdoException = $exception;
        if ($this->boolTransactionFlg) {
            $this->rollback();
        }
        $this->objDaoPdo = null;
        $this->strWhere = null;
    }

    function add_where ($strWhere, $strOption = "") {
        if (empty($this->strWhere)) {
            $this->strWhere = "WHERE $strWhere ";
        } else {
            $this->strWhere .= " $strOption $strWhere ";
        }
    }

    function add_option ($strOption) {
        $this->strWhere .= " $strOption ";
    }

    function is_error ($result) {
//        if ($result === false) {
        if (!empty($this->objDaoPdoException)) {
            if ($this->boolTransactionFlg) {
                $this->rollback();
            }
            $this->close();
            return true;

        } else {
            $this->clear();
            return false;
        }
    }

    function logger ($arrData)
    {
        $strSubject = "DBエラーが発生しました。";
        $strBody = "";
        $strMailAddress = "error@ec2-54-248-42-151.ap-northeast-1.compute.amazonaws.com";

        foreach ($arrData as $data) {
            FileUtil::logger($data, LOG_DIR . DIRECTORY_SEPARATOR . "app_". date('Ymd') . ".log");
            $strBody .= $data . "\n\n";
        }

        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        if (mb_send_mail("masashi.nagamine@d2c.co.jp, masashi.nagamine@gmail.com", $strSubject, $strBody, "From: $strMailAddress")) {

        } else {

        }
    }
}



