<?php
// 設定ファイル読込
require_once '../conf/const.php';
// 関数ファイル読込
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
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
  // DB接続
  $db = get_db_connect();
  // ログインユーザ情報取得
  $user = get_login_user($db);
  // POST値取得
  $cart_id = get_post('cart_id');
  // カートから商品削除
  if(delete_cart($db, $cart_id)){
    // 正常メッセージ
    set_message('カートを削除しました。');
  } else {
    // 異常メッセージ
    set_error('カートの削除に失敗しました。');
  }
}
// cart.phpにリダイレクト
redirect_to(CART_URL);