<?php

// session_start();
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/logic/common/common_logic.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/logic/common/trynavi_common_logic.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/model/t_member_model.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/model/t_store_basic_model.php';
// $t_member_model = new t_member_model();
// $t_store_basic_model = new t_store_basic_model();

// $script_html = '';
// if ($_SESSION ['try_login_member_data'] ['member_id'] == null || $_SESSION ['try_login_member_data'] ['member_id'] == '') {
// 	$script_html = '
// 			<script>
// 				alert("ログイン後にご利用になれる機能です。\r\nTOPページへ移動します。");
// 				location.href = "../";
// 			</script>
// 			';
// }else{
// 	$member_data = $t_member_model->get_member_detail($_SESSION ['try_login_member_data'] ['member_id']);
// 	// $member_data = $t_member_model->get_member_detail(6);
// 	$_SESSION['try_login_member_data']  = $member_data[0];
// 	$_SESSION['try_login_member_data'] ['password'] = '';

// 	$store_data = $t_store_basic_model->get_store_basic_detail($member_data[0]['store_basic_id']);
// 	$_SESSION['member_data'] ['store_name'] = $store_data[0]['store_name'];
// }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once '../required/html_head.php';?>
<?php print $script_html?>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="../assets/front/css/jquery.datepicker.css">
<script type='text/javascript' src='//code.jquery.com/jquery-migrate-1.2.1.min.js'></script>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>
<script type="text/javascript" src="../assets/front/js/moment.js"></script>
<script type="text/javascript" src="../assets/front/page_js/right2.js"></script>

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

<!-- システム用 -->
<script type="text/javascript" src="../assets/admin/js/common/validate.js"></script>
<script type="text/javascript" src="../assets/front/js/edit_cuisine.js"></script>
<script type="text/javascript" src="../assets/front/js/plural_file_upload.js"></script>

</head>
<body>

	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once '../required/header_out_lower.php';?>
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
								<div class="mypageTopName">ようこそ、<span class="mypageTopNameB"><?php print( $_SESSION['member_data'] ['store_name']);?></span>さん</div>
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
							<a href="edit.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">基本情報の編集</span></span></a>
							<a href="edit_seat.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">座席の登録編集</span></span></a>
						</div>
						<div class="storeEditBtnBox">
							<span class="storeEditImgList"><a href="edit_inview.php">店外写真</a></span>
							<span class="storeEditImgList"><a href="edit_appearance.php">店内写真</a></span>
							<span class="storeEditImgList"><a href="edit_staff.php">スタッフ写真</a></span>
							<span class="storeEditImgList"><a href="javascript:void(0)" class="active">料理写真</a></span>
						</div>
					</section>

					<section class="borderBox">
						<div class="storeEditIn">
							<h4 class="titleBN">料理写真登録・編集</h4>
							<div class="storeEditItem">
<!-- 								<div class="storeEditRow"> -->
<!-- 									<div class="storeEditCate">料理1名称</div> -->
<!-- 									<div class="storeEditForm"> -->
<!-- 										<input type="text" name="" class="formTxt1"> -->
<!-- 									</div> -->
<!-- 								</div> -->
								<div class="storeEditRow">
									<div class="storeEditCate">料理1説明文</div>
									<div class="storeEditForm">
										<textarea name="" rows="5" cols="" class="formTxt1 comment_area store_detail_comment_1"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">料理1画像</div>
									<div class="storeEditForm">
										<span>登録されている画像：　</span><span class="img_name_area img_name_0"></span>
										<div id="fileArea1" class="form_btn img_btn">
											<form id="upload_form1" enctype="multipart/form-data" method="post">
												<input type="file" name="file1" id="file1" jq_id="1" cnt="0" class="form_file">
												<br>
												<div id="progressArea1" class="progressArea">
													<progress id="progressBar1" value="0" max="100" style="width: 100px;"> </progress>
													&nbsp;：
													<output id="outp1">&nbsp;0</output>
													%
												</div>
												<h4 id="status1"></h4>
											</form>
										</div>
											<div id="img_area1"></div>
									</div>
								</div>
							</div>
							<div class="storeEditItem">
