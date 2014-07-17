<?php

class apps extends WebBaseController
{
    // コンストラクタ
    function __construct ()
    {
        parent::__construct();
    }

    // デストラクタ
    function __destruct ()
    {

    }

    function index ()
    {
        echo "index test.";
    }

    // トップチャート
    function ranking ()
    {
        $this->_set_init_condition();
        $this->set_master_data($this->arrRequest['os_id']);

        $arrWhereFeed = array();
        $arrWhereFeed = $this->_set_feed_condition();

        $listRanking = array();
        $objRankingModel = new RankingModel();
        $objRankingModel->connect();

        foreach ($arrWhereFeed as $strWhereFeedKey => $strWhereFeedValue) {
            // 国データ取得
            $listRanking[$strWhereFeedKey] = $objRankingModel->get_ranking_data(
                array(
                    $this->arrRequest['ranking_year'],
                    $this->arrRequest['ranking_month'],
                    $this->arrRequest['ranking_date'],
                    $this->arrRequest['ranking_time'] . '00',
                    $this->arrRequest['os_id'],
                    $this->arrRequest['country_id'],
                    $this->arrRequest['category_id'],
                    $strWhereFeedValue,
                ),
                array(
                    "dr.ranking_year = ?" => "",
                    "dr.ranking_month = ?" => "and",
                    "dr.ranking_date = ?" => "and",
                    "dr.ranking_time = ?" => "and",
                    "dr.os_id = ?" => "and",
                    "dr.country_id = ?" => "and",
                    "dr.category_id = ?" => "and",
                    "dr.feed_id = ?" => "and",
                ),
                    " ORDER BY ranking"
            );

            $strBeforeDateTime = DateUtil::conpute_hour($this->arrRequest['ranking_year'], $this->arrRequest['ranking_month'], $this->arrRequest['ranking_date'], $this->arrRequest['ranking_time'] . ':00', "-1");
            $arrBeforeDateTime = explode(" ", $strBeforeDateTime);
            $arrBeforeDate = explode("-", $arrBeforeDateTime[0]);
            $arrBeforeTime = explode(":", $arrBeforeDateTime[1]);
            $listBeforeRanking[$strWhereFeedKey] = $objRankingModel->get_ranking_data(
                array(
                    $arrBeforeDate[0],
                    $arrBeforeDate[1],
                    $arrBeforeDate[2],
                    $arrBeforeTime[0] . $arrBeforeTime[1],
                    $this->arrRequest['os_id'],
                    $this->arrRequest['country_id'],
                    $this->arrRequest['category_id'],
                    $strWhereFeedValue,
                ),
                array(
                    "dr.ranking_year = ?" => "",
                    "dr.ranking_month = ?" => "and",
                    "dr.ranking_date = ?" => "and",
                    "dr.ranking_time = ?" => "and",
                    "dr.os_id = ?" => "and",
                    "dr.country_id = ?" => "and",
                    "dr.category_id = ?" => "and",
                    "dr.feed_id = ?" => "and",
                ),
                    " ORDER BY ranking"
            );
        }
        $listRanking = $this->_compare_ranking($listRanking, $listBeforeRanking);
        $objRankingModel->close();
        $this->objSmartyUtil->all_assign($this->arrRequest);
        $this->objSmartyUtil->assign('osOption', $this->set_array_reverse(RankingConf::get('OS_LIST')->data));
        $this->objSmartyUtil->assign('listRanking', $listRanking);
        $this->objSmartyUtil->display("ranking_list.tpl");
    }

