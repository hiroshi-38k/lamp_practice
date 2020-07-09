<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// DB利用
// 指定の商品情報取得
function get_item($db, $item_id){
  $sql = "
    SELECT
      item_id, 
      name,
      stock,
      price,
      image,
      status
    FROM
      items
    WHERE
      item_id = ?
  ";

  return fetch_query($db, $sql, array($item_id));
}
// 商品情報取得
function get_items($db, $change_order, $is_open = false){
  // SQL文作成
  $sql = '
    SELECT
      item_id, 
      name,
      stock,
      price,
      image,
      status
    FROM
      items
  ';
  if($is_open === true){
    $sql .= '
      WHERE status = 1
    ';
  }
  // 商品の並び順を指定
  $sql = change_order($sql, $change_order);
  // クエリを実行し、成功すればレコード全て（２次元）を返し、失敗すればfalseを返す
  return fetch_all_query($db, $sql);
}
// 全商品情報を取得
function get_all_items($db, $change_order = ""){
  return get_items($db, $change_order = "");
}
// 購入可能な商品の情報を取得
function get_open_items($db, $change_order = ""){
  return get_items($db, $change_order, true);
}
// 商品の並び順を指定
function change_order($sql, $change_order){
  if($change_order === "low_price"){
    $sql .= "
      ORDER BY price ASC
    ";
  } else if($change_order === "high_price") {
    $sql .= "
      ORDER BY price DESC
    ";
  } else {
    $sql .= "
      ORDER BY item_id DESC
    ";
  }
  return $sql;
}
// 商品テーブルに商品登録
function regist_item($db, $name, $price, $stock, $status, $image){
  // ファイルをアップロード
  $filename = get_upload_filename($image);
  // 商品情報のバリデーション
  if(validate_item($name, $price, $stock, $filename, $status) === false){
    return false;
  }
  // 商品登録処理成功でtrue、失敗でfalseを返す
  return regist_item_transaction($db, $name, $price, $stock, $status, $image, $filename);
}
// 商品登録処理
function regist_item_transaction($db, $name, $price, $stock, $status, $image, $filename){
  // トランザクション開始
  $db->beginTransaction();
  // 商品の登録処理と画像保存が成功：コミット
  if(insert_item($db, $name, $price, $stock, $filename, $status) 
    && save_image($image, $filename)){
    $db->commit();
    return true;
  }
  // 失敗:：ロールバック
  $db->rollback();
  return false;
  
}
// 商品登録
function insert_item($db, $name, $price, $stock, $filename, $status){
  // itemステータス取得
  $status_value = PERMITTED_ITEM_STATUSES[$status];
  // SQL文作成
  $sql = "
    INSERT INTO
      items(
        name,
        price,
        stock,
        image,
        status
      )
    VALUES(?, ?, ?, ?, ?);
  ";
  // クエリを実行し、成功すればtrue、失敗すればfalseを返す
  return execute_query($db, $sql, array($name, $price, $stock, $filename, $status_value));
}

function update_item_status($db, $item_id, $status){
  $sql = "
    UPDATE
      items
    SET
      status = ?
    WHERE
      item_id = ?
    LIMIT 1
  ";
  
  return execute_query($db, $sql, array($status, $item_id));
}
// item_id照会：商品の在庫情報を更新
function update_item_stock($db, $item_id, $stock){
  // SQL文作成
  $sql = "
    UPDATE
      items
    SET
      stock = ?
    WHERE
      item_id = ?
    LIMIT 1
  ";
  // クエリ実行が、成功でtrue、失敗でfalseを返す
  return execute_query($db, $sql, array($stock, $item_id));
}

function destroy_item($db, $item_id){
  $item = get_item($db, $item_id);
  if($item === false){
    return false;
  }
  $db->beginTransaction();
  if(delete_item($db, $item['item_id'])
    && delete_image($item['image'])){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
}

function delete_item($db, $item_id){
  $sql = "
    DELETE FROM
      items
    WHERE
      item_id = ?
    LIMIT 1
  ";
  
  return execute_query($db, $sql, array($item_id));
}


// 非DB

// item_status: 1（購入可能）かどうか確認
function is_open($item){
  // true or false で返す
  return $item['status'] === 1;
}
// 商品情報のバリデーション
function validate_item($name, $price, $stock, $filename, $status){
  // バリデーション実行
  $is_valid_item_name = is_valid_item_name($name);
  $is_valid_item_price = is_valid_item_price($price);
  $is_valid_item_stock = is_valid_item_stock($stock);
  $is_valid_item_filename = is_valid_item_filename($filename);
  $is_valid_item_status = is_valid_item_status($status);
  // バリデーションの結果を返す
  return $is_valid_item_name
    && $is_valid_item_price
    && $is_valid_item_stock
    && $is_valid_item_filename
    && $is_valid_item_status;
}
// nameのバリデーション
function is_valid_item_name($name){
  // 初期値: true
  $is_valid = true;
  // 文字数チェック
  if(is_valid_length($name, ITEM_NAME_LENGTH_MIN, ITEM_NAME_LENGTH_MAX) === false){
    // 異常メッセージ
    set_error('商品名は'. ITEM_NAME_LENGTH_MIN . '文字以上、' . ITEM_NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}
// priceのバリデーション
function is_valid_item_price($price){
  // 初期値: true
  $is_valid = true;
  if(is_positive_integer($price) === false){
    set_error('価格は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}
// stockのバリデーション
function is_valid_item_stock($stock){
  // 初期値: true
  $is_valid = true;
  // 0以上の整数かどうか確認
  if(is_positive_integer($stock) === false){
    // 異常メッセージ
    set_error('在庫数は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}
// filenameのバリデーション
function is_valid_item_filename($filename){
  // 初期値: true
  $is_valid = true;
  // filenameが存在するか確認
  if($filename === ''){
    $is_valid = false;
  }
  return $is_valid;
}
// statusのバリデーション
function is_valid_item_status($status){
  // 初期値: true
  $is_valid = true;
  // 指定したitemステータスの値になっているか確認
  if(isset(PERMITTED_ITEM_STATUSES[$status]) === false){
    $is_valid = false;
  }
  return $is_valid;
}