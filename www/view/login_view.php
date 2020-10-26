<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>ログイン</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'login.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <div class="container">
    <h1>ログイン</h1>

    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <form method="post" action="login_process.php" class="login_form mx-auto">
      <input type="hidden" name="token" value="<?php print $token; ?>">
      <div class="form-group">
        <label for="name">名前: </label>
        <input type="text" name="name" id="name" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">パスワード: </label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <input type="submit" value="ログイン" class="btn btn-primary">
    </form>
    <p>(1) 本ページは架空のECサイトです。</p>
    <p>(2) お好きなユーザー名・パスワードを登録し、ログインしてください。</p>
    <p>(3) 名前「adminuser」、パスワード「ecadmin2020」でログインすると、管理者として商品管理機能が利用できます。</p>
  </div>
</body>
</html>