    // マトリックス
    function topmatrix()
    {
        $this->_set_init_condition();
        $this->set_master_data($this->arrRequest['os_id']);

        $arrWhereFeed = array();
        $arrWhereFeed = $this->_set_feed_condition();

        $listRanking = array();
        $objRankingModel = new RankingModel();
        $objRankingModel->connect();

        foreach ($arrWhereFeed as $strWhereFeedKey => $strWhereFeedValue) {
            $arrCountryOption = $this->objSmartyUtil->get_template_vars('countryOption');
            foreach ($arrCountryOption as $countryOptionKey => $countryOptionValue) {
                // 国データ取得
                $listRanking[$strWhereFeedKey][$countryOptionKey] = $objRankingModel->get_ranking_data(
                    array(
                        $this->arrRequest['ranking_year'],
                        $this->arrRequest['ranking_month'],
                        $this->arrRequest['ranking_date'],
                        $this->arrRequest['ranking_time'] . '00',
                        $this->arrRequest['os_id'],
                        $countryOptionKey,
                        $this->arrRequest['category_id'],
                        $strWhereFeedValue,
                    ),
                    array(
                        "dr.ranking_year = ?" => "",
                        "dr.ranking_month = ?" => "and",
                        "dr.ranking_date = ?" => "and",
                        "dr.ranking_time = ?" => "and",
                        "dr.os_id = ?" => "and",
                        "dr.country_id = ?" => "and",
                        "dr.category_id = ?" => "and",
                        "dr.feed_id = ?" => "and",
                    ),
                    "  ORDER BY dr.ranking LIMIT 5 "
                );
            }
        }

        $objRankingModel->close();
        $this->objSmartyUtil->all_assign($this->arrRequest);
        $this->objSmartyUtil->assign('osOption', $this->set_array_reverse(RankingConf::get('OS_LIST')->data));
        $this->objSmartyUtil->assign('listRanking', $listRanking);
        $this->objSmartyUtil->display("ranking_matrix.tpl");
    }

    // 詳細
    function detail ()
    {
        $this->_set_init_condition();
        $this->set_master_data($this->arrRequest['os_id']);

        $arrWhereFeed = array();
        $arrWhereFeed = $this->_set_feed_condition();

        $objRankingModel = new RankingModel();
        $objRankingModel->connect();

        // アプリ詳細データ取得
        $arrAppli = $objRankingModel->get_appli(
            array($this->arrRequest['appli_id'],),
            array("appli_id = ?" => "",)
        );
        $listRanking = array();
        foreach ($arrWhereFeed as $strWhereFeedKey => $strWhereFeedValue) {
            $arrCategoryOption = $this->objSmartyUtil->get_template_vars('categoryOption');
            foreach ($arrCategoryOption as $categoryOptionKey => $categoryOptionValue) {
                if ($this->arrRequest['graph_kind'] == 1) {
                    // 時間別ランキングデータ取得
                    $listRanking[$strWhereFeedKey . " " . $categoryOptionValue] = $objRankingModel->get_ranking(
                        array(
                            $this->arrRequest['ranking_year'],
                            $this->arrRequest['ranking_month'],
                            $this->arrRequest['ranking_date'],
                            $this->arrRequest['os_id'],
                            $this->arrRequest['country_id'],
                            $strWhereFeedValue,
                            $categoryOptionKey,
                            $this->arrRequest['appli_id'],
                        ),
                        array(
                            "ranking_year = ?" => "",
                            "ranking_month = ?" => "and",
                            "ranking_date = ?" => "and",
                            "os_id = ?" => "and",
                            "country_id = ?" => "and",
                            "feed_id = ?" => "and",
                            "category_id = ?" => "and",
                            "appli_id = ?" => "and"
                        ),
                        "  ORDER BY ranking_time "
                    );
                } elseif ($this->arrRequest['graph_kind'] == 2) {
                    // 日別ランキングデータ取得
                    $listRanking[$strWhereFeedKey . " " . $categoryOptionValue] = $objRankingModel->get_ranking(
                        array(
                            $this->arrRequest['ranking_year'],
                            $this->arrRequest['ranking_month'],
                            $this->arrRequest['ranking_time'] . "00",
                            $this->arrRequest['os_id'],
                            $this->arrRequest['country_id'],
                            $strWhereFeedValue,
                            $categoryOptionKey,
                            $this->arrRequest['appli_id'],
                        ),
                        array(
                            "ranking_year = ?" => "",
                            "ranking_month = ?" => "and",
                            "ranking_time = ?" => "and",
                            "os_id = ?" => "and",
                            "country_id = ?" => "and",
                            "feed_id = ?" => "and",
                            "category_id = ?" => "and",
                            "appli_id = ?" => "and"
                        ),
                        "  ORDER BY ranking_date "
                    );
                }
            }
        }
        $objRankingModel->close();
        $this->_set_highchart_graph_ranking($listRanking);
        // $this->_set_graph_ranking($listRanking);

        $this->objSmartyUtil->all_assign($this->arrRequest);
        $this->objSmartyUtil->assign('graphKindOption', array("1" => "時間別", "2" => "日別"));  // グラフの種類
        $this->objSmartyUtil->assign('arrAppli', $arrAppli[0]);
        $this->objSmartyUtil->assign('osOption', $this->set_array_reverse(RankingConf::get('OS_LIST')->data));
        $this->objSmartyUtil->assign('listRanking', $listRanking);
        $this->objSmartyUtil->display("ranking_detail.tpl");
    }

