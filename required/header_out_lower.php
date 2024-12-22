<?php
if($_SESSION['jis']['ty'] == 1){
	$your_name = $_SESSION['jis']['login_member']['name'];
	$m_url = 'mypage_users/';
	$mypage_link = '<p class="try__login-btn">
						<a href="'.$path.'mypage_users/">
							mypage
						</a>
					</p>';

	$logout_html = '
<li><a href="'.$path.'mypage_users/">mypage</a></li>
<li><a href="'.$path . 'logout.php">logout</a></li>';

}elseif($_SESSION['jis']['ty'] == 2){
	$your_name = $_SESSION['jis']['login_member']['company_name'];
	$m_url = 'mypage_agency/';
	$mypage_link = '<p class="try__login-btn">
						<a href="'.$path.'mypage_agency/">
							mypage
						</a>
					</p>';
	$logout_html = '
<li><a href="'.$path.'mypage_agency/">mypage</a></li>
<li><a href="'.$path . 'logout.php">logout</a></li>';

}else{
	$your_name  = 'Guest';
	$m_url = 'login.php';
	$mypage_link = '<p class="try__login-btn">
						<a href="'.$path.'login.php">
							Login
						</a>
					</p>';
	$logout_html = '';
}



if($_SESSION['jis']['ty'] == 1){
    $mypage_link_sp = '<li><a href="'.$path.'mypage_users/" class="try__menu-current">
						<span class="navTxt1 ffMintyo">mypage</span>
					</a>
				</li>
                <li><a href="'.$path.'logout.php" class="try__menu-current">
						<span class="navTxt1 ffMintyo">Logout</span>
					</a>
				</li>
';

}elseif($_SESSION['jis']['ty'] == 2){
    $mypage_link_sp = '<li><a href="'.$path.'mypage_agency/" class="try__menu-current">
						<span class="navTxt1 ffMintyo">mypage</span>
					</a>
				</li>
                <li><a href="'.$path.'logout.php" class="try__menu-current">
						<span class="navTxt1 ffMintyo">Logout</span>
					</a>
				</li>
    ';
}else{
    $mypage_link_sp = '
                    <li><a href="'.$path.'login.php" class="try__menu-current">
						<span class="navTxt1 ffMintyo">Login</span>
					</a>
				</li>

';
}


?>

<style>
.try__menu-wrap .try__menu,.try__header-ttl-wrap .try__header-ttl{
	width: auto;
}

.hidden-xs-main{
	width: 100%;
}

.header-xs-flex{
	display: flex
;
    max-width: 1260px;
    margin: 0 auto;
}

.headerLogoArea a{
	width: 100%;
    height: auto;
}

.try__menu li:first-child {
     flex-basis: auto; 
}
</style>

<div class="hidden-xs">
	<div class="try__header-line-wrap">
		<div class="try__header-line">
			<ul class="try__header-line-list">
				<li><a href="<?php print $path?>advertise_eg.php">User Guide</a></li>
				<li><a href="<?php print $path?>advertise_eg.php#FAQ">Help</a></li>
				<li><a href="<?php print $path?>contact.php">Contact</a></li>
				<li><a href="<?php print $path?>contact.php"></a></li>
				<?php print $logout_html?>
			</ul>
		</div>
	</div>
	<div class="header-xs-flex">

	<div class="headerLogoArea">
		<a href="<?php print $path?>" class="headerLogoAreaLink"><img src="<?php print $path?>img/logo_pn.png" alt="Healing Tokyo"></a>
	</div>

	<div class="hidden-xs-main">
		<div class="try__header-ttl-wrap">
			<div class="try__header-ttl cf">
				<ul class="try__header-ttl-link">
					<li class="try__login-name">Hello, <span><?php print $your_name?></span>
					</li>
					<li class="try__login-list">
						<?php print $mypage_link;?>
					</li>
				</ul>
			</div>
		</div>
		<div class="menuBorder">
			<div class="try__menu-wrap">


				<ul class="try__menu" id="fade-in">
					
					<li><a href="<?php print $path?>category.php?cate=2" class="try__menu-current">
							<span class="navTxt1 ffMintyo">SIGHTSEEING</span>
						</a>
					</li>
					<li><a href="<?php print $path?>category.php?cate=4" class="try__menu-current">
							<span class="navTxt1 ffMintyo">HEALING</span>
						</a>
					</li>
					<li><a href="<?php print $path?>category.php?cate=5" class="try__menu-current">
							<span class="navTxt1 ffMintyo">EATING</span>
						</a>
					</li>
					<li><a href="<?php print $path?>category.php?cate=3" class="try__menu-current">
							<span class="navTxt1 ffMintyo">EXPERIENCE</span>
						</a>
					</li>
					<li><a href="<?php print $path?>category.php?cate=1" class="try__menu-current">
							<span class="navTxt1 ffMintyo">ANIME</span>
						</a>
					</li>
					<li><a href="<?php print $path?>category.php?type=tokyo" class="try__menu-current">
							<span class="navTxt1 ffMintyo">TOKYO</span>
						</a>
					</li>
					<li><a href="<?php print $path?>category.php?type=greater" class="try__menu-current">
							<span class="navTxt1 ffMintyo">GREATER TOKYO</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	</div>

