<?php

require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'file_util.php');
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'f1_util.php');
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'twitteroauth.php');

class News
{
    var $strYear = "";
    var $strMonth = "";
    var $strDate = "";
    var $strTime = "";

    // コンストラクタ
    function __construct ()
    {
        $this->strYear = date('Y');
        $this->strMonth = date('m');
        $this->strDate = date('d');
        $this->strTime = date('H') . '00';
        F1Controller::load_model("F1Model");
    }

    // デストラクタ
    function __destruct ()
    {

    }

    // 初期処理
    function init ()
    {

    }

    // ランキング取得
    function execute ()
    {
        set_time_limit(1200);
        ini_set("max_execution_time", 1200);
        foreach (RankingConf::get('OS_LIST')->data as $key => $value) {
            $this->get_before_ranking_data($value);
            $this->ins_ranking_data($value);
        }
        $this->ins_ranking_data(ANDROID);
    }

    fucntion execute_twitter ($screen_name)
    {
        $since_id = '';
        $twitter_param = array(
            "count" => TWITTER_LIMIT,
        );

        $objF1Model = new F1Model();
        $intLastTweetID = $objF1Model->get_last_tweet_id(
            array($screen_name),
            array("user_screen_name = ? " => "", "delete_flg = 0 " => "AND")
        );

        $twitter_param['screen_name'] = $screen_name;

        if (count($intLastTweetID) != 0 && !empty($tweetLastID[0]['id'])) {
            $twitter_param['since_id'] = $tweetLastID[0]['id'];
        }

        $objTwitterOAuth = new TwitterOAuth(
            $twitterValue['customer_key'],
            $twitterValue['customer_secret'],
            $twitterValue['access_token'],
            $twitterValue['access_token_secret']
        );

        $objRequest = $objTwitterOAuth->OAuthRequest(TWITTER_TIMELINE_URL, "GET", $twitter_param);
        $arrRequestXML = array();
        $arrRequestXML = xml2array($objRequest);

        if (!array_key_exists('status', $arrRequestXML['statuses'])) {
            echo "no result";
            continue;
        }

        if (array_key_exists('created_at', $arrRequestXML['statuses']['status'])) {
            $arrRequestXML['statuses']['status'] = array($arrRequestXML['statuses']['status']);
        }

        $objDaoTwitter->beginTransaction();
        //var_dump($arrRequestXML);
        //var_dump(count($arrRequestXML['statuses']['status']));
        foreach ($arrRequestXML['statuses']['status'] as $requestXML) {
            //var_dump($requestXML);
            $result = $objDaoTwitter->insTweet(
                array(
                    $twitterValue['id'],
                    $requestXML['id'],
                    date('Y-m-d H:i:s', strtotime($requestXML['created_at'])),
                    $requestXML['text'],
                    $requestXML['source'],
                    null,
                    $requestXML['user']['id'],
                    $requestXML['user']['name'],
                    $requestXML['user']['screen_name'],
                    $requestXML['user']['description'],
                    $requestXML['user']['profile_image_url'],
                    $requestXML['user']['profile_image_url_https'],
                    date('Y-m-d H:i:s', strtotime($requestXML['user']['created_at'])),
                )
            );
        }
    }

    function execute_rss ()
    {

    }

    function execute_site ()
    {

    }

    function execute_ios ()
    {
        set_time_limit(1200);
        ini_set("max_execution_time", 1200);
        $this->get_before_ranking_data(IOS);
        $this->ins_ranking_data(IOS);
    }

    function execute_android ()
    {
        set_time_limit(1200);
        ini_set("max_execution_time", 1200);
        $this->get_before_ranking_data(ANDROID);
        $this->ins_ranking_data(ANDROID);
    }

    // ランキング取得用に必要なデータを取得
    function get_before_ranking_data ($intOsId)
    {
        $objRankingModel = new RankingModel();
        $objRankingModel->connect();
        // 国データ取得
        $listCountry = $objRankingModel->get_country(
            array($intOsId),
            array("os_id = ?" => "")
        );

        // feedデータ取得
        $listFeed = $objRankingModel->get_feed(
            array($intOsId),
            array("os_id = ?" => "")
        );

        // カテゴリデータ取得
        $listCategory = $objRankingModel->get_category(
            array($intOsId),
            array("os_id = ?" => "")
        );
        $objRankingModel->close();

        // ストアのURLを取得
        $strStoreUrl = RankingConf::get('RANKING_URL_LIST')->data[$intOsId];
        $this->make_ranking_url($strStoreUrl, $listCountry, $listFeed, $listCategory);
    }

