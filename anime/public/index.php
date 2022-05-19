<?php
//difine(定数名, 値) 定義する関数
//str_replace('置き換える','置き換え後','対象')
define('ROOT_PATH', str_replace('public', '', $_SERVER["DOCUMENT_ROOT"]));
//parse_urlは連想配列にして返す
$parse = parse_url($_SERVER["REQUEST_URI"]);
//ファイル名が省略されていた場合、index.phpを補填する
//日本語の文字列を取得時、mb_substr()
if(mb_substr($parse['path'], -1) === '/') {
  $parse['path'] .= $_SERVER["SCRIPT_NAME"];
}
require_once(ROOT_PATH.'Views'.$parse['path']);
?>
