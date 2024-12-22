<?php
session_start();
require_once __DIR__ .  '/../../logic/common/common_logic.php';
require_once __DIR__ .  '/../../logic/common/jis_common_logic.php';

$regist_edit_logic = new regist_edit_logic();
$regist_edit_logic->ct($_POST);

class regist_edit_logic {

	private $common_logic;
	private $jis_common_logic;

	public function __construct(){
		$this->common_logic = new common_logic();
		$this->jis_common_logic = new jis_common_logic();
	}

	public function ct($post) {
		if($post['method'] == 'member_regist'){
			$this->member_regist($post);
		}elseif($post['method'] == 'member_edit'){
			$this->member_edit($post);
		}elseif($post['method'] == 'store_basic_edit'){
			$this->store_basic_edit($post);
		}elseif($post['method'] == 'store_basic_regist'){
			$this->store_basic_regist($post);
		}elseif($post['method'] == 'tour_regist'){
			$this->tour_regist($post);
		}elseif($post['method'] == 'tour_edit'){
			$this->tour_edit($post);
		}
	}


	public function member_regist($post) {

		$post['password'] = $this->common_logic->convert_password_encode($post['password']);

		if($post['nationality'] == 'Othre'){
			$post['nationality'] = $post['nationality_othre'];
		}

		$member_id = $this->common_logic->insert_logic("t_member", array(
				$post['name'],
				$post['last_name'],
				$post['mail'],
				$post['password'],
				$post['country_phone'],
				$post['tel'],
				$post['sex'],
				$post['birthday_y'] . '-' . $post['birthday_m'] . '-' . $post['birthday_d'],
				$post['nationality'],
				$post['addr'],
				$post['icon'],
				'', //$post['google_au'],
				'', //$post['facebook_au'],
				9, //$post['del_flg'],
		), "member_id");

		$rc = $post['mail'] . "###" . $member_id;

		$sex ='Male';
		if($post['sex'] == '1')$sex = 'Female';

		$subject = '【'."healing-tokyo".'】Membership registration.';

        $body = "Dear Sir/Madam,\r\n\r\n" .

            "Thank you for requesting a healing-tokyo new membership.\r\n\r\n" .

            "Please, access bellow URL to confirm your mail address.\r\n" .
            "https://www.healing-tokyo.com/reconfirm.php?rc=" . urlencode(base64_encode($rc)) . "\r\n\r\n" .

            "First Name　　　：" . $post['name'] . "\r\n" .
            "Family Name　：" . $post['last_name'] . "\r\n" .
            "Mail　　　　：" . $post['mail'] . "\r\n" .
            "Country Phone ：" .'+'. $post['country_phone'] . "\r\n" .
            "Tel 　　　　：" . $post['tel'] . "\r\n" .
            "Sex 　　　　：" . $sex . "\r\n" .
            "Birthday　　：" . $post['birthday_d'] . '/' . $post['birthday_m'] . '/' . $post['birthday_y'] . "\r\n" .
            "Nationality ：" . $post['nationality'] . "\r\n" .
            "Address 　　：" . $post['addr'] . "\r\n\r\n" .

            "*Please do not reply to this email.\r\n\r\n" .

            "*******************************************************\r\n" .
            " Company name\r\n" .
            " Company addr\r\n" .
            " Tel：\r\n" .
            " Fax：\r\n" .
            " E-Mail：test@sample.com\r\n" .
            " URL：https://www.healing-tokyo.com/\r\n" .
            "*******************************************************\r\n";

        mb_language ( "Japanese" );
		mb_internal_encoding ( "UTF-8" );
		
		
		$header  = "Content-Type: text/plain; charset=ISO-2022-JP \n";
		$header .= "Content-Transfer-Encoding: 7bit \n";
		$header .= "Mime-Version: 1.0 \n";
		$header .= "Return-Path: " . "no-reply@healing-tokyo.com" . "\n";
		$header .= "From:" .mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
		$header .= "Sender: " . mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
		$header .= "Reply-To: " .mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
		$header .= "Organization: " . "no-reply@healing-tokyo.com" . " \n";
		$header .= "X-Sender: " . "no-reply@healing-tokyo.com" . " \n";
		$header .= "X-Priority: 3 \n";

        mb_send_mail(
            $post['mail'],
            $subject,
            $body,
            $header
        );


		header("Location:../../mypage_users/new_member_comp.php");
		exit();
	}

