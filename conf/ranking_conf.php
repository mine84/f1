<?php
define("LIMIT", 200);           // 取得件数
define("ANDROID_NUM", 100);     // androidの一回の取得件数

define("DISP_RANKING_LIMIT", LIMIT);    // ランキング表示件数
define("DISP_MATRIX_LIMIT", 5);         // マトリックス表示件数

// OS
define("IOS", 1);
define("ANDROID", 2);

// user agent
define("USER_AGENT", 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.149 Safari/537.36');

define("IOS_TARGET_DOMAIN", 'itunes.apple.com');    // ios Storeドメイン
define("IOS_TARGET_PORT", 443);                     // ios Store port

define("ANDROID_TARGET_DOMAIN", 'play.google.com'); // android Storeドメイン
define("ANDROID_TARGET_PORT", 443);                 // android Store port


// 配列を無理矢理 define に設定
define("OS_LIST", serialize(array("ios" => IOS, "android" => ANDROID,)));
define("RANKING_URL_LIST", serialize(array(IOS => "http://itunes.apple.com/", ANDROID => "https://play.google.com/store/apps/",)));

// get proxy でのproxy取得APIのKEY
define("GET_PROXY_KEY", "913667f6db9b80deab3be4407545371d456cb3df");
/*
get proxy でのproxy取得APIのURL
参考URL：http://www.getproxy.jp/api/
パラメータ
piKey(必須)
area(必須)    国別コード(大文字)  国別コード表に参照
page    1～100
type    all,https
sort    requesttime,updatetime  requesttime:Request Time順,updatetime:Check Date順
orderby asc,desc    asc:昇順,desc:降順
*/
define("GET_PROXY_URL", "http://www.getproxy.jp/proxyapi?ApiKey=" . GET_PROXY_KEY . "&area=[country]&sort=requesttime&orderby=asc");
define("GET_PROXY_HTTP_URL", "http://www.getproxy.jp/[country]");
define("GET_PROXY_COUNTRY",
    serialize(
        array(
            "fr" => "france",       // フランス
            "de" => "germany",      // ドイツ
            "gb" => "uk",           // イギリス
            "es" => "spain",        // スペイン
            "ru" => "russia",       // ロシア
            "us" => "russia",       // アメリカ
            "ca" => "canada",       // カナダ
            "au" => "australia",    // オーストラリア
            "ph" => "philippines",  // フィリピン
            "id" => "indonesia",    // インドネシア
            "in" => "india",        // インド
        )
    )
);
define("GET_PROXY_ERROR_MSG_NOTHING", "データーがありませんです。");
define("GET_PROXY_ERROR_MSG_LOCK", "サーバは一時的な過負荷かサーバのメンテナンスの為現在リクエストを扱うことができません。一定時間ロックがかかりますので、リクエストが再び利用できるようになるまでしばらくお待ちください。");

// その他取得できないProxyは以下のサイトから取得する。とりあえず、今は一個のサイトのみ
// 今はgetter proxyのサイトのみから取得
define("OTHOER_PROXY_URL_LIST",
    serialize(
        array(
            array(
                "url" => "http://spys.ru/free-proxy-list/[country]/",
                'referer' => "",
            ),
        )
    )
);

// 配列を無理矢理 define に設定した値を取得するクラス
class RankingConf
{
    /*
     var_dump(RankingConf::get('OS_LIST')->data);
     var_dump(RankingConf::get('RANKING_URL_LIST')->data[IOS]);
     var_dump(RankingConf::get('OS_LIST')->data);
     var_dump(RankingConf::get('OS_LIST')->data['ios']);
    */
    // defineに設定した配列を取得。使い方は上を参照してください。
    function get($strDefineName)
    {
        eval('$conf = unserialize(' . $strDefineName . ');');
        $obj = new stdClass;
        $obj->data = $conf;
        return $obj;
    }
}