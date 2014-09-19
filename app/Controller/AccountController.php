<?php
class AccountController extends AppController
{
	function index()
	{
		$data1 = 'アカウント';
		$this->set('data1',$data1);
		/*ログイン*/
		//test用メールアドレス、パスワード
		$test_mail_address = '1234@567.com';
		$test_password = '1234567';
		$data2 = $this->Account->login($test_mail_address,$test_password);
		if($data2 != null){
			$this->set('data2',$data2['user_id']);
		}else{
			$this->set('data2','ログインエラー');
		}
		/*新規アカウント登録*/
		//test用メールアドレス、パスワード
		$test_mail_address = 'qwerty1@qwerty.com';
		$test_password = 'qwerty';
		$data3 = $this->Account->regist($test_mail_address,$test_password);
		if($data3 != null){
			$this->set('data3',$data3['user_id']);
		}else{
			$this->set('data3','登録済みアドレスエラー');
		}
	}

	function regist()
	{
		//inputでtrueを指定しないと(連想)配列にならないらしい。
		$postData = $this->request->input('json_decode',true);
		$registParams = $postData['params'];
		$registMailAddress = $registParams['mail_address'];
		$registPassword = $registParams['password'];
		$registAccount = $this->Account->regist($registMailAddress, $registPassword);
		if($registAccount == null){
			$status = 'ng';
			$errorMessage = 'this account already exsit.';
		}else{
			$status = 'ok';
			$errorMessage = null;
		}
		$result = ['status' => $status,'data' => $registAccount, 'error' => $errorMessage];
		$this->viewClass = 'Json';
        $this->set(compact('result'));
        $this->set('_serialize', 'result');
	}

	function login()
	{
		$postData = $this->request->input('json_decode',true);
		$loginParams = $postData['params'];
		$loginMailAddress = $loginParams['mail_address'];
		$loginPassword = $loginParams['password'];
		$loginAccount = $this->Account->login($loginMailAddress, $loginPassword);
		if($loginAccount != null){
			$status = 'ok';
			$errorMessage = null;
		}else{
			$status = 'ng';
			$errorMessage = 'this password is wrong.';
		}
		$result = ['status' => $status,'data' => $loginAccount, 'error' => $errorMessage];
		$this->viewClass = 'Json';
        $this->set(compact('result'));
        $this->set('_serialize', 'result');
	}
}
?>