	public function member_edit($post) {

		if($post['password'] != null && $post['password'] != ''){
			$pw = $this->common_logic->convert_password_encode($post['password']);
			$this->common_logic->update_logic("t_member", " where member_id = ? ", array("password"), array($pw, $_SESSION['jis']['login_member']['member_id']));
		}

		if($post['nationality'] == 'Othre'){
			$post['nationality'] = $post['nationality_othre'];
		}

		$r = $this->common_logic->update_logic("t_member", " where member_id = ? ", array(
				'name',
				'last_name',
				'mail',
				'country_phone',
				'tel',
				'sex',
				'birthday',
				'nationality',
				'addr',
				'icon',
		), array(
				$post['name'],
				$post['last_name'],
				$post['mail'],
				$post['country_phone'],
				$post['tel'],
				$post['sex'],
				$post['birthday_y'] . '-' . $post['birthday_m'] . '-' . $post['birthday_d'],
				$post['nationality'],
				$post['addr'],
				$post['icon'],
				$_SESSION['jis']['login_member']['member_id'],
		));

		$mem = $this->common_logic->select_logic("select * from t_member where member_id = ? ", array($_SESSION['jis']['login_member']['member_id']));
		$_SESSION['jis']['login_member'] = $mem[0];
		unset($_SESSION['jis']['login_member']['password']);
		$_SESSION['jis']['ty'] = 1;

		header("Location:../../mypage_users/edit_member_comp.php");
		exit();
	}


	public function store_basic_regist($post) {
		$pw = $this->common_logic->convert_password_encode($post['password']);
		$r = $this->common_logic->insert_logic("t_store_basic", array(
				0,//$post['auth_flg'],
				$post['store_type'],
				$post['company_name'],
				$post['company_name_eng'],
				$post['contact_name'],
				$post['contact_name_kana'],
				$post['contact_name_eng'],
				$post['mail'],
				$pw,//$post['password'],
				$post['country_phone'],
				$post['tel'],
				$post['fax'],
				$post['emergency_tel'],
				$post['emergency_contact_name'],
				$post['location'],
				$post['url'],
				null,//$post['img'],
				$post['addr'],
				$post['trading_hours'],
				null,//$post['youtube_tag'],
				null,//$post['bank_name'],
				null,//$post['bank_branch'],
				null,//$post['bank_branch_number'],
				null,//$post['bank_type'],
				null,//$post['bank_number'],
				null,//$post['bank_meigi'],
				null,//$post['cd_title'],
				null,//$post['cd_deatil'],
				null,//$post['cdf_title'],
				null,//$post['cdf_img1'],
				null,//$post['cdf_detail1'],
				null,//$post['cdf_img2'],
				null,//$post['cdf_detail2'],
				null,//$post['cdf_img3'],
				null,//$post['cdf_detail3'],
				0,//$post['browse_num'],
				0,//$post['reserve_num'],
				0,//$post['review_point'],
				0,//$post['review_num'],
				0,//$post['review_ave'],
				null,//$post['etc_comment'],
				0,//$post['del_flg'],
		));

		$subject_adminer = '【'."healing-tokyo".'】仮登録がありました。';

		$body_in = '
/***********************************************************/
This will be an automatic email.
/***********************************************************/

ご担当者様
ご掲載社さま('.$post['company_name'].')より仮登録がありました。
お手数ですが認証等のご対応よろしくお願い致します。


/*--------------------------------------------*/
healing-tokyo
/*--------------------------------------------*/
';

		$subject__me = '【'."healing-tokyo".'】healing-tokyo 会員登録ありがとうございます。';
		$body_in_me = '

'.$post['company_name'].'様

この度は、healing-tokyo会員にご登録頂き、誠にありがとうございます。
このメールは、ご登録時に確認のため送信させて頂いております。

簡単な審査を行いますので、恐縮ですが会員登録完了のメールが届くまで、
今しばらくお待ちください。

※このメールは送信専用メールアドレスから配信されています。

*******************************************************
 Company name
 company addr
 Tel：
 Fax：
 E-Mail：test@sample.com
 URL：https://www.healing-tokyo.com/
*******************************************************

';


		if ($_SERVER['HTTP_HOST']=='localhost') {
			var_dump($post);
			var_dump($subject);
			var_dump($body);
		} else {
			mb_language ( "Japanese" );
			mb_internal_encoding ( "UTF-8" );
			
			
			$header  = "Content-Type: text/plain; charset=ISO-2022-JP \n";
			$header .= "Content-Transfer-Encoding: 7bit \n";
			$header .= "Mime-Version: 1.0 \n";
			$header .= "Return-Path: " . "no-reply@healing-tokyo.com" . "\n";
			$header .= "From:" .mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
			$header .= "Sender: " . mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
			$header .= "Reply-To: " .mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
			$header .= "Organization: " . "no-reply@healing-tokyo.com" . " \n";
			$header .= "X-Sender: " . "no-reply@healing-tokyo.com" . " \n";
			$header .= "X-Priority: 3 \n";

			mb_send_mail($post['mail'], $subject__me, $body_in_me, $header);
			mb_send_mail("tech@2floor.jp", $subject_adminer, $body_in, $header);
		}




		header("Location:../../agency_signup_comp.php");
		exit();
	}




