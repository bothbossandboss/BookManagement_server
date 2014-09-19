<?php
class BookController extends AppController
{
	public $components = array('Session', 'RequestHandler');
	/*画像ファイルアップッロードは保留で...*/
	function index()
	{
		//test用アカウント
		$request_token = array('user_id' => 3,
								'mail_address' => '01234@567.com',
								'password' => '01234567');
		/*新規書籍登録*/
		$data3 = $this->Book->regist($request_token,"nyanko dayo",12000,"2014/10/13",null);
		$this->set('data3',$data3);
		/*一覧取得*/
		$page = array('begin' => 5, 'numOfPage' => 10, 'position' => 'latest');
		//getの返り値は連想配列で、('image_url','name','price','purchase_date')
		$data4 = $this->Book->get($request_token,$page);
		$this->set('data4',$data4);
		/*書籍更新*/
		$data5 = $this->Book->update($request_token,10,'hoshi no shima no nyanko',1000,'2014/12/12',null);
		$this->set('data5',$data5);
	}
	public function test()
	{
		$request_token = array('user_id' => 3,
								'mail_address' => '01234@567.com',
								'password' => '01234567');
		$page = array('begin' => 6, 'numOfPage' => 10);
		$data = $this->Book->get($request_token,$page);
		$result = ['status' => 'complete', 'book_data' => $data];
		$this->viewClass = 'Json';
        $this->set(compact('result'));
        $this->set('_serialize', 'result');
	}

	function get()
	{
		$postData = $this->request->input('json_decode',true);
		$getParams = $postData['params'];
		$request_token = $getParams['request_token'];
		$page = $getParams['page'];
		$bookData = $this->Book->get($request_token,$page);
		if($bookData != null){
			$status = 'ok';
			$errorMessage = null;
		}else{
			$status = 'ng';
			$errorMessage = "this user don't have any books.";
		}
		$result = ['status' => $status,'data' => $bookData, 'error' => $errorMessage];
		$this->viewClass = 'Json';
        $this->set(compact('result'));
        $this->set('_serialize', 'result');
	}

	function regist()
	{
		$postData = $this->request->input('json_decode',true);
		$getParams = $postData['params'];
		$request_token = $getParams['request_token'];
		$book_name = $getParams['book_name'];
		$price = $getParams['price'];
		$purchase_date = $getParams['purchase_date'];
		$image = $getParams['image'];
		$book_id = $this->Book->regist($request_token, $book_name,$price,$purchase_date,$image);
		if($book_id != null){
			$status = 'ok';
			$errorMessage = null;
		}else{
			$status = 'ng';
			$errorMessage = "this book is already registed.";
		}
		$result = ['status' => $status,'data' => array('book_id' => $book_id), 'error' => $errorMessage];
		$this->viewClass = 'Json';
        $this->set(compact('result'));
        $this->set('_serialize', 'result');
	}

	function update()
	{
		$postData = $this->request->input('json_decode',true);
		$getParams = $postData['params'];
		$request_token = $getParams['request_token'];
		$book_id = $getParams['book_id'];
		$book_name = $getParams['book_name'];
		$price = $getParams['price'];
		$purchase_date = $getParams['purchase_date'];
		$image = $getParams['image'];
		$book_id = $this->Book->update($request_token, $book_id, $book_name, $price, $purchase_date, $image);
		if($book_id != null){
			$status = 'ok';
			$errorMessage = null;
		}else{
			$status = 'ng';
			$errorMessage = "cannot update";
		}
		$result = ['status' => $status,'data' => array('book_id' => $book_id), 'error' => $errorMessage];
		$this->viewClass = 'Json';
        $this->set(compact('result'));
        $this->set('_serialize', 'result');
	}
}
?>