    // ランキング推移
    function transition ()
    {
        $this->_set_init_condition();
        $this->set_master_data($this->arrRequest['os_id']);

        // feed IDの設定
        if (empty($this->arrRequest['feed_id'])) {
            $arrFeedOption = $this->objSmartyUtil->get_template_vars('feedOption');
            $arrFeedKeys = array_keys($arrFeedOption);
            $this->arrRequest['feed_id'] = $arrFeedKeys[0];
        }

        // 表示種別の設定 1:テキスト、2:アイコン
        if (empty($this->arrRequest['disp_type'])) {
            $this->arrRequest['disp_type'] = 1;
        }

        $objRankingModel = new RankingModel();
        $objRankingModel->connect();

        $listRanking = $objRankingModel->get_ranking_data(
            array(
                $this->arrRequest['ranking_year'],
                $this->arrRequest['ranking_month'],
                $this->arrRequest['ranking_date'],
                $this->arrRequest['os_id'],
                $this->arrRequest['country_id'],
                $this->arrRequest['category_id'],
                $this->arrRequest['feed_id'],
            ),
            array(
                "dr.ranking_year = ?" => "",
                "dr.ranking_month = ?" => "and",
                "dr.ranking_date = ?" => "and",
                "dr.os_id = ?" => "and",
                "dr.country_id = ?" => "and",
                "dr.category_id = ?" => "and",
                "dr.feed_id = ?" => "and",
            ),
            " ORDER BY dr.ranking_time, dr.ranking"
        );

        $objRankingModel->close();
        $listRanking = $this->_set_transition_ranking($listRanking);

        $this->objSmartyUtil->all_assign($this->arrRequest);
        $this->objSmartyUtil->assign('osOption', $this->set_array_reverse(RankingConf::get('OS_LIST')->data));
        $this->objSmartyUtil->assign('listRanking', $listRanking);
        $this->objSmartyUtil->assign('dispTypeOption', array('1' => 'テキスト', '2' => 'アイコン'));
        $this->objSmartyUtil->display("ranking_transition.tpl");
    }

    // 検索
    function search ()
    {
        $this->_set_init_condition();
        $objRankingModel = new RankingModel();
        $objRankingModel->connect();

        $arrAppli = array();
        $arrCountry = array();
        if (!empty($this->arrRequest['search_word'])) {
            $arrAppli = $objRankingModel->get_appli(
                array("%" . $this->arrRequest['search_word'] . "%"),
                array("name like ? " => '')
            );
            $arrWorkCountry = $objRankingModel->get_country();
            foreach ($arrWorkCountry as $value) {
                $arrCountry[$value['country_id']] = $value['name'];
            }
        }

        $objRankingModel->close();
        $this->objSmartyUtil->assign('arrAppli', $arrAppli);
        $this->objSmartyUtil->assign('arrCountry', $arrCountry);
        $this->objSmartyUtil->assign('osOption', $this->set_array_reverse(RankingConf::get('OS_LIST')->data));
        $this->objSmartyUtil->display("ranking_search.tpl");
    }

    //
    function _set_feed_condition ()
    {
        $arrWhereFeed = array();
        $tempListFeed = $this->objSmartyUtil->get_template_vars('listFeed');
        foreach ($tempListFeed as $tempFeed) {
            if ($tempFeed['os_id'] == $this->arrRequest['os_id']) {
                $arrWhereFeed[$tempFeed['name']] = $tempFeed['feed_id'];
            }
        }
        return $arrWhereFeed;
    }

