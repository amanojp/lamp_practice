<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// DB利用

//ユーザー別購入履歴 注文番号、購入日時、注文合計金額
function get_order_history($db, $user_id, $type){
  if($type === 1){
    $sql = "
      SELECT users.name, order_detail.order_number, SUM(order_detail.amount*order_detail.price) AS order_total, order_history.order_datetime
      FROM order_history JOIN order_detail ON order_history.order_number = order_detail.order_number
      JOIN users ON users.user_id = order_history.user_id
      GROUP BY order_detail.order_number
      ORDER BY order_history.order_datetime DESC
    ";
    return fetch_all_query($db, $sql);
  }else{
    $sql = "
      SELECT order_detail.order_number, SUM(order_detail.amount*order_detail.price) AS order_total, order_history.order_datetime
      FROM order_history JOIN order_detail ON order_history.order_number = order_detail.order_number
      WHERE order_history.user_id = ?
      GROUP BY order_detail.order_number
      ORDER BY order_history.order_datetime DESC
    ";
    return fetch_all_query($db, $sql, array($user_id));
  }
}

//購入明細画面 商品名、購入時商品価格、購入数、小計、注文番号、購入日時
function get_order_detail($db, $order_number){
  $sql = "
    SELECT  order_history.order_number, items.image, items.name, order_detail.price, order_detail.amount,
      order_detail.price*order_detail.amount AS total ,order_history.order_datetime
    FROM order_history JOIN order_detail ON order_history.order_number = order_detail.order_number
    RIGHT JOIN items ON order_detail.item_id = items.item_id
    WHERE order_history.order_number = ?
  ";

  return fetch_all_query($db, $sql, array($order_number));
}

//注文履歴Tableへの登録
function insert_order_history($db, $user_id){
  $sql = "
    INSERT INTO
      order_history(
        user_id
      )
    VALUES(?);
  ";

  return execute_query($db, $sql, array($user_id));
}

//注文詳細Tableへの登録
function insert_order_detail($db, $order_number, $item_id, $amount, $price){
  $sql = "
    INSERT INTO
      order_detail(
        order_number,
        item_id,
        amount,
        price
      )
    VALUES(?, ?, ?, ?);
  ";

  return execute_query($db, $sql, array($order_number, $item_id, $amount, $price));
}

//DB以外

function sum_detail($details){
  $total_price = 0;
  foreach($details as $detail){
    $total_price += $detail['total'];
  }
  return $total_price;
}