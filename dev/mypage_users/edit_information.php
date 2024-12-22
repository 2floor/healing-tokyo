<?php
// session_start();
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/common_logic.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/jis_common_logic.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_member_model.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_store_basic_model.php';
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
// 	$_SESSION['try_login_member_data'] ['store_name'] = $store_data[0]['store_name'];
// }
?>



<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once '../required/html_head.php';?>
<?php print $script_html?>

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
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> MY PAGE</h2>
							</div>
							<div class="mypageTopNameBox">
								<div class="mypageTopName">Hello,<span class="mypageTopNameB"><?php print($_SESSION['member_data'] ['store_name']); ?></span></div>
								<div class="mypageTopEdit">
									<div class="mypageTopEditBtn"><a href="../mypage_users/index.php">My page top</a></div>
									<!--<div class="mypageTopEditBtn"><a href="../mypage/edit_information.php">Unsubscribed</a></div>-->

									<div class="mypageTopEditBtn"><a href="../mypage_users/edit_information.php">Edit my information</a></div>
								</div>
							</div>
							<div class="mypageAttention">
								<?php print $plan_regist_msg?>
							</div>
						</div>
					</section>

<!-- 					<section> -->
<!-- 						<h3 class="titleUnderline">事業者様情報管理</h3> -->
<!-- 						<div class="storeEditBtnBox"> -->
<!-- 							<a href="edit_information.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">事業者様情報編集</span></span></a> -->
<!-- 							<a href="booking_details.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">商品情報編集</span></span></a> -->
<!-- 						</div> -->

<!-- 					</section> -->

					<section class="borderBox">
						<div class="storeEditIn">
							<h4 class="titleBN">Basic information editing&nbsp;<span class="registTit1" id="conf_text">The following items are ※ required items</span></h4>
							<div class="storeEditItem">
								<div class="storeEditRow">
									<div class="storeEditCate">Mail addless</div>
									<div class="storeEditForm required_form">
										<input type="text" name="mail" id="mail" class="formTxt1 validate required mail" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">First name</div>
									<div class="storeEditForm required_form">
										<input type="text" name="mail" id="mail" class="formTxt1 validate required mail" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Last name</div>
									<div class="storeEditForm required_form">
										<input type="text" name="mail" id="mail" class="formTxt1 validate required mail" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Mail address</div>
									<div class="storeEditForm required_form">
										<input type="text" name="mail" id="mail" class="formTxt1 validate required mail" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">Mail address（confi.)</div>
									<div class="storeEditForm required_form">
										<input type="text" name="mail" id="mail" class="formTxt1 validate required mail" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">Change Password</div>
									<div class="storeEditForm">
										<span class="formRBox"><input type="checkbox" name="available_card" value="0" class="validate" style="width: 15px; height: auto; display: inline;">パスワードを変更する</span>

									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">After change</div>
									<div class="storeEditForm">
										<input type="text" name="mail" id="mail" class="formTxt1 validate required mail" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">Nickname</div>
									<div class="storeEditForm required_form">
										<input type="text" name="mail" id="mail" class="formTxt1 validate required mail" value="<?php print($_SESSION['try_login_member_data']['mail']); ?>">
									</div>
								</div>
								<p>※This is the name displayed when you review</p>


							</div>


						</div>
					</section>

					<section>
						<div class="storeEditBtnBox mT20">
							<button type="button" class="btn btn-primary button_input button_form btnBase btnBg1 btnW1" name='conf' id="conf"><span class="btnLh2"> SEND</span></button>

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
<input type="hidden" id="img_path1" value="store_detail_img/exterior/">
<input type="hidden" id="img_path2" value="store_detail_img/exterior/">
<input type="hidden" id="img_path3" value="store_detail_img/exterior/">
<input type="hidden" id="img_path4" value="store_detail_img/exterior/">
<input type="hidden" id="img_path5" value="store_detail_img/exterior/">
<input type="hidden" id="img_path6" value="store_detail_img/exterior/">
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
