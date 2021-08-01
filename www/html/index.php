<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$current_page = get_current_page('page');
$all_items = count_items($db);
$all_pages = count_pages($db);
$start = check_start($current_page);

$items = get_open_items($db, $start);
$items = sanitize($items);

//フレーム内のページ表示を全ドメインで禁止
header('X-Frame-Options:DENY');

include_once VIEW_PATH . 'index_view.php';