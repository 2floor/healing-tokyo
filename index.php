<?php
session_start();
require_once __DIR__ . "/./logic/front/front_disp_logic.php";
require_once __DIR__ . "/./logic/common/common_logic.php";
$front_disp_logic = new front_disp_logic();

$common_logic = new common_logic();
$index_html = $front_disp_logic->get_index_html();
$_GET['req_index'] = true;

$ad_res = $common_logic->select_logic_no_param("select * from t_ad where del_flg = '0' and public_flg = '0' ORDER BY RAND() LIMIT 10 ");
$ad_html = '';
for ($i = 0; $i < count($ad_res); $i++) {
    $ad_row = $ad_res[$i];
    if ($i == 0) {
        $ad_html .= '
                <li class="slideCell" style="margin-left: -106.02px;">
                    <a href="' . $ad_row['ad_eng'] . '" style="height:50px" target="_blank">
					   <img src="./upload_files/ad/'.$ad_row['thumbnail'].'" alt="" class=" " width="300">
                    </a>
				</li>';
    } else {
        $ad_html .= '
                <li class="slideCell">
                    <a href="' . $ad_row['ad_eng'] . '" style="height:50px" target="_blank">
					   <img src="./upload_files/ad/'.$ad_row['thumbnail'].'" alt="" class=" " width="300">
                    </a>
				</li>';
    }
}
// $ad_html = '';
for ($i = 0; $i < 5; $i++) {
	$ad_html .= $ad_html;
}

if($ad_html != ''){
	$ad_html = '<!--imgs-->
<section class="features8 cid-qIjI4pKeSS" data-sortbtn="btn-primary">
	<div class="">
		<div class="slideFrame">
			<ul class="slideGuide left"  id="undSlider" >
				'.$ad_html.'
			</ul>
		</div>
	</div>
</section>';
}


?>
<!DOCTYPE html>
<html >
<head>
<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
<?php require_once './required/html_head.php'?>
<link rel="stylesheet" href="./assets/css/mbr-additional.css">