	public function store_basic_edit($post) {

		if($post['password_change'] != null && $post['password_change'] != ''){
			$pw = $this->common_logic->convert_password_encode($post['password']);
			$this->common_logic->update_logic("t_store_basic", " where store_basic_id = ? ", array("password"), array($pw, $_SESSION['jis']['login_member']['store_basic_id']));
		}

		$r = $this->common_logic->update_logic("t_store_basic", " where store_basic_id = ? ", array(
				'store_type',
				'company_name',
				'company_name_eng',
				'contact_name',
				'contact_name_kana',
				'contact_name_eng',
				'mail',
				'country_phone',
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
		), array(
				$post['store_type'],
				$post['company_name'],
				$post['company_name_eng'],
				$post['contact_name'],
				$post['contact_name_kana'],
				$post['contact_name_eng'],
				$post['mail'],
				$post['country_phone'],
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
				$_SESSION['jis']['login_member']['store_basic_id'],
		));

		$mem = $this->common_logic->select_logic("select * from t_store_basic where store_basic_id = ? ", array($_SESSION['jis']['login_member']['store_basic_id']));
		$_SESSION['jis']['login_member'] = $mem[0];
		unset($_SESSION['jis']['login_member']['password']);
		$_SESSION['jis']['ty'] = 2;



		$subject = '【'."healing-tokyo".'】事業者様情報が変更されました。';

		$body = '
/***********************************************************/
This will be an automatic email.
/***********************************************************/

'.$mem[0]['company_name'].'
'.$mem[0]['contact_name'].' 様

事業者様情報の編集が完了いたしました。
これからもhealing-tokyoを宜しくお願い致します。

/*--------------------------------------------*/
healing-tokyo
/*--------------------------------------------*/
';


			mb_language ( "Japanese" );
			mb_internal_encoding ( "UTF-8" );
			
			$header  = "Content-Type: text/plain; charset=ISO-2022-JP \n";
			$header .= "Content-Transfer-Encoding: 7bit \n";
			$header .= "Mime-Version: 1.0 \n";
			$header .= "Return-Path: " . "no-reply@healing-tokyo.com" . "\n";
			$header .= "From:" .mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
			$header .= "Sender: " . mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
			$header .= "Reply-To: " .mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
			$header .= "Organization: " . "no-reply@healing-tokyo.com" . " \n";
			$header .= "X-Sender: " . "no-reply@healing-tokyo.com" . " \n";
			$header .= "X-Priority: 3 \n";

			mb_send_mail($post['mail'], $subject, $body, $header);




			
			$subject = '【'."healing-tokyo".'】事業者様情報が変更されました。';
		$body = '
/***********************************************************/
This will be an automatic email.
/***********************************************************/

ご担当者様

'.$mem[0]['company_name'].'
'.$mem[0]['contact_name'].' 様の事業者様情報の編集が完了いたしました。
ご確認お願い致します。

/*--------------------------------------------*/
healing-tokyo
/*--------------------------------------------*/
';
			mb_send_mail("tech@2floor.jp", $subject, $body, $header);






		header("Location:../../mypage_agency/edit_infomation_comp.php");
		exit();
	}


