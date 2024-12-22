<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
require_once __DIR__ .  '/../logic/common/common_logic.php';
$jis_common_logic = new jis_common_logic();
$front_disp_logic = new front_disp_logic();
$common_logic = new common_logic();

$jis_common_logic->login_check("rsv", $_GET['trid'], $_GET['date'] );
if($_SESSION['jis']['ty'] == "1"){

}else{
	header("Location: ../login.php?er=rsv&r=".$_GET['trid']."&d=".$_GET['date']);
	exit();
}

if($_GET['trid'] == '' || $_GET['trid'] == null ){
	header("Location: ../");
	exit();
}

$tour = $jis_common_logic->get_tour($_GET['trid'], true);
foreach ((array)$tour['tour_relation'] as $tour_relation) {
	if($tour_relation['tour_relation_id'] == $_GET["trid"]){
		$sTime = $tour_relation['start_time'];
		$eTime = $tour_relation['end_time'];

		$limit_num = $tour_relation['max_number_of_people'];
		$excemi = $jis_common_logic->tour_relation_ex_ar_conv($tour['tour_relation_exception'][$_GET["trid"]]);
		if($excemi[$_GET['date']]) $limit_num = $excemi[$_GET['date']]['max_number_of_people'];
		$tour_sum = $common_logic->select_logic("SELECT SUM(`men_num`) AS `sum1`, SUM(`women_num`) AS `sum2`, SUM(`children_num`) AS `sum3` FROM `t_reservation` WHERE `tour_relation_id` = ? AND `del_flg` = 0 AND `cancel_flg` = 0 AND DATE(`come_date`) = ?", array($_GET['trid'], $_GET['date']));
		$sum = (int)$tour_sum[0]['sum1'] + (int)$tour_sum[0]['sum2'] + (int)$tour_sum[0]['sum3'];
		$limit_num = $limit_num - $sum;
	}
}



$tour_img = explode(',', $tour['tour']['img']);
$tour_img = '<img src="../upload_files/tour/'.$tour_img[0].'" alt="">';
if($tour_img[0] == null || $tour_img[0] == ''){
	$tour_img = '<img src="../img/noimage_lg.jpg" alt="">';
}



$payment_way = '';
if(strpos($tour['tour']['payment_way'], "0") !== false ){
	$payment_way .= '<label class="formRBox radioStyle"><input type="radio" name="payment_way" value="1" class="validate" style="width: 15px; height: auto;" checked="checked"><span>Cash on the day</span></label>';
}
if(strpos($tour['tour']['payment_way'], "2") !== false ){
	$payment_way .= '<label class="formRBox radioStyle"><input type="radio" name="payment_way" value="3" class="validate" style="width: 15px; height: auto;"><span>Credit card on the day（'.$tour['tour']['card_choice'].'）</span></span></label>';
}

if(strpos($tour['tour']['payment_way'], "1") !== false ){
	$payment_way .= '<label class="formRBox radioStyle"><input type="radio" name="payment_way" value="2" class="validate" style="width: 15px; height: auto;"><span> Healing Tokyo collects advance payments by credit car</span></span></label>';
}




$numberOpt = '';
$max = 10;
for ($i = 0; $i <= $max; $i++) {
	$numberOpt .= '<option value="'.$i.'">'.$i.'</option>';
}

$tax = $jis_common_logic->get_tax();

$descPrioce = $jis_common_logic->calc_discount($tour['tour']['adult_fee'], $tour['tour']['discount_rate_setting']);
$childDescPrioce = $jis_common_logic->calc_discount($tour['tour']['children_fee'], $tour['tour']['discount_rate_setting']);
$descPrioce_t = $front_disp_logic->change_rate($descPrioce);
$childDescPrioce_t = $front_disp_logic->change_rate($childDescPrioce);

?>

<!DOCTYPE html>
<html lang="ja">
<head>

<?php require_once '../required/html_head.php'?>
<script type="text/javascript" src="../assets/js/validate.js"></script>
<script type="text/javascript" src="../assets/js/form.js"></script>
<script type="text/javascript" src="../assets/admin/js/common.js"></script>

