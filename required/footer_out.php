<?php

$mypage_link_sp_f1 = '<a href="'.$path.'login.php">Login</a>';
$mypage_link_sp_f2 = '<a href="'.$path.'login.php">ログイン</a>';
$mypage_link_sp_f3 = '<a href="'.$path.'login.php">Login</a>';

if($_SESSION['jis']['ty'] == 1){
    $mypage_link_sp_f1 = '<a href="'.$path.'mypage_users/">Mypage</a>';
}elseif($_SESSION['jis']['ty'] == 2){
    $mypage_link_sp_f2 = '<a href="'.$path.'mypage_agency/">Mypage</a>';
}else{
    $mypage_link_sp_f3 = '<a href="'.$path.'login.php">Login</a>';
}

?>
<style>
    @media (max-width: 991px) {
        .cid-qIjMDc36tP_2 .logo-section {
            justify-content: center;
            padding-left: 0;
            margin-bottom: 1.5rem;
        }
    }

    .cid-qIjMDc36tP_2 .logo-section {
        display: flex;
        align-items: center;
    }
</style>

<footer class="cid-qIjMDc36tP_2" id="footer2-l" data-sortbtn="btn-primary"  style="border-top: 1px solid #757575;">
	<div class="container">
		<div class="row align-center justify-content-center align-items-center">
			<div class="logo-section col-sm-12 col-lg-3 logoArea">
				<a href="<?php print $path?>"><img src="<?php print $path?>img/footer_logo.png" alt="Healingtokyo" title="Healingtokyo" style="width:200px;height:auto;"></a>
			</div>
			<div class="social-media col-sm-12 col-lg-9">
				<ul class="footerLinkArea">

					<li>For user
						<ul class="footerLinkAreaIn">
							<li><?php print $mypage_link_sp_f1?></li>

							<li><a href="<?php print $path?>advertise_eg.php">User Guides</a></li>
							<li class="sp_fn"><a href="<?php print $path?>mypage_users/new_member.php">New member registration</a></li>
						</ul>
					</li>
					
					<li>Policy
						<ul class="footerLinkAreaIn">
							<li><a href="<?php print $path?>terms.php">Membership</a></li>
							<li><a href="<?php print $path?>terms/privacy_policy.php">Privacy</a></li>
							<li class="sp_fn"><a href="<?php print $path?>terms/website_policy.php">Website policy</a></li>
						</ul>
					</li>
					<li>Our company
						<ul class="footerLinkAreaIn">
							<li><a href="<?php print $path?>company-details.php">Company Profile</a></li>
							<li><a href="<?php print $path?>terms/environment.php">IT Environment</a></li>
							<li><a href="<?php print $path?>contact.php">Contact</a></li>

						</ul>
					</li>
					<li>事業者様
						<ul class="footerLinkAreaIn">
							<li><?php print $mypage_link_sp_f2?></li>

							<li class="sp_fn"><a href="<?php print $path?>advertisement.php">広告掲載希望の事業者様</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<div class="row align-center justify-content-center align-items-center">
			<div class="col-sm-12 col-lg-7 mbr-text mbr-fonts-style mbr-light display-7" style="text-align: left;">
				<!--Licenced Travel Agency;Tokyo Class 2 No.7808<br>-->
				Copyright © healing-tokyo.com All Rights Reserved.
			</div>
			<div class="social-media col-sm-12 col-lg-5 forSnsIcon" style="display: flex;justify-content: flex-end;">
				<ul>
					<li>
						<a class="icon-transition" href="#" target="_blank">
							<img src="<?php print $path?>img/foot_facebook.png" alt="facebook" class="card_image lazy">
						</a>
					</li>
					<!--
					<li>
						<a class="icon-transition" href="#" target="_blank">
							<img src="<?php print $path?>img/foot_twitter.png" alt="Twitter" class="card_image lazy">
						</a>
					</li>
					-->
					<li>
						<a class="icon-transition" href="#" target="_blank">
							<img src="<?php print $path?>img/foot_insta.png" alt="Instagram" class="card_image lazy">
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>
<style>
@media screen and (max-width: 767px){
    .footerLinkArea li{
        width: 100%;
    }


    .sp_fn{
        margin-bottom: 30px!important;
    }

}

</style>


  <script type="text/javascript">
  var mainViArea = $('.mainViArea').height();
	var nowSc = $(window).scrollTop();
	if(nowSc > mainViArea){
		$('header').addClass('sc');
	}else{
		$('header').removeClass('sc');
	}
$(function(){
	$(window).scroll(function(){
		nowSc = $(window).scrollTop();
		if(nowSc > mainViArea){
			$('header').addClass('sc');
		}else{
			$('header').removeClass('sc');
		}

	});
})
</script>
<script>
// $(function(){$('.datepicker').datepicker();});
</script>


