<?php
class t_store_basic_model {
	private $common_logic;

	/**
	 * コンストラクタ
	 */
	function __construct() {
		$this->common_logic = new common_logic ();
	}

	/**
	 * 一覧情報取得
	 */
	public function get_store_basic_list($offset, $limit, $sqlAdd) {
		return $this->common_logic->select_logic ( "SELECT * FROM `t_store_basic` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " limit " . $limit . " offset " . $offset , $sqlAdd['whereParam'] );
	}

	/**
	 * 総件数取得
	 */
	public function get_store_basic_list_cnt($sqlAdd ) {
		return $this->common_logic->select_logic ( "SELECT COUNT(*) AS `cnt` FROM `t_store_basic` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " " , $sqlAdd['whereParam'] );
	}

	/**
	 * 詳細取得
	 *
	 * @param unknown $admin_user_id
	 * @return Ambigous
	 */
	public function get_store_basic_detail($store_basic_id) {
		return $this->common_logic->select_logic ( 'select * from t_store_basic where store_basic_id = ?', array (
				$store_basic_id
		) );
	}

	/**
	 * 最後に登録されたidを入手
	 */
	public function search_store_basic(){
		return $this->common_logic->select_logic_no_param('select store_basic_id from t_store_basic order by create_at desc limit 1');
	}

	/**
	 * 新規登録
	 *
	 * @param unknown $params
	 */
	public function entry_store_basic($params) {
		return $this->common_logic->insert_logic ( "t_store_basic", $params );
	}

	/**
	 * 編集更新
	 */
	public function update_store_basic($params) {
		$this->common_logic->update_logic ( "t_store_basic", " where store_basic_id = ?", array (
				'auth_flg',
				'store_type',
				'company_name',
				'company_name_eng',
				'contact_name',
				'contact_name_kana',
				'contact_name_eng',
				'mail',
				'tel',
				'fax',
				'emergency_tel',
				'emergency_contact_name',
				'location',
				'url',
				'img',
				'addr',
				'trading_hours',
				'youtube_tag',
				'bank_name',
				'bank_branch',
				'bank_branch_number',
				'bank_type',
				'bank_number',
				'bank_meigi',
				'cd_title',
				'cd_deatil',
				'cdf_title',
				'cdf_img1',
				'cdf_detail1',
				'cdf_img2',
				'cdf_detail2',
				'cdf_img3',
				'cdf_detail3',
				'browse_num',
				'reserve_num',
				'review_point',
				'review_num',
				'review_ave',
				'etc_comment',
				'del_flg',
		), $params );

	}


	/**
	 * 削除(論理削除)
	 *
	 * @param unknown $id
	 */
	public function del_store_basic($id) {
		return $this->common_logic->update_logic ( "t_store_basic", " where store_basic_id = ?", array (
				"del_flg"
		), array (
				'1',
				$id
		) );
	}
	/**
	 * 有効化
	 *
	 * @param unknown $id
	 */
	public function recoveryl_store_basic($id) {
		return $this->common_logic->update_logic ( "t_store_basic", " where store_basic_id = ?", array (
				"del_flg"
		), array (
				'0',
				$id
		) );
	}

	/**
	 * 非公開化
	 *
	 * @param unknown $id
	 */
	public function private_store_basic($id) {
		return $this->common_logic->update_logic ( "t_store_basic", " where store_basic_id = ?", array (
				"public_flg"
		), array (
				'1',
				$id
		) );
	}
	/**
	 * 公開
	 *
	 * @param unknown $id
	 */
	public function release_store_basic($id) {
		return $this->common_logic->update_logic ( "t_store_basic", " where store_basic_id = ?", array (
				"public_flg"
		), array (
				'0',
				$id
		) );
	}


	/**
	 * 非公開化
	 *
	 * @param unknown $id
	 */
	public function auth($id) {
		return $this->common_logic->update_logic ( "t_store_basic", " where store_basic_id = ?", array (
				"auth_flg"
		), array (
				'1',
				$id
		) );
	}
	/**
	 * 公開
	 *
	 * @param unknown $id
	 */
	public function auth_inna($id) {
		return $this->common_logic->update_logic ( "t_store_basic", " where store_basic_id = ?", array (
				"auth_flg"
		), array (
				'0',
				$id
		) );
	}
}