    // 初期データの設定
    function _set_init_condition ()
    {
        if (empty($this->arrRequest['os_id'])) {
            $this->arrRequest['os_id'] = IOS;
        }

        if (empty($this->arrRequest['country_id'])) {
            if ($this->arrRequest['os_id'] == IOS) {
                $this->arrRequest['country_id'] = 1;
            } elseif ($this->arrRequest['os_id'] == ANDROID) {
                $this->arrRequest['country_id'] = 13;
            }
        }

        if (empty($this->arrRequest['feed_id'])) {
            $this->arrRequest['feed_id'] = null;
        }

        if (empty($this->arrRequest['category_id'])) {
            if ($this->arrRequest['os_id'] == IOS) {
                $this->arrRequest['category_id'] = 1;
            } elseif ($this->arrRequest['os_id'] == ANDROID) {
                $this->arrRequest['category_id'] = 3;
            }
        }

        if (empty($this->arrRequest['ranking_year'])) {
            $this->arrRequest['ranking_year'] = date('Y');
        }

        if (empty($this->arrRequest['ranking_month'])) {
            $this->arrRequest['ranking_month'] = date('m');
        }

        if (empty($this->arrRequest['ranking_date'])) {
            $this->arrRequest['ranking_date'] = date('d');
        }

        if (empty($this->arrRequest['ranking_time'])) {
            $this->arrRequest['ranking_time'] = date('H');
        }

        if (empty($this->arrRequest['graph_kind'])) {
            $this->arrRequest['graph_kind'] = 1;
        }
    }

    // 今回のランキングと前回のランキングを比べる
    function _compare_ranking ($listRanking, $listBeforeRanking)
    {
        $arrRankingKeys = array_keys($listRanking);

        foreach ($arrRankingKeys as $strRankingKeysValue) {
            for ($i = 0; $i < count($listRanking[$strRankingKeysValue]); $i++) {
                $boolRankingExist = false;
                for ($j = 0; $j < count($listBeforeRanking[$strRankingKeysValue]); $j++) {
                    if ($listRanking[$strRankingKeysValue][$i]['appli_id'] == $listBeforeRanking[$strRankingKeysValue][$j]['appli_id']) {
                        $boolRankingExist = true;
                        if ((int)$listRanking[$strRankingKeysValue][$i]['ranking'] == (int)$listBeforeRanking[$strRankingKeysValue][$j]['ranking']) {
                            $listRanking[$strRankingKeysValue][$i]['compare'] = '<i class="fa fa-arrow-left"></i>';
                        } elseif ((int)$listRanking[$strRankingKeysValue][$i]['ranking'] > (int)$listBeforeRanking[$strRankingKeysValue][$j]['ranking']) {
                            $listRanking[$strRankingKeysValue][$i]['compare'] = '<span style="color:#a66"><i class="fa fa-arrow-down"></i>  -' . (string)((int)$listRanking[$strRankingKeysValue][$i]['ranking'] - (int)$listBeforeRanking[$strRankingKeysValue][$j]['ranking']) . '</span>';
                        } elseif ((int)$listRanking[$strRankingKeysValue][$i]['ranking'] < (int)$listBeforeRanking[$strRankingKeysValue][$j]['ranking']) {
                            $listRanking[$strRankingKeysValue][$i]['compare'] = '<span style="color:#6a6"><i class="fa fa-arrow-up"></i>  +' . (string)(abs((int)$listRanking[$strRankingKeysValue][$i]['ranking'] - (int)$listBeforeRanking[$strRankingKeysValue][$j]['ranking'])) . '</span>';
                        }
                    }
                }
                if (!$boolRankingExist) {
                    $listRanking[$strRankingKeysValue][$i]['compare'] = '<i class="fa fa-arrow-up"></i>  new';
                }
            }
        }
        return $listRanking;
    }

    // ランキング推移の設定をする
    function _set_transition_ranking ($listRanking)
    {
        $arrFeedOption = $this->objSmartyUtil->get_template_vars('feedOption');
        $arrCategoryOption = $this->objSmartyUtil->get_template_vars('categoryOption');

        $arrTransitionRanking = array();
        $strRankingTime = "";
        $strRankingKey = "";
        $arrRankingKey = array();

        for ($i = 0; $i < count($listRanking); $i++) {
            if ($strRankingTime != $listRanking[$i]['ranking_time']) {
                $strRankingTime = $listRanking[$i]['ranking_time'];
                $strRankingKey = wordwrap($listRanking[$i]['ranking_time'], 2, ":", true);
                $arrRankingKey[] = $strRankingKey;
            }

            $arrTransitionRanking[$strRankingKey][] = $listRanking[$i];
            if ($strRankingKey != wordwrap($listRanking[$i+1]['ranking_time'], 2, ":", true) && count($arrRankingKey) > 1) {
                $arrTransitionRanking[$strRankingKey] = $this->_compare_transition_ranking($arrTransitionRanking[$strRankingKey], $arrTransitionRanking[$arrRankingKey[count($arrRankingKey)-2]]);
            } else {
                # ここは必要なら、後で実装する
            }
        }
        return $arrTransitionRanking;
    }

