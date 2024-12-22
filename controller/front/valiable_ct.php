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
		}elseif ($post ['method'] == 'add_fav') {
			$data = $this->add_fav ( $post );
		}elseif ($post ['method'] == 'delete_fav') {
			$data = $this->delete_fav ( $post );
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


	/**
	* お気に入り処理
	*/
	private function add_fav($post) {
		$fav_res = false;
		$login = false;
		if($_SESSION['jis']['login_member']['member_id'] != null && $_SESSION['jis']['login_member']['member_id'] != ''){
			$login = true;
			$store = $this->common_logic->select_logic("select * from t_tour where tour_id = ? ", array($post['tour_id']));
			$fav = $this->common_logic->select_logic("select * from t_member_favorite where tour_id = ? and member_id = ? ", array($post['tour_id'], $_SESSION['jis']['login_member']['member_id']));
			if($fav == null || $fav == ''){
				$fav_res = true;
				$this->common_logic->insert_logic("t_member_favorite", array(
						$_SESSION['jis']['login_member']['member_id'],
						$store[0]['store_basic_id'],
						$post['tour_id'],
						0
				));
			}

		}

		return array(
				'status' => true,
				'fav_res' => $fav_res,
				'login' => $login,
		);
	}

	/**
	 * お気に入り処理
	 */
	private function delete_fav($post) {
		$this->common_logic->delete_row_logic("DELETE from t_member_favorite where member_favorite_id = ? ", array($post['fav']));
		return array(
				'status' => true,
		);


	}

}
