<?php
session_start();
require_once __DIR__ .  '/../../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../../logic/common/common_logic.php';
// require_once __DIR__ .  '/../../logic/common/veritrans.php';
$jis_common_logic = new jis_common_logic();
$common_logic = new common_logic();
// $veritrans = new veritrans();

$post = $_POST;

$tax = $jis_common_logic->get_tax();
$tour = $jis_common_logic->get_tour($post['trid'], true);

$adult_num = (int)$post['men_num'] + (int)$post['women_num'];
$adult_base = $adult_num * $tour['tour']['adult_fee'];
$adult_price = $adult_base + ceil($adult_base * $tax);


$child_num = (int)$post['children_num'];
$child_base = $child_num * $tour['tour']['children_fee'];
$child_price = $child_base + ceil($child_base * $tax);
$total= $adult_price + $child_price;

$r = $common_logic->update_logic("t_reservation", " where reservation_id = ? ",array(
		'men_num',
		'women_num',
		'children_num',
		"total",
		"total_add_tax"
),array(
		$post['men_num'],
		$post['women_num'],
		$post['children_num'],
		$total,
		$jis_common_logic->add_tax($total),
		$post['rid']
));


$url = '../../mypage_agency/reserve_comp.php';
header("Location:".$url);
exit();







$tour_relation = $common_logic->select_logic("select * from t_tour_relation where tour_relation_id = ?  ",array($post['tour_relation_id']));

$m_res = $common_logic->select_logic("select * from t_member where member_id = ? ", array($_SESSION['jis']['login_member']['member_id']));
$m_row = $m_res[0];




//多重決済回避
$rsv_check = $common_logic->select_logic("select * from  t_reservation where member_id = ? and tour_relation_id = ? and DATE_FORMAT(`come_date`, '%Y-%m-%d') = ? and cancel_flg = 0 ", array($_SESSION['jis']['login_member']['member_id'], $post['tour_relation_id'], $post['come_date']));
if($rsv_check != null && $rsv_check != ''){
	if($rsv_check[0]['settlement_flg'] == '0'){
		header("Location:".$rsv_check[0]['settlement_url']);
		exit();
	}else{
		echo "This tour Alerady paied.";
	}
}

$tax = $jis_common_logic->get_tax();

$adult_num = (int)$post['men_num'] + (int)$post['women_num'];
$adult_base = $adult_num * $tour['tour']['adult_fee'];
$adult_price = $adult_base + ceil($adult_base * $tax);


$child_num = (int)$post['children_num'];
$child_base = $child_num * $tour['tour']['children_fee'];
$child_price = $child_base + ceil($child_base * $tax);
$total= $adult_price + $child_price;

$reservation_id = $common_logic->insert_logic("t_reservation", array(
		$post['tour_relation_id'],
		$tour['tour']['title'],
		$post['men_num'],
		$post['women_num'],
		$post['children_num'],
		$post['come_date'] ." " .$tour_relation[0]['start_time'],
		$post['come_date'] ." " .$tour_relation[0]['end_time'],
		$post['payment_way'],
		$tour['tour']['adult_fee'],
		$tour['tour']['children_fee'],
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
),"reservation_id");
if($reservation_id == null || $reservation_id == '' || $reservation_id == '0'){
	echo "reservation_id is null";
	exit();
}

$order_id =  ceil(microtime(true))."-".$common_logic->zero_padding($reservation_id,8);

if($post['payment_way'] ==2 ){
	//決済処理
	$veritrans = new veritrans();
	$veritrans->set_key_param($order_id, $total);
	$respons = $veritrans->create_key();
	$url = $respons['url'];

	$common_logic->update_logic("t_reservation", " where reservation_id = ? " ,array(
			'order_id',
			'session_id',
			'link_exp_datetime',
			'settlement_url',
	),array(
			$order_id,
			$respons['session_id'],
			$respons['link_exp_datetime'],
			$respons['url'],
			$reservation_id
	));





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

		$body_in = "Title　　　　　　:". $rsv[0]['tour_name']."
Date　　　　　　:". date("d/M/Y H:i", strtotime($rsv[0]['come_date']))."
Male 　　　　　　:". $rsv[0]['men_num']."
Femail 　　　　　:". $rsv[0]['women_num']."
Children 　　　　:". $rsv[0]['children_num']."
Adult fee　　　　:". $rsv[0]['adult_fee']."
Chilren’s fare　:". $rsv[0]['children_fee']."
Total　　　　　　:". number_format($rsv[0]['total'])."(JPY)

Your Information.
name 　　　　:". $rsv[0]['name']."
age　　　　　:". $rsv[0]['age']."
Tel　　　　　:". $rsv[0]['tel']."
";

		mb_language ( "Japanese" );
		mb_internal_encoding ( "UTF-8" );

		$from_name = 'healing-tokyo';
		$from = 'no-reply@healing-tokyo.com';
		$subject = "【healing-tokyo】Payment completed.";
		$subject_adminer = "【healing-tokyo】Reservation entered.";
		$body = "
/***********************************************************/
This will be an automatic email.
/***********************************************************/


Hi. ". $rsv[0]['name']."

Payment completed.Thank you.
Please keep this email in a safe place.

Details below.

".$body_in."

/*--------------------------------------------*/
healing-tokyo
/*--------------------------------------------*/
";

		$body_adminer = "
/***********************************************************/
This will be an automatic email.
/***********************************************************/


Hi. ". $store[0]['name']."

Payment completed.
A reservation has been made.
Please confirm details below.

".$body_in."

/*--------------------------------------------*/
healing-tokyo
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

		mb_send_mail("tech@2floor.jp", $subject_adminer, base64_encode($body_adminer), $header);
		mb_send_mail("tech@2floor.jp", $subject, base64_encode($body), $header);

		$url = '../../search/reserve_comp.php';


}

header("Location:".$url);
exit();

?>