<!-- 								<div class="storeEditRow"> -->
<!-- 									<div class="storeEditCate">料理2名称</div> -->
<!-- 									<div class="storeEditForm"> -->
<!-- 										<input type="text" name="" class="formTxt1"> -->
<!-- 									</div> -->
<!-- 								</div> -->
								<div class="storeEditRow">
									<div class="storeEditCate">料理2説明文</div>
									<div class="storeEditForm">
										<textarea name="" rows="5" cols="" class="formTxt1 comment_area store_detail_comment_2"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">料理2画像</div>
									<div class="storeEditForm">
										<span>登録されている画像：　</span><span class="img_name_area img_name_1"></span>
										<div id="fileArea2" class="form_btn img_btn">
											<form id="upload_form2" enctype="multipart/form-data" method="post">
												<input type="file" name="file2" id="file2" jq_id="2" cnt="1" class="form_file">
												<br>
												<div id="progressArea2" class="progressArea">
													<progress id="progressBar2" value="0" max="100" style="width: 200px;"> </progress>
													&nbsp;：
													<output id="outp2">&nbsp;0</output>
													%
												</div>
												<h4 id="status2"></h4>
											</form>
										</div>
											<div id="img_area2"></div>
									</div>
								</div>
							</div>
							<div class="storeEditItem">
<!-- 								<div class="storeEditRow"> -->
<!-- 									<div class="storeEditCate">料理3名称</div> -->
<!-- 									<div class="storeEditForm"> -->
<!-- 										<input type="text" name="" class="formTxt1"> -->
<!-- 									</div> -->
<!-- 								</div> -->
								<div class="storeEditRow">
									<div class="storeEditCate">料理3説明文</div>
									<div class="storeEditForm">
										<textarea name="" rows="5" cols="" class="formTxt1 comment_area store_detail_comment_3"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">料理3画像</div>
									<div class="storeEditForm">
										<span>登録されている画像：　</span><span class="img_name_area img_name_2"></span>
										<div id="fileArea3" class="form_btn img_btn">
											<form id="upload_form3" enctype="multipart/form-data" method="post">
												<input type="file" name="file3" id="file3" jq_id="3" cnt="2" class="form_file">
												<br>
												<div id="progressArea3" class="progressArea">
													<progress id="progressBar3" value="0" max="100" style="width: 300px;"> </progress>
													&nbsp;：
													<output id="outp3">&nbsp;0</output>
													%
												</div>
												<h4 id="status3"></h4>
											</form>
										</div>
											<div id="img_area3"></div>
									</div>
								</div>
							</div>
							<div class="storeEditItem">
<!-- 								<div class="storeEditRow"> -->
<!-- 									<div class="storeEditCate">料理4名称</div> -->
<!-- 									<div class="storeEditForm"> -->
<!-- 										<input type="text" name="" class="formTxt1"> -->
<!-- 									</div> -->
<!-- 								</div> -->
								<div class="storeEditRow">
									<div class="storeEditCate">料理4説明文</div>
									<div class="storeEditForm">
										<textarea name="" rows="5" cols="" class="formTxt1 comment_area store_detail_comment_4"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">料理4画像</div>
									<div class="storeEditForm">
										<span>登録されている画像：　</span><span class="img_name_area img_name_3"></span>
										<div id="fileArea4" class="form_btn img_btn">
											<form id="upload_form4" enctype="multipart/form-data" method="post">
												<input type="file" name="file4" id="file4" jq_id="4" cnt="3" class="form_file">
												<br>
												<div id="progressArea4" class="progressArea">
													<progress id="progressBar4" value="0" max="100" style="width: 400px;"> </progress>
													&nbsp;：
													<output id="outp4">&nbsp;0</output>
													%
												</div>
												<h4 id="status4"></h4>
											</form>
										</div>
											<div id="img_area4"></div>
									</div>
								</div>
							</div>
							<div class="storeEditItem">
