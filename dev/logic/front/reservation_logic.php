<?php
session_start();
require_once __DIR__ .  '/../../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../../logic/common/common_logic.php';
require_once __DIR__ .  '/../../logic/common/veritrans.php';
$jis_common_logic = new jis_common_logic();
$common_logic = new common_logic();
$veritrans = new veritrans();


$post = $_POST;

$tour = $jis_common_logic->get_tour($post['tour_relation_id'], true);
$tour_relation = $common_logic->select_logic("select * from t_tour_relation where tour_relation_id = ?  ",array($post['tour_relation_id']));

$m_res = $common_logic->select_logic("select * from t_member where member_id = ? ", array($_SESSION['jis']['login_member']['member_id']));
$m_row = $m_res[0];


//多重決済回避
$rsv_check = $common_logic->select_logic("select * from  t_reservation where member_id = ? and tour_relation_id = ? and DATE_FORMAT(`come_date`, '%Y-%m-%d') = ? and cancel_flg = 0 ", array($_SESSION['jis']['login_member']['member_id'], $post['tour_relation_id'], $post['come_date']));
if($rsv_check != null && $rsv_check != ''){
	if($rsv_check[0]['settlement_flg'] == '0' && $rsv_check[0]['settlement_flg'] != null){
		header("Location:".$rsv_check[0]['settlement_url']);
		exit();
	}else{
		echo "Duplicate booking.";
		exit();
	}
}

$tax = $jis_common_logic->get_tax();

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


$adult_num = (int)$post['men_num'] + (int)$post['women_num'];
$adult_base = $adult_num * $descPrioce;
$adult_price = $adult_base;// + ceil($adult_base * $tax);


$child_num = (int)$post['children_num'];
$child_base = $child_num * $childDescPrioce;
$child_price = $child_base;// + ceil($child_base * $tax);
$total= $adult_price + $child_price;


$rsv_table = 'reservation';
//クレカ決済事前登録処理用テーブルインサート
if($post['payment_way'] ==2 ){
	$rsv_table = 'reservation_pre';
}

$reservation_id = $common_logic->insert_logic("t_".$rsv_table, array(
		$post['tour_relation_id'],
		$tour['tour']['title'],
		$post['men_num'],
		$post['women_num'],
		$post['children_num'],
		$post['come_date'] ." " .$tour_relation[0]['start_time'],
		$post['come_date'] ." " .$tour_relation[0]['end_time'],
		$post['payment_way'],
		$descPrioce,
		$childDescPrioce,
		$child_base + $adult_base,
		$tax,
		$total,
		null,//$post['order_id'],
		null,//$post['session_id'],
		null,//$post['link_exp_datetime'],
		null,//$post['settlement_url'],
		0,//$post['settlement_flg'],
		null,//$post['vResultCode'],
		$_SESSION['jis']['login_member']['name'],
		$_SESSION['jis']['login_member']['name_kana'],
		$_SESSION['jis']['login_member']['age'],
		$_SESSION['jis']['login_member']['sex'],
		$_SESSION['jis']['login_member']['tel'],
		$_SESSION['jis']['login_member']['mail'],
		$post['question_answer'],
		0,//$post['cancel_flg'],
		$_SESSION['jis']['login_member']['member_id'],
		$tour['tour']['store_basic_id'],
		0,//$post['del_flg'],
),$rsv_table."_id");


if($reservation_id == null || $reservation_id == '' || $reservation_id == '0'){
	echo "reservation_id is null";
	exit();
}


$order_id = $common_logic->zero_padding($tour['tour']['tour_id'],6). "-1" .$common_logic->zero_padding($reservation_id,5);

