<!DOCTYPE html>
<html lang="ja">
<head>
<script  src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

</head>
<body>
						<form action="./logic/front/login_logic.php" name="login_form" method="post">
							<div class="storeEditIn">
								<div class="storeEditItem">
									<div class="storeEditRow">
										<div class="storeEditCate loginW">ID</div>
										<div class="storeEditForm">
											<input type="text" name="mail" class="formTxt1 validate mail">
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate loginW">PASSWORD</div>
										<div class="storeEditForm">
											<input type="password" name="password" class="formTxt1 validate required">
										</div>
									</div>
								</div>
							</div>

							<div class="storeEditBtnBox mT20">
								<button type="submit" class="btnBase btnBg1 btnW1" name="login_btn">
									<span class="btnLh2">LOGIN</span>
								</button>
							</div>
							<div class="storeEditBtnBox authLoginImgBox mT20">
								<a class="authLoginImg">
									<img alt="" src="./img/17639236_1785253958471956_282550797298827264_n.png">
								</a>
								<a class="authLoginImg">
									<img alt="" src="./img/btn_google_signin_light_normal_web@2x.png">
								</a>
							</div>
						</form>

	<script type="text/javascript">
	$('[name="login_btn"]').on('click', function(){
// 		$('[name="login_form"]').submit();
	});
	</script>

	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->
	
<?php print phpinfo(); ?>
	
</body>
</html>
