<?php

$domain = $_SERVER['SERVER_NAME'];
$nowDir = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$nowDir = str_replace("www.", "", $nowDir);
$nowDirAr = explode("/", $nowDir);

$path_base = "./";
$DirCounter = 0;
if(strpos($domain, "localhost") !== false || strpos($domain, "2floor.xyz") !== false) {
	//ローカル、2ｆテスト環境時
	$DirCounter -= 1;
}

foreach ($nowDirAr as $ND) {
	if($ND == '') continue;
	if(strpos($ND, '.php') !== false)continue;
	if(strpos($ND, '?') !== false)continue;


	if($domain != $ND ){
		++$DirCounter;
	}
}
$path_base .= str_repeat("../", $DirCounter);
$path = $path_base;



// $domain = $_SERVER['SERVER_NAME'];
// $nowDir = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
// $nowDirAr = explode("/", $nowDir);
// $path = "./";
// $DirCounter = 0;
// $nowUrl = '';
// $nowDir = '';

// if(strpos($domain, "localhost") !== false || strpos($domain, "2floor.xyz") !== false)$DirCounter -= 1;

// foreach ($nowDirAr as $ND) {
// 	if($ND == '' || strpos($ND, '.php') !== false) {
// 		$nowUrl = $ND;
// 		continue;
// 	}elseif(strpos($ND, '.php') === false && strpos($ND, '?') !== false){
// 		continue;
// 	}
// 	if($domain != $ND){

// 		$nowDir = $ND;
// 		++$DirCounter;

// 	}
// }
// if($DirCounter > 0){
// 	$path .= str_repeat("../", $DirCounter);
// }
$link_add = '';

$ttl = '';
$description = '';
$keyword = '';
$nowUrl = str_replace("/jis2/", "",  $_SERVER['SCRIPT_NAME']);
if(strpos($nowUrl, "/") !== false){
	$nowDIR_a = explode("/", $nowUrl);
	$nowDIR = $nowDIR_a[0];
}else{
	$nowDIR = '';
}

if(($nowUrl == '' || $nowUrl == 'index.php') && $path == "./"){
	$ttl = 'Activities × Japan = JIS';
	$description = 'Travel JIS main Index';
	$keyword = 'Travel JIS';
	$link_add = '
<link rel="stylesheet" href="'.$path.'assets/css/bootstrap.min.css">
<link rel="stylesheet" href="'.$path.'assets/css/mbr-additional.css" type="text/css">
';
}elseif(strpos($nowDIR, "mypage_agency") !== false){
	if(strpos($nowUrl, "index.php") !== false){
		$ttl = 'Japan × Activities = JIS';
		$description = 'Travel JIS';
		$keyword = 'Travel JIS';
	}else{
		$ttl = 'Japan × Activities = JIS';
		$description = 'Travel JIS';
		$keyword = 'Travel JIS';
	}
}else{
	$ttl = 'Japan × Activities = JIS';
	$description = 'Travel JIS';
	$keyword = 'Travel JIS';
}
$meta = '
<meta name="description" content="'.$description.'">
<meta name="keywords" content="'.$keyword.'">
<title>'.$ttl.'</title>';
?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="generator" content="Mobirise v4.6.4, mobirise.com">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no">
<link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">


<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">


<?php print $meta?>
<link rel="shortcut icon" href="<?php print $path?>favicon.ico">
<link rel="stylesheet" href="<?php print $path?>assets/front/css/base.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="<?php print $path?>assets/front/css/top-prts.css">
<link rel="stylesheet" href="<?php print $path?>assets/front/css/special-prts.css">
<link rel="stylesheet" href="<?php print $path?>assets/front/css/top-prts.css">
<link rel="stylesheet" href="<?php print $path?>assets/front/css/pc.css">
<link rel="stylesheet" href="<?php print $path?>assets/front/css/restaurant_shop.css">
<link rel="stylesheet" href="<?php print $path?>assets/front/css/restaurant-top.css">
<link rel="stylesheet" href="<?php print $path?>assets/front/css/slider-pro.css">
<link rel="stylesheet" href="<?php print $path?>assets/front/css/slider.css">
<?php print $link_add?>
<link rel="stylesheet" href="<?php print $path?>assets/css/mobirise-icons.css">
<link rel="stylesheet" href="<?php print $path?>assets/css/b_style.css">
<link rel="stylesheet" href="<?php print $path?>assets/css/bootstrap-grid.min.css">
<link rel="stylesheet" href="<?php print $path?>assets/css/header.css">
<link rel="stylesheet" href="<?php print $path?>assets/css/footer.css">
<link rel="stylesheet" href="<?php print $path?>assets/css/layout.css">
<link rel="stylesheet" href="<?php print $path?>assets/css/style.css">
<link rel="stylesheet" href="<?php print $path?>assets/css/style2.css">
<link rel="stylesheet" href="<?php print $path?>assets/css/theme_style.css">
<link rel="stylesheet" href="<?php print $path?>assets/css/gallery_style.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css" />
<link href="//use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

<link rel="icon" href="/favicon.ico">

<link href="<?php print $path?>assets/front/css/font-awesome.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php print $path?>assets/front/css/design.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="<?php print $path?>assets/front/css/side200.css" type="text/css" media="screen,print" />

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Noto+Sans:400,700|Noto+Serif:400,700' rel='stylesheet' type='text/css'>
<title>Travel JIS</title>

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="<?php print $path?>assets/front/css/jquery.datepicker.css">
<link href="//fonts.googleapis.com/earlyaccess/sawarabimincho.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php print $path?>assets/front/css/slick.css" />

<script type="text/javascript" src="<?php print $path?>assets/front/js/moment.js"></script>

<script src="<?php print $path?>assets/front/js/jquery.sliderPro.min.js"></script>
<script src="<?php print $path?>assets/front/js/slider.js"></script>
<script src="<?php print $path?>assets/front/js/slick.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"></script>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-151118072-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-151118072-1');
</script>