if($post['payment_way'] ==2 ){
	//決済処理
	$veritrans = new veritrans();
	$veritrans->set_key_param($order_id, $total);
	$respons = $veritrans->create_key();
	$url = $respons['url'];

	$common_logic->update_logic("t_reservation_pre", " where reservation_pre_id = ? " ,array(
			'order_id',
			'session_id',
			'link_exp_datetime',
// 			'settlement_url',
	),array(
			$order_id,
			$respons['session_id'],
			$respons['link_exp_datetime'],
// 			$respons['url'],
			$reservation_id
	));

	if($respons['link_settlement']){
		print '<script type="text/javascript">
			    window.onload = function(){
			        document.postForm.submit();
			    }
			</script>

			<form action="https://pay.veritrans.co.jp/web1/deviceCheck.action" method="POST" name="postForm">
			    '.$respons['url'].'
			</form>';exit();
	}


}else{
		$common_logic->update_logic("t_reservation", " where reservation_id = ? " ,array(
				'order_id',
		),array(
				$order_id,
				$reservation_id
		));

		$rsv = $common_logic->select_logic("select * from t_reservation where reservation_id = ? ", array(
				$reservation_id
		));
		$store = $common_logic->select_logic("select * from t_store_basic where store_basic_id = ? ", array(
				$rsv[0]['store_basic_id'],
		));

		$common_logic->update_logic("t_store_basic", " where store_basic_id = ? " ,array(
				'reserve_num',
		),array(
				(int)$store[0]['reserve_num'] + 1,
				$rsv[0]['store_basic_id'],
		));

		if((int)$tour['tour']['discount_rate_setting'] > 0){
			$descPrioce =   $jis_common_logic->calc_discount($tour['tour']['adult_fee'], $tour['tour']['discount_rate_setting']);
			$childDescPrioce =   $jis_common_logic->calc_discount($tour['tour']['children_fee'], $tour['tour']['discount_rate_setting']);
			$child_price = '';
			$descper =  '
'. $tour['tour']['discount_rate_setting'] . "% OFF";
			$newA_Price = "". number_format($tour['tour']['adult_fee']) . "→" . "". number_format($descPrioce);
			$newC_Price = "". number_format($tour['tour']['children_fee']) . "→" . "". number_format($childDescPrioce);
		}else{
			$descPrioce = $tour['tour']['adult_fee'];
			$childDescPrioce =   $tour['tour']['children_fee'];

			$descper =   "";
			$newA_Price = number_format($descPrioce);
			$newC_Price = number_format($childDescPrioce);

		}


		if(strpos($rsv[0]['payment_way'], "1") !== false ){
			$payment_way = 'Cash on site';
		}elseif(strpos($rsv[0]['payment_way'], "3") !== false ){
			$payment_way  = 'Credit card('.$tour['tour']['card_choice'].')';
		}elseif(strpos($rsv[0]['payment_way'], "2") !== false ){
			$payment_way = 'Immediate payment by credit card';
		}


		$body_in = "
Booking ref　　　:". $order_id."
Title　　　　　　:". $rsv[0]['tour_name']."
Date,Time　　　　:". date("d/M/Y H:i", strtotime($rsv[0]['come_date']))."
Operator 　　　　:". $store[0]['company_name_eng']."
Emergency contact:". $store[0]['emergency_tel']."
Male 　　　　　　:". $rsv[0]['men_num']."
Female 　　　　　:". $rsv[0]['women_num']."
Child　　　　　　:". $rsv[0]['children_num']."
Adult fee(JPY)　 :". $newA_Price."
Child fee(JPY)　 :". $newC_Price."".$descper."
Total fee(JPY)　 :". number_format($rsv[0]['total'])."
Payment method　 :".$payment_way."


Customer Information.
name 　　　　:". $rsv[0]['name']."
Tel　　　　　:". $rsv[0]['tel']."


Activity meeting Point
Please copy and paste the bellow address into Google Map.
".$tour['tour']['meeting_place']."


";

		mb_language ( "Japanese" );
		mb_internal_encoding ( "UTF-8" );

		$from_name = 'Japan International Services';
		$from = 'no-reply@jis-j.com';
		$subject = "【Japan International Services】Your booking has been completed.";
		$subject_adminer = "【Japan International Services】アクティビティの予約が入りました";
		$body = "
*This will be an automatic email.

Hi. ". $rsv[0]['name']."

Your booking has been completed.
Please keep this email as confirmed document.

Details as follows


".$body_in."

*If the operator require to make a contact (starting time, clothing size adjustment, etc.), you may receive additional email directly.
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

		$body_adminer = "
/***********************************************************/
こちらは自動送信メールになります。
/***********************************************************/


". $store[0]['company_name']."さま

下記のユーザーより、予約が入りました。
ご確認お願い致します

".$body_in."

/*--------------------------------------------*/
Japan International Services
/*--------------------------------------------*/
";
		$body_adminer_jis = "
/***********************************************************/
こちらは自動送信メールになります。
/***********************************************************/


下記のユーザーより、予約が入りました。
ご確認お願い致します

".$body_in."

/*--------------------------------------------*/
Japan International Services
/*--------------------------------------------*/
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


		mb_send_mail($rsv[0]['mail'], $subject, base64_encode($body), $header);
		mb_send_mail($store[0]['mail'], $subject_adminer, base64_encode($body_adminer), $header);

		mb_send_mail("kawahata@2floor.jp", "[2fDev]".$subject_adminer, base64_encode($body_adminer), $header);
		mb_send_mail("kawahata@2floor.jp", "[2fDev]".$subject, base64_encode($body), $header);
		mb_send_mail("tour@jis-j.com", "".$subject_adminer, base64_encode($body_adminer_jis), $header);


		$url = '../../search/reserve_comp.php';

}

header("Location:".$url);
exit();

?>