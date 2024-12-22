<?php
require_once __DIR__ .  '/../../model/t_store_basic_model.php';
require_once __DIR__ .  '/../../logic/common/common_logic.php';


class store_basic_logic {
	private $t_store_basic_model;
	private $common_logic;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		$this->t_store_basic_model= new t_store_basic_model();
		$this->common_logic = new common_logic ();
	}

	/**
	 * 初期HTML生成
	 */
	public function create_data_list($params, $search_select = null){

		$this->common_logic->create_table_dump("t_store_basic");


		$sqlAdd = $this->common_logic->create_where($search_select);

		$page_title = 'サンプル';

		//総件数取得
		$result_cnt = $this->t_store_basic_model->get_store_basic_list_cnt($sqlAdd);

		$all_cnt = $result_cnt[0]['cnt'];
		$pager_cnt = ceil($all_cnt / $params[2]);
		$offset = ($params[1] - 1) * $params[2];

		$result_store_basic = $this->t_store_basic_model->get_store_basic_list($offset, $params[2],$sqlAdd);

		$return_html = "";
		$back_color = 1;
		$cnt = $offset;
		for($i = 0; $i < count ( $result_store_basic ); $i ++) {
			$row = $result_store_basic [$i];

			$cnt ++;
			$edit_html = '&nbsp;';

			$store_basic_id = $this->common_logic->zero_padding ( $row ['store_basic_id'] );

			//各データをhtmlに変換







			//画像表示処理
			$img_tag_html = '<img src="../assets/admin/img/nophoto.png" style="height:50px">';
			$nmage_list = array ();
			if (strpos ( $row ['image'], ',' ) !== false && ($row ['image'] != null && $row ['image'] != '')) {
				// 'abcd'のなかに'bc'が含まれている場合
				$img_tag_html = '';
				$nmage_list = explode ( ',', $row ['image'] );

				for($n = 0; $n < count ( $nmage_list ); $n ++) {
					$img_tag_html .= '<img src="../upload_files/store_basic/' . $nmage_list [$n] . '" style="height:50px">';
				}
			} else if ($row ['image'] != null && $row ['image'] != '') {
				$img_tag_html = '<img src="../upload_files/store_basic/' . $row ['image'] . '" style="height:50px">';
			}

			//動画
			if ($row['movie'] != null && $row['movie'] != ""){
				$movie = '<a  href="#modal" class="check_movie" store_basic_id="'. $row['store_basic_id'] .'">有り</a>';
			}else{
				$movie = '無し';
			}


			//削除フラグ
			$del_color = "";
			$edit_html_a = "<a herf='javascript:void(0);' class='edit clr1' name='edit_" . $row ['store_basic_id'] . "' value='" . $row ['store_basic_id'] . "'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a><br>";
			$del_html = "有効";
			if ($row ['del_flg'] == 1) {
				$del_color = "color:#d3d3d3";
				$del_html = "削除";
				$edit_html_a .= "<a herf='javascript:void(0);' class='recovery clr2' name='recovery_" . $row ['store_basic_id'] . "' value='" . $row ['store_basic_id'] . "' ><i class=\"fa fa-undo\" aria-hidden=\"true\"></i></a><br>";
			} else {
				$edit_html_a .= "<a herf='javascript:void(0);' class='del clr2' name='del_" . $row ['store_basic_id'] . "' value='" . $row ['store_basic_id'] . "'><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a><br>";
			}

			if ($back_color == 2) {
				$back_color_html = "style='background: #f7f7f9; " . $del_color . "'";
				$back_color_bottom_html = "style='background: #f7f7f9; border-bottom:solid 2px #d0d0d0;'";
			} else {
				$back_color_html = "style='background: #ffffff; " . $del_color . "'";
				$back_color_bottom_html = "style='background: #ffffff; border-bottom:solid 2px #d0d0d0;'";
			}

			$edit_html_b = '';
// 			$public_html = "公開";
// 			if ($row ['public_flg'] == 1) {
// 				$public_html = "非公開";
// 				$edit_html_b .= "<a herf='javascript:void(0);' class='release btn btn-default waves-effect w-md btn-xs' name='release_" . $row ['store_basic_id'] . "' value='" . $row ['store_basic_id'] . "'>未認証</a>";
// 			} else {
// 				$edit_html_b .= "<a herf='javascript:void(0);' class='private btn btn-custom waves-effect w-md btn-xs ' name='private_" . $row ['store_basic_id'] . "' value='" . $row ['store_basic_id'] . "'>認証</a>";
// 			}

			if ($row ['auth_flg'] == 1) {
				$edit_html_b .= "<a herf='javascript:void(0);' class='auth_inna btn btn-custom waves-effect w-md btn-xs ' name='auth_" . $row ['store_basic_id'] . "' value='" . $row ['store_basic_id'] . "'>認証</a>";

			} else {
				$edit_html_b .= "<a herf='javascript:void(0);' class='auth btn btn-default waves-effect w-md btn-xs' name='auth_" . $row ['store_basic_id'] . "' value='" . $row ['store_basic_id'] . "'>未認証</a>";
			}

			$create_at = $row['create_at'];
			$diff = strtotime(date('YmdHis')) - strtotime($create_at);
			if($diff < 60){
				$time = $diff;
				$create_at = $time . '秒前';
			}elseif($diff < 60 * 60){
				$time = round($diff / 60);
				$create_at = $time . '分前';
			}elseif($diff < 60 * 60 * 24){
				$time = round($diff / 3600);
				$create_at = $time . '時間前';
			}

			$update_at = $row['update_at'];
			$diff = strtotime(date('YmdHis')) - strtotime($update_at);
			if($diff < 60){
				$time = $diff;
				$update_at = $time . '秒前';
			}elseif($diff < 60 * 60){
				$time = round($diff / 60);
				$update_at = $time . '分前';
			}elseif($diff < 60 * 60 * 24){
				$time = round($diff / 3600);
				$update_at = $time . '時間前';
			}

			$auth = '認証済み';
			if(($row['auth_flg'] == 0))$auth = '<span style="color:red;">未認証</span>';
			if(($row['auth_flg'] == 2))$auth = '<span style="">認証不可</span>';




			$return_html .= "
					<tr " . $back_color_html . ">
						<td class='count_no'>" . $cnt . "</td>
						<td>" . $row['store_basic_id'] . "</td>
						<td>" . $row['company_name'] . "<br>" . $row['company_name_eng'] . "<br>" . $row['contact_name'] . "<br>" . $row['contact_name_kana'] . "</td>
						<td>TEL : " . $row['tel'] . "<br>MAIL: " . $row['mail'] . "<br>FAX : " . $row['fax'] . "</td>
						<td>" . $auth . "</td>
						<td>" . $create_at . "</td>
						<td>" . $update_at . "</td>
						<td>
							$edit_html_a
						</td>
						<td>
							$edit_html_b
						</td>
					</tr>
";
			$back_color ++;

			if ($back_color >= 3) {
				$back_color = 1;
			}
		}
		// }

		//ページャー部分HTML生成
		$pager_html = '<li><a href="javascript:void(0)" class="page prev" pager_type="prev">prev</a></li>';
		for ($i = 0; $i < $pager_cnt; $i++) {
			$disp_cnt = $i+1;

			if ($i == 0) {
				$pager_html .= '<li><a href="javascript:void(0)" class="page num_link" num_link="true" disp_id="'.$disp_cnt.'">'.$disp_cnt.'</a></li>';
			} else {
				$pager_html .= '<li><a href="javascript:void(0)" class="page num_link" num_link="true" disp_id="'.$disp_cnt.'">'.$disp_cnt.'</a></li>';
			}
		}
		$pager_html .= '<li><a href="javascript:void(0)" class="page next" pager_type="next">next</a></li>';

		return array (
				"entry_menu_list_html" => $admin_menu_list_html,
				"list_html" => $return_html,
				"pager_html" => $pager_html,
				'page_cnt' => $pager_cnt,
				'all_cnt' => $all_cnt,
				'disp_all' => $disp_all,
		);
	}


	/**
	 * 新規登録処理
	 */
	public function entry_new_data($params) {

		$result = $this->t_store_basic_model->entry_store_basic( $params );
		return true;
	}

	/**
	 * 取得処理
	 */
	public function get_detail($store_basic_id ){
		$result = $this->t_store_basic_model->get_store_basic_detail ( $store_basic_id );

		return  $result [0];
	}

	/**
	 * 編集更新処理
	 * @param unknown $post
	 */
	public function update_detail($params){

		$result = $this->t_store_basic_model->update_store_basic($params);
		return true;
	}

	/**
	 * 有効化処理
	 *
	 * @param unknown $id
	 */
	public function recoveryl_func($id) {
		$this->t_store_basic_model->recoveryl_store_basic ( $id );
	}


	/**
	 * 削除処理
	 *
	 * @param unknown $id
	 */
	public function del_func($id) {
		$this->t_store_basic_model->del_store_basic ( $id );
	}

	/**
	 * 非公開化処理
	 *
	 * @param unknown $id
	 */
	public function private_func($id) {
		$this->t_store_basic_model->private_store_basic ( $id );
	}


	/**
	 * 公開処理
	 *
	 * @param unknown $id
	 */
	public function release_func($id) {
		$this->t_store_basic_model->release_store_basic ( $id );
	}

	/**
	 * 非公開化処理
	 *
	 * @param unknown $id
	 */
	public function auth($id) {
		$this->t_store_basic_model->auth ( $id );

		$store = $this->common_logic->select_logic("select * from t_store_basic where store_basic_id = ? ", array($id));


		$body = '

'.$store[0]['company_name'].'
'.$store[0]['contact_name'].' 様



この度は、JIS事業者会員にご登録頂き、誠にありがとうございます。
会員登録が完了致しましたのでご連絡申し上げます。

アクティビティの登録方法：
ログインして頂き、マイページよりアクティビティの詳細を入力して頂きます。
ログインページ https://healing-tokyo.com/login.php
アクティビティ登録について
アクティビティ登録基本編 https://healing-tokyo.com/manual/Activity_registration_manual_basics.pdf
1日に2回以上催行の場合等、登録応用編 https://healing-tokyo.com/manual/Activity_registration_manual_application.pdf
先に登録応用編もお読み頂き、参考にして頂くとよりスムーズに作業が行えます。

また、空き人数管理（ブロック数管理）の変更・期間延長については https://healing-tokyo.com/manual/Block_management_manual.pdf
会員情報編集は https://healing-tokyo.com/manual/Company_Information_Management_Registration_Manual.pdf

尚、これら上記のリンク先につきましては今後もアクセスする機会があると思われますので、ブックマークをして頂くか、
このメールを保存して頂きますようお願い致します。

ご不明な点やご質問などございましたら、enquiry@healing-tokyo.com まで
お気軽にお問い合せください。


※このメールは送信専用メールアドレスから配信されています。

*******************************************************
 ㈱ジャパン インターナショナル サービス(JIS)
 〒151-0053 東京都渋谷区代々木2-23-1-218
 Tel：03-4588-1055/Fax：03-6300-0887
 E-Mail：enquiry@healing-tokyo.com
 URL：https://www.healing-tokyo.com
*******************************************************
';

		$from = 'english@healing-tokyo.com';
		$from_name = 'Japan International Services';

		$header  = "Content-Type: text/plain; charset=ISO-2022-JP \n";
		$header .= "Content-Transfer-Encoding: 7bit \n";
		$header .= "Mime-Version: 1.0 \n";
		$header .= "Return-Path: " . $from . "\n";
		$header .= "From:" .mb_encode_mimeheader($from_name,'ISO-2022-JP') ."<".$from.">\n";
		$header .= "Sender: " . mb_encode_mimeheader($from_name,'ISO-2022-JP') ."<".$from.">\n";
		$header .= "Reply-To: " .mb_encode_mimeheader($from_name,'ISO-2022-JP') ."<".$from.">\n";
		$header .= "Organization: " . $from . " \n";
		$header .= "X-Sender: " . $from . " \n";
		$header .= "X-Priority: 3 \n";

		mb_send_mail($store[0]['mail'], "【Japan International Services】事業者様会員登録完了のお知らせ", $body, $header);

	}


	/**
	 * 公開処理
	 *
	 * @param unknown $id
	 */
	public function auth_inna($id) {
		$this->t_store_basic_model->auth_inna ( $id );
	}

}