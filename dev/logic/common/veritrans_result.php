<?php
ini_set("display_errors", '1');

require_once __DIR__ .  '/../../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../../logic/common/common_logic.php';
$jis_common_logic = new jis_common_logic();
$common_logic = new common_logic();


$dump = '';
foreach ($_POST as $k => $v){
	$dump .= $k.':'.$v."\n";
}
file_put_contents(ceil(microtime(true)) ."vewi.txt", $dump);

if($_POST['orderId'] != null && $_POST['orderId'] != ''){
	if($_POST['mStatus'] == 'success'){
		$rsv_pre = $common_logic->select_logic("select * from t_reservation_pre where order_id = ? ", array(
				$_POST['orderId'],
		));

		if($rsv_pre != null && $rsv_pre != ''){
// 			$common_logic->update_logic("t_reservation_pre", " where reservation_pre_id = ? ", array(
// 					'settlement_flg',
// 					'vResultCode'
// 			), array(
// 					1,
// 					$_POST['vResultCode'],
// 					$rsv_pre[0]['reservation_pre_id'],
// 			));

			$reservation_id = $common_logic->insert_logic("t_reservation", array(
					$rsv_pre[0]['tour_relation_id'],
					$rsv_pre[0]['tour_name'],
					$rsv_pre[0]['men_num'],
					$rsv_pre[0]['women_num'],
					$rsv_pre[0]['children_num'],
					$rsv_pre[0]['come_date'],
					$rsv_pre[0]['end_date'],
					$rsv_pre[0]['payment_way'],
					$rsv_pre[0]['adult_fee'],
					$rsv_pre[0]['children_fee'],
					$rsv_pre[0]['total'],
					$rsv_pre[0]['tax'],
					$rsv_pre[0]['total_add_tax'],
					$rsv_pre[0]['order_id'],
					$rsv_pre[0]['session_id'],
					$rsv_pre[0]['link_exp_datetime'],
					$rsv_pre[0]['settlement_url'],
					1,//$rsv_pre[0]['settlement_flg'],
					$_POST['vResultCode'],
					$rsv_pre[0]['name'],
					$rsv_pre[0]['name_kana'],
					$rsv_pre[0]['age'],
					$rsv_pre[0]['sex'],
					$rsv_pre[0]['tel'],
					$rsv_pre[0]['mail'],
					$rsv_pre[0]['question_answer'],
					0,//$rsv_pre[0]['cancel_flg'],
					$rsv_pre[0]['member_id'],
					$rsv_pre[0]['store_basic_id'],
					0,//$rsv_pre[0]['del_flg'],
			),"reservation_id");


			$rsv = $jis_common_logic->get_reserve_detail($reservation_id);


			$store = $common_logic->select_logic("select * from t_store_basic where store_basic_id = ? ", array(
					$rsv['store_basic_id'],
			));

			$member = $common_logic->select_logic("select * from t_member where member_id = ? ", array($rsv['member_id']));

			$tour = $jis_common_logic->get_tour($rsv['tour_relation_id'], true);

			if((int)$tour['tour']['discount_rate_setting'] > 0){
				$descPrioce =   $jis_common_logic->calc_discount($tour['tour']['adult_fee'], $tour['tour']['discount_rate_setting']);
				$childDescPrioce =   $jis_common_logic->calc_discount($tour['tour']['children_fee'], $tour['tour']['discount_rate_setting']);
				$child_price = '';
				$descper =  '
'. $tour['tour']['discount_rate_setting'] . "% OFF";
				$newA_Price = number_format($tour['tour']['adult_fee']) . "→" . number_format($descPrioce);
				$newC_Price = number_format($tour['tour']['children_fee']) . "→" . number_format($childDescPrioce);
			}else{
				$descPrioce = $tour['tour']['adult_fee'];
				$childDescPrioce =   $tour['tour']['children_fee'];

				$descper =   "";
				$newA_Price = number_format($descPrioce);
				$newC_Price = number_format($childDescPrioce);

			}

			if(strpos($rsv['payment_way'], "1") !== false ){
				$payment_way = 'Cash on site';
			}elseif(strpos($rsv['payment_way'], "3") !== false ){
				$payment_way  = 'Credit card('.$tour['tour']['card_choice'].')';
			}elseif(strpos($rsv['payment_way'], "2") !== false ){
				$payment_way = 'Immediate payment by credit card';
			}

			$body_in = "
Booking ref　　　:". $_POST['orderId']."
Title　　　　　　:". $rsv['tour_name']."
Date,Time　　　　:". date("d/M/Y H:i", strtotime($rsv['come_date']))."
Operator 　　　　:". $store[0]['company_name_eng']."
Emergency contact:". $store[0]['emergency_tel']."
Male 　　　　　　:". $rsv['men_num']."
Female 　　　　　:". $rsv['women_num']."
Child　　　　　　:". $rsv['children_num']."
Adult fee(JPY)　 :". $newA_Price."
Child fee(JPY)　 :". $newC_Price."".$descper."
Total fee(JPY)　 :". number_format($rsv['total'])."
Payment method　 :".$payment_way."


Customer Information.
name 　　　　:". $rsv['name']."
Tel　　　　　:". $rsv['tel']."


Activity meeting Point
Please copy and paste the bellow address into Google Map.
".$rsv['tour']['meeting_place']."


";

			mb_language ( "Japanese" );
			mb_internal_encoding ( "UTF-8" );

			$from_name = 'Japan International Services';
			$from = 'credit@jis-j.com';
			$subject = "【Japan International Services】Your booking has been completed.";
			$subject_adminer = "【Japan International Services】アクティビティ予約が入りました。";
			$body = "
*This will be an automatic email.

Hi. ". $rsv['name']."

Your booking has been completed.
Please keep this email as confirmed document.

Details as follows


".$body_in."

* If the operator require to make a contact (starting time, clothing size adjustment, etc.), you may receive additional email directly.
* When you would like to change the number of participants or the contents, please cancel the original booking then make a new booking.
* You can check current booking status by “MY PAGE”
* If you wish to cancel on the day of the activity, be sure to call the operator's emergency contact.


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
/***********************************************************/
こちらは自動送信メールになります。
/***********************************************************/

". $store[0]['company_name']."さま

下記のユーザーより予約が完了しました。
ご確認お願い致します。

" .$body_in;

			$header = "Content-Type: text/plain; charset=UTF-8 \n";
			$header .= "Content-Transfer-Encoding: BASE64 \n";
			$header .= "Return-Path: " . $from . "\n";
			$header .= "From:" .mb_encode_mimeheader($from_name) ."<".$from.">\n";
			$header .= "Sender: " . $from_name ."\n";
			$header .= "Reply-To: " .mb_encode_mimeheader($from_name) ."<".$from.">\n";
			$header .= "Organization: " . $from . " \n";
			$header .= "X-Sender: " . $from . " \n";
			$header .= "X-Priority: 3 \n";


			mb_send_mail($member[0]['mail'], $subject, base64_encode($body), $header);
			mb_send_mail($store[0]['mail'], $subject_adminer, base64_encode($body_adminer), $header);

			mb_send_mail("kawahata@2floor.jp", "[2fDev]".$subject_adminer, base64_encode($body_adminer), $header);
			mb_send_mail("kawahata@2floor.jp", "[2fDev]".$subject, base64_encode($body), $header);

			mb_send_mail("tour@jis-j.com", "".$subject_adminer, base64_encode($body_adminer), $header);



		}else{
			header("Location:../../");
			exit();
		}

	}else{
		//キャンセル処理
		$common_logic->update_logic("t_reservation", " where reservation_id = ? ", array(
				'cancel_flg',
				'vResultCode'
		), array(
				1,
				$_POST['vResultCode'],
				$rsv['reservation_id'],

		));
	}
}else{
	header("Location:../../");
	exit();
}