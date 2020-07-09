<?php
// 設定ファイル読込
require_once '../conf/const.php';
// 関数ファイル読込
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'history.php';
// iframe読込禁止
header('X-FRAME-OPTIONS: DENY');
// セッション開始
session_start();
// ログインしていなければログイン画面へリダイレクト
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
// トークンのバリデーション
if(is_valid_token() === true){
  // DB接続
  $db = get_db_connect();
  // ユーザ情報取得
  $user = get_login_user($db);
  // POST値取得
  $history_id = get_post('history_id');
  // ユーザの購入明細取得
  $details = get_user_details($db, $history_id, $user['user_id'], $user['type']);
  // 合計金額取得
  $total = get_details_total($details);
  // HTMLエンティティ化
  $user = entity_array($user);
  $details = entity_arrays($details);
  // 購入明細ページのviewファイル出力
  include_once VIEW_PATH . 'detail_view.php';
} else {
  redirect_to(HISTORY_URL);
}