    // ランキングデータ取得に必要な URL、保存ファイル名等を作成する
    function make_ranking_url ($strStoreUrl, $listCountry, $listFeed, $listCategory)
    {
        $listOptions = array();

        foreach ($listCountry as $countryKey => $countryVal) {
            foreach ($listFeed as $feedKey => $feedVal) {
                foreach ($listCategory as $categoryKey => $categoryVal) {
                    $fileName = "";
                    $url = "";
                    $option = array();

                    // ios
                    if ($strStoreUrl == RankingConf::get('RANKING_URL_LIST')->data[IOS]) {
                        $fileName = IOS . "_" . $countryVal['country_id'] . "_" . $feedVal['feed_id'] . "_" . $categoryVal['category_id'];
                        $url = $strStoreUrl . $countryVal['url'] . "rss/" . $feedVal['url'] . "limit=" . LIMIT . "/";

                        if (!empty($categoryVal['url'])) {
                            $url .= $categoryVal['url'];
                        }
                        $url .= "json";
                        $listOptions[] = array(
                            'os' => IOS,
                            'proxy_host' => null,
                            'proxy_port' => null,
                            'target_domain' => IOS_TARGET_DOMAIN,
                            'target_port' => IOS_TARGET_PORT,
                            'target_url' => $url,
                            'file_name' => IOS_DATA_DIR . DIRECTORY_SEPARATOR . str_replace("/", "", $fileName),
                        );

                    // android
                    } elseif ($strStoreUrl == RankingConf::get('RANKING_URL_LIST')->data[ANDROID]) {
                        $url = $strStoreUrl;
                        $fileName = ANDROID . "_" . $countryVal['country_id'] . "_" . $feedVal['feed_id'] . "_" . $categoryVal['category_id'];

                        if (!empty($categoryVal['url'])) {
                            $url .= "category/" . $categoryVal['url'] . "/";
                        }
                        $url .= "collection/" . $feedVal['url'];

                        $intNum = LIMIT;
                        $intStart = 0;
                        $intLoopCnt = 0;
                        do {
                            $strProxy = RankingConf::get('PROXY_LIST')->data[$countryVal['url']];
                            $listProxyHostPort = array("", "");
                            if (!empty($strProxy)) {
                                $listProxyHostPort = explode(":", $strProxy);
                            }
                            $listOptions[] = array(
                                'os' => ANDROID,
                                'proxy_host' => $listProxyHostPort[0],
                                'proxy_port' => $listProxyHostPort[1],
                                'target_domain' => ANDROID_TARGET_DOMAIN,
                                'target_port' => ANDROID_TARGET_PORT,
                                'target_url' => $url . "?start=" . $intStart . "&num=" . ANDROID_NUM,
                                'file_name' => ANDROID_DATA_DIR . DIRECTORY_SEPARATOR . str_replace("/", "", $fileName . "_" . $intLoopCnt),
                            );
                            $intStart = $intStart + ANDROID_NUM;
                            $intNum = $intNum - ANDROID_NUM;
                            $intLoopCnt++;
                        } while ($intNum > 0);
                    }
                }
            }
        }
        if ($strStoreUrl == RankingConf::get('RANKING_URL_LIST')->data[IOS]) {
            $this->fetch_ranking_url($listOptions);
        } else {
            $this->fetch_ranking_url_single($listOptions);
        }
    }

