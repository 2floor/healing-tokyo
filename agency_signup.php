<?php
session_start();
require_once __DIR__ .  '/./logic/common/jis_common_logic.php';
require_once __DIR__ .  '/./logic/common/common_logic.php';
$common_logic = new common_logic();
$jis_common_logic = new jis_common_logic();

$sitekey = '6LcPqpkqAAAAAFf_1I9u9MT9TYqMCHymNLfa4eEw';

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once 'required/html_head.php';?>
<script type="text/javascript">
<?php print $script?>
</script>

<script type="text/javascript" src="./assets/js/validate.js"></script>
<script type="text/javascript" src="./assets/js/plural_file_upload.js"></script>
<script type="text/javascript" src="./assets/js/mail_depricate.js"></script>
<script type="text/javascript" src="./assets/js/form.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $sitekey; ?>"></script>

</head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
<?php require_once 'required/header_out_lower.php';?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->
	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="container1080 cf">
				<div class="container760">

					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji"> 新規仮登録</h2>
							</div>
						</div>
					</section>


					<section>
						<h3 class="titleUnderline">掲載ご希望の事業者様</h3>

					</section>
					<section class="borderBox"id="inputFormArea" >
						<div class="storeEditIn" >
							<h4 class="titleBN">基本情報編集<span class="registTit1" id="conf_text">以下の項目はすべて※必須項目です</span></h4>
							<div class="storeEditItem">
							<div class="storeEditRow">
								<div class="storeEditRow">
									<div class="storeEditCate">種別<br>Type</div>
									<div class="storeEditForm required_form">
										<label><span class="formRBox"><input type="radio" name="store_type" value="0" class="validate" style="width: 15px; height: auto; display: inline;" checked="checked">法人</span></label>
										<label><span class="formRBox"><input type="radio" name="store_type" value="1" class="validate" style="width: 15px; height: auto; display: inline;">個人経営</span></label>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">事業者名<br>Company name</div>
									<div class="storeEditForm required_form">
										<input type="text" name="company_name" id="company_name" class="formTxt1 validate required" value="" placeholder="ヒーリングトウキョウ">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">事業者名（英語）<br>Company name(En.)</div>
									<div class="storeEditForm">
										<input type="text" name="company_name_eng" id="company_name_eng" class="formTxt1 validate " value="" placeholder="Healing Tokyo Co.,Ltd.">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">メールアドレス<br>Mail address</div>
									<div class="storeEditForm required_form">
										<input type="text" name="mail" id="mail" class="formTxt1 validate required mail depricate_check" value="" own="<?php print $_SESSION['jis']['login_member']['store_basic_id']?>" placeholder="info@healing-tokyo.com">
									</div>
								</div>

								<div class="storeEditRow password_change_form">
									<div class="storeEditCate">パスワード<br>Passwords</div>
									<div class="storeEditForm required_form">
										<input type="text" name="password" id="password" class="formTxt1 validate required password" value="">
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">担当者名<br>Contact name</div>
									<div class="storeEditForm required_form">
										<input type="text" name="contact_name" id="contact_name" class="formTxt1 validate required" value="" placeholder="伊藤">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">担当者名(カナ)<br>Contact name(Kana)</div>
									<div class="storeEditForm required_form">
										<input type="text" name="contact_name_kana" id="contact_name_kana" class="formTxt1 validate required" value="" placeholder="イトウ">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">担当者名（英語）<br>Contact name(En.)</div>
									<div class="storeEditForm">
										<input type="text" name="contact_name_eng" id="contact_name_eng" class="formTxt1 validate " value=""placeholder="Itou">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">電話番号<br>Phone no.</div>
									<div class="storeEditForm required_form">
										<input type="tel" name="tel" id="tel" class="formTxt1 validate required tel" value="" placeholder="0312345678">
										<p>ハイフンは入れないでください</p>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">FAX<br>FAX no.</div>
									<div class="storeEditForm">
										<input type="tel" name="fax" id="fax" class="formTxt1 validate tel " value="" placeholder="0312345678">
										<p>ハイフンは入れないでください</p>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">緊急連絡<br>Emergency mobile no</div>
									<div class="storeEditForm required_form">
										<input type="tel" name="emergency_tel" id="emergency_tel" class="formTxt1 validate required tel" value="" placeholder="08011112222">
										<p>ハイフンは入れないでください</p>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">緊急連絡 担当者名（英語）<br>Emergency contact name(En.)</div>
									<div class="storeEditForm">
										<input type="text" name="emergency_contact_name" id="emergency_contact_name" class="formTxt1 validate " value="" placeholder="Ito">
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">事業者所在地（英語）<br>Business location(En.)</div>
									<div class="storeEditForm required_form">
										<input type="text" name="location" id="location" class="formTxt1 validate required" value="" placeholder="1-1-1 Ikebukuro, Taito-ku, Tokyo 111-0000">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">営業時間（英語）<br>Trading Hours(En.)</div>
									<div class="storeEditForm">
										<textarea name="trading_hours" rows="3" cols="" class="formTxt1 validate " placeholder="From 10:00 to 19:00"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">URL</div>
									<div class="storeEditForm">
										<input type="text" name="url" id="url" class="formTxt1 validate " value="" placeholder="https://sample.com">
									</div>
								</div>

							</div>
								<input type="hidden" name="method" value="store_basic_regist">
								<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
							<div class="btnArea">
								<button type="button" class=" btn btnBg1 conf_hide" name="conf">確認画面へ</button>
								<button type="button" class=" btn btnBgBack conf_show" name="back">Back</button>
								<button type="button" class=" btn btnBg1 conf_show" name="submitBtn">仮登録をする</button>
							</div>


						</div>

					</section>

<form action="./logic/front/regist_edit_logic.php" name="inputFormArea" method="post"></form>
				</div>

				<!--▼▼▼▼▼ right ▼▼▼▼▼-->
				<?php require_once 'right_out.php';?>
				<!--▲▲▲▲▲ right ▲▲▲▲▲-->

			</div>
		</div>
	</div>
	<!--▼▼▼▼▼ footer ▼▼▼▼▼-->
	<?php require_once 'required/footer_out.php';?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->
	<!-- ページTOPへ-->
	<p id="try__page-top">
		<a href="#wrap">TOP</a>
	</p>
	<!-- ページTOPへ-->

	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->

	<input type="hidden" id="common_ct_url" value="../controller/admin/common_ct.php">
	<input type="hidden" id="img_path1" value="tour/">
	<input type="hidden" id="img_length1" class="hid_img_length" value="3">
	<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">

	<script type="text/javascript" src="./assets/js/kankyou_conv.js"></script>
<script>
grecaptcha.ready(function() {
    grecaptcha.execute('<?php echo $sitekey; ?>', {action: 'submit'}).then(function(token) {
        var recaptchaResponse = document.getElementById('recaptchaResponse');
        recaptchaResponse.value = token;
    });
});
</script>
</body>
</html>