<style type="text/css">
.mbr-title{
	padding-top:10px;
	line-height: 28px;
}
.mbr-card-price{
	padding-top:10px;
}
.slickPagerPos{
	position: relative;
}
.slickPrevNext.prev {
	left: -10px;
	text-indent: -3px;
}
.slickPrevNext.next {
	right: -10px;
	text-indent: 3px;
}
.slickPrevNext {
	position: absolute;
	top: 160px;
	z-index: 2;
	background-color: #FFF;
	filter: drop-shadow(3px 3px 4px #a5a5a5);
	border-radius: 50%;
	width: 50px;
	height: 50px;
	display: flex;
	justify-content: center;
	align-items: center;
	color: #333;
	cursor: pointer;
	padding-top: 5px;
	font-weight: bold;
	text-align: center;
}
.slideFrame {
  overflow: hidden;
  width: 100%;
  height: 252px;
}
.ImmediatePayment{
position: absolute;
	top: -290px;
	font-size: 50px;
	bottom: 0;
	right: 0;
	left: 0;
	margin: auto;
	width: 100%;
	text-align: center;
	height: 40px;
	color: #FFF;
	letter-spacing: 0.03em;
	font-weight: bold;
}

.cmsi__head {
    margin: 15px 0;
}

.card{
	border: none;
}

@media all and (-ms-high-contrast:none){
  *::-ms-backdrop,
  .searchAreaBoxWrap { margin-top: 20% } /* IE11 */
  .headerMenuTop {margin-bottom:20px}
}

@media screen and (max-width:991px){
	.searchAreaBoxWrap{
		top: 100px;
	}
	.ImmediatePayment {
		top: -390px;
		font-size: 40px;
		line-height: 1.13;
	}
}
</style>
 <style>
  .spShow,.spShow-flexd{
        	display: none!important;
        }
   .slideFrame .slideCell img{
	backface-visibility:hidden;
}
        
  @media screen and ( min-width:757px){
        .arrivalArea{
        	display: flex;
        	justify-content: space-between!important;
        	align-items: center;
        	flex-wrap: wrap;
        	padding: 0 20px;
        }
        .arrivalArea > div{
        	flex-basis: 31%;
        	display: flex;
        	justify-content: center;
        	margin-bottom: 30px;
        }

        .arrivalArea > div img{
        	height: 220px;
        	width: 100%;
        	object-fit: cover;
        	margin-bottom: 10px;
        	border-radius: 15px
        }

        .arrivalArea > div:nth-child(10),
        .arrivalArea > div:nth-child(11),
        .arrivalArea > div:nth-child(12){
        	display: none;
        }
}

        @media screen and ( max-width: 756px){
	        .arrivalArea{
	        	display: flex;
	        	justify-content: space-between!important;
	        	align-items: center;
	        	flex-wrap: wrap;
	        	padding: 0 20px;
	        }
	        .spShow{
	        	display: block!important;
	        }
	        .spShow-flex{
	        	display: flex!important;
	        }
        }

        </style>
<script src="https://d.shutto-translation.com/trans.js?id=62902"></script>
</head>
<body>

<?php require_once './required/header_out.php'?>
<!-- TOP画像-->

<!-- mainvidual -->
<div class="mainSliderItem top_mv">
	<div class="top_mv_slide slide01">
		<img src="img/slide_img_bk01.png" style="border-radius:0">
		<div class="inner_left">
			<p class="main_clinicTtl serif">SIGHTSEEING</p>
			<!-- 20231102追加分 -->
			<p class="main_cath serif">Tourist Attractions Nationwide</p>
			<p class="main_clinich serif">Introduced by Region</p>
			<p class="main_clinicp serif">You can explore tourist spots from representative areas.</p>
			<a href="category.php?cate=2" class="main_clinic_button" tabindex="-1">Read More</a>
			<!-- /20231102追加分 -->
		</div>
	</div>
	<div class="top_mv_slide slide02">
		<img src="img/slide_img_bk02.png" style="border-radius:0">
		<div class="inner_left">
			<p class="main_clinicTtl serif">ANIME</p>
			<p class="main_cath serif">Introducing Local Anime</p>
			<p class="main_clinicp serif">Why not conquer Japan’s local anime offerings?</p>
			<a href="category.php?cate=1" class="main_clinic_button" tabindex="-1">Read More</a>
		</div>
	</div>
	<div class="top_mv_slide slide03">
		<img src="img/slide_img_bk03.png" style="border-radius:0">
		<div class="inner_left">
			<p class="main_clinicTtl serif">EXPERIENCE</p>
			<!-- 20231102追加分 -->
			<p class="main_cath serif">Cat Café</p>
			<p class="main_clinich serif">Tea Time with Cats</p>
			<p class="main_clinicp serif">A uniquely Japanese café experience perfect for cat lovers.</p>
			<a href="category.php?cate=3" class="main_clinic_button" tabindex="-1">Read More</a>
			<!-- /20231102追加分 -->
		</div>
	</div>
	<div class="top_mv_slide slide04">
		<img src="img/slide_img_bk04.png" style="border-radius:0">
		<div class="inner_left">
			<p class="main_clinicTtl serif">HEALING</p>
			<!-- 20231102追加分 -->
			<p class="main_cath serif">Professional Ear Cleaning</p>
			<p class="main_clinich serif">Offering a Moment of Relaxation Through Ear Cleaning</p>
			<p class="main_clinicp serif">We have a variety of courses, including blissful ear cleaning and premium massages.</p>
			<a href="category.php?cate=4" class="main_clinic_button" tabindex="-1">Read More</a>
			<!-- /20231102追加分 -->
		</div>
	</div>
</div>

<!-- catch copy-->
<section class="cid-qIjLr2VMr0_2" id="content7-i" data-sortbtn="btn-primary">
	 <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-12 align-center">
                <h2 class="mbr-section-title align-center mbr-fonts-style mbr-bold display-7">
                	<span style="font-weight: normal;text-align:center;padding-top:30px">It is a site where you can introduce and book sightseeing spots and fun in Japan.</span>
                </h2>
                <!--<a href="./assets/pdf/temporary_closed.pdf" target="_blank" style="color: #f44545;display: inline-block;margin: 10px 0;padding: 10px;font-size: 20px;text-decoration: underline;">臨時休業のお知らせ</a>-->
            </div>
        </div>
    </div>
</section>

<!--AREA-->
<section class="features19 cid-qIjES4e5vV" id="features19-5" data-sortbtn="btn-primary">
    <div class="container">
		<div class="cmsi__head">
			<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji"> Area</h2>
		</div>

        <div class="row justify-content-center align-items-start">
		<?php echo $front_disp_logic->get_area_list(); ?>
<!--
            <div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        <a href="search/?area=1"><img src="img/top_tokyo.jpg" alt="TOKYO" class="card_image lazy"></a>
                    </div>
                </div>
            </div>

            <div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        <a href="search/?area=2"><img src="img/top_fuji.jpg" alt="Mt.FUJI" class="card_image lazy"></a>
                    </div>
                </div>
            </div>

            <div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        <a href="search/?area=3"><img src="img/top_hokaido.jpg" alt="HOKKAIDO" class="card_image lazy"></a>
                    </div>
                </div>
            </div>

            <div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        <a href="search/?area=4"><img src="img/top_okinawa.jpg" alt="OKINAWA" class="card_image lazy"></a>
                    </div>
                </div>
            </div>


            <div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        <a href="search/?area=5"><img src="img/top_osaka.jpg" alt="OSAKA" class="card_image lazy"></a>
                    </div>
                </div>
            </div>

            <div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                       <a href="search/?area=6"><img src="img/top_kyoto.jpg" alt="KYOTO" class="card_image lazy"></a>
                    </div>
                </div>
            </div>

            <div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        <a href="search/?area=7"><img src="img/top_hiroshima.jpg" alt="HIROSHIMA" class="card_image lazy"></a>
                    </div>
                </div>
            </div>

            <div class="card px-3 py-4 col-md-3 col-sm-6 col-xs-6">
                <div class="card-wrapper flip-card">
                    <div class="card-img">
                        <a href="search/?area=8"><img src="img/top_other.jpg" alt="OTHER" class="card_image lazy"></a>
                    </div>
                </div>
            </div>
-->
        </div>
    </div>
</section>



<!--Category-->
<section class="features19 cid-qIjES4e5vV" id="features19-5" data-sortbtn="btn-primary">
    <div class="container slickPagerPos">
        <div class="cmsi__head">
			<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji"> Category</h2>
		</div>

		<div class="row justify-content-center align-items-start" id="sliderCate" style="padding-top: 20px;">
		<?php echo $front_disp_logic->get_cate_list(); ?>

<!--
			<div>
				<div class="card-wrapper flip-card">
					<div class="card-img">
						<a href="category.php?cate=4"><img src="img/top_healing_a.jpg" alt="Healing" class="card_image lazy"></a>
					</div>
				</div>
			</div>
			<div>
				<div class="card-wrapper flip-card">
					<div class="card-img">
							<a href="category.php?cate=3"><img src="img/top_play_a.jpg" alt="Play"
								class="card_image lazy"></a>
					</div>
				</div>
			</div>
			<div>
				<div class="card-wrapper flip-card">
					<div class="card-img">
						<a href="category.php?cate=2"><img src="img/top_see_a.jpg" alt="See" class="card_image lazy"></a>
					</div>
				</div>
			</div>
			<div>
				<div class="card-wrapper flip-card">
					<div class="card-img">
						<a href="category.php?cate=1"><img src="img/top_anime2_a.jpg" alt="Anime" class="card_image lazy"></a>
					</div>
				</div>
			</div>
			<div>
				<div class="card-wrapper flip-card">
					<div class="card-img">
						<a href="category.php?cate=4"><img src="img/top_healing_a.jpg" alt="Healing" class="card_image lazy"></a>
					</div>
				</div>
			</div>
			<div>
				<div class="card-wrapper flip-card">
					<div class="card-img">
							<a href="category.php?cate=3"><img src="img/top_play_a.jpg" alt="Play"
								class="card_image lazy"></a>
					</div>
				</div>
			</div>
			<div>
				<div class="card-wrapper flip-card">
					<div class="card-img">
						<a href="category.php?cate=2"><img src="img/top_see_a.jpg" alt="See" class="card_image lazy"></a>
					</div>
				</div>
			</div>
			<div>
				<div class="card-wrapper flip-card">
					<div class="card-img">
						<a href="category.php?cate=1"><img src="img/top_anime2_a.jpg" alt="Anime" class="card_image lazy"></a>
					</div>
				</div>
			</div>
-->
		</div>
		<div class="prev slickPrevNext">＜</div>
		<div class="next slickPrevNext">＞</div>
		<script type="text/javascript">
		var $slickCate = $('#sliderCate')
		$slickCate.slick({
			arrows : false,
			autoplay : true,
			slidesToShow: 4,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 2
					}
				},
			]
		});
		$('#sliderCate ~ .slickPrevNext.next').off().on('click', function(){$slickCate.slick('slickNext');});
		$('#sliderCate ~ .slickPrevNext.prev').off().on('click', function(){$slickCate.slick('slickPrev');});
		</script>
		</div>
