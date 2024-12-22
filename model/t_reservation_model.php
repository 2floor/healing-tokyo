<?php
class t_reservation_model {
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
	public function get_reservation_list($offset, $limit, $sqlAdd) {
		return $this->common_logic->select_logic ( "SELECT * FROM `t_reservation` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " limit " . $limit . " offset " . $offset , $sqlAdd['whereParam'] );
	}

	/**
	 * 総件数取得
	 */
	public function get_reservation_list_cnt($sqlAdd ) {
		return $this->common_logic->select_logic ( "SELECT COUNT(*) AS `cnt` FROM `t_reservation` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " " , $sqlAdd['whereParam'] );
	}

	/**
	 * 詳細取得
	 *
	 * @param unknown $admin_user_id
	 * @return Ambigous
	 */
	public function get_reservation_detail($reservation_id) {
		return $this->common_logic->select_logic ( 'select * from t_reservation where reservation_id = ?', array (
				$reservation_id
		) );
	}

	/**
	 * 最後に登録されたidを入手
	 */
	public function search_reservation(){
		return $this->common_logic->select_logic_no_param('select reservation_id from t_reservation order by create_at desc limit 1');
	}

	/**
	 * 新規登録
	 *
	 * @param unknown $params
	 */
	public function entry_reservation($params) {
		return $this->common_logic->insert_logic ( "t_reservation", $params );
	}

	/**
	 * 編集更新
	 */
	public function update_reservation($params) {
		$this->common_logic->update_logic ( "t_reservation", " where reservation_id = ?", array (
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
	public function del_reservation($id) {
		return $this->common_logic->update_logic ( "t_reservation", " where reservation_id = ?", array (
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
	public function recoveryl_reservation($id) {
		return $this->common_logic->update_logic ( "t_reservation", " where reservation_id = ?", array (
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
	public function private_reservation($id) {
		return $this->common_logic->update_logic ( "t_reservation", " where reservation_id = ?", array (
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
	public function release_reservation($id) {
		return $this->common_logic->update_logic ( "t_reservation", " where reservation_id = ?", array (
				"public_flg"
		), array (
				'0',
				$id
		) );
	}
}