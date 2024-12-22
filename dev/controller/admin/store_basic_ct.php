<?php
session_start ();
// header('Content-Type: applistore_basicion/json');

require_once __DIR__ .  '/../../logic/common/common_logic.php';
require_once __DIR__ .  '/../../logic/common/common_string_logic.php';
require_once __DIR__ .  '/../../logic/admin/store_basic_logic.php';
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
	$store_basic_ct = new store_basic_ct ();

	// コントローラー呼び出し
	$data = $store_basic_ct->main_control ( $_POST );
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
class store_basic_ct {
	private $store_basic_ct;
	private $common_logic;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		// 管理画面ユーザーロジックインスタンス
		$this->store_basic_logic = new store_basic_logic ();
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
		$store_basic_ct = new store_basic_ct ();
		if ($post ['method'] == 'init') {
			// 初期処理　HTML生成処理呼び出し
			$data = $store_basic_ct->create_data_list ( $post );
		} else if ($post ['method'] == 'entry') {
			// 新規登録処理
			$data = $store_basic_ct->entry_new_data ( $post );
		} else if ($post ['method'] == 'edit_init') {
			// 編集初期処理
			$data = $store_basic_ct->get_detail ( $post ['edit_del_id'] );
		} else if ($post ['method'] == 'edit') {
			// 編集更新処理
			$data = $store_basic_ct->update_detail ( $post );
		} else if ($post ['method'] == 'delete') {
			// 削除処理
			$data = $store_basic_ct->delete ( $post ['id'] );
		} else if ($post ['method'] == 'recovery') {
			// 有効化処理
			$data = $store_basic_ct->recovery ( $post ['id'] );
		} else if ($post ['method'] == 'private') {
			// 非公開化処理
			$data = $store_basic_ct->private_func ( $post ['id'] );
		} else if ($post ['method'] == 'release') {
			// 公開化処理
			$data = $store_basic_ct->release ( $post ['id'] );
		} else if ($post ['method'] == 'auth') {
			// 非公開化処理
			$data = $store_basic_ct->auth ( $post ['id'] );
		} else if ($post ['method'] == 'auth_inna') {
			// 公開化処理
			$data = $store_basic_ct->auth_inna ( $post ['id'] );
		}

