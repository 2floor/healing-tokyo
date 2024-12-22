<?php
session_start ();
// header('Content-Type: applimemberion/json');

require_once __DIR__ .  '/../../logic/common/common_logic.php';
require_once __DIR__ .  '/../../logic/common/common_string_logic.php';
require_once __DIR__ .  '/../../logic/admin/member_logic.php';
require_once __DIR__ .  '/../../common/security_common_logic.php';

/**
 * セキュリティチェック
 */
// インスタンス生成
$security_common_logic = new security_common_logic ();

// XSSチェック、NULLバイトチェック
$security_result = $security_common_logic->security_exection ( $_POST, $_REQUEST, $_COOKIE );

// セキュリティチェック後の値を再設定
$_POST = $security_result [0];
$_REQUEST = $security_result [1];
$_COOKIE = $security_result [2];

// tokenチェック
$security_common_logic = new security_common_logic ();
$data = $security_common_logic->isTokenExection ();
if ($data ['status']) {
	// 正常処理 コントローラー呼び出し

	// インスタンス生成
	$member_ct = new member_ct ();

	// コントローラー呼び出し
	$data = $member_ct->main_control ( $_POST );
} else {
	// パラメータに不正があった場合
	// AJAX返却用データ成型
	$data = array (
			'status' => false,
			'input_datas' => $post,
			'return_url' => 'logout.php'
	);
}

// AJAXへ返却
echo json_encode ( compact ( 'data' ) );

/**
 * 管理画面ユーザー管理処理
 *
 * ViewからLogic呼び出しを行うclass。
 * 本クラスではLogic呼び出しやデータの成型、入力チェックのみを行うものとする。
 * ※：セキュリティ保持の為Logic呼び出元をmain_controlクラスのみとする。
 * 各ロジック呼び出しをクラス化し、かつ、privateとする。
 *
 * @author Seidou
 *
 */
class member_ct {
	private $member_ct;
	private $common_logic;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		// 管理画面ユーザーロジックインスタンス
		$this->member_logic = new member_logic ();
		$this->common_logic = new common_logic();
		$this->common_string_logic = new common_string_logic ();
	}

	/**
	 * コントローラー
	 * 各処理の振り分けをmethodの文字列により行う
	 *
	 * @param unknown $post
	 */
	public function main_control($post) {
		$member_ct = new member_ct ();
		if ($post ['method'] == 'init') {
			// 初期処理　HTML生成処理呼び出し
			$data = $member_ct->create_data_list ( $post );
		} else if ($post ['method'] == 'entry') {
			// 新規登録処理
			$data = $member_ct->entry_new_data ( $post );
		} else if ($post ['method'] == 'edit_init') {
			// 編集初期処理
			$data = $member_ct->get_detail ( $post ['edit_del_id'] );
		} else if ($post ['method'] == 'edit') {
			// 編集更新処理
			$data = $member_ct->update_detail ( $post );
		} else if ($post ['method'] == 'delete') {
			// 削除処理
			$data = $member_ct->delete ( $post ['id'] );
		} else if ($post ['method'] == 'recovery') {
			// 有効化処理
			$data = $member_ct->recovery ( $post ['id'] );
		} else if ($post ['method'] == 'private') {
			// 非公開化処理
			$data = $member_ct->private_func ( $post ['id'] );
		} else if ($post ['method'] == 'release') {
			// 公開化処理
			$data = $member_ct->release ( $post ['id'] );
		}

		return $data;
	}

	/**
	 * 初期処理(一覧HTML生成)
	 */
	private function create_data_list($post) {

		$list_html = $this->member_logic->create_data_list ( array (
				$post ['now_page_num'], // 現在のページ
				$post ['get_next_disp_page'], // 次に表示するページ
				$post ['page_disp_cnt'],
		),  $post ['search_select']);

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'empty' => '',
				'edit_menu_list_html' => $list_html ['entry_menu_list_html'],
				'html' => $list_html ['list_html'],
				'cnt' => $list_html ['all_cnt'],
				'pager_html' => $list_html ['pager_html'],
				'page_cnt' => $list_html ['page_cnt'],
		);

		return $data;
	}

	/**
	 * 新規登録処理
	 */
	private function entry_new_data($post) {

		$post['password'] = $this->common_logic->convert_password_encode($post['password']);

		// 登録ロジック呼び出し
		$this->member_logic->entry_new_data ( array (
				$post['name'],
				$post['mail'],
				$post['password'],
				$post['tel'],
				$post['sex'],
				$post['birthday'],
				$post['nationality'],
				$post['addr'],
				$post['icon'],
				$post['google_au'],
				$post['facebook_au'],
				$post['del_flg'],
		) );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'entry',
				'msg' => '登録しました'
		);

		return $data;
	}

	/**
	 * 編集初期処理(詳細情報取得)
	 *
	 * @param unknown $admin_user_id
	 */
	private function get_detail($member_id) {
		$reult_detail = $this->member_logic->get_detail ( $member_id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'name' => $reult_detail['name'],
				'mail' => $reult_detail['mail'],
				'tel' => $reult_detail['tel'],
				'sex' => $reult_detail['sex'],
				'birthday' => $reult_detail['birthday'],
				'nationality' => $reult_detail['nationality'],
				'addr' => $reult_detail['addr'],
				'icon' => $reult_detail['icon'],
				'del_flg' => $reult_detail['del_flg'],
				'member_id' => $reult_detail['member_id'],
			);

		return $data;
	}


	/**
	 * 編集更新処理
	 *
	 * @param unknown $admin_user_id
	 */
	private function update_detail($post) {

		if($post['password'] != null && $post['password'] != ''){
			$pw = $this->common_logic->convert_password_encode($post['password']);
			$this->common_logic->update_logic("t_member", " where member_id = ? ", array(
					'password'
			), array(
					$pw,
					$post ['edit_del_id']
			));
		}

		// 編集ロジック呼び出し
		$this->member_logic->update_detail ( array (
				$post['name'],
				$post['mail'],
				$post['tel'],
				$post['sex'],
				$post['birthday'],
				$post['nationality'],
				$post['addr'],
				$post['icon'],
				$post['del_flg'],
				$post ['edit_del_id']
		) );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'update',
				'msg' => '変更しました'
		);

		return $data;
	}

	/**
	 * 有効化処理
	 *
	 * @param unknown $id
	 */
	public function recovery($id) {
		// 更新ロジック呼び出し
		$this->member_logic->recoveryl_func ( $id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'recovery',
				'msg' => '有効にしました'
		);
		return $data;
	}

	/**
	 * 削除処理
	 *
	 * @param unknown $post
	 */
	public function delete($id) {
		// 更新ロジック呼び出し
		$this->member_logic->del_func ( $id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'delete',
				'msg' => '削除しました'
		);
		return $data;
	}

	/**
	 * 非公開処理
	 *
	 * @param unknown $id
	 */
	public function private_func($id) {
		// 更新ロジック呼び出し
		$this->member_logic->private_func ( $id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'private',
				'msg' => '非公開にしました'
		);
		return $data;
	}

	/**
	 * 公開処理
	 *
	 * @param unknown $post
	 */
	public function release($id) {
		// 更新ロジック呼び出し
		$this->member_logic->release_func ( $id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'release',
				'msg' => '公開しました'
		);
		return $data;
	}


}
