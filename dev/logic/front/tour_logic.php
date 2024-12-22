<?php

session_start();
require_once __DIR__ .  '/../../logic/common/common_logic.php';
require_once __DIR__ .  '/../../logic/common/jis_common_logic.php';

$tour_logic = new tour_logic();
$tour_logic->ct($_POST);

class tour_logic {

	private $common_logic;
	private $jis_common_logic;

	public function __construct(){
		$this->common_logic = new common_logic();
		$this->jis_common_logic = new jis_common_logic();
	}

	public function ct($post) {
		if($post['method'] == 'status_change'){
			$this->status_change($post);
		}elseif($post['method'] == 'cancel_rsv'){
			$this->cancel_rsv($post);
		}
	}

	public function status_change($post) {
		$this->common_logic->update_logic("t_tour", " where tour_id = ? ", array(
				$post['status_change_col'],
		), array(
				$post['status_change_val'],
				$post['tour_id'],
		));

		$data = array(
				'status' => true,
		);
		echo json_encode ( compact ( 'data' ) );
	}

	public function cancel_rsv($post) {
		$this->common_logic->update_logic("t_reservation", " where reservation_id = ? ", array(
				"cancel_flg",
		), array(
				1,
				$post['rsv_id'],
		));

		$rsv = $this->jis_common_logic->get_reserve_detail($post['rsv_id']);

		$store = $this->common_logic->select_logic("select * from t_store_basic where store_basic_id = ? ", array(
				$rsv['store_basic_id']
		));


		$descPrioce = $rsv['adult_fee'] * ($rsv['men_num'] + $rsv['women_num']);
		$childDescPrioce =   $rsv['children_fee'] * ($rsv['children_num'] );

		$newA_Price = number_format($descPrioce);
		$newC_Price = number_format($childDescPrioce);


		if(strpos($rsv['payment_way'], "1") !== false ){
			$payment_way = 'Cash on site';
		}elseif(strpos($rsv['payment_way'], "3") !== false ){
			$payment_way  = 'Credit card('.$rsv['tour']['card_choice'].')';
		}elseif(strpos($rsv['payment_way'], "2") !== false ){
			$payment_way = 'Immediate payment by credit card';
		}

		$body_in = "
Booking ref　　　:". $rsv['order_id']."
Title　　　　　　:". $rsv['tour_name']."
Date,Time　　　　:". date("d/M/Y H:i", strtotime($rsv['come_date']))."
Operator 　　　　:". $store[0]['company_name_eng']."
Emergency contact:". $store[0]['emergency_tel']."
Male 　　　　　　:". $rsv['men_num']."
Female 　　　　　:". $rsv['women_num']."
Child　  　　　　:". $rsv['children_num']."
Adult fee(JPY)　 :". $newA_Price."
Child fee(JPY)　 :". $newC_Price."
Total fee(JPY)　 :". number_format($rsv['total'])."
Payment method　 :".$payment_way."


Activity meeting Point
Please copy and paste the bellow address into Google Map.
".$rsv['tour']['meeting_place']."


Customer Information.
name 　　　　:". $rsv['name']."
Tel　　　　　:". $rsv['tel']."

";

		mb_language ( "Japanese" );
		mb_internal_encoding ( "UTF-8" );

		$from_name = 'Japan International Services';
		$from = 'jis@jis-j.com';
		$subject = "【Japan International Services】Your booking has been cancelled.";
		$subject_admier = "【Japan International Services】アクティビティ予約がキャンセルされました.";
		$body = "
*This will be an automatic email.

Hi. ". $rsv['name']."

Thank you for letting us know your cancellation.
We have acknowledged your E-Mail.

Details as follows

".$body_in."

* We hope to see you again.
* You can check current booking status by “MY PAGE”
* Refer to cancellation policy, operator may contact you later.

*******************************************************
 Japan International Service Co.,Ltd.(JIS)
 2-23-1-218 Yoyogi Shibuya-ku Tokyo 151-0053
 Tel：+81-3-4588-1055
 Fax：+81-3-6300-0887
 E-Mail：enquiry@jis-j.com
 URL：https://www.jis-j.com/
*******************************************************

";
		$body_adminer  = "
下記のユーザーより予約がキャンセルされました。
ご確認お願い致します。

				" .$body_in . "

*******************************************************
 ㈱ジャパン インターナショナル サービス(JIS)
 〒151-0053 東京都渋谷区代々木2-23-1-218
 Tel：03-4588-1055/Fax：03-6300-0887
 E-Mail：enquiry@jis-j.com
 URL：https://www.jis-j.com
*******************************************************
";
		$header = "Content-Type: text/plain; charset=UTF-8 \n";
		$header .= "Content-Transfer-Encoding: BASE64 \n";
		$header .= "Return-Path: " . $from . "\n";
		$header .= "From:" .mb_encode_mimeheader($from_name) ."<".$from.">\n";
		$header .= "Sender: " . $from_name ."\n";
		$header .= "Reply-To: " .mb_encode_mimeheader($from_name) ."<".$from.">\n";
		$header .= "Organization: " . $from . " \n";
		$header .= "X-Sender: " . $from . " \n";
		$header .= "X-Priority: 3 \n";


		mb_send_mail($rsv['mail'], $subject, base64_encode($body), $header);
		mb_send_mail($store[0]['mail'], $subject_admier, base64_encode($body_adminer), $header);
		mb_send_mail("tour@jis-j.com", $subject_admier, base64_encode($body_adminer), $header);
		mb_send_mail("kawahata@2floor.jp", "[2fDev]".$subject_admier, base64_encode($body_adminer), $header);

		$data = array(
				'status' => true,
		);
		echo json_encode ( compact ( 'data' ) );
	}


}