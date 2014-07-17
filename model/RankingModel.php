<?php

class RankingModel extends BaseModel
{

    // コンストラクタ
    function __construct ()
    {
        parent::__construct();
    }

    // デストラクタ
    function __destruct ()
    {
        parent::__destruct();
    }

    function get_appli ($arrParams = null, $arrWhere = null)
    {
        $strSql = "SELECT appli_id, os_id, country_id, store_id, name, url, price, icon_url, content FROM m_appli ";
        $this->set_where($arrWhere);
        return $this->exec_select($strSql, $arrParams);
    }

    function ins_appli ($arrParams)
    {
        $strSql = "INSERT INTO m_appli (os_id, country_id, store_id, name, url, price, icon_url, content) VALUE (?, ?, ?, ?, ?, ?, ?, ?) " .
            "ON DUPLICATE KEY UPDATE os_id = ?, country_id = ?, store_id = ?, name = ?, url = ?, price = ?, icon_url = ?, content = ? ";
        return $this->array_prepare($strSql, $arrParams);
    }

    function upd_appli ($arrParams = null, $arrWhere = null)
    {
        $strSql = "UPDATE m_appli SET os_id = ?, country_id = ?, store_id = ?, name = ?, url = ?, price = ?, icon_url = ? ";
        $this->set_where($arrWhere);
        return $this->prepare($strSql, $arrParams);
    }

    function get_ranking ($arrParams = null, $arrWhere = null, $strOption = null)
    {
        $strSql = "SELECT ranking, ranking_year, ranking_month, ranking_date, ranking_time, os_id, country_id, feed_id, category_id, appli_id FROM d_ranking ";
        $this->set_where($arrWhere);
        if (!empty($strOption)) {
            $this->set_option($strOption);
        }
        return $this->exec_select($strSql, $arrParams);
    }

    function get_ranking_data ($arrParams, $arrWhere, $strOption = null)
    {
        // var_dump($arrParams);
        $strSql = "SELECT dr.ranking,  dr.ranking_year, dr.ranking_month, dr.ranking_date, dr.ranking_time, dr.os_id,
                    dr.country_id, dr.feed_id, dr.category_id, dr.appli_id, ma.name, ma.store_id, ma.url, ma.price, ma.icon_url
                    FROM d_ranking as dr INNER JOIN m_appli as ma ON dr.appli_id = ma.appli_id ";
        $this->set_where($arrWhere);
        if (!empty($strOption)) {
            $this->set_option($strOption);
        }
        return $this->exec_select($strSql, $arrParams);
    }

    function ins_ranking ($arrParams)
    {
        $strSql = "INSERT INTO d_ranking (ranking, ranking_year, ranking_month, ranking_date, ranking_time, os_id, " .
            "country_id, feed_id, category_id, appli_id) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ";
        return $this->prepare($strSql, $arrParams);
    }

    function ins_ranking_from_appli ($arrParams = null, $arrWhere = null)
    {
        $strSql = "INSERT INTO d_ranking SELECT ?, ?, ?, ?, ?, os_id, country_id, ?, ?, appli_id FROM (SELECT os_id, country_id, appli_id FROM m_appli ";
        $strOption = ") AS ma ON DUPLICATE KEY UPDATE ranking = ?, ranking_year = ?, ranking_month = ?, ranking_date = ?, ranking_time = ?, " .
            "os_id = ma.os_id, country_id = ma.country_id, feed_id = ?, category_id = ?, appli_id = ma.appli_id ";
        $this->set_where($arrWhere);
        $this->set_option($strOption);
        return $this->array_prepare($strSql, $arrParams);
    }

    function get_country ($arrParams = null, $arrWhere = null)
    {
        $strSql = "SELECT country_id, os_id, name, url FROM m_country ";
        $this->set_where($arrWhere);
        return $this->exec_select($strSql, $arrParams);
    }

    function get_feed ($arrParams = null, $arrWhere = null)
    {
        $strSql = "SELECT feed_id, os_id, name, url FROM m_feed ";
        $this->set_where($arrWhere);
        return $this->exec_select($strSql, $arrParams);
    }

    function get_category ($arrParams = null, $arrWhere = null)
    {
        $strSql = "SELECT category_id, os_id, name, url FROM m_category ";
        $this->set_where($arrWhere);
        return $this->exec_select($strSql, $arrParams);
    }
}