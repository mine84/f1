<?php
define("TWITTER_LIMIT", 200);           // 取得件数
define('TWITTER_TIMELINE_URL', 'https://api.twitter.com/1.1/statuses/user_timeline.json');
define('TWITTER_GET_COUNT', "200");

// user agent
define("USER_AGENT", 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.149 Safari/537.36');


define('F1_NEWS_SITE_URL',
    serialize(
        array(
            'F1-Gate.com' => '',
            'STRINGER' => '',
            'F1通信' => '',
        )
    )
);

define('F1_NEWS_RSS_URL',
    serialize(
        array(
            'F1-Gate.com' => '',
            'STRINGER' => '',
            'F1通信' => '',
        )
    )
);

define('F1_NEWS_TWITTER_URL',
    serialize(
        array(
            'redbullf1spy' => '',
            'InsideFerrari' => '',
            'McLarenF1' => '',
            '' => '',
            '' => '',
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