	public function tour_regist($post){

		if($post['discount_rate_setting'] == '' || $post['discount_rate_setting'] == null)$post['discount_rate_setting'] = 0;

		$tour_id = $this->common_logic->insert_logic("t_tour", array(
				$_SESSION['jis']['login_member']['store_basic_id'],
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
				0,// $post['del_flg'],
				$post['public_flg'],

		), "tour_id");


		for ($i = 1; $i <= $post["tour_num"]; $i++) {


		    if ($post['max_number_of_people-' . $i] == '') {
		        $post['max_number_of_people-' . $i] = null;
		    }



			$tour_relation_id = $this->common_logic->insert_logic("t_tour_relation", array(
					$tour_id,
					$post['start_date-' . $i],
					$post['end_date-' . $i],
					$post['start_time-' . $i],
					$post['end_time-' . $i],
					$post['holiday_week-' . $i],
					$post['max_number_of_people-' . $i],
					0,//$post['del_flg'],
					$post['public_flg'],
			), "tour_relation_id");


			for ($j = 1; $j <= $post["exception_num-" . $i]; $j++) {

			    if ($post['exception_date-' . $i . '_' . $j] == '') {
			        $post['exception_date-' . $i . '_' . $j] = null;
			    }

			    if ($post['ex_max_number_of_people-' . $i . '_' . $j] == '') {
			        $post['ex_max_number_of_people-' . $i . '_' . $j] = null;
			    }

				$this->common_logic->insert_logic("t_tour_relation_exception", array(
						$tour_relation_id,
						$tour_id,
						$post['exception_date-' . $i . '_' . $j],
						$post['ex_max_number_of_people-' . $i . '_' . $j],
						0,//$post['del_flg'],
				));
			}
		}

		if($post['honyaku'] == '1'){
			//翻訳申請
			$this->common_logic->insert_logic("t_eng_offer", array(
					$_SESSION['jis']['login_member']['store_basic_id'],
					$tour_id,
					0,//$post['status'],
					null,//$post['remarks'],
					0,//$post['del_flg'],
			));

			$subject_adminer = '【'."healing-tokyo".'】翻訳申請がありました';

			$body_in = '
/***********************************************************/
This will be an automatic email.
/***********************************************************/


ご担当者様
ご掲載社さま('.$_SESSION['jis']['login_member']['company_name'].')より翻訳の申請がございました。
お手数ですがご対応よろしくお願い致します。


/*--------------------------------------------*/
healing-tokyo
/*--------------------------------------------*/
';


			if ($_SERVER['HTTP_HOST']=='localhost') {
				var_dump($post);
				var_dump($subject);
				var_dump($body);
			} else {
				mb_language ( "Japanese" );
				mb_internal_encoding ( "UTF-8" );

				
				$header  = "Content-Type: text/plain; charset=ISO-2022-JP \n";
				$header .= "Content-Transfer-Encoding: 7bit \n";
				$header .= "Mime-Version: 1.0 \n";
				$header .= "Return-Path: " . "no-reply@healing-tokyo.com" . "\n";
				$header .= "From:" .mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
				$header .= "Sender: " . mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
				$header .= "Reply-To: " .mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
				$header .= "Organization: " . "no-reply@healing-tokyo.com" . " \n";
				$header .= "X-Sender: " . "no-reply@healing-tokyo.com" . " \n";
				$header .= "X-Priority: 3 \n";

// 				mb_send_mail($mail, $subject, $body, $header);
				mb_send_mail("tech@2floor.jp", $subject_adminer, $body_in, $header);
			}

		}


		header("Location:../../mypage_agency/edit_comp.php");
		exit();
	}



