<?php session_start();
if($_GET['e'] == 'rec'){
	$sle = '<section>
						<h3 class="titleUnderline">Contact Submit.</h3>

					</section>


					<section class="borderBox">
						<h3 class="titleUnderline">不正なアクセスを検知し、メールの送信が失敗しました。<br>Unauthorized access was detected, and mail transmission failed.</h3>
					</section>';
}else{
	$sle = '<section>
						<h3 class="titleUnderline">Contact Submit.</h3>

					</section>


					<section class="borderBox">
						<h3 class="titleUnderline">メールが送信されました<br>Please check your spam folder</h3>
					</section>';
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once './required/html_head.php'?>

<script type="text/javascript" src="./assets/js/validate.js"></script>
<script type="text/javascript" src="./assets/js/plural_file_upload.js"></script>
<script type="text/javascript" src="./assets/js/form.js"></script>
<script src="https://d.shutto-translation.com/trans.js?id=62902"></script>
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
					<?php print $sle?>
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


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
</body>
</html>
