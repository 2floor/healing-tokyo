<?php
if($_SESSION['jis']['ty'] == 1){
	$mypage_link = '<div class="headerMenuTopBox">
						<a href="'.$path.'mypage_users/" class="headerMenuTopLink">
							mypage
						</a>
					</div>
                    <div class="headerMenuTopBox">
						<a href="'.$path.'logout.php" class="headerMenuTopLink">
							Logout
						</a>
					</div>
';

}elseif($_SESSION['jis']['ty'] == 2){
	$mypage_link = '<div class="headerMenuTopBox">
						<a href="'.$path.'mypage_agency/" class="headerMenuTopLink">
							mypage
						</a>
					</div>
                    <div class="headerMenuTopBox">
						<a href="'.$path.'logout.php"" class="headerMenuTopLink">
							Logout
						</a>
					</div>
';
}else{
	$mypage_link = '
                    <div class="headerMenuTopBox ">
						<a href="'.$path.'login.php" class="headerMenuTopLink">
							Login
						</a>
					</div>

';
}



?>
<style>
	@media screen and ( max-width: 756px){
    .headerMenuArea {
        
        top: 85px;
	}	
	.headerMenuTopBox, .headerMenuBottomBox{
		border-top: 1px solid #999;
	}
	.headerMenuBottomLink,.headerMenuTopLink{
		padding: 10px 13px;
		text-align: center;
		font-size: 15px !important;
	}
}
</style>
<input type="checkbox" id="humb" style="display: none;">
<header>
	<div class="container headerAreaWrap">
		<div class="headerLogoArea">
			<a href="<?php print $path?>" class="headerLogoAreaLink">
				<h1><img class="scShow" src="<?php print $path?>img/logo_pn.png" alt="Healing Tokyo"><img class="scHide" src="<?php print $path?>img/logo_wh.png" alt="Healing Tokyo"></h1>
			</a>
		</div>
		<div class="headerHumbArea">
			<label for="humb" class="headerHumb"><span></span></label>
		</div>
		<div class="headerMenuArea">
			<div class="headerMenuTop">
				<div class="headerMenuTopWrap">
					<div class="headerMenuTopBox">
						<a href="<?php print $path?>advertise_eg.php" class="headerMenuTopLink">User Guide</a>
					</div>
					<div class="headerMenuTopBox">
						<a href="<?php print $path?>advertise_eg.php#FAQ" class="headerMenuTopLink">Help</a>
					</div>
					<div class="headerMenuTopBox">
						<a href="<?php print $path?>contact.php?area=true" class="headerMenuTopLink">Contact</a>
					</div>
					<?php print $mypage_link?>
				</div>
			</div>
			<div class="headerMenuBottom">
				<div class="headerMenuBottomWrap">
<!-- 					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php" class="headerMenuBottomLink">RESTAURANT</a>
						</div> -->
					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php?cate=2" class="headerMenuBottomLink">SIGHTSEEING</a>
					</div>
					
					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php?cate=4" class="headerMenuBottomLink">HEALING</a>
					</div>
					
					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php?cate=5" class="headerMenuBottomLink">EATING</a>
					</div>
					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php?cate=3" class="headerMenuBottomLink">EXPERIENCE</a>
					</div>
					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php?cate=1" class="headerMenuBottomLink">ANIME</a>
					</div>
					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php?type=tokyo" class="headerMenuBottomLink">TOKYO</a>
					</div>
					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php?type=greater" class="headerMenuBottomLink">GREATER TOKYO</a>
					</div>
					
				</div>
			</div>
			
			
		</div>
	</div>
</header>