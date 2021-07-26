<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'order.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

if(check_token()=== false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$order_number = get_post('order_number');

$details = get_order_detail($db, $order_number);
$details = sanitize($details);

$total_price = sum_detail($details);

include_once VIEW_PATH . 'order_detail_view.php';