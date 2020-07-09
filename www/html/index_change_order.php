<?php
// 設定ファイル読込
require_once '../conf/const.php';
// 関数ファイル読込
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
// iframe読込禁止
header('X-FRAME-OPTIONS: DENY');
// セッション開始
session_start();
// ログインしていない場合ログイン画面にリダイレクト
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
// トークンのバリデーション
if(is_valid_token() === true){
  // トークン生成
  $token = get_token();
  // DB接続
  $db = get_db_connect();
  // ログインユーザ情報取得
  $user = get_login_user($db);
  // POST値取得
  $change_order = get_post('change_order');
  // 購入可能な商品の情報を取得
  $items = get_open_items($db, $change_order);
  // HTMLエンティティ化
  $user = entity_array($user);
  $items = entity_arrays($items);
  // ホームページのviewファイル出力
  include_once VIEW_PATH . 'index_view.php';
} else {
// ホームページにリダイレクト
redirect_to(HOME_URL);
}