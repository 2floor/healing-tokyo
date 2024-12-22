<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/front/front_disp_logic.php';
$jis_common_logic = new jis_common_logic();
$front_disp_logic = new front_disp_logic();
$tour_html = $front_disp_logic->search_tour_html($_GET);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once '../required/html_head.php'?>
<style type="text/css">
.pager{
	margin-top: 10px;;
	display: flex;
	align-items: center;
}
.pager li{
	margin: 0 10px;
}

.pager li a{
	display: flex;
	justify-content: center;
	align-items: center;
	width: 30px;
	height: 30px;
	border: 1px solid #3f7ab9;
	color: #3f7ab9;
	border-radius: 5px;
}

.pager li a:hover,
.pager li a.active{
	background-color:#3f7ab9;
	color: #FFF;
}
.sp-slide {
    width: 100%;
}
.sp-image {
    width: 100%;
}
</style>
<script src="https://d.shutto-translation.com/trans.js?id=62902"></script>
</head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once "../required/header_out_lower.php"?>
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
							            <img class="sp-image" src="../assets/front/img/tit_reservation_rank.jpg"/>
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
							            <img class="sp-image" src="../assets/front/img/tit_reservation_rank.jpg"/>
							        </div>
							    </div>
							  </div>
						</section>
					</div>
					<?php require_once __DIR__ . "/../required/main_vi_post.php"?>
				</div>
			</div>



			<div class="container1080 cf">
				<div class="container760">
					<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> Ranking</h2>
							</div>


					<section class="borderBox">
						<?php print $tour_html['tour_html']?>
					</section>
					<ul class="pager">
						<?php print $tour_html['pager']?>
					</ul>

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
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css">
<script type="text/javascript">
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
    		  })();
		  $.datepicker._gotoToday = function(id) {
				var target = $(id);
				var inst = this._getInst(target[0]);
				var date = new Date();
				this._setDate(inst,date);
				this._hideDatepicker();
			};
    });

    </script>
</body>
</html>
