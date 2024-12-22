<?php
session_start ();
require_once __DIR__ .  '/../../logic/common/common_logic.php';

$valiable_ct = new valiable_ct ();
$data = $valiable_ct->main_control ( $_POST );

// AJAXへ返却
echo json_encode ( compact ( 'data' ) );
class valiable_ct {
	private $common_logic;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		// 管理画面ユーザーロジックインスタンス
		$this->common_logic = new common_logic ();
	}

	/**
	 * コントローラー
	 * 各処理の振り分けをmethodの文字列により行う
	 *
	 * @param unknown $post
	 */
	public function main_control($post) {
		if ($post ['method'] == 'depricate_check') {
			$data = $this->depricate_check ( $post );
		}

		return $data;
	}

	/**
	 * 重複チェック
	 */
	private function depricate_check($post) {

		$base = $this->common_logic->select_logic(" ( select `member_id` as `id`, `mail` as `target` from t_member where mail = ? ) UNION ALL  ( select `store_basic_id` as `id`, `mail` as `target` from t_store_basic where `mail` = ? ) ", array(
				$post['val'],
				$post['val'],
		));
		$double_flg = false;
		if($base != null && $base != ''){
			if($post['own'] != $base[0]['id']){
				$double_flg = true;
			}
		}
		return array(
				'status' => true,
				'double_flg' => $double_flg,
		);


	}

}
