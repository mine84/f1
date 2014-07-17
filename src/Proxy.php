<?php
require_once(CONF_DIR . DIRECTORY_SEPARATOR . 'proxy_conf.php');
require_once(CONF_DIR . DIRECTORY_SEPARATOR . 'ranking_conf.php');
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'file_util.php');
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'ranking_util.php');
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'simple_html_dom.php');

class Proxy
{
    var $strProxyConfBefore = '<?php
define(
    "PROXY_LIST",
    serialize(';
    var $strProxyConfAfter = '    )
);';
    // コンストラクタ
    function __construct ()
    {
        RankingController::load_model("RankingModel");
    }

    // デストラクタ
    function __destruct ()
    {

    }

    // 初期処理
    function init ()
    {

    }

    // proxy情報取得
    function execute ()
    {
        $this->init();
        // $this->get_other_proxy(array('es' => ''));
        $listProxy = array();
        // proxy 一覧を初期化
        foreach (RankingConf::get('PROXY_LIST')->data as $key => $value) {
            $listProxy[$key] = "";
        }
        $listProxy = $this->get_getproxy_http($listProxy);
        var_dump($listProxy);
        // exit;
        // $listProxy = $this->get_getproxy($listProxy);
        // var_dump($listProxy);
        $this->file_write_print_array(
            array($this->strProxyConfBefore, $listProxy, $this->strProxyConfAfter),
            CONF_DIR . DIRECTORY_SEPARATOR . 'proxy_conf.php'
        );
    }

    function get_getproxy_http($listProxy)
    {
        $listOptions = array();
        $arrGetProxyCountry = RankingConf::get('GET_PROXY_COUNTRY')->data;
        foreach ($listProxy as $strProxyKey => $strProxyValue) {
            if ($strProxyKey == "jp") continue;
            $url = str_replace("[country]", $arrGetProxyCountry[$strProxyKey], GET_PROXY_HTTP_URL);
            $listOptions[] = array(
                'country' => $strProxyKey,
                'proxy_host' => null,
                'proxy_port' => null,
                'target_url' => $url,
            );
        }
        // var_dump($listProxy);
        // var_dump($listOptions);exit;
        $arrResponse = $this->fetch_proxy_url_single($listOptions);
        foreach ($arrResponse as $strResponseKey => $strResponseValue) {
            // $strResponseValue = preg_replace('/<\/html(\n|.)*/', '</html>', preg_replace('/<(no)?script.*?script>/', '', $strResponseValue));
            // var_dump(substr($strResponseValue, strpos($strResponseValue, "\n")));exit;
            $strResponseValue = preg_replace('/<!(DOCTYPE)[\w|\s|\/|\"|\.|\=|\-|\+|\(|\)]*(EN|\.dtd)\">/', '', $strResponseValue);
            $strResponseValue = substr($strResponseValue, strpos($strResponseValue, "\n"));
            // var_dump($strResponseKey);
            // var_dump($strResponseValue);
            $domDocument = new DOMDocument();
            @$domDocument->loadHTML(mb_convert_encoding($strResponseValue,'HTML-ENTITIES','auto'));
            $strXml = $domDocument->saveXML();
            $objXml = simplexml_load_string($strXml);
            $arrResponseValue = RankingUtil::object2array($objXml);
            $listProxy[$strResponseKey] = $this->get_proxy_ip($arrResponseValue["body"]["div"][1]["div"][0]["table"]);
        }
        return $listProxy;
    }

    // 基本は GET PROXY から、proxyのデータを取得する
    function get_getproxy ($listProxy)
    {
        $strResponse = null;
        foreach ($listProxy as $key => $value) {
            $boolResponseFlg = false;
            if ($key != 'jp') {
                // responseを受け取れるまでループ
                do {
                    var_dump(str_replace("[country]", strtoupper($key), GET_PROXY_URL));
                    $strResponse = "";
                    $strResponse = $this->proxy_request(str_replace("[country]", strtoupper($key), GET_PROXY_URL));
                    $listProxy[$key] = $this->set_getproxy_data($strResponse);
                    var_dump($listProxy[$key]);

                    // データがない場合
                    if ($listProxy[$key] == GET_PROXY_ERROR_MSG_NOTHING) {
                        $listProxy[$key] = "";
                    // 他のエラー
                    } elseif (strpos($listProxy[$key], ":") === false) {
                        var_dump(strpos($listProxy[$key], ":"));
                        var_dump(": is nothing.");
                        $boolResponseFlg = true;
                        usleep(30000000);              // エラーの場合、ちょいと処理を止める(とりあえず10秒)
                    } else {
                        $boolResponseFlg = false;
                        usleep(8000000);              // エラーの場合、ちょいと処理を止める(とりあえず10秒)
                    }
                } while ($boolResponseFlg);
            }
        }
        return $listProxy;
    }

    // GET PROXY から取得したXMLデータの解析
    function set_getproxy_data ($strXml)
    {
        $listGetproxyData = $this->object2array(simplexml_load_string($strXml));
        // エラー
        if (array_key_exists("errorinfo", $listGetproxyData)) {
            return $listGetproxyData['errorinfo'];
        } elseif (array_key_exists("item", $listGetproxyData)) {
            if (array_key_exists('ip', $listGetproxyData['item'])) {
                return $listGetproxyData['item']['ip'];
            }
            return $listGetproxyData['item'][0]['ip'];
        }
    }

    // GET PROXY から取得できなかった proxy データを取得する
    function get_other_proxy ($listProxy)
    {
        $strResponse = null;
        foreach (RankingConf::get('OTHOER_PROXY_URL_LIST')->data as $otherProxyUrlKey => $otherProxyUrlValue) {
            foreach ($listProxy as $proxyKey => $proxyValue) {
                $strResponse = "";
                if (empty($proxyValue)) {
                    var_dump(str_replace("[country]", strtoupper($proxyKey), $otherProxyUrlValue['url']));
                    var_dump($proxyValue);
                    var_dump($proxyKey);
                    // $listResponse[$proxyKey] = $this->proxy_request(str_replace("[country]", strtoupper($proxyKey), $otherProxyUrlValue['url']));

                    $objHtmlDom = file_get_html(str_replace("[country]", strtoupper($proxyKey), $otherProxyUrlValue['url']));
                    var_dump($objHtmlDom);
                    exit;
                    // $strResponse = $this->proxy_request(
                    //     str_replace("[country]", strtoupper($proxyKey),
                    //     $otherProxyUrlValue['url']), $otherProxyUrlValue['referer']
                    // );
                    // var_dump($strResponse);
                    // $listProxy[$proxyKey] = $this->set_other_proxy_data($strResponse);
                }
            }
        }
    }

    function set_other_proxy_data ($strHtml)
    {
        $domDocument = new DOMDocument();
        $domDocument->loadHTML($strHtml);
        $strXml = $domDocument->saveXML();

        $objXml = simplexml_load_string($strXml);

        var_dump($objXml);
        if (count($objXml['body']['table'][1]['tr'][2]['td']['table']['tr']) >= 3) {
            var_dump($objXml['body']['table'][1]['tr'][2]['td']['table']['tr'][3]);
        }

        // exit;
    }

    function proxy_request ($strUrl, $strReferer = null, $intTimeOut = 0)
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $strUrl);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POST, false);
        curl_setopt($handle, CURLOPT_USERAGENT, USER_AGENT);
        if (!empty($strReferer)) {
            curl_setopt($handle, CURLOPT_REFERER, $strReferer);
        }
        curl_setopt($handle, CURLOPT_TIMEOUT, $intTimeOut);
        usleep(10000);   // requestエラーにならないようにちょっと待つ
        $data = curl_exec($handle);
        curl_close($handle);
        return $data;
    }

    function object2array($obj)
    {
        $arr = $obj;
        if (is_object($arr)) {
            $arr = (array)$arr;
        }
        if (is_array($arr)) {
            foreach ($arr as &$a) {
                if (is_object($a)) {
                    $a = (array)$a;
                }
                $a = $this->object2array($a);
            }
        }
        return $arr;
    }

    function file_write_print_array ($data, $fileName, $mode = "wb")
    {
        ob_start();
        foreach ($data as $datakey => $dataValue) {
            if (is_array($dataValue)) {
                print_r("\n" . '        array(' . "\n");
                foreach ($dataValue as $arraykey => $arrayvalue) {
                    print_r('            "' . $arraykey . '" => "' . $arrayvalue . '",' . "\n");
                }
                print_r('        )' . "\n");
            } else {
                print_r($dataValue);
            }
        }
        $result = ob_get_contents();
        ob_end_clean();
        $fp = fopen($fileName, $mode);
        fputs($fp, $result);
        fclose($fp);
    }

    function get_proxy_ip ($arrProxy)
    {
        if (count($arrProxy["tr"]) < 2) return "";

        $arrProxyIp = array("response_time" => 999, "ip" => "");
        for ($i = 1; $i < count($arrProxy["tr"]); $i++) {
            $doubleResponseTime = (double)str_replace("s", "", trim($arrProxy["tr"][$i]["td"][2]));
            if ($arrProxyIp["response_time"] > $doubleResponseTime) {
                $arrProxyIp["response_time"] = $doubleResponseTime;
                $arrProxyIp["ip"] = trim($arrProxy["tr"][$i]["td"][0]["strong"]);
            }
        }
        // var_dump($arrProxyIp);exit;
        return $arrProxyIp["ip"];
    }

    function fetch_proxy_url_single ($listOptions, $intTimeOut = 600)
    {
        // $dateStartTime = date("Y/m/d H:i:s");
        $arrResponse = array();
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
            // FileUtility::file_write_print($strResponse, DATA_DIR . DIRECTORY_SEPARATOR . $listOptions[$i]['file_name']);
            $arrResponse[$listOptions[$i]['country']] = $strResponse;
        }
        return $arrResponse;
    }

    // ランキングデータを取得し、ファイルに保存する
    function fetch_proxy_url ($listOptions, $intTimeOut = 600)
    {
        $listConn = array(count($listOptions));
        foreach ($listOptions as $i => $optionsVal) {
            $listConn[$i] = curl_init($optionsVal['target_url']);
        }

        $mh = curl_multi_init();
        foreach ($listConn as $i => $connVal) {
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

        // $res = array();
        $listResponse = array(count($listConn));
        $strResponse = null;
        foreach ($listConn as $i => $conn) {
            $strResponse = null;
            if (($err = curl_error($conn)) == '') {
                $strResponse = curl_multi_getcontent($conn);
                $listResponse[$listOptions[$i]['country']] = $strResponse;
                // FileUtility::file_write_print($strResponse, DATA_DIR . DIRECTORY_SEPARATOR . $listOptions[$i]['file_name']);
            } else {
                var_dump(curl_error($conn));
                var_dump('取得に失敗しました:'.$listOptions[$i]['target_url'] . '  ' . $listOptions[$i]['proxy_host'] . ':' . $listOptions[$i]['proxy_port']);
            }
            curl_multi_remove_handle($mh, $conn);
            curl_close($conn);
        }
        curl_multi_close($mh);
        return $listResponse;
    }
}