<?php session_start();?>
<!DOCTYPE html>
<html lang="ja">
<head>

<?php require_once './required/html_head.php'?>

</head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once "./required/header_out_lower.php"?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">

			<div class="container1080 cf">

				<div class="container760">
					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji"> Password reminder</h2>
							</div>
							<div class="mypageTopNameBox">
								<div class="registTopTxt">
									We will send an e-mail describing the password reissue procedure to the registered e-mail address.
								</div>
							</div>
						</div>
					</section>
					<form action="./logic/front/reminder_logic.php" method="post">
						<input type="hidden"name="method" value="reminder">
						<section class="borderBox">
							<div class="storeEditIn">
								<div class="storeEditItem">
									<div class="storeEditRow">
										<div class="storeEditCate loginW">MAIL ADDRESS</div>
										<div class="storeEditForm">
											<input type="text" name="mail" class="formTxt1 validate required mail">
										</div>
									</div>
<!-- 									<div class="storeEditRow"> -->
<!-- 										<div class="storeEditCate loginW">BIRTHDAY</div> -->
<!-- 										<div class="storeEditForm"> -->
<!-- 											<input type="text" name="birthday" class="formTxt1 validate required"> -->
<!-- 										</div> -->
<!-- 									</div> -->
								</div>
							</div>

							<div class="storeEditBtnBox mT20">
								<button type="submit" class="btnBase btnBg1 btnW1" name="login">
									<span class="btnLh2">SEND</span>
								</button>
							</div>

						</section>
					</form>


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
	<?php require_once './required/footer_out.php';?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
</body>
</html>