    // 今回のランキングと前回のランキングを比べる
    function _compare_transition_ranking ($listRanking, $listBeforeRanking)
    {
        for ($i = 0; $i < count($listRanking); $i++) {
            $boolRankingExist = false;
            for ($j = 0; $j < count($listBeforeRanking); $j++) {
                if ($listRanking[$i]['appli_id'] == $listBeforeRanking[$j]['appli_id']) {
                    $boolRankingExist = true;
                    if ((int)$listRanking[$i]['ranking'] == (int)$listBeforeRanking[$j]['ranking']) {
                        $listRanking[$i]['compare'] = '<i class="fa fa-arrow-left"></i>';
                    } elseif ((int)$listRanking[$i]['ranking'] > (int)$listBeforeRanking[$j]['ranking']) {
                        $listRanking[$i]['compare'] = '<span style="color:#a66"><i class="fa fa-arrow-down"></i>  -' . (string)((int)$listRanking[$i]['ranking'] - (int)$listBeforeRanking[$j]['ranking']) . '</span>';
                    } elseif ((int)$listRanking[$i]['ranking'] < (int)$listBeforeRanking[$j]['ranking']) {
                        $listRanking[$i]['compare'] = '<span style="color:#6a6"><i class="fa fa-arrow-up"></i>  +' . (string)(abs((int)$listRanking[$i]['ranking'] - (int)$listBeforeRanking[$j]['ranking'])) . '</span>';
                    }
                }
            }
            if (!$boolRankingExist) {
                $listRanking[$i]['compare'] = '<i class="fa fa-arrow-up"></i>  new';
            }
        }
        return $listRanking;
    }

    // ランキングのグラフの設定
    function _set_highchart_graph_ranking ($listRanking)
    {
        $arrHighchartRanking = array();
        $arrRankingKeys = array_keys($listRanking);
        $arrHighchartGraphCategoies = array();

        // $arr = array(array('name' => '', 'data' => array()));
        if ($this->arrRequest['graph_kind'] == 1) {
            foreach ($arrRankingKeys as $strRankingKeysValue) {
                $arrData = array('name' => $strRankingKeysValue, 'data' => array());
                for ($i = 0; $i < 24; $i++) {
                    $boolTargetExist = false;
                    if (is_array($listRanking[$strRankingKeysValue])) {
                        foreach ($listRanking[$strRankingKeysValue] as $value) {
                            if (($value['ranking_time'] == "0000" && $i == 0) || (int)$value['ranking_time'] == $i*100) {
                                $arrData['data'][] = (int)$value['ranking'];
                                if (count($arrHighchartGraphCategoies) < 24) {
                                    $arrHighchartGraphCategoies[] = wordwrap($value['ranking_time'], 2, ":", true);
                                }
                                $boolTargetExist = true;
                            }
                        }
                    }
                    if (!$boolTargetExist) {
                        if (count($arrHighchartGraphCategoies) < 24) {
                            $arrHighchartGraphCategoies[] = str_pad((string)$i, 2, '0', STR_PAD_LEFT) . ":" . "00";
                        }
                        $arrData['data'][] = null;
                    }
                }
                // var_dump($arrData);
                // exit;
                $arrHighchartRanking[] = $arrData;
            }
        }  elseif ($this->arrRequest['graph_kind'] == 2) {
            $intEndDay = (int)DateUtil::get_month_end_day($this->arrRequest['ranking_year'], $this->arrRequest['ranking_month']);
            foreach ($arrRankingKeys as $strRankingKeysValue) {
                $arrData = array('name' => $strRankingKeysValue, 'data' => array());
                for ($i = 1; $i <= $intEndDay; $i++) {
                    $boolTargetExist = false;
                    if (is_array($listRanking[$strRankingKeysValue])) {
                        foreach ($listRanking[$strRankingKeysValue] as $value) {
                            if ((int)$value['ranking_date'] == $i) {
                                $arrData['data'][] = (int)$value['ranking'];
                                if (count($arrHighchartGraphCategoies) < $intEndDay) {
                                    // $arrHighchartGraphCategoies[] = $value['ranking_year'] . "-" . $value['ranking_month'] . "-" . $value['ranking_date'];
                                    $arrHighchartGraphCategoies[] = $value['ranking_date'];
                                }
                                $boolTargetExist = true;
                            }
                        }
                    }
                    if (!$boolTargetExist) {
                        if (count($arrHighchartGraphCategoies) < $intEndDay) {
                            // $arrHighchartGraphCategoies[] = $this->arrRequest['ranking_year'] . "-" . $this->arrRequest['ranking_month'] . "-" . str_pad((string)$i, 2, '0', STR_PAD_LEFT);
                            $arrHighchartGraphCategoies[] = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
                        }
                        $arrData['data'][] = null;
                    }
                }
                $arrHighchartRanking[] = $arrData;
            }
        }

        $this->objSmartyUtil->assign("arrHighchartGraphCategoies", json_encode($arrHighchartGraphCategoies));
        $this->objSmartyUtil->assign("arrRankingKeys", json_encode($arrRankingKeys));
        $this->objSmartyUtil->assign("arrHighchartRanking", json_encode($arrHighchartRanking));
    }