</head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once "../required/header_out_lower.php"?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="sliderBorBtm rsvTop ">
				<div class="container1080 marB0 posRel">
					<div class="reserveMainImage1Area sli_height">
						<div class="reserveMainImage1AreaTxtBox">
							<h1>
								<?php print $tour['tour']['title']?>
							</h1>
						</div>
			            <div class="reserveMainImage1AreaImgBox">
			            	<?php print $tour_img?>
			            </div>
					</div>
				</div>
			</div>


			<div class="container1080 cf">
				<div class="container760" id="inputFormArea">
					<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> Booking form</h2>
							</div>
					<section>
						<h3 class="titleUnderline">Booking application</h3>

					</section>

					<section class="borderBox">
						<div class="storeEditItem">
							<div class="storeEditRow">
									<div class="storeEditCate"> Day</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span><?php print date("d/M/Y H:i", strtotime($_GET['date'] . " ". $sTime))?>～<?php print date("d/M/Y H:i", strtotime($_GET['date'] . " ". $eTime))?></span>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Title</div>
									<div class="storeEditForm">
										<span><a href="./plan.php?tid=<?php print $tour['tour']['tour_id']?>" target="_blank">　<?php print $tour['tour']['title']?></a></span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Pax</div>
									<div class="storeEditForm">
										<span class="formRBox">Male :
											<select class="formTxt1 numberSelect change_money" name="men_num">
												<?php print $numberOpt?>
											</select>
										</span>
										<span class="formRBox">Female :
											<select class="formTxt1 numberSelect change_money" name="women_num">
												<?php print $numberOpt?>
											</select>
										</span>
										<span class="formRBox">Child :
											<select class="formTxt1 numberSelect change_money" name="children_num">
												<?php print $numberOpt?>
											</select>
										</span>

									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">Adult fee</div>
									<div class="storeEditForm">
										<span><?php print $descPrioce_t?>　per person</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Child fee</div>
									<div class="storeEditForm">
										<span><?php print $childDescPrioce_t?>　per person</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Total</div>
									<div class="storeEditForm">
										<span>￥ <span id="totalPrice">0</span></span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Payment method</div>
									<div class="storeEditForm">
										<?php print $payment_way?>
									</div>
								</div>

							</div>
						</section>
					<section>
						<h3 class="titleUnderline">Member information</h3>

					</section>

					<section class="borderBox">
					<div class="storeEditItem">
						<div class="storeEditRow">
							<div class="storeEditCate"> Name</div>
							<div class="storeEditForm">
								<div class="storeEditForm">
								<span><?php print $_SESSION['jis']['login_member']['name']?></span>
								</div>
							</div>
						</div>
						<div class="storeEditRow">
							<div class="storeEditCate"> Mail address</div>
							<div class="storeEditForm">
								<div class="storeEditForm">
								<span><?php print $_SESSION['jis']['login_member']['mail']?></span>
								</div>
							</div>
						</div>
						<div class="storeEditRow">
							<div class="storeEditCate"> Tel</div>
							<div class="storeEditForm">
								<div class="storeEditForm">
								<span><?php print $_SESSION['jis']['login_member']['tel']?></span>
								</div>
							</div>
						</div>
						<div class="storeEditRow">
							<div class="storeEditCate"> Birthday</div>
							<div class="storeEditForm">
								<div class="storeEditForm">
								<span><?php print date('d/m/Y', strtotime($_SESSION['jis']['login_member']['birthday']))?></span>
								</div>
							</div>
						</div>
					</div>
					</section>
					<section >
						<h3 class="titleUnderline">Cancellation policy</h3>
						<p class="planDetailCautionTxt noteTextArea"><?php print nl2br($tour['tour']['note'])?></p>
					</section>

					<section >
						<div class="agreementCheckBoxArea">
							<label class="noteTextArea checkboxStyle"><input type="checkbox" name="pp_check" value="0" class="validate" style="width: 15px; height: auto;"><span>I agree with the above</span></label>
						</div>
					</section>

					<section>
						<h3 class="titleUnderline">Questionnaire</h3>
					</section>

					<div class="storeEditRow">
									<div class="storeEditCate">Reason for choosing</div>
									<div class="storeEditForm required_form">
										<select name="question_answer" id="question_answer" class="formTxt1 validate required">
											<option value="0">Interesting activity</option>
											<option value="1">Reasonable price.</option>
											<option value="2">Recommendations from friends or review.</option>
											<option value="3">Tour duration.</option>
											<option value="4">Past experience</option>
										</select>
									</div>
								</div>
					<section>

						<input type="hidden" name="tour_relation_id" value="<?php print $_GET['trid']?>">
						<input type="hidden" name="come_date" value="<?php print $_GET['date']?>">

						<div class="storeEditBtnBox mT20">
							<form action="../logic/front/reservation_logic.php" name="inputFormArea" method="post"></form>
							<div class="btnArea">
								<button type="button" class=" btn btnBg1 conf_hide" name="conf">Confirm</button>
								<button type="button" class=" btn btnBgBack conf_show" name="back">Back</button>
								<button type="button" class=" btn btnBg1 conf_show" name="submitBtn">Submit</button>
							</div>
						</div>
					</section>



				</div>

	<!--▼▼▼▼▼ right ▼▼▼▼▼-->
	<?php require_once '../right_out.php';?>
	<!--▲▲▲▲▲ right ▲▲▲▲▲-->

			</div>
		</div>
	</div>

	<!--▼▼▼▼▼ bottomslider ▼▼▼▼▼-->
	<?php print $buttom_bunner?>
	<!--▲▲▲▲▲ bottomslider ▲▲▲▲▲-->

	<!--▼▼▼▼▼ footer ▼▼▼▼▼-->
	<?php require_once '../required/footer_out.php';?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->



	<script>
	$(function(){
		var adult_fee = <?php print $descPrioce?>;
		var child_fee = <?php print $childDescPrioce?>;
		var tax = 0;//<?php print $tax?>;
		var limit_num = <?php print $limit_num?>;


		$('.change_money').off().on('change', function (){
			var adult_num = parseInt($('[name=men_num]').val()) + parseInt($('[name=women_num]').val());
			var adult_price_base = (adult_fee * adult_num);
			var adult_price = adult_price_base  + Math.ceil(adult_price_base * tax);

			var child_num = parseInt($('[name=children_num]').val())
			var child_price_base = (child_fee * child_num);
			var child_price = child_price_base  + Math.ceil(child_price_base * tax);

			$("#totalPrice").html(insertCommaDelimiter(child_price + adult_price));
		});
	});

	var additionalValidate = function(callback){
		var adult_num = parseInt($('[name=men_num]').val()) + parseInt($('[name=women_num]').val());
		var child_num = parseInt($('[name=children_num]').val());
		var limit_num = <?php print $limit_num?>;
		if(adult_num <= 0) {
			alert("Cannot register with zero people.");
			callback(false);
		} else if(adult_num > limit_num) {
			alert("Over quantity.");
			callback(false);
		} else if($('[name=pp_check]').prop("checked") !== true) {
			alert("You have not agreed to the cancellation policy.");
			callback(false);
		} else {
			callback(true)
		}
	}

	</script>


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
</body>
</html>
