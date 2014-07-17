<?php

class BaseModel extends DaoPdoUtil
{
    // コンストラクタ
    function __construct ()
    {
    }

    // デストラクタ
    function __destruct ()
    {
        parent::close();
    }

    // DB接続
    function connect ()
    {
        parent::connect(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    // where句の設定setteisettei
    function set_where ($arrWhere)
    {
        if (is_array($arrWhere)) {
            foreach ($arrWhere as $key => $value) {
                $this->add_where($key, $value);
            }
        }
    }

    function set_option ($strOption)
    {
        $this->add_option($strOption);
    }
}