    // ランキングのグラフの設定
    function _set_graph_ranking ($listRanking)
    {
        $arrRanking = array();
        $arrRankingKeys = array_keys($listRanking);

        if ($this->arrRequest['graph_kind'] == 1) {
            for ($i = 0; $i < 24; $i++) {
                foreach ($arrRankingKeys as $strRankingKeysValue) {
                    $boolTargetExist = false;
                    if (is_array($listRanking[$strRankingKeysValue])) {
                        foreach ($listRanking[$strRankingKeysValue] as $value) {
                            if ($value['ranking_time'] == "0000" || (int)$value['ranking_time'] == $i*100) {
                                $arrRanking[$i]['ranking_date_time'] = $value['ranking_year'] . "-" . $value['ranking_month'] . "-" . $value['ranking_date'] . " " . wordwrap($value['ranking_time'], 2, ":", true);
                                $arrRanking[$i][$strRankingKeysValue] = (int)$value['ranking'];
                                $boolTargetExist = true;
                            }
                        }
                    }
                    if (!$boolTargetExist) {
                        $arrRanking[$i]['ranking_date_time'] = $this->arrRequest['ranking_year'] . "-" . $this->arrRequest['ranking_month'] . "-" . $this->arrRequest['ranking_date'] . " " . str_pad((string)$i, 2, '0', STR_PAD_LEFT) . ":" . "00";
                        $arrRanking[$i][$strRankingKeysValue] = null;
                    }
                }
            }
        }  elseif ($this->arrRequest['graph_kind'] == 2) {
            $intEndDay = (int)DateUtil::get_month_end_day($this->arrRequest['ranking_year'], $this->arrRequest['ranking_month']);
            for ($i = 1; $i <= $intEndDay; $i++) {
                foreach ($arrRankingKeys as $strRankingKeysValue) {
                    $boolTargetExist = false;
                    if (is_array($listRanking[$strRankingKeysValue])) {
                        foreach ($listRanking[$strRankingKeysValue] as $value) {
                            if ((int)$value['ranking_date'] == $i) {
                                $arrRanking[$i-1]['ranking_date_time'] = $value['ranking_year'] . "-" . $value['ranking_month'] . "-" . $value['ranking_date'];
                                $arrRanking[$i-1][$strRankingKeysValue] = (int)$value['ranking'];
                                $boolTargetExist = true;
                            }
                        }
                    }
                    if (!$boolTargetExist) {
                        $arrRanking[$i-1]['ranking_date_time'] = $this->arrRequest['ranking_year'] . "-" . $this->arrRequest['ranking_month'] . "-" . str_pad((string)$i, 2, '0', STR_PAD_LEFT);
                        $arrRanking[$i-1][$strRankingKeysValue] = null;
                    }
                }
            }
        }

        $this->objSmartyUtil->assign("arrRankingKeys", json_encode($arrRankingKeys));
        $this->objSmartyUtil->assign("arrRanking", json_encode($arrRanking));
    }
}