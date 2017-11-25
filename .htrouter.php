<?php

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if ($uri !== '/' && file_exists(__DIR__ . '/webroot' . $uri)) {
    return false;
}
$_GET['_url'] = $_SERVER['REQUEST_URI'];

require __DIR__ . '/webroot/index.php';
