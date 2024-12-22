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
                    <div class="headerMenuTopBox">
						<a href="'.$path.'login.php" class="headerMenuTopLink">
							Login
						</a>
					</div>

';
}



?>

<input type="checkbox" id="humb" style="display: none;">
<header>
	<div class="container headerAreaWrap">
		<div class="headerLogoArea">
			<a href="<?php print $path?>" class="headerLogoAreaLink"><img class="scShow" src="<?php print $path?>img/logo_bl.svg"><img class="scHide" src="<?php print $path?>img/logo_wh.svg"></a>
		</div>
		<div class="headerHumbArea">
			<label for="humb" class="headerHumb"><span></span></label>
		</div>
		<div class="headerMenuArea">
			<div class="headerMenuTop">
				<div class="headerMenuTopWrap">
					<div class="headerMenuTopBox">
						<a href="<?php print $path?>advertise_eg.php" class="headerMenuTopLink">For beginner</a>
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
						<a href="<?php print $path?>category.php?cate=3" class="headerMenuBottomLink">EXPERIENCE</a>
					</div>
					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php?cate=4" class="headerMenuBottomLink">HEALING</a>
					</div>
					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php?cate=1" class="headerMenuBottomLink">ANIME</a>
					</div>
					<div class="headerMenuBottomBox">
						<a href="<?php print $path?>category.php?area=true" class="headerMenuBottomLink">AREA</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>