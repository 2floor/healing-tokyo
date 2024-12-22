<?php
class t_core_main_model {
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
	public function get_core_main_list($offset, $limit, $sqlAdd) {
		return $this->common_logic->select_logic ( "SELECT * FROM `core_main_article` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " limit " . $limit . " offset " . $offset , $sqlAdd['whereParam'] );
	}

	/**
	 * 総件数取得
	 */
	public function get_core_main_list_cnt($sqlAdd ) {
		return $this->common_logic->select_logic ( "SELECT COUNT(*) AS `cnt` FROM `core_main_article` " . $sqlAdd['where'] . " " . $sqlAdd['order'] . " " , $sqlAdd['whereParam'] );
	}

	/**
	 * 詳細取得
	 *
	 * @param unknown $admin_user_id
	 * @return Ambigous
	 */
	public function get_core_main_detail($article_id) {
		return $this->common_logic->select_logic ( 'select * from core_main_article where article_id = ?', array (
				$article_id
		) );
	}

	/**
	 * 最後に登録されたidを入手
	 */
	public function search_core_main(){
		return $this->common_logic->select_logic_no_param('select article_id from core_main_article order by create_at desc limit 1');
	}

	/**
	 * 新規登録
	 *
	 * @param unknown $params
	 */
	public function entry_core_main($params) {
		return $this->common_logic->insert_logic ( "core_main_article", $params );
	}

	/**
	 * 編集更新
	 */
	public function update_core_main($params) {
		$this->common_logic->update_logic ( "core_main_article", " where article_id = ?", array (
				'article_title_jap',
				'article_text',
				'article_image',
				'public_flg',
		), $params );

	}


	/**
	 * 削除(論理削除)
	 *
	 * @param unknown $id
	 */
	public function del_core_main($id) {
		return $this->common_logic->update_logic ( "core_main_article", " where article_id = ?", array (
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
	public function recoveryl_core_main($id) {
		return $this->common_logic->update_logic ( "core_main_article", " where article_id = ?", array (
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
	public function private_core_main($id) {
		return $this->common_logic->update_logic ( "core_main_article", " where article_id = ?", array (
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
	public function release_core_main($id) {
		return $this->common_logic->update_logic ( "core_main_article", " where article_id = ?", array (
				"public_flg"
		), array (
				'0',
				$id
		) );
	}
}