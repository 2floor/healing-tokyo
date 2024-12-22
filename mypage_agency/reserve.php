<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/common/common_logic.php';
require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
$common_logic = new common_logic();
$jis_common_logic = new jis_common_logic();
$front_disp_logic = new front_disp_logic();

$jis_common_logic->login_check();

if($_GET['rid'] == '' || $_GET['rid'] == null ){
	header("Location: ./");
	exit();
}else{
	$rsv = $common_logic->select_logic("select * from t_reservation where reservation_id = ? ", array($_GET['rid']));
	$tour = $jis_common_logic->get_tour($rsv[0]['tour_relation_id'], true);
}


$tour_img = explode(',', $tour['tour']['img']);

$r_only = '';
if($rsv[0]['payment_way'] == 1){
	$payment_way = '<span>Cash</span>';
	$btn = '<div class="btnArea">
				<button type="button" class=" btn btnBg1 conf_hide" name="conf">Confirm</button>
				<button type="button" class=" btn btnBgBack conf_show" name="back">Back</button>
				<button type="button" class=" btn btnBg1 conf_show" name="submitBtn">Submit</button>
			</div>';
}else{
	$payment_way = '<span>Credit</span>';
	$r_only = 'disabled="disabled"';
}


$payment_way = '';
if(strpos($rsv[0]['payment_way'], "1") !== false ){
	$payment_way = 'Payable cash';
}elseif(strpos($rsv[0]['payment_way'], "3") !== false ){
	$payment_way  = 'Credit card('.$tour['tour']['card_choice'].')';
}elseif(strpos($rsv[0]['payment_way'], "2") !== false ){
	$payment_way = 'Immediate payment by credit card';
}


$numberOpt = '';
$max = 10;
for ($i = 0; $i <= $max; $i++) {
	$numberOpt .= '<option value="'.$i.'">'.$i.'</option>';
}

$tax = $jis_common_logic->get_tax();


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
			            	<img src="../upload_files/tour/<?php print $tour_img[0]?>" alt="">
			            </div>
					</div>
				</div>
			</div>


			<div class="container1080 cf">
				<div class="container760" id="inputFormArea">
					<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> Booking Edit Form</h2>
							</div>
					<section>

					</section>

					<section class="borderBox">
						<div class="storeEditItem">
							<div class="storeEditRow">
									<div class="storeEditCate"> DAY</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span><?php print date("d/M/Y H:i", strtotime($rsv[0]['come_date']))?></span>
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
											<select class="formTxt1 numberSelect change_money" name="men_num"  <?php print $r_only?>>
												<?php print $numberOpt?>
											</select>
											<script type="text/javascript">$('[name=men_num]').val("<?php print $rsv[0]['men_num']?>")</script>
										</span>
										<span class="formRBox">Femail :
											<select class="formTxt1 numberSelect change_money" name="women_num" <?php print $r_only?>>
												<?php print $numberOpt?>
											</select>
											<script type="text/javascript">$('[name=women_num]').val("<?php print $rsv[0]['women_num']?>")</script>
										</span>
										<span class="formRBox">Children :
											<select class="formTxt1 numberSelect change_money" name="children_num" <?php print $r_only?>>
												<?php print $numberOpt?>
											</select>
											<script type="text/javascript">$('[name=children_num]').val("<?php print $rsv[0]['children_num']?>")</script>
										</span>

									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">Adult fee</div>
									<div class="storeEditForm">
										<span>¥ <?php print number_format($rsv[0]['adult_fee'])?>　per person</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Child fee</div>
									<div class="storeEditForm">
										<span>¥ <?php print number_format($rsv[0]['children_fee'])?>　per person</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Total</div>
									<div class="storeEditForm">
										<span>￥ <span id="totalPrice"><?php print number_format($rsv[0]['total_add_tax'])?></span></span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Local payment</div>
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
								<span><?php print $rsv[0]['name']?></span>
								</div>
							</div>
						</div>
						<div class="storeEditRow">
							<div class="storeEditCate"> Mail address</div>
							<div class="storeEditForm">
								<div class="storeEditForm">
								<span><?php print $rsv[0]['mail']?></span>
								</div>
							</div>
						</div>
						<div class="storeEditRow">
							<div class="storeEditCate"> Tel</div>
							<div class="storeEditForm">
								<div class="storeEditForm">
								<span><?php print $rsv[0]['tel']?></span>
								</div>
							</div>
						</div>
					</div>
					</section>
					<section >
						<h3 class="titleUnderline">Note</h3>
						<p class="planDetailCautionTxt noteTextArea"><?php print nl2br($tour['tour']['note'])?></p>
					</section>

					<section>
						<h3 class="titleUnderline">Questionnaire</h3>
					</section>

					<div class="storeEditRow">
							<div class="storeEditCate">Reason for using</div>
							<div class="storeEditForm required_form">
								<p>Reason for choosing?</p>
									<select name="question_answer" id="question_answer" class="formTxt1 validate" disabled="disabled">
										<option value="0"> Interesting activity.</option>
										<option value="1">Reasonable price.</option>
										<option value="2">Recommendations from friends or review.</option>
										<option value="3">Tour duration.</option>
										<option value="4">Past experience</option>
									</select>
									<script type="text/javascript">$('[name=question_answer]').val("<?php print $rsv[0]['question_answer']?>")</script>
							</div>
						</div>
					<section>

						<input type="hidden" name="tour_relation_id" value="<?php print $_GET['trid']?>">
						<input type="hidden" name="come_date" value="<?php print $_GET['date']?>">

						<div class="storeEditBtnBox mT20">
							<form action="../logic/front/reservation_edit_logic.php" name="inputFormArea" method="post">
								<input type="hidden" name="rid" value="<?php print $_GET['rid']?>">
								<input type="hidden" name="trid" value="<?php print $rsv[0]['tour_relation_id']?>">
							</form>

							<?php print $btn;?>

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
		var adult_fee = <?php print $rsv[0]['adult_fee']?>;
		var child_fee = <?php print $rsv[0]['children_fee']?>;
		var tax = 0;//<?php print $tax?>;


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
		if(adult_num <= 0) {
			alert("Cannot register with zero people.");
			callback(false);
		} else {
			callback(true)
		}
	}

	</script>


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
</body>
</html>
