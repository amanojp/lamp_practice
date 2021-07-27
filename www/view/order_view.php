<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入履歴</h1>
  <div class="container">

    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <?php if(count($orders) > 0){ ?>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <?php if($user['type']===1){?>
            <th><?php print('ユーザー'); ?></th>
            <?php } ?>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>金額</th>
            <th>購入明細</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($orders as $order){?>
          <tr>
            <?php if($user['type']===1){?>
              <td><?php print($order['name']); ?></td>
            <?php } ?>
            <td><?php print($order['order_number']); ?></td>
            <td><?php print(date('Y年n月j日 H時i分s秒',strtotime($order['order_datetime']))); ?></td>
            <td><?php print(number_format($order['order_total'])); ?>円</td>
            <td>
              <form method="post" action="order_detail.php">
                <input type="submit" value="表示" class="btn btn-secondary">
                <input type="hidden" name="order_number" value="<?php print($order['order_number']); ?>">
                <input type="hidden" name="token" value="<?php print ($_SESSION['csrf_token']); ?>">
              </form>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>注文履歴はありません。</p>
    <?php } ?> 
  </div>
</body>
</html>