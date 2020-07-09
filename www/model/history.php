<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';
// ユーザの購入履歴情報取得
function get_user_histories($db, $user_id, $type){
  if($type === 1){
    // 管理ユーザは全ての購入履歴取得
    return get_histories($db);
  } else if ($type === 2) {
    // 一般ユーザは自分の購入履歴のみ取得
    return get_histories($db, $user_id, false);
  }

  return array();
}
// 購入履歴取得
function get_histories($db, $user_id = "", $is_all = true) {
  // SQL文作成
  $sql = "
    SELECT
      histories.history_id,
      histories.created,
      SUM(price*amount) AS sum
    FROM histories
    INNER JOIN details ON histories.history_id=details.history_id
  ";
  if($is_all === false){
    $sql .= "
      WHERE user_id = ?
    ";
  }
  $sql .= "
    GROUP BY histories.history_id
    ORDER BY histories.history_id DESC
  ";
  // クエリを実行し、成功すればレコード全て（２次元）を返し、失敗すればfalseを返す
  if($is_all === false){
    return fetch_all_query($db, $sql, array($user_id));
  }
  return fetch_all_query($db, $sql);
}
// ユーザの購入明細情報取得
function get_user_details($db, $history_id, $user_id, $type){
    if($type === 1){
      // 管理ユーザは全ての購入明細が取得可能
      return get_details($db, $history_id);
    } else if ($type === 2) {
      // 一般ユーザは自分の購入履歴のみ取得可能
      return get_details($db, $history_id, $user_id, false);
    }
  
    return array();
}
// 購入明細取得
function get_details($db, $history_id, $user_id = "", $is_all = true){
  // SQL文作成
  $sql = "
    SELECT
    histories.history_id,
    histories.created,
    items.name,
    details.price,
    details.amount,
    details.price*details.amount AS subtotal
    FROM histories
    INNER JOIN details ON histories.history_id=details.history_id
    INNER JOIN items ON details.item_id=items.item_id
    WHERE histories.history_id = ?
  ";
  if($is_all === false){
    $sql .= "
      AND user_id = ?
    ";
  }
  // クエリを実行し、成功すればレコード全て（２次元）を返し、失敗すればfalseを返す
  if($is_all === false){
    return fetch_all_query($db, $sql, array($history_id, $user_id));
  }
  return fetch_all_query($db, $sql, array($history_id));
}
// 合計金額取得
function get_details_total($details){
    $total=0;
    if(count($details) === 0){
      return $total;
    }
    foreach($details as $detail){
      $total += $detail['subtotal'];
    }
    return $total;
}