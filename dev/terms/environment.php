<?php session_start();?>
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


			<div class="container1080 cf">
				<div class="container1080 cf">
				<div class="container760">
					<section class="mB50">
						<div class="cmsi__head mL0 mR0">
							<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> Recommended environment</h2>
						</div>

						<div class="enviTxt">
						The following environment is recommended for using this site. Please note in advance that some functions can not be used in other environments.<br><br>

						※ JIS uses JavaScript. Please set JavaScript to "Enable".


						</div>

						<table class="shopdetails mT10">
							<tr>
								<th>OS</th>
								<td>
									<p class="storeDataTxt">Microsoft Windows 8,10</p>
								</td>
							</tr>
							<tr>
								<th>Web browser</th>
								<td>
									<p class="storeDataTxt">
										Google Chrome (Latest edition)<br>
										Mozilla Firefox (Latest edition)<br>
										Edge (Latest edition)
									</p>
								</td>
							</tr>
						</table>

					</section>

					<section class="mB50">
						<div class="cmsi__head mL0 mR0">
							<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> SSL</h2>
						</div>

						<div class="enviTxt">
							JIS has introduced SSL (Secure Socket Layer), so you can securely exchange important data such as personal information and credit card information.
						</div>
						<img alt="" src="../assets/front/img/envi_img1.jpg" class="enviImg">


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
