<?php
session_start();
require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/common_logic.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/jis_common_logic.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_member_model.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_store_basic_model.php';
$t_member_model = new t_member_model();
$t_store_basic_model = new t_store_basic_model();

$script_html = '';
if ($_SESSION ['try_login_member_data'] ['member_id'] == null || $_SESSION ['try_login_member_data'] ['member_id'] == '') {
	$script_html = '
			<script>
				alert("ログイン後にご利用になれる機能です。\r\nTOPページへ移動します。");
				location.href = "../";
			</script>
			';
}else{
	$member_data = $t_member_model->get_member_detail($_SESSION ['try_login_member_data'] ['member_id']);
	// $member_data = $t_member_model->get_member_detail(6);
	$_SESSION['try_login_member_data']  = $member_data[0];
	$_SESSION['try_login_member_data']['password'] = '';

	$store_data = $t_store_basic_model->get_store_basic_detail($member_data[0]['store_basic_id']);
	$_SESSION['member_data']['store_name'] = $store_data[0]['store_name'];

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<meta name="description" content="jisのバーのページです。お得に銀座の店舗を予約するなら「Healing Tokyo」!!" />
<meta name="keywords" content="銀座,レストラン,予約,ランチ,ディナー,バー,クラブ,フリードリンク,有楽町,日比谷" />
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../assets/front/css/base.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="../assets/front/css/top-prts.css">
<link rel="stylesheet" href="../assets/front/css/special-prts.css">
<link rel="stylesheet" href="../assets/front/css/top-prts.css">
<link rel="stylesheet" href="../assets/front/css/pc.css">
<link rel="stylesheet" href="../assets/front/css/restaurant_shop.css">
<link rel="stylesheet" href="../assets/front/css/restaurant-top.css">
<link rel="stylesheet" href="../assets/front/css/slider-pro.css">
<link href="../assets/front/css/font-awesome.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../assets/front/css/design.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="../assets/front/css/side200.css" type="text/css" media="screen,print" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<link href="../assets/front/css/commodity_client.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700|Noto+Serif:400,700' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="../assets/front/css/jquery.datepicker.css">
<script type='text/javascript' src='//code.jquery.com/jquery-migrate-1.2.1.min.js'></script>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
<script type="text/javascript" src="../assets/front/js/moment.js"></script>
<script type="text/javascript" src="../assets/front/page_js/right2.js"></script>

<!-- システム用 -->
<script type="text/javascript" src="../assets/admin/js/common/validate.js"></script>
<script type="text/javascript" src="../assets/front/js/edit_seat.js"></script>
<script type="text/javascript" src="../assets/front/js/plural_file_upload.js"></script>


<?php print $script_html?>
<script src="../assets/front/js/jquery.sliderPro.min.js"></script>
<script type="text/javascript">
            $(document).ready(function($) {
 var slideImageWidth = (screen.width > 768) ? 760 : 300,
 slideImageHeight = (screen.width > 768) ? 452 : 3000 / 19 + 40;
 var $slides = $('.sp-slide'),
 slideCount = $slides.length;
 if (slideCount < 3 || slideCount === 3) {
 $slides.clone(true).appendTo('.sp-slides');
 }
 $('.slider-pro').sliderPro({
 width: '1090px',
 autoHeight: true,
 slideDistance: 0,
 arrows: true,
 fadeArrows: false,
 buttons: false,
 loop: true,
 visibleSize: '100%',
 init: function() {
 if (
 (navigator.userAgent.indexOf('iPad')) > 0 ||
 (navigator.userAgent.indexOf('Android')) > 0 &&
 (navigator.userAgent.indexOf('Mobile')) === -1
 ) {
 $('.sp-slides-container').css('overflow', 'hidden');
 } else {
 $(".sp-slides .sp-slide a").each(function(i, el) {
 $(el).addClass("sp-selectable").css("cursor", "pointer");
 });
 }
 }
 });
 });
</script>
</head>
<body>

	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once '../header_out.php';?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
<!-- 			<div class="container1080"> -->
<!-- 				<div class="visible-xs"> -->
<!-- 					<section> -->
<!-- 						<div class="slider-pro"> -->
<!-- 						    <div class="sp-slides"> -->
						        <!-- Slide 1 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/sp_top1.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 2 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/sp_top2.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 3 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/sp_top3.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 4 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/sp_top4.jpg"/> -->
<!-- 						        </div> -->
<!-- 							 </div> -->
<!-- 						  </div> -->
<!-- 					</section> -->
<!-- 			    </div> -->
<!-- 				<div class="hidden-xs"> -->
<!-- 					<section> -->
<!-- 						<div class="slider-pro"> -->
<!-- 						    <div class="sp-slides"> -->
						        <!-- Slide 1 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/top1.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 2 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/top2.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 3 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/top3.jpg"/> -->
<!-- 						        </div> -->
						        <!-- Slide 4 -->
<!-- 						        <div class="sp-slide sliderBorBtm"> -->
<!-- 						            <img class="sp-image" src="../assets/front/img/top4.jpg"/> -->
<!-- 						        </div> -->
<!-- 						    </div> -->
<!-- 						  </div> -->
<!-- 					</section> -->
<!-- 				</div> -->
<!-- 			</div> -->
			<div class="container1080 cf">
				<div class="container760">

					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title">マイページ</h2>
							</div>
							<div class="mypageTopNameBox">
								<div class="mypageTopName">ようこそ、<span class="mypageTopNameB"><?php print($_SESSION['member_data']['store_name'] );?></span>さん</div>
								<div class="mypageTopEdit">
									<div class="mypageTopEditBtn"><a href="../mypage/withdrawal.php">会員退会手続き</a></div>
								</div>
							</div>
						</div>
					</section>

					<section>
						<h3 class="titleUnderline">店舗情報管理</h3>
						<div class="storeEditBtnBox">
							<a href="edit_reason.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">店舗TOPページ編集</span></span></a>
							<a href="booking_details.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">基本情報の編集</span></span></a>
							<a href="edit_appearance.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">各種写真の登録編集</span></span></a>
						</div>
					</section>

					<form action="" name="frm" method="post" id="frm">
					<section class="borderBox">
						<div class="storeEditIn">
							<h4 class="titleBN">座席登録・編集</h4><span class="registTit1" id="conf_text"></span>
								<div class="storeEditItem seat_input_area_1" id="from_1">
									<input type="hidden" name="store_seat_id_1" class="seat_id" value="">
									<div class="storeEditRow">
										<div class="storeEditCate">座席1名称</div>
										<div class="storeEditForm">
											<input type="text" id="seat_title_1" name="seat_title_1" class="formTxt1 validate required">
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">座席1説明文</div>
										<div class="storeEditForm">
											<textarea id="comment_1" name="comment_1" rows="5" cols="" class="formTxt1 validate required"></textarea>
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">座席タイプ</div>
										<div class="storeEditForm">
											<span class="registBox33">
												<select name="seat_type_1" id="seat_type_1" class="formTxt1 validate required">
													<option value="0" selected>窓際</option>
													<option value="1">テラス席</option>
													<option value="2">ソファ席</option>
													<option value="3">個室</option>
													<option value="4">半個室</option>
													<option value="5">カウンター</option>
												</select>
											</span>
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">座席数</div>
										<div class="storeEditForm">
											<span class="registBox33">
												<input type="text" id="seat_num_1" name="seat_num_1" class="formTxt2 validate required number"><!--  --><span class="registItem">席</span>
											</span>
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">座席利用可能人数</div>
										<div class="storeEditForm">
											<span class="registBox33">
												<input type="text" name="people_min_1" id="people_min_1" class="formTxt2 validate required number"><!--  --><span class="registItem">人～</span>
											</span>

											<span class="registBox33">
												<input type="text" name="people_max_1" id="people_max_1" class="formTxt2 validate required number"><!--  --><span class="registItem">人</span>
											</span>
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">たばこ</div>
										<div class="storeEditForm">
											<span class="formRBox"><input type="radio" name="smoke_flg_1" value="0" checked>&nbsp;禁煙</span>
											<span class="formRBox"><input type="radio" name="smoke_flg_1" value="1">&nbsp;喫煙</span>
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">座席1画像</div>
										<div class="storeEditForm">
											<span>登録されている画像：　</span><span class="img_name_area img_name_0"></span>
											<div id="fileArea1" class="form_btn img_btn">
												<form id="upload_form1" enctype="multipart/form-data" method="post">
													<input type="file" name="file1" id="file1" jq_id="1" cnt="0" class="form_file">
													<br>
													<div id="progressArea1" class="progressArea">
														<progress id="progressBar1" value="0" max="100" style="width: 300px;"> </progress>
														&nbsp;：
														<output id="outp1">&nbsp;0</output>
														%
													</div>
													<h4 id="status1"></h4>
												</form>
												<input type="hidden" name="img_1" class="img_1" value="">
											</div>
											<div id="img_area1"></div>
										</div>
									</div>
								</div>
								<div id="new_form_area"></div>
							<div class="storeEditRow">
								<div class="editSeatBtn">
									<button type="button" class="btnBase btnBg1 btnW1 require_text" name="add_form" id="add_form" value="2"><span class="btnLh2"><i class="fa fa-pencil"></i> 座席を追加する</span></button>
								</div>
							</div>

						</div>
					</section>
					</form>

					<section>
						<div class="storeEditBtnBox mT20">
							<button type="button" class="btn btn-primary button_input button_form btnBase btnBg1 btnW1" name='conf' id="conf"><span class="btnLh2"><i class='fa fa-pencil'></i> 確認画面へ進む</span></button>
							<button type="button" class="button_conf button_form btnBase btnBg1 btnW1" name='return' id="return"><span class="btnLh2"><i class='fa fa-pencil'></i> 戻る</span></button>
							<button type="button" class="button_conf button_form btnBase btnBg1 btnW1" name='submit' id="submit"><span class="btnLh2"><i class='fa fa-pencil'></i> 登録</span></button>
						</div>
					</section>
				</div>

	<!--▼▼▼▼▼ right ▼▼▼▼▼-->
	<?php require_once '../right_out.php';?>
	<!--▲▲▲▲▲ right ▲▲▲▲▲-->

			</div>
		</div>
	</div>

	<!--▼▼▼▼▼ footer ▼▼▼▼▼-->
	<?php require_once '../footer_out.php';?>
	<!--▲▲▲▲▲ footer ▲▲▲▲▲-->

	<!-- ページTOPへ-->
	<p id="try__page-top">
		<a href="#wrap">TOP</a>
	</p>
	<!-- ページTOPへ-->


	<!--▲▲▲▲▲ contents ▲▲▲▲▲-->

<!-- システム用 -->
<input type="hidden" id="ct_url" value="../controller/front/edit_store_ct.php">
<input type="hidden" id="id" value="">
<input type="hidden" id="page_type" value="edit_init">
<input type="password" id="before_password" value="" style="display: none;">
<!--  //ファイル即時アップロード用CT -->
<input type="hidden" id="common_ct_url" value="../controller/admin/common_ct.php">
<!-- ベースディレクトリ -->
<input type="hidden" id="base_dir" value="store/">
<!-- 一時フォルダ名 -->
<input type="hidden" id="tmp_dir" value="">
<!-- 編集フラグ（編集時は直接個人のフォルダに格納） -->
<input type="hidden" id="edit_flg" value="1">
<input type="hidden" id="personal_dir" value="">
<input type="hidden" id="img_path1" value="store_seat/">
<input type="hidden" id="img_length1" class="hid_img_length" value="1">
<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">

<!-- 動的作成 -->
<div id="file_up_conf"></div>



</body>
</html>
