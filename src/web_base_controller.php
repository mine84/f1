<?php

class WebBaseController {

    var $arrRequest = array();
    var $arrServer = array();
    var $objSmartyUtil = null;

    // コンストラクタ
    function __construct ()
    {
        $this->set_request($_REQUEST, $_SERVER);
        $this->objSmartyUtil = new SmartyUtil(SMARTY_TEMPLATES_DIR, SMARTY_COMPILE_DIR);
        RankingController::load_model("RankingModel");
        // 年、月、日、時間のリストを設定
        $this->objSmartyUtil->assign('yearOption', DateUtil::get_year_list(2014, date('Y')));
        $this->objSmartyUtil->assign('monthOption', DateUtil::get_month_list());
        $this->objSmartyUtil->assign('dateOption', DateUtil::get_day_list());
        $this->objSmartyUtil->assign('timeOption', DateUtil::get_hour_list());
    }

    // デストラクタ
    function __destruct ()
    {

    }

    // リクエストをセット
    function set_request ($arrRequest, $arrServer)
    {
        $this->arrRequest = $arrRequest;
        $this->arrServer = $arrServer;
    }

    // マスタデータを smarty オブジェクトに設定する
    function set_master_data ($intOsId)
    {
        $objRankingModel = new RankingModel();
        $objRankingModel->connect();
        // 国データ取得
        $listCountry = $objRankingModel->get_country(
            array($intOsId),
            array("os_id = ?" => "")
        );
        // echo mb_internal_encoding();
        // var_dump($listCountry);
        $this->objSmartyUtil->assign("listCountry", $listCountry);
        if (!empty($this->arrRequest['country_id'])) {
            $boolExist = false;
            foreach ($listCountry as $arrCountryValue) {
                if ($this->arrRequest['country_id'] == $arrCountryValue['country_id']) {
                    $boolExist = true;
                }
            }
            if (!$boolExist) {
                $this->arrRequest['country_id'] = $listCountry[0]['country_id'];
            }
        }
        $this->objSmartyUtil->assign("countryOption", $this->set_options_data($listCountry, 'country_id', 'name'));

        // feedデータ取得
        $listFeed = $objRankingModel->get_feed(
            array($intOsId),
            array("os_id = ?" => "")
        );
        $this->objSmartyUtil->assign("listFeed", $listFeed);
        $this->objSmartyUtil->assign("feedOption", $this->set_options_data($listFeed, 'feed_id', 'name'));

        // カテゴリデータ取得
        $listCategory = $objRankingModel->get_category(
            array($intOsId),
            array("os_id = ?" => "")
        );
        $this->objSmartyUtil->assign("listCategory", $listCategory);
        if (!empty($this->arrRequest['category_id'])) {
            $boolExist = false;
            foreach ($listCategory as $arrCategoryValue) {
                if ($this->arrRequest['category_id'] == $arrCategoryValue['category_id']) {
                    $boolExist = true;
                }
            }
            if (!$boolExist) {
                $this->arrRequest['category_id'] = $listCategory[0]['category_id'];
            }
        }
        $this->objSmartyUtil->assign("categoryOption", $this->set_options_data($listCategory, 'category_id', 'name'));
        $objRankingModel->close();
    }

    function make_ranking_array ($listRankingData)
    {
        foreach ($listRankingData as $strRankingDataKey => $arrRankingDataValue) {
            $arrRanking = array();
        }
    }

    function set_options_data ($listTarget, $strIdName, $strValueName)
    {
        $arrOption = array();
        foreach ($listTarget as $arrTargetValue) {
            $arrOption[$arrTargetValue[$strIdName]] = $arrTargetValue[$strValueName];
        }
        return $arrOption;
    }

    function set_array_reverse ($arrTarget)
    {
        $arrReverse = array();
        foreach ($arrTarget as $key => $value) {
            $arrReverse[$value] = $key;
        }
        return $arrReverse;
    }
}