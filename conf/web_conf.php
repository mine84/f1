<?php

if (!empty($_SERVER)) {
    define('DOMAIN', $_SERVER['HTTP_HOST']);
    define('BASE_URL', 'http://' . DOMAIN . '/');
    define('BASE_SSL_URL', 'https://' . DOMAIN . '/');
    define('JS_URL', BASE_URL . 'js');
    define('CSS_URL', BASE_URL . 'css');
    define('IMAGE_URL', BASE_URL . 'images');
    define('LESS_URL', BASE_URL . 'less');
}