</section>



<!--New arrival-->
<section class="features19 cid-qIjES4e5vV" id="features19-5" data-sortbtn="btn-primary">
    <div class="container">
        <div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji">New arrival</h2>
		</div>

        <div class="row justify-content-center align-items-start arrivalArea " id="sliderArrivale" style="padding-top: 20px;">

           <?php print $index_html['arr_html']?>

        </div>


		<div class="prev slickPrevNext spShow">＜</div>
		<div class="next slickPrevNext spShow">＞</div>
		<script type="text/javascript">

		$(function(){
			function sliderSetting(){
					var width = $(window).width();
					if(width <= 756){
						$('#sliderArrivale').not('.slick-initialized').slick({
							arrows : false,
							autoplay : true,
							slidesToShow: 3,
							responsive: [
								{
									breakpoint: 768,
									settings: {
										slidesToShow: 2
									}
								},
							]
						});
						$('#sliderArrivale ~ .slickPrevNext.next').off().on('click', function(){$('#sliderArrivale').slick('slickNext');});
						$('#sliderArrivale ~ .slickPrevNext.prev').off().on('click', function(){$('#sliderArrivale').slick('slickPrev');});
					} else {
						$('#sliderArrivale.slick-initialized').slick('unslick');
					}
			}
			sliderSetting();
			$(window).resize( function() { sliderSetting(); }); });
		</script>
    </div>
