<?php
class Account extends AppModel
{
	public $useTable = 'users';
	//アカウント新規登録
	function regist($mail_address, $password)
	{
		//新規登録メールアドレスかどうか確認。
		$is_this_new_data = $this->find('all',array(
			'conditions' => array('mail_address' => $mail_address)));
		if(count($is_this_new_data) === 0){
			$this->set(array(
				'mail_address' => $mail_address,
				'password' => $password
				));
			$this->save();
			$request_token = array(
				'user_id' => $this->id,
				'mail_address' => $mail_address,
				'password' => $password
				);
		}else{
			$request_token = null;
		}
		return $request_token;
	}

	//ログインは、ios側で新規登録を試みた後、既に存在するアカウントだと分かった場合のみ呼び出されるものとする。
	function login($mail_address, $password)
	{
		//データベースからmail_addressが一致するアカウントデータを見つけ出し、パスワードを確認。
		//パスワードが違ったらエラーメッセージを出力。
		$tmp = $this->find('first',array(
					'conditions'=>array(
					'mail_address' => $mail_address,
					)));
		$data = $tmp['Account'];
		if($data['password'] != $password){
			$data = null;
		}
		return $data;
	}
}
?>