	public function tour_edit($post){


		$id_ar = $this->jis_common_logic->get_tour_id($post['tour_id']);

		if($post['adult_fee'] == '')$post['adult_fee'] == null;
		if($post['children_fee'] == '')$post['children_fee'] == null;
		if($post['adult_fee'] == '')$post['adult_fee'] == null;
		if($post['discount_rate_setting'] == '' || $post['discount_rate_setting'] == null)$post['discount_rate_setting'] = 0;
		if($post['payment_way'] == '')$post['payment_way'] == 1;

		$tour_id = $this->common_logic->update_logic("t_tour", "where tour_id = ? and store_basic_id = ? ", array(
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
				'public_flg',
		),array(
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
				$post['public_flg'],
				$post['tour_id'],
				$_SESSION['jis']['login_member']['store_basic_id'],
		));

		$t_re = $id_ar['tour_relation'];
		for ($i = 1; $i <= $post["tour_num"]; $i++) {

		    if ($post['max_number_of_people-' . $i] == '') {
		        $post['max_number_of_people-' . $i] = null;
		    }

			if($t_re[$post['tour_relation_id-' . $i]]){
				unset($t_re[$post['tour_relation_id-' . $i]]);



				$this->common_logic->update_logic("t_tour_relation", " where tour_relation_id = ? ", array(
						'start_date',
						'end_date',
						'start_time',
						'end_time',
						'holiday_week',
						'max_number_of_people',
						'public_flg',
				), array(
						$post['start_date-' . $i],
						$post['end_date-' . $i],
						$post['start_time-' . $i],
						$post['end_time-' . $i],
						$post['holiday_week-' . $i],
						$post['max_number_of_people-' . $i],
						$post['public_flg'],
						$post['tour_relation_id-' . $i],
				));
				$tour_relation_id = $post['tour_relation_id-' . $i];
			}else{
				$tour_relation_id = $this->common_logic->insert_logic("t_tour_relation", array(
						$post['tour_id'],
						$post['start_date-' . $i],
						$post['end_date-' . $i],
						$post['start_time-' . $i],
						$post['end_time-' . $i],
						$post['holiday_week-' . $i],
						$post['max_number_of_people-' . $i],
						0,//$post['del_flg'],
						$post['public_flg'],
				), "tour_relation_id");
			}


			$t_re_ex = $id_ar['tour_relation_exception'][$post['tour_relation_id-' . $i]];
			for ($j = 1; $j <= $post["exception_num-" . $i]; $j++) {

				if($post['ex_max_number_of_people-' . $i . '_' . $j] == '' || $post['ex_max_number_of_people-' . $i . '_' . $j] == null || $post['exception_date-' . $i . '_' . $j] == null || $post['exception_date-' . $i . '_' . $j] == '' )continue;
				if($t_re_ex[$post['tour_relation_exception_id-' . $i . '_' . $j]]){
					unset($t_re_ex[$post['tour_relation_exception_id-' . $i . '_' . $j]]);

					if ($post['ex_max_number_of_people-' . $i . '_' . $j] == '') {
					    $post['ex_max_number_of_people-' . $i . '_' . $j] = null;
					}

					if ($post['exception_date-' . $i . '_' . $j] == '') {
					    $post['exception_date-' . $i . '_' . $j] = null;
					}


					$f = $this->common_logic->update_logic("t_tour_relation_exception", " where tour_relation_exception_id = ? ", array(
							'exception_date',
							'max_number_of_people',
					), array(
							$post['exception_date-' . $i . '_' . $j],
							$post['ex_max_number_of_people-' . $i . '_' . $j],
							$post['tour_relation_exception_id-' . $i . '_' . $j],
					));
				}else{
					$this->common_logic->insert_logic("t_tour_relation_exception", array(
							$tour_relation_id,
							$post['tour_id'],
							$post['exception_date-' . $i . '_' . $j],
							$post['ex_max_number_of_people-' . $i . '_' . $j],
							0,//$post['del_flg'],
					));
				}
			}
			foreach ((array)$t_re_ex as $tre_id => $b2) {
				$r  = $this->common_logic->select_logic("DELETE from t_tour_relation_exception where tour_relation_exception_id = ? ", array($tre_id));
			}
		}
		foreach ((array)$t_re as $tr_id => $b1) {
			$this->common_logic->select_logic("DELETE from t_tour_relation where tour_relation_id = ? ", array($tr_id));
		}



		if($post['honyaku'] == '1'){
			//翻訳申請
			$this->common_logic->insert_logic("t_eng_offer", array(
					$_SESSION['jis']['login_member']['store_basic_id'],
					$post['tour_id'],
					0,//$post['status'],
					null,//$post['remarks'],
					0,//$post['del_flg'],
			));

			$subject_adminer = '【'."healing-tokyo".'】翻訳申請がありました';

			$body_in = '
/***********************************************************/
This will be an automatic email.
/***********************************************************/


ご担当者様
ご掲載社さま('.$_SESSION['jis']['login_member']['company_name'].')より翻訳の申請がございました。
お手数ですがご対応よろしくお願い致します。


/*--------------------------------------------*/
healing-tokyo
/*--------------------------------------------*/
';


			if ($_SERVER['HTTP_HOST']=='localhost') {
				var_dump($post);
				var_dump($subject);
				var_dump($body);
				exit();
			} else {
				mb_language ( "Japanese" );
				mb_internal_encoding ( "UTF-8" );

				$header  = "Content-Type: text/plain; charset=ISO-2022-JP \n";
				$header .= "Content-Transfer-Encoding: 7bit \n";
				$header .= "Mime-Version: 1.0 \n";
				$header .= "Return-Path: " . "no-reply@healing-tokyo.com" . "\n";
				$header .= "From:" .mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
				$header .= "Sender: " . mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
				$header .= "Reply-To: " .mb_encode_mimeheader("healing-tokyo",'ISO-2022-JP') ."<"."no-reply@healing-tokyo.com".">\n";
				$header .= "Organization: " . "no-reply@healing-tokyo.com" . " \n";
				$header .= "X-Sender: " . "no-reply@healing-tokyo.com" . " \n";
				$header .= "X-Priority: 3 \n";

				// 				mb_send_mail($mail, $subject, $body, $header);
				mb_send_mail("tech@2floor.jp", $subject_adminer, $body_in, $header);
			}

		}




		header("Location:../../mypage_agency/edit_comp.php");
		exit();
	}




}