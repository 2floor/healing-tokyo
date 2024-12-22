<?php
class t_code_model {
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
	public function get_code_list($offset, $limit, $sqlAdd) {
		return $this->common_logic->select_logic ( "SELECT *, 0 AS `del_flg` FROM `m_code` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " limit " . $limit . " offset " . $offset , $sqlAdd['whereParam'] );
	}

	/**
	 * 総件数取得
	 */
	public function get_code_list_cnt($sqlAdd ) {
		return $this->common_logic->select_logic ( "SELECT COUNT(*) AS `cnt`, 0 AS `del_flg` FROM `m_code` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " " , $sqlAdd['whereParam'] );
	}

	/**
	 * 詳細取得
	 *
	 * @param unknown $admin_user_id
	 * @return Ambigous
	 */
	public function get_code_detail($code_id) {
		return $this->common_logic->select_logic ( 'select * from m_code where code_id = ?', array (
				$code_id
		) );
	}

	/**
	 * 最後に登録されたidを入手
	 */
	public function search_code(){
		return $this->common_logic->select_logic_no_param('select code_id from m_code order by create_at desc limit 1');
	}

	/**
	 * 新規登録
	 *
	 * @param unknown $params
	 */
	public function entry_code($params) {
		return $this->common_logic->insert_logic ( "m_code", $params );
	}

	/**
	 * 編集更新
	 */
	public function update_code($params) {
		$this->common_logic->update_logic ( "m_code", " where code_id = ?", array (
				'description1',
				'description2',
				'description3',
		), $params );

	}


	/**
	 * 削除(論理削除)
	 *
	 * @param unknown $id
	 */
	public function del_code($id) {
		return $this->common_logic->update_logic ( "m_code", " where code_id = ?", array (
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
	public function recoveryl_code($id) {
		return $this->common_logic->update_logic ( "m_code", " where code_id = ?", array (
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
	public function private_code($id) {
		return $this->common_logic->update_logic ( "m_code", " where code_id = ?", array (
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
	public function release_code($id) {
		return $this->common_logic->update_logic ( "m_code", " where code_id = ?", array (
				"public_flg"
		), array (
				'0',
				$id
		) );
	}
}