<?php
// 設定ファイルの読込
require_once '../conf/const.php';
// 関数ファイルの読込
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
// iframe読込禁止
header('X-FRAME-OPTIONS: DENY');
// セッション開始
session_start();
// ログインしていなければログイン画面へリダイレクト
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
// DB接続
$db = get_db_connect();
// ユーザ情報取得
$user = get_login_user($db);
// ユーザ情報取得が失敗した場合はログイン画面へリダイレクト
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}
// トークンのバリデーション
if(is_valid_token() === true){
  // POST値取得
  $item_id = get_post('item_id');
  $stock = get_post('stock');
  // item_id照会：商品テーブルの在庫情報を更新
  if(update_item_stock($db, $item_id, $stock)){
    // 正常メッセージ
    set_message('在庫数を変更しました。');
  } else {
    // 異常メッセージ
    set_error('在庫数の変更に失敗しました。');
  }
  // admin.phpへリダイレクト
  redirect_to(ADMIN_URL);
}