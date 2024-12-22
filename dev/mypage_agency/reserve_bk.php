<?php

$numberOpt = '';
$max = 10;
for ($i = 0; $i <= $max; $i++) {
	$numberOpt .= '<option value="'.$i.'">'.$i.'</option>';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>

<?php require_once '../required/html_head.php'?>

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
								Hiroshima & Miyajima 1-Day from Hiroshima with Lunch
							</h1>
						</div>
			            <div class="reserveMainImage1AreaImgBox">
			            	<img src="../assets/front/img/agency_05.jpg" alt="">
			            </div>
					</div>
				</div>
			</div>


			<div class="container1080 cf">
				<div class="container760">
					<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> 予約情報編集</h2>
							</div>
					<section>
						<h3 class="titleUnderline">予約情報 Booking application</h3>

					</section>

					<section class="borderBox">
					<div class="storeEditItem">
						<div class="storeEditRow">
									<div class="storeEditCate"> 日程<br>Schedule</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span>8/Aug/2019</span>
										</div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">タイトル<br>title</div>
									<div class="storeEditForm">
										<span><a href="../search/plan.php">　Hiroshima & Miyajima 1-Day from Hiroshima with lunch</a></span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">人数<br>Pax</div>
									<div class="storeEditForm">
										<span class="formRBox">Male :
											<select class="formTxt1 numberSelect">
												<?php print $numberOpt?>
											</select>
										</span>
										<span class="formRBox">Femail :
											<select class="formTxt1 numberSelect">
												<?php print $numberOpt?>
											</select>
										</span>
										<span class="formRBox">Children :
											<select class="formTxt1 numberSelect">
												<?php print $numberOpt?>
											</select>
										</span>
									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">大人料金<br>adult fee</div>
									<div class="storeEditForm">
										<span>¥ 15,000　per person</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">子供料金<br>chilren’s fare</div>
									<div class="storeEditForm">
										<span>¥ 15,000　per person</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">合計<br>Total</div>
									<div class="storeEditForm">
										<span>￥ 30,000</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">お支払方法<br>Local payment</div>
									<div class="storeEditForm">
										<label class="formRBox radioStyle"><input type="radio" name="available_card" value="0" class="validate" style="width: 15px; height: auto;"><span>Cash</span></label>
										<label class="formRBox radioStyle"><input type="radio" name="available_card" value="1" class="validate" style="width: 15px; height: auto;"><span>Credit card</span></span></label>

									</div>
								</div>

							</div>
						</section>
					<section>
						<h3 class="titleUnderline">会員情報 Member information</h3>

					</section>

					<section class="borderBox">
					<div class="storeEditItem">
						<div class="storeEditRow">
									<div class="storeEditCate"> 氏名<br>Name</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span>Jonh Smith</span>
										</div>
									</div>
						</div>
						<div class="storeEditRow">
									<div class="storeEditCate"> メールアドレス<br>Mail address</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span>***@***.com</span>
										</div>
									</div>
						</div>
						<div class="storeEditRow">
									<div class="storeEditCate"> Tel</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span>000-000-0000</span>
										</div>
									</div>
						</div>
						<div class="storeEditRow">
									<div class="storeEditCate"> 誕生日<br>Birthday</div>
									<div class="storeEditForm">
										<div class="storeEditForm">
										<span>08/05/1999</span>
										</div>
									</div>
						</div>
					</div>
					</section>
					<section >
						<h3 class="titleUnderline">備考<br>Note</h3>
						<p class="planDetailCautionTxt noteTextArea">It's sample Description.</p>
					</section>

					<section >
						<div class="agreementCheckBoxArea">
							<span>I agree with the above</span>
						</div>
					</section>

					<section>
						<h3 class="titleUnderline">Questionnaire</h3>
					</section>

					<div class="storeEditRow">
									<div class="storeEditCate">Reason for using</div>
									<div class="storeEditForm required_form">
										<p>Reason for choosing?</p>
											<select name="etc7" id="etc7" class="formTxt1 validate required">

												<option value="0">reason01</option>
												<option value="1">reason02</option>

											</select>
									</div>
								</div>
					<section>
						<div class="storeEditBtnBox mT20">

							<button type="button" class="btn btn-primary button_input button_form btnBase btnBg1 btnW1" name='conf' id="conf"><span class="btnLh2">更新する</span></button>

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


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
</body>
</html>
