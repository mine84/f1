<?PHP
date_default_timezone_set('Asia/Tokyo');
// 各ディレクトリ
define('BASE_DIR', dirname(dirname(__FILE__)));
define('CONF_DIR',  BASE_DIR . DIRECTORY_SEPARATOR . 'conf');
define('LOG_DIR',  BASE_DIR . DIRECTORY_SEPARATOR . 'log');
define('LIB_DIR',  BASE_DIR . DIRECTORY_SEPARATOR . 'lib');
define('SRC_DIR',  BASE_DIR . DIRECTORY_SEPARATOR . 'src');
define('BIN_DIR',  BASE_DIR . DIRECTORY_SEPARATOR . 'bin');
define('DATA_DIR',  BASE_DIR . DIRECTORY_SEPARATOR . 'data');
define('IOS_DATA_DIR',  BASE_DIR . DIRECTORY_SEPARATOR . 'data_ios');
define('ANDROID_DATA_DIR',  BASE_DIR . DIRECTORY_SEPARATOR . 'data_android');
define('MODEL_DIR',  BASE_DIR . DIRECTORY_SEPARATOR . 'model');
define('WEB_DIR',  BASE_DIR . DIRECTORY_SEPARATOR . 'htdocs');
define('JS_DIR',  WEB_DIR . DIRECTORY_SEPARATOR . 'js');
define('CSS_DIR',  WEB_DIR . DIRECTORY_SEPARATOR . 'css');
define('IMAGE_DIR',  WEB_DIR . DIRECTORY_SEPARATOR . 'images');

// smarty
define('SMARTY_DIR', LIB_DIR . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR);
define('VIEW_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
define('SMARTY_TEMPLATES_DIR', VIEW_DIR . 'templates' . DIRECTORY_SEPARATOR);
define('SMARTY_COMPILE_DIR', VIEW_DIR . 'templates_c'. DIRECTORY_SEPARATOR);
define('SMARTY_CACHE_DIR', VIEW_DIR . 'cache' . DIRECTORY_SEPARATOR);
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php');


// define('WEB_DIR', '/pointmanage/');

// DataBase
// define('DB_HOST', 'logmaster01.ccni5b2dmuq9.ap-northeast-1.rds.amazonaws.com'); // 本番用ホスト
define('DB_HOST', 'localhost'); // テスト用ホスト
define('DB_NAME', 'ranking');   // DB
define('DB_USER', 'logmaster'); // ユーザ
define('DB_PASS', 'd2cd2cd2c'); // パスワード

// smarty
// define('SMARTY_TEMPLATES_DIR', VIEW_DIR . 'templates'   . DIRECTORY_SEPARATOR);
// define('SMARTY_COMPILE_DIR',   VIEW_DIR . 'templates_c' . DIRECTORY_SEPARATOR);
// define('SMARTY_CACHE_DIR',     VIEW_DIR . 'cache'       . DIRECTORY_SEPARATOR);



?>