</section>


<!--Reservation number ranking-->
<section class="features19 cid-qIjES4e5vV spShow" id="features19-5" data-sortbtn="btn-primary">
    <div class="container">
        <div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji">Reservation ranking</h2>
		</div>


        <div class="row justify-content-center align-items-start">

            <?php print $index_html['rsv_html']?>
            <div class="card px-3 py-4 col-md-12" style="display: inline-block;text-align: right;">
				<a href="search/reservation_ranking.php" class="btn-border">More</a>
			</div>
        </div>
    </div>
</section>


<!--Anime-->
<section class="features19 cid-qIjES4e5vV spShow" id="features19-5" data-sortbtn="btn-primary">
    <div class="container">
         <div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji">Anime</h2>
		</div>

        <div class="row justify-content-center align-items-start">

           <?php print $index_html['category_html']['Anime']?>
            <div class="card px-3 py-4 col-md-12" style="display: inline-block;text-align: right;">
				<a href="./category.php?cate=1" class="btn-border">More</a>
			</div>
        </div>
    </div>
</section>

<!--See-->
<section class="features19 cid-qIjES4e5vV" id="features19-5" data-sortbtn="btn-primary">
    <div class="container">
         <div class="cmsi__head">
				<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji">Sightseeing</h2>
		</div>

        <div class="row justify-content-center align-items-start">

             <?php print $index_html['category_html']['Sightseeing']?>
            <div class="card px-3 py-4 col-md-12" style="display: inline-block;text-align: right;">
				<a href="./category.php?cate=2" class="btn-border">More</a>
			</div>
        </div>
    </div>
</section>

