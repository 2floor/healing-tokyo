<?php
session_start ();
// header('Content-Type: applitourion/json');

require_once __DIR__ .  '/../../logic/common/common_logic.php';
require_once __DIR__ .  '/../../logic/common/common_string_logic.php';
require_once __DIR__ .  '/../../logic/admin/tour_logic.php';
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
	$tour_ct = new tour_ct ();

	// コントローラー呼び出し
	$data = $tour_ct->main_control ( $_POST );
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
class tour_ct {
	private $member_ct;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		// 管理画面ユーザーロジックインスタンス
		$this->tour_logic = new tour_logic ();
		$this->common_string_logic = new common_string_logic ();
	}

	/**
	 * コントローラー
	 * 各処理の振り分けをmethodの文字列により行う
	 *
	 * @param unknown $post
	 */
	public function main_control($post) {
		$tour_ct = new tour_ct ();
		if ($post ['method'] == 'init') {
			// 初期処理　HTML生成処理呼び出し
			$data = $tour_ct->create_data_list ( $post );
		} else if ($post ['method'] == 'entry') {
			// 新規登録処理
			$data = $tour_ct->entry_new_data ( $post );
		} else if ($post ['method'] == 'edit_init') {
			// 編集初期処理
			$data = $tour_ct->get_detail ( $post ['edit_del_id'] );
		} else if ($post ['method'] == 'edit') {
			// 編集更新処理
			$data = $tour_ct->update_detail ( $post );
		} else if ($post ['method'] == 'delete') {
			// 削除処理
			$data = $tour_ct->delete ( $post ['id'] );
		} else if ($post ['method'] == 'recovery') {
			// 有効化処理
			$data = $tour_ct->recovery ( $post ['id'] );
		} else if ($post ['method'] == 'private') {
			// 非公開化処理
			$data = $tour_ct->private_func ( $post ['id'] );
		} else if ($post ['method'] == 'release') {
			// 公開化処理
			$data = $tour_ct->release ( $post ['id'] );
		}

		return $data;
	}

	/**
	 * 初期処理(一覧HTML生成)
	 */
	private function create_data_list($post) {

		$list_html = $this->tour_logic->create_data_list ( array (
				$post ['now_page_num'], // 現在のページ
				$post ['get_next_disp_page'], // 次に表示するページ
				$post ['page_disp_cnt'],
		),  $post ['search_select'],  array(
				'tid' => $post['tid']
		));

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

		// 登録ロジック呼び出し
		$this->tour_logic->entry_new_data ( array (
				$post['etc1'],
				$post['etc2'],
				$post['etc3'],
				$post['etc4'],
				$post['etc5'],
				$post['etc6'],
				$post['etc7'],
				$post['etc8'],
				$post['etc9'],
				'0',
				'0',
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
	private function get_detail($tour_id) {
		$reult_detail = $this->tour_logic->get_detail ( $tour_id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'title' => $reult_detail['title'],
				'd_title' => $reult_detail['d_title'],
				'd_detail' => $reult_detail['d_detail'],
				'femeal_only' => $reult_detail['femeal_only'],
				'category' => $reult_detail['category'],
				'area' => $reult_detail['area'],
				'adult_fee' => $reult_detail['adult_fee'],
				'children_fee' => $reult_detail['children_fee'],
				'discount_rate_setting' => $reult_detail['discount_rate_setting'],
				'children_age_limit' => $reult_detail['children_age_limit'],
				'tranvel' => $reult_detail['tranvel'],
				'youtube' => htmlspecialchars_decode($reult_detail['youtube']),
				'img' => $reult_detail['img'],
				'schedule' => $reult_detail['schedule'],
				'meeting_place' => $reult_detail['meeting_place'],
				'note' => $reult_detail['note'],
				'note_agreement_flg' => $reult_detail['note_agreement_flg'],
				'inclusion' => $reult_detail['inclusion'],
				'what_to_bring' => $reult_detail['what_to_bring'],
				'duration' => $reult_detail['duration'],
				'card_choice' => $reult_detail['card_choice'],
				'payment_way' => $reult_detail['payment_way'],
				'remarks' => $reult_detail['remarks'],
			);

		return $data;
	}


	/**
	 * 編集更新処理
	 *
	 * @param unknown $admin_user_id
	 */
	private function update_detail($post) {

		// 編集ロジック呼び出し
		$this->tour_logic->update_detail ( array (
				$post['title'],
				$post['d_title'],
				$post['d_detail'],
				$post['femeal_only'],
				$post['category'],
				$post['area'],
				$post['adult_fee'],
				$post['children_fee'],
				$post['discount_rate_setting'],
				$post['children_age_limit'],
				$post['tranvel'],
				$post['youtube'],
				$post['img'],
				$post['schedule'],
				$post['meeting_place'],
				$post['note'],
				$post['note_agreement_flg'],
				$post['inclusion'],
				$post['what_to_bring'],
				$post['duration'],
				$post['payment_way'],
				$post['card_choice'],
				$post['remarks'],
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
		$this->tour_logic->recoveryl_func ( $id );

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
		$this->tour_logic->del_func ( $id );

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
		$this->tour_logic->private_func ( $id );

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
		$this->tour_logic->release_func ( $id );

		// AJAX返却用データ成型
		$data = array (
				'status' => true,
				'method' => 'release',
				'msg' => '公開しました'
		);
		return $data;
	}


}