    // ランキングデータを取得し、ファイルに保存する
    function fetch_ranking_url ($listOptions, $intTimeOut = 600)
    {
        $listConn = array(count($listOptions));
        foreach ($listOptions as $i => $optionsVal) {
            $listConn[$i] = curl_init($optionsVal['target_url']);
        }

        $mh = curl_multi_init();
        foreach ($listConn as $i => $connVal) {
            if ($listOptions[$i]['os'] != IOS) {
                if (!empty($listOptions[$i]['proxy_host'])) {
                    curl_setopt($connVal, CURLOPT_PROXY, $listOptions[$i]['proxy_host']);
                }
                if (!empty($listOptions[$i]['proxy_port'])) {
                    curl_setopt($connVal, CURLOPT_PROXYPORT, $listOptions[$i]['proxy_port']);
                }
                curl_setopt($connVal, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($connVal, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($connVal, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($connVal, CURLOPT_VERBOSE, true);
                curl_setopt($connVal, CURLOPT_TIMEOUT, $intTimeOut);
            } else {
                curl_setopt($connVal, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($connVal, CURLOPT_TIMEOUT, $intTimeOut);
            }
            curl_multi_add_handle($mh, $connVal);
        }

        // リクエスト開始
        $stat = null;
        $running = null;
        $counter = 0;
        do
        {
            usleep(20000);
            curl_multi_exec( $mh, $running );
        } while($running > 0);

        while ($running and $stat == CURLM_OK) {
            if (curl_multi_select($mh) != -1) {
                usleep(20000); //ちょっと待ってからretryするのがお作法らしい？
                do {
                    $stat = curl_multi_exec($mh,$running);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }

        $listResponse = array(count($listConn));
        $strResponse = null;
        foreach ($listConn as $i => $conn) {
            $strResponse = null;
            if (($err = curl_error($conn)) == '') {
                $strResponse = curl_multi_getcontent($conn);
                // androidの場合、HTML → XML → json 変換する
                // if ($listOptions[$i]['os'] == ANDROID) {
                //     libxml_use_internal_errors(true);
                //     $strResponse = preg_replace('/<!\[CDATA\[(.*?)\]\]>/', '', $strResponse);
                //     $domDocument = new DOMDocument();
                //     $domDocument->loadHTML($strResponse);
                //     $strXml = $domDocument->saveXML();
                //     $objXml = simplexml_load_string($strXml);
                //     $arrXml = RankingUtil::object2array(simplexml_load_string($objXml));
                //     $strResponse = json_encode($arrXml);
                // }
                FileUtility::file_write_print($strResponse, $listOptions[$i]['file_name']);
            } else {
                var_dump(curl_error($conn));
                var_dump('取得に失敗しました:'.$listOptions[$i]['target_url'] . '  ' . $listOptions[$i]['proxy_host'] . ':' . $listOptions[$i]['proxy_port']);
            }
            curl_multi_remove_handle($mh, $conn);
            curl_close($conn);
        }
        curl_multi_close($mh);
    }

    function fetch_ranking_url_single ($listOptions, $intTimeOut = 30)
    {
        foreach ($listOptions as $i => $optionsVal) {
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $optionsVal['target_url']);
            if (!empty($optionsVal['proxy_host'])) {
                curl_setopt($handle, CURLOPT_PROXY, $optionsVal['proxy_host']);
            }
            if (!empty($optionsVal['proxy_port'])) {
                curl_setopt($handle, CURLOPT_PROXYPORT, $optionsVal['proxy_port']);
            }
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($handle, CURLOPT_VERBOSE, TRUE);
            curl_setopt($handle, CURLOPT_TIMEOUT, $intTimeOut);
            $strResponse = curl_exec($handle);
            FileUtility::file_write_print($strResponse, $listOptions[$i]['file_name']);
        }
    }

    // ランキングデータをDBに保存
    function ins_ranking_data ($os_id)
    {
        $arrFile = array();
        $strDataDir = "";
        if ($os_id == IOS) {
            $strDataDir = IOS_DATA_DIR . DIRECTORY_SEPARATOR;
            $arrFile = FileUtility::get_file_list($strDataDir);
        } elseif ($os_id == ANDROID) {
            $strDataDir = ANDROID_DATA_DIR . DIRECTORY_SEPARATOR;
            $arrFile = FileUtility::get_file_list($strDataDir);
        }

        $objRankingModel = new RankingModel();
        $objRankingModel->connect();

        foreach ($arrFile as $strFileName) {
            $strFileData = file_get_contents($strDataDir . $strFileName);
            $arrFileData = array();
            $arrFileName = explode('_', $strFileName);

            if ($arrFileName[0] == IOS) {
                $arrFileData = json_decode($strFileData, true);
                $arrFileData = $arrFileData['feed']['entry'];
            }  elseif ($arrFileName[0] == ANDROID) {
                $strFileData = substr($strFileData, strpos($strFileData, "\n"));
                $strFileData = preg_replace('/<\/html(\n|.)*/', '</html>', preg_replace('/<(no)?script.*?script>/', '', $strFileData));
                $domDocument = new DOMDocument();
                @$domDocument->loadHTML(mb_convert_encoding($strFileData,'HTML-ENTITIES','auto'));
                $strXml = $domDocument->saveXML();
                $objXml = simplexml_load_string($strXml);
                $arrFileData = RankingUtil::object2array($objXml);
                // var_dump($arrFileData['body']['div'][2]['div'][5]['div']['div']['div']['div']['div']);
                $arrFileData = $arrFileData['body']['div'][2]['div'][5]['div']['div']['div']['div']['div'];
            }

            $arrAppliMasterList = null;
            $arrAppliRankingList = null;

            list ($arrAppliMasterList, $arrAppliRankingList) = $this->set_ranking_data($arrFileData, $arrFileName);
            $objRankingModel->ins_appli($arrAppliMasterList);
            $arrWhere = array(
                "os_id = ? " => "",
                "country_id = ? " => "AND",
                "store_id = ? " => "AND",
            );
            $objRankingModel->ins_ranking_from_appli($arrAppliRankingList, $arrWhere);
        }

        $objRankingModel->close();
        foreach ($arrFile as $strFileName) {
            unlink($strDataDir . $strFileName);
        }
    }

    function set_ranking_data ($arrFileData, $arrFileName)
    {
        $arrAppliList = array();
        $arrRankingList = array();

        for ($i = 0; $i < count($arrFileData); $i++) {
            $intRanking = $i + 1;
            $arrAppli = array();
            $arrRanking = array();
            $strStoreId = "";
            if ($arrFileName[0] == IOS) {
                $strStoreId = $arrFileData[$i]['id']['attributes']['im:id'];
                $arrAppli = array(
                    'ins_os_id'      => $arrFileName[0],
                    'ins_country_id' => $arrFileName[1],
                    'ins_store_id'   => $strStoreId,
                    'ins_name'       => $arrFileData[$i]['im:name']['label'],
                    'ins_url'        => $arrFileData[$i]['link']['attributes']['href'],
                    'ins_price'      => $arrFileData[$i]['im:price']['label'],
                    'ins_icon_url'   => $arrFileData[$i]['im:image'][1]['label'],
                    'ins_content'    => $arrFileData[$i]['summary']['label'],
                    'upd_os_id'      => $arrFileName[0],
                    'upd_country_id' => $arrFileName[1],
                    'upd_store_id'   => $arrFileData[$i]['id']['attributes']['im:id'],
                    'upd_name'       => $arrFileData[$i]['im:name']['label'],
                    'upd_url'        => $arrFileData[$i]['link']['attributes']['href'],
                    'upd_price'      => $arrFileData[$i]['im:price']['label'],
                    'upd_icon_url'   => $arrFileData[$i]['im:image'][1]['label'],
                    'upd_content'    => $arrFileData[$i]['summary']['label'],
                );
            } elseif ($arrFileName[0] == ANDROID) {
                $strStoreId = $arrFileData[$i]['div']['div'][0]['a']['span']['@attributes']['data-docid'];
                $arrAppli = array(
                    'ins_os_id'      => $arrFileName[0],
                    'ins_country_id' => $arrFileName[1],
                    'ins_store_id'   => $strStoreId,
                    'ins_name'       => $arrFileData[$i]['div']['div'][0]['div']['div']['div']['img']['@attributes']['alt'],
                    'ins_url'        => $arrFileData[$i]['div']['div'][0]['a']['@attributes']['href'],
                    'ins_price'      => $arrFileData[$i]['div']['div'][1]['div'][0]['span']['span'][1]['button']['span'],
                    'ins_icon_url'   => $arrFileData[$i]['div']['div'][0]['div']['div']['div']['img']['@attributes']['data-cover-small'],
                    'ins_content'    => $arrFileData[$i]['div']['div'][1]['div'][1],
                    'upd_os_id'      => $arrFileName[0],
                    'upd_country_id' => $arrFileName[1],
                    'upd_store_id'   => $arrFileData[$i]['div']['div'][0]['a']['span']['@attributes']['data-docid'],
                    'upd_name'       => $arrFileData[$i]['div']['div'][0]['div']['div']['div']['img']['@attributes']['alt'],
                    'upd_url'        => $arrFileData[$i]['div']['div'][0]['a']['@attributes']['href'],
                    'upd_price'      => $arrFileData[$i]['div']['div'][1]['div'][0]['span']['span'][1]['button']['span'],
                    'upd_icon_url'   => $arrFileData[$i]['div']['div'][0]['div']['div']['div']['img']['@attributes']['data-cover-small'],
                    'upd_content'    => $arrFileData[$i]['div']['div'][1]['div'][1],
                );
                $intRanking = $intRanking + (ANDROID_NUM * $arrFileName[4]);
            }
            $arrRanking = array(
                'ins_ranking'       => $intRanking,
                'ins_ranking_year'  => $this->strRankingYear,
                'ins_ranking_month' => $this->strRankingMonth,
                'ins_ranking_date'  => $this->strRankingDate,
                'ins_ranking_time'  => $this->strRankingTime,
                'ins_feed_id'       => $arrFileName[2],
                'ins_category_id'   => $arrFileName[3],
                'ins_os_id'         => $arrFileName[0],
                'ins_country_id'    => $arrFileName[1],
                'ins_store_id'      => $strStoreId,
                'upd_ranking'       => $intRanking,
                'upd_ranking_year'  => $this->strRankingYear,
                'upd_ranking_month' => $this->strRankingMonth,
                'upd_ranking_date'  => $this->strRankingDate,
                'upd_ranking_time'  => $this->strRankingTime,
                'upd_feed_id'       => $arrFileName[2],
                'upd_category_id'   => $arrFileName[3],
            );
            $arrAppliList[] = $arrAppli;
            $arrRankingList[] = $arrRanking;
        }
        return array($arrAppliList, $arrRankingList);
    }

}