<!--Play-->
<section class="features19 cid-qIjES4e5vV" id="features19-5" data-sortbtn="btn-primary">
    <div class="container">
         <div class="cmsi__head">
				<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji">Experience</h2>
		</div>

        <div class="row justify-content-center align-items-start">

            <?php print $index_html['category_html']['Experience']?>
            <div class="card px-3 py-4 col-md-12" style="display: inline-block;text-align: right;">
				<a href="./category.php?cate=3" class="btn-border">More</a>
			</div>
        </div>
    </div>
</section>


<!--Healing-->
<section class="features19 cid-qIjES4e5vV spShow" id="features19-5" data-sortbtn="btn-primary">
    <div class="container">
        <div class="cmsi__head">
				<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png"" alt="Fuji">Healing</h2>
		</div>

        <div class="row justify-content-center align-items-start">

             <?php print $index_html['category_html']['Healing']?>
            <div class="card px-3 py-4 col-md-12" style="display: inline-block;text-align: right;">
				<a href="./category.php?cate=4" class="btn-border">More</a>
			</div>
        </div>
    </div>
</section>


<!--Word of mouth ranking-->
<section class="features19 cid-qIjES4e5vV spShow" id="features19-5" data-sortbtn="btn-primary">
    <div class="container">
        <div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="img/ttl_icon.png" alt="Fuji">Word of mouth ranking</h2>
		</div>

        <div class="row justify-content-center align-items-start">

            <?php print $index_html['rev_html']?>
            <div class="card px-3 py-4 col-md-12" style="display: inline-block;text-align: right;">
				<a href="search/review_ranking.php" class="btn-border">More</a>
			</div>
        </div>
    </div>
</section>


<!--
<section class="mbr-section info5 cid-qIjGVVeB7i" id="info5-9" data-sortbtn="btn-primary">
    <div class="container">
        <div class="row justify-content-center content-row">
            <div class="media-container-column title col-12 col-lg-7 col-md-6">
            </div>
        </div>
    </div>
</section>
-->

<!--imgs-->
				<!-- ?php print $ad_html? -->

<!--footer-->
<?php require_once './required/footer_out.php'?>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css">

<script type="text/javascript">
    $(function() {
		// 下部スライダー
    	$('#undSlider').slick({
    	    arrows: false,
    	    autoplay: true,
    	    loop: true,
    	    autoplaySpeed: 0,
    	    cssEase: 'linear',
    	    speed: 5000,
    	    /* ～ここまで */
    	    slidesToShow: 7,
    	    slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 1600,
					settings: {
						slidesToShow: 6
					}
				},{
					breakpoint: 1300,
					settings: {
						slidesToShow: 5
					}
				},{
					breakpoint: 991,
					settings: {
						slidesToShow: 4
					}
				},{
					breakpoint: 768,
					settings: {
						slidesToShow: 3
					}
				},{
					breakpoint: 600,
					settings: {
						slidesToShow: 2
					}
				}
			]
    	});

});

    $(function() {
    	$("[name=date]").datepicker({
    	    showButtonPanel: true
    	   });
    	 (function(){
    		    var old_fn = $.datepicker._updateDatepicker;
    		    $.datepicker._updateDatepicker = function(inst) {
    		      old_fn.call(this, inst);
    		      var buttonPane = $(this).datepicker("widget").find(
    		        ".ui-datepicker-buttonpane");
    		      var buttonHtml = "<button type='button' class='ui-datepicker-clean ui-state-default ui-priority-primary ui-corner-all'>Reset</button>";
    		      $(buttonHtml).appendTo(buttonPane).click(function(ev) {
    		        $.datepicker._clearDate(inst.input);
    		      });
    		    }
    		  })()
    		  $.datepicker._gotoToday = function(id) {
					var target = $(id);
					var inst = this._getInst(target[0]);
					var date = new Date();
					this._setDate(inst,date);
					this._hideDatepicker();
				};
    });

	$(function(){

$('.mainSliderItem').slick({
  autoplay: true,
  fade: true,
  dots:true,
  arrows: false,
  infinite:true,
  speed: 2000,
  autoplaySpeed: 4000,
  pauseOnFocus: false,
  pauseOnHover: false,
 
});

});

</script>

</body>
</html>