		return $data;
	}

	/**
	 * 初期処理(一覧HTML生成)
	 */
	private function create_data_list($post) {

		$list_html = $this->store_basic_logic->create_data_list ( array (
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
		$post['browse_num'] = $this->zeroIns($post['browse_num']);
		$post['reserve_num'] = $this->zeroIns($post['reserve_num']);
		$post['review_point'] = $this->zeroIns($post['review_point']);
		$post['review_num'] = $this->zeroIns($post['review_num']);
		$post['review_ave'] = $this->zeroIns($post['review_ave']);
		$post['bank_type'] = $this->zeroIns($post['bank_type']);


		// 登録ロジック呼び出し
		$this->store_basic_logic->entry_new_data ( array (
				$post['auth_flg'],
				$post['store_type'],
				$post['company_name'],
				$post['company_name_eng'],
				$post['contact_name'],
				$post['contact_name_kana'],
				$post['contact_name_eng'],
				$post['mail'],
				$post['password'],
				$post['tel'],
				$post['fax'],
				$post['emergency_tel'],
				$post['emergency_contact_name'],
				$post['location'],
				$post['url'],
				$post['img'],
				$post['addr'],
				$post['trading_hours'],
				$post['youtube_tag'],
				$post['bank_name'],
				$post['bank_branch'],
				$post['bank_branch_number'],
				$post['bank_type'],
				$post['bank_number'],
				$post['bank_meigi'],
				$post['cd_title'],
				$post['cd_deatil'],
				$post['cdf_title'],
				$post['cdf_img1'],
				$post['cdf_detail1'],
				$post['cdf_img2'],
				$post['cdf_detail2'],
				$post['cdf_img3'],
				$post['cdf_detail3'],
				$post['browse_num'],
				$post['reserve_num'],
				$post['review_point'],
				$post['review_num'],
				$post['review_ave'],
				$post['etc_comment'],
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
	private function get_detail($store_basic_id) {
		$reult_detail = $this->store_basic_logic->get_detail ( $store_basic_id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'auth_flg' => $reult_detail['auth_flg'],
				'store_type' => $reult_detail['store_type'],
				'company_name' => $reult_detail['company_name'],
				'company_name_eng' => $reult_detail['company_name_eng'],
				'contact_name' => $reult_detail['contact_name'],
				'contact_name_kana' => $reult_detail['contact_name_kana'],
				'contact_name_eng' => $reult_detail['contact_name_eng'],
				'mail' => $reult_detail['mail'],
				'tel' => $reult_detail['tel'],
				'fax' => $reult_detail['fax'],
				'emergency_tel' => $reult_detail['emergency_tel'],
				'emergency_contact_name' => $reult_detail['emergency_contact_name'],
				'location' => $reult_detail['location'],
				'url' => $reult_detail['url'],
				'img' => $reult_detail['img'],
				'addr' => $reult_detail['addr'],
				'trading_hours' => $reult_detail['trading_hours'],
				'youtube_tag' => htmlspecialchars_decode($reult_detail['youtube_tag']),
				'bank_name' => $reult_detail['bank_name'],
				'bank_branch' => $reult_detail['bank_branch'],
				'bank_branch_number' => $reult_detail['bank_branch_number'],
				'bank_type' => $reult_detail['bank_type'],
				'bank_number' => $reult_detail['bank_number'],
				'bank_meigi' => $reult_detail['bank_meigi'],
				'cd_title' => $reult_detail['cd_title'],
				'cd_deatil' => $reult_detail['cd_deatil'],
				'cdf_title' => $reult_detail['cdf_title'],
				'cdf_img1' => $reult_detail['cdf_img1'],
				'cdf_detail1' => $reult_detail['cdf_detail1'],
				'cdf_img2' => $reult_detail['cdf_img2'],
				'cdf_detail2' => $reult_detail['cdf_detail2'],
				'cdf_img3' => $reult_detail['cdf_img3'],
				'cdf_detail3' => $reult_detail['cdf_detail3'],
				'browse_num' => $reult_detail['browse_num'],
				'reserve_num' => $reult_detail['reserve_num'],
				'review_point' => $reult_detail['review_point'],
				'review_num' => $reult_detail['review_num'],
				'review_ave' => $reult_detail['review_ave'],
				'etc_comment' => $reult_detail['etc_comment'],
				'del_flg' => $reult_detail['del_flg'],
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
			$this->common_logic->update_logic("t_store_basic", " where store_basic_id = ? ", array(
					'password'
			), array(
					$pw,
					$post ['edit_del_id']
			));
		}
		$post['browse_num'] = $this->zeroIns($post['browse_num']);
		$post['reserve_num'] = $this->zeroIns($post['reserve_num']);
		$post['review_point'] = $this->zeroIns($post['review_point']);
		$post['review_num'] = $this->zeroIns($post['review_num']);
		$post['review_ave'] = $this->zeroIns($post['review_ave']);
		$post['bank_type'] = $this->zeroIns($post['bank_type']);

		// 編集ロジック呼び出し
		$this->store_basic_logic->update_detail ( array (
				$post['auth_flg'],
				$post['store_type'],
				$post['company_name'],
				$post['company_name_eng'],
				$post['contact_name'],
				$post['contact_name_kana'],
				$post['contact_name_eng'],
				$post['mail'],
				$post['tel'],
				$post['fax'],
				$post['emergency_tel'],
				$post['emergency_contact_name'],
				$post['location'],
				$post['url'],
				$post['img'],
				$post['addr'],
				$post['trading_hours'],
				$post['youtube_tag'],
				$post['bank_name'],
				$post['bank_branch'],
				$post['bank_branch_number'],
				$post['bank_type'],
				$post['bank_number'],
				$post['bank_meigi'],
				$post['cd_title'],
				$post['cd_deatil'],
				$post['cdf_title'],
				$post['cdf_img1'],
				$post['cdf_detail1'],
				$post['cdf_img2'],
				$post['cdf_detail2'],
				$post['cdf_img3'],
				$post['cdf_detail3'],
				$post['browse_num'],
				$post['reserve_num'],
				$post['review_point'],
				$post['review_num'],
				$post['review_ave'],
				$post['etc_comment'],
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
		$this->store_basic_logic->recoveryl_func ( $id );

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
		$this->store_basic_logic->del_func ( $id );

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
		$this->store_basic_logic->private_func ( $id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'private',
				'msg' => '認証にしました'
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
		$this->store_basic_logic->release_func ( $id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'release',
				'msg' => '未認証しました'
		);
		return $data;
	}

	/**
	 * 非公開処理
	 *
	 * @param unknown $id
	 */
	public function auth($id) {
		// 更新ロジック呼び出し
		$this->store_basic_logic->auth ( $id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'private',
				'msg' => '認証にしました'
		);
		return $data;
	}

	/**
	 * 公開処理
	 *
	 * @param unknown $post
	 */
	public function auth_inna($id) {
		// 更新ロジック呼び出し
		$this->store_basic_logic->auth_inna ( $id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'release',
				'msg' => '未認証しました'
		);
		return $data;
	}

	private function zeroIns($pa){
		if($pa == null || $pa == '' || $pa == 'undefined')$pa = 0;
		return $pa;
	}


}
