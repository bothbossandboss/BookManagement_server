<?php
class Book extends AppModel
{
	//bookmanagerのテーブルを指定。
	public $useTable = 'books';
	//書籍一覧取得
	function get($request_token, $page)
	{
		//findの条件指定方法に注意
		$data = $this->find('all',array(
			'conditions' => array('user_id' => $request_token['user_id'])
			));
		$numOfData = count($data);
		if($numOfData === 0){
			//データなし
			//echo 'このユーザーのデータはありません';
			$bookdata = null;
		}else{
			$k = 0;
			$bookdata = array();
			//１冊目、２冊目と数えるのに、配列は0スタートなので調整。
			if($numOfData < $page['begin'] || $numOfData < $page['numOfPage']){
				//request:17-10 real:0~5 要素数自体が足りない。
				//もしくはrequest:7-10 real:0~6　10冊も登録がない。
				$firstI = $numOfData;
				$endI = 0;
			}elseif ($page['begin'] < $page['numOfPage']) {
				//最後の方の10冊以下の読み込み。
				$firstI = $page['begin'] - 1;
				$endI = 0;
			}else{
				$firstI = $page['begin'] - 1;
				$endI = $page['begin'] - $page['numOfPage'];
			}
			if($page['position'] === 'latest' ){
				$firstI = $numOfData - 1;
				$endI = $numOfData - $page['numOfPage'];
			}
			for ($i=$firstI; $i >= $endI; $i--){
				$tmp = $data[$i];
				$tmp1 = $tmp['Book'];  //Model名が付いてしまうようです。
				$tmp2 = array(
					'image_url' => $tmp1['image_url'],
					'title' => $tmp1['name'],
					'price' => $tmp1['price'],
					'purchase_date' => $tmp1['purchase_date']
					);
				//配列にインデックスを付けないとios側の処理で困る。+=は加算の配列演算。
				//この時bookdataはarrayであると予め定義しておく必要がある。
				$bookdata += array('array'.$k => $tmp2);
				$k++;
			}
			$bookdata += array('numOfBooks' => $numOfData);
		}
		return $bookdata;
	}

	//新規書籍登録
	function regist($request_token, $book_name, $price, $purchase_date, $image)
	{
		$isThisNewData = $this->find('all',array(
			'conditions' => array(
				'user_id' => $request_token['user_id'],
				'name' => $book_name
				)));
		if(count($isThisNewData) === 0){
			$this->set(array(
				'user_id' => $request_token['user_id'],
				'name' => $book_name,
				'price' => $price,
				'purchase_date' => $purchase_date,
				'image_url' => $image,
				));
			$this->save();
			//今登録(save)した本のidを取得
			$book_id = $this->id;
		}else{
			$book_id = null;
		}
		return $book_id;
	}

	//書籍更新
	function update($request_token, $book_id, $book_name, $price, $purchase_date, $image)
	{
		$tmp = array(
			'id' => $book_id,
			'user_id' => $request_token['user_id'],
			'image_url' => $image,
			'name' => $book_name,
			'price' => $price,
			'purchase_date' => $purchase_date,
			);
		$this->save($tmp);
		return $this->id;
	}
/*
	//画像のupload
	function addImage($image)
	{
		//画像の要領のチェック
		$limit = 1024*1024;
		if($this->data['Image']['image']['size'] > $limit){
			echo 'ファイルサイズオーバーです。';
		}
		//アップロードされた画像かどうか
		if(!is_uploaded_file($this->data['Image']['image']['tmp_name'])){
			echo 'アップロードされた画像ではありません。';
		}
		//保存
		$image = array(''



			);

	}
*/
}
?>