<!-- 								<div class="storeEditRow"> -->
<!-- 									<div class="storeEditCate">料理5名称</div> -->
<!-- 									<div class="storeEditForm"> -->
<!-- 										<input type="text" name="" class="formTxt1"> -->
<!-- 									</div> -->
<!-- 								</div> -->
								<div class="storeEditRow">
									<div class="storeEditCate">料理5説明文</div>
									<div class="storeEditForm">
										<textarea name="" rows="5" cols="" class="formTxt1 comment_area store_detail_comment_5"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">料理5画像</div>
									<div class="storeEditForm">
										<span>登録されている画像：　</span><span class="img_name_area img_name_4"></span>
										<div id="fileArea5" class="form_btn img_btn">
											<form id="upload_form5" enctype="multipart/form-data" method="post">
												<input type="file" name="file5" id="file5" jq_id="5" cnt="4" class="form_file">
												<br>
												<div id="progressArea5" class="progressArea">
													<progress id="progressBar5" value="0" max="100" style="width: 500px;"> </progress>
													&nbsp;：
													<output id="outp5">&nbsp;0</output>
													%
												</div>
												<h4 id="status5"></h4>
											</form>
										</div>
											<div id="img_area5"></div>
									</div>
								</div>
							</div>
							<div class="storeEditItem">
<!-- 								<div class="storeEditRow"> -->
<!-- 									<div class="storeEditCate">料理6名称</div> -->
<!-- 									<div class="storeEditForm"> -->
<!-- 										<input type="text" name="" class="formTxt1"> -->
<!-- 									</div> -->
<!-- 								</div> -->
								<div class="storeEditRow">
									<div class="storeEditCate">料理6説明文</div>
									<div class="storeEditForm">
										<textarea name="" rows="5" cols="" class="formTxt1 comment_area store_detail_comment_6"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">料理6画像</div>
									<div class="storeEditForm">
										<span>登録されている画像：　</span><span class="img_name_area img_name_5"></span>
										<div id="fileArea6" class="form_btn img_btn">
											<form id="upload_form6" enctype="multipart/form-data" method="post">
												<input type="file" name="file6" id="file6" jq_id="6" cnt="5" class="form_file">
												<br>
												<div id="progressArea6" class="progressArea">
													<progress id="progressBar6" value="0" max="100" style="width: 600px;"> </progress>
													&nbsp;：
													<output id="outp6">&nbsp;0</output>
													%
												</div>
												<h4 id="status6"></h4>
											</form>
										</div>
											<div id="img_area6"></div>
									</div>
								</div>
							</div>
						</div>
					</section>

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
	<?php require_once '../required/footer_out.php';?>
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
<input type="hidden" id="img_path1" value="store_detail_img/cuisine/">
<input type="hidden" id="img_path2" value="store_detail_img/cuisine/">
<input type="hidden" id="img_path3" value="store_detail_img/cuisine/">
<input type="hidden" id="img_path4" value="store_detail_img/cuisine/">
<input type="hidden" id="img_path5" value="store_detail_img/cuisine/">
<input type="hidden" id="img_path6" value="store_detail_img/cuisine/">
<input type="hidden" id="img_length1" class="hid_img_length" value="1">
<input type="hidden" id="img_length2" class="hid_img_length" value="1">
<input type="hidden" id="img_length3" class="hid_img_length" value="1">
<input type="hidden" id="img_length4" class="hid_img_length" value="1">
<input type="hidden" id="img_length5" class="hid_img_length" value="1">
<input type="hidden" id="img_length6" class="hid_img_length" value="1">
<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
<input type="hidden" id="img_type2" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
<input type="hidden" id="img_type3" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
<input type="hidden" id="img_type4" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
<input type="hidden" id="img_type5" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
<input type="hidden" id="img_type6" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">


</body>
</html>
