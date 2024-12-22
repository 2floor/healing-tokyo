<?php session_start();?>
<!DOCTYPE html>
<html lang="ja">
<head>

<?php require_once './required/html_head.php'?>

<script type="text/javascript" src="./assets/js/validate.js"></script>
<script type="text/javascript" src="./assets/js/plural_file_upload.js"></script>
<script type="text/javascript" src="./assets/js/form.js"></script>

<script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>
<script type="text/javascript">
	function clearcall(code) {
		if(code !== ""){
			$('[name=conf]').addClass("robotOK");
		}
	}
	</script>
</head>

</head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once "./required/header_out_lower.php"?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="sliderBorBtm sli_height">
				<div class="container1080 marB0 posRel">
					<div class="visible-xs">
						<section>
							<div class="">
							    <div class="sp-slides">
							        <!-- Slide 1 -->
							        <div class="sp-slide sliderBorBtm">
							            <img class="sp-image" src="assets/front/img/tit_contact.jpg"/>
							        </div>
								 </div>
							  </div>
						</section>
				    </div>
					<div class="hidden-xs">
						<section>
							<div class="">
							    <div class="sp-slides">
							        <!-- Slide 1 -->
							        <div class="sp-slide sliderBorBtm">
							            <img class="sp-image" src="assets/front/img/tit_contact.jpg"/>
							        </div>
							    </div>
							  </div>
						</section>
					</div>

				</div>
			</div>



			<div class="container1080 cf">
				<div class="container760">
					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji"> Contact</h2>
							</div>
						</div>
					</section>
<!-- 					<section> -->
<!-- 						<h3 class="titleUnderline">Input form</h3> -->
<!-- 					</section> -->


					<section class="borderBox" id="inputFormArea">
						<div class="storeEditIn">

							<div class="storeEditItem">


								<div class="storeEditRow">
									<div class="storeEditCate">Contact subject<br>お問い合わせ項目</div>
									<div class="storeEditForm required_form">
										<input type="text" name="type" id="type" class="formTxt1 validate required" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Your name<br>氏名</div>
									<div class="storeEditForm required_form">
										<input type="text" name="name" id="name" class="formTxt1 validate required" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Mail address<br class="hidden-xs">メールアドレス</div>
									<div class="storeEditForm required_form">
										<input type="text" name="mail" id="mail" class="formTxt1 validate required mail" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">Phone no<br>電話番号</div>
									<div class="storeEditForm">

										<input type="tel" name="tel" id="tel" class="formTxt1 validate tel" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">

									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">Address<br>住所</div>
									<div class="storeEditForm">
										<input type="text" name="addr" id="addr" class="formTxt1 validate l" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">Contents<br>お問い合わせ内容</div>
									<div class="storeEditForm required_form">
										<textarea name="detail" id="detail" rows="5" cols="" class="formTxt1 validate required"></textarea>
									</div>
								</div>

								<div class="btnArea conf_hide " style="margin-bottom: 10px;">
									<div class="g-recaptcha" data-callback="clearcall" data-sitekey="6LczQ9oUAAAAACYQhU2eDWuItDjjZwT07TDNS7Zh"></div>
									<input type="hidden" name="recap" value="1">
								</div>

							</div>
						</div>

					</section>
					<section>
						<div class="storeEditBtnBox mT20">

							<div class="btnArea">
								<button type="button" class=" btn btnBg1 button_input button_form btnBase btnBg1 btnW1 conf_hide" name="conf">Confirm</button>
								<button type="button" class=" btn btnBgBack button_input button_form btnBase btnBg1 btnW1 conf_show" name="back">Back</button>
								<button type="button" class=" btn btnBg1 button_input button_form btnBase btnBg1 btnW1 conf_show" name="submitBtn">SEND</button>
							</div>

						</div>
					</section>
					<p class="planDetailCautionTxt noteTextArea">※Currently, we are temporarily unable telephone support. Please contact us above form.<br>
					※現在お電話対応を一時休止させて頂いております。上記メールフォームよりお問合せ下さい。</p>

					<section class="borderBox">

						<h3 class="titleUnderline"><i class="fas fa-envelope-square"></i>&nbsp;迷惑メールフォルダーを確認ください<br>Please check your spam folder</h3>
						<p class="planDetailCautionTxt noteTextArea">弊社からのご返信が、お使いのメールアカウントによっては、迷惑メールフォルダーに分類されてしまう場合もございます。特にフリーメール（Gmail,Yahoo等）では、比較的多く発生します。再度お問い合わせをいただく前に、迷惑メールフォルダーを確認の上、お問い合わせください。<br><br>
						Depending on your email account, our reply may be classified as spam folder. In particular, free mail (Gmail,Yahoo, etc.) occurs relatively often. Please check the spam folder and make an inquiry before making an inquiry again.</p>


						<h3 class="titleUnderline"><i class="fas fa-key"></i>&nbsp;個人情報の利用目的<br>Purpose of use of personal information</h3>
						<p class="planDetailCautionTxt noteTextArea">当社では本お問い合わせフォーム上で取得した個人情報を、ユーザーへの返信目的、お問い合わせ内容を統計的に把握する目的以外には利用しません。質問の前に個人情報保護方針についてご確認ください。<br><br>
						We do not use the personal information acquired on this inquiry form for the purpose of replying to the user or for the purpose of statistically grasping the contents of the inquiry. Please check the privacy policy prior to your question.</p>
<form action="./logic/front/mail_logic.php"  name="inputFormArea" method="post">
</form>
					</section>
				</div>

	<!--▼▼▼▼▼ right ▼▼▼▼▼-->
	<?php require_once 'right_out.php';?>
	<!--▲▲▲▲▲ right ▲▲▲▲▲-->

			</div>
		</div>
	</div>

	<!--▼▼▼▼▼ bottomslider ▼▼▼▼▼-->
	<?php print $buttom_bunner?>
	<!--▲▲▲▲▲ bottomslider ▲▲▲▲▲-->

	<!--▼▼▼▼▼ footer ▼▼▼▼▼-->
	<?php require_once 'required/footer_out.php';?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->


	<script type="text/javascript">
	function additionalValidate( callback){
		if($("[name=conf]").hasClass("robotOK")){
			callback(true);
		}else{
			alert("私はロボットではありませんにチェックされていません\n\nI am not checked to not a robot");
			callback(false);
		}
	}
	</script>


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
</body>
</html>
