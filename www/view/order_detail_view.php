<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入明細</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入明細</h1>
  <div class="container">

    <?php include VIEW_PATH . 'templates/messages.php'; ?>
      <p>注文番号：<?php print($order_number); ?></p>
      <p>購入日時：<?php print(date('Y年n月j日 H時i分s秒',strtotime($details['0']['order_datetime']))); ?></p>
      <p>合計金額：<?php print(number_format($total_price)); ?>円</p>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>            
            <th>商品画像</th>
            <th>商品名</th>
            <th>商品価格（購入時）</th>
            <th>数量</th>
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($details as $detail){?>
          <tr>
            <td><img src="<?php print(IMAGE_PATH . $detail['image']);?>" class="item_image"></td>
            <td><?php print($detail['name']); ?></td>
            <td><?php print(number_format($detail['price'])); ?>円</td>
            <td><?php print(number_format($detail['amount'])); ?></td>
            <td><?php print(number_format($detail['total'])); ?>円</td>            
          </tr>
          <?php } ?>
        </tbody>
      </table>
  </div>
</body>
</html>