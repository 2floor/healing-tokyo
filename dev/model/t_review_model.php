<?php
class t_review_model {
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
	public function get_review_list($offset, $limit, $sqlAdd) {
		return $this->common_logic->select_logic ( "SELECT * FROM `t_review` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " limit " . $limit . " offset " . $offset , $sqlAdd['whereParam'] );
	}

	/**
	 * 総件数取得
	 */
	public function get_review_list_cnt($sqlAdd ) {
		return $this->common_logic->select_logic ( "SELECT COUNT(*) AS `cnt` FROM `t_review` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " " , $sqlAdd['whereParam'] );
	}

	/**
	 * 詳細取得
	 *
	 * @param unknown $admin_user_id
	 * @return Ambigous
	 */
	public function get_review_detail($review_id) {
		return $this->common_logic->select_logic ( 'select * from t_review where review_id = ?', array (
				$review_id
		) );
	}

	/**
	 * 最後に登録されたidを入手
	 */
	public function search_review(){
		return $this->common_logic->select_logic_no_param('select review_id from t_review order by create_at desc limit 1');
	}

	/**
	 * 新規登録
	 *
	 * @param unknown $params
	 */
	public function entry_review($params) {
		return $this->common_logic->insert_logic ( "t_review", $params );
	}

	/**
	 * 編集更新
	 */
	public function update_review($params) {
		$this->common_logic->update_logic ( "t_review", " where review_id = ?", array (
				'etc1',
				'etc2',
				'etc3',
				'etc4',
				'etc5',
				'etc6',
				'etc7',
				'etc8',
				'etc9',
		), $params );

	}


	/**
	 * 削除(論理削除)
	 *
	 * @param unknown $id
	 */
	public function del_review($id) {
		return $this->common_logic->update_logic ( "t_review", " where review_id = ?", array (
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
	public function recoveryl_review($id) {
		return $this->common_logic->update_logic ( "t_review", " where review_id = ?", array (
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
	public function private_review($id) {
		return $this->common_logic->update_logic ( "t_review", " where review_id = ?", array (
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
	public function release_review($id) {
		return $this->common_logic->update_logic ( "t_review", " where review_id = ?", array (
				"public_flg"
		), array (
				'0',
				$id
		) );
	}
}