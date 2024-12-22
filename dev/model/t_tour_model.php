<?php
class t_tour_model {
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
	public function get_tour_list($offset, $limit, $sqlAdd) {
		return $this->common_logic->select_logic ( "SELECT * FROM `t_tour` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " limit " . $limit . " offset " . $offset , $sqlAdd['whereParam'] );
	}

	/**
	 * 総件数取得
	 */
	public function get_tour_list_cnt($sqlAdd ) {
		return $this->common_logic->select_logic ( "SELECT COUNT(*) AS `cnt` FROM `t_tour` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " " , $sqlAdd['whereParam'] );
	}

	/**
	 * 詳細取得
	 *
	 * @param unknown $admin_user_id
	 * @return Ambigous
	 */
	public function get_tour_detail($tour_id) {
		return $this->common_logic->select_logic ( 'select * from t_tour where tour_id = ?', array (
				$tour_id
		) );
	}

	/**
	 * 最後に登録されたidを入手
	 */
	public function search_tour(){
		return $this->common_logic->select_logic_no_param('select tour_id from t_tour order by create_at desc limit 1');
	}

	/**
	 * 新規登録
	 *
	 * @param unknown $params
	 */
	public function entry_tour($params) {
		return $this->common_logic->insert_logic ( "t_tour", $params );
	}

	/**
	 * 編集更新
	 */
	public function update_tour($params) {

		$r = $this->common_logic->update_logic ( "t_tour", " where tour_id = ?", array (
				'title',
				'd_title',
				'd_detail',
				'femeal_only',
				'category',
				'area',
				'adult_fee',
				'children_fee',
				'discount_rate_setting',
				'children_age_limit',
				'tranvel',
				'youtube',
				'img',
				'schedule',
				'meeting_place',
				'note',
				'note_agreement_flg',
				'inclusion',
				'what_to_bring',
				'duration',
				'payment_way',
				'card_choice',
				'remarks',
		), $params );

	}


	/**
	 * 削除(論理削除)
	 *
	 * @param unknown $id
	 */
	public function del_tour($id) {
		return $this->common_logic->update_logic ( "t_tour", " where tour_id = ?", array (
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
	public function recoveryl_tour($id) {
		return $this->common_logic->update_logic ( "t_tour", " where tour_id = ?", array (
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
	public function private_tour($id) {
		return $this->common_logic->update_logic ( "t_tour", " where tour_id = ?", array (
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
	public function release_tour($id) {
		return $this->common_logic->update_logic ( "t_tour", " where tour_id = ?", array (
				"public_flg"
		), array (
				'0',
				$id
		) );
	}
}