</div>

<script>
$(function() {
	$(window).on("load", function(){
		if(location.hash == "#shin"){
			$("html, body").animate({scrollTop : $(".shin").offset().top - 70});
		}
	});
	//SP用ヘッダー
	$(".spmenu_btn").on("click", function() {
		//$(this).next().slideToggle();
		$(this).toggleClass("active");

	    //パネルをアニメーションでトグル出来るようにする
	    $(".spmenu").animate({width: "toggle"}, 300);
		$("body,html").toggleClass("fixed");
	});
	$(".spmenu_btn2").on("click", function() {

		$(".spmenu_btn").toggleClass("active");

	    //パネルをアニメーションでトグル出来るようにする
	    $(".spmenu").animate({width: "toggle"}, 300);
		$("body,html").toggleClass("fixed");
	});

	  // 親メニュー処理
	  $(".spmenu2").click(function() {
	    // メニュー表示/非表示
	    $(this).next("ul").slideToggle("fast");
	  });

	  // 子メニュー処理

		menubind();
	  function menubind(){
		  $("li").off().click(function(e) {
			  if($(this).parents().find("footer").lendth > 0){
				    // メニュー表示/非表示
				    $(this).children("ul").slideToggle("fast");
				    e.stopPropagation();
			  }
		  });
	  }

});
</script>

<header class="visible-xs headerSp">
	<div class="headerLogoSp" style="float:left;display: flex; align-items: center;">
		<a href="./index.php"><img alt="Activities in Japan" src="<?php print $path?>img/logo_bl.png"></a></div>
	<div class="spHeadBtnBox">
		<?php /* ><div class="spHeadBtn"><a href="search"><img alt="検索" src="<?php print $path?>assets/front/img/sp_search.png"></a></div> */ ?>
		<div class="spHeadBtn"><a href="<?php print $path. $m_url?>"><img alt="マイページ" src="<?php print $path?>assets/front/img/sp_mypage.png"></a></div>
	</div>

      <span class="spmenu_btn">
		<img alt="MENU" src="<?php print $path?>assets/front/img/sp_menu.png">
	</span>
    <div class="spmenu">
        <nav>
            <ul>

                <li class="list_ab">
                    Healing Tokyo Menu
                </li>
				<li><a href="<?php print $path?>index.php" class="try__menu-current">
				<!--<li><a href="./index.php" class="try__menu-current">-->
						<span class="navTxt1 ffMintyo">TOP</span>
					</a>
				</li>
				<li><a href="<?php print $path?>category.php?cate=2" class="try__menu-current">
						<span class="navTxt1 ffMintyo">SIGHTSEEING</span>
					</a>
				</li>
				<li><a href="<?php print $path?>category.php?cate=3" class="try__menu-current">
						<span class="navTxt1 ffMintyo">EXPERIENCE</span>
					</a>
				</li>
				<li><a href="<?php print $path?>category.php?cate=4" class="try__menu-current">
						<span class="navTxt1 ffMintyo">HEALING</span>
					</a>
				</li>
				<li><a href="<?php print $path?>category.php?cate=1" class="try__menu-current">
						<span class="navTxt1 ffMintyo">ANIME</span>
					</a>
				</li>
				<li><a href="<?php print $path?>category.php?area=true" class="try__menu-current">
						<span class="navTxt1 ffMintyo">AREA</span>
					</a>
				</li>




				<li><a href="<?php print $path?>advertise_eg.php" class="try__menu-current">
						<span class="navTxt1 ffMintyo">User Guide</span>
					</a>
				</li>
				<li><a href="<?php print $path?>advertise_eg.php" class="try__menu-current">
						<span class="navTxt1 ffMintyo">Help</span>
					</a>
				</li>
				<li><a href="<?php print $path?>contact.php" class="try__menu-current">
						<span class="navTxt1 ffMintyo">Contact</span>
					</a>
				</li>
				<?php print $mypage_link_sp?>


            </ul>
        </nav>
    </div>
</header>


<script>
$(document).ready(function() {
// 	if(location.pathname != "/") {
// 	var $path = location.href.split('/');
// 	var $endPath = $path.slice($path.length-2,$path.length-1);
// 	$('ul.try__menu li a[href$="'+$endPath+'/"]').parent().addClass('active');
// 	}
	});
</script>