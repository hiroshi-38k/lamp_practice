<?php
// 設定ファイル読込
require_once '../conf/const.php';
// 関数ファイル読込
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'history.php';
// セッション開始
session_start();
// トークン生成
$token = get_token();
// ログインしていなければログイン画面へリダイレクト
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
// DB接続
$db = get_db_connect();
// ユーザ情報取得
$user = get_login_user($db);
// ユーザの購入履歴情報取得
$histories = get_user_histories($db, $user['user_id'], $user['type']);
// HTMLエンティティ化
$user = entity_array($user);
$histories = entity_arrays($histories);
// 購入履歴ページのviewファイル出力
include_once VIEW_PATH . 'history_view.php';