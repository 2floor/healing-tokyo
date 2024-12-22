<?php
// session_start();
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/common_logic.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/jis_common_logic.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_member_model.php';
// require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_store_basic_model.php';
// $t_member_model = new t_member_model();
// $common_logic = new common_logic();
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

// 	$scene_data = $common_logic->select_logic('select * from t_scene where del_flg = ? and public_flg = ? order by create_at desc', array(0,0));
// 	$scene_html = '<div class="storeEditRow">
// 									<div class="storeEditCate">シーン</div>
// 									<div class="storeEditForm">';
// 	if($scene_data){
// 		foreach ($scene_data as $sv){
// 			$scene_html .= '<span class="formRBox scene_chkbox"  etc1="'.$sv['etc1'].'" ><input type="checkbox" name="etc5" value="'.$sv['scene_id'].'" class="validate " style="width: 15px; height: auto; display: inline;">'.$sv['name'].'</span>';
// 		}
// 	}

// 	$scene_html .= '</div>
// 				</div>';
// }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once "../required/html_head.php"?>


<!-- システム用 -->
<script type="text/javascript" src="../assets/admin/js/common/validate.js"></script>
<!-- <script type="text/javascript" src="../assets/front/js/edit_plan.js"></script> -->
<script type="text/javascript" src="../assets/front/js/plural_file_upload.js"></script>




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
<?php require_once "../required/header_out_lower.php"?>
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
							<a href="edit_seat.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">座席の登録編集</span></span></a>
							<a href="edit_inview.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">各種写真の登録編集</span></span></a>
						</div>
					</section>

					<section class="borderBox">
						<div class="storeEditIn">
							<h4 class="titleBN">プラン編集<span class="registTit1" id="conf_text">以下の項目はすべて<span class="registTit2">※必須項目</span>です。</span></h4>
							<div class="storeEditItem">
								<div class="storeEditRow">
									<div class="storeEditCate">タイトル</div>
									<div class="storeEditForm">
										<textarea name="title" id="title" rows="5" cols="" class="formTxt1 validate required"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">説明</div>
									<div class="storeEditForm">
										<textarea name="detail" id="detail" rows="5" cols="" class="formTxt1 validate required"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">画像</div>
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
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">金額</div>
									<div class="storeEditForm">
										<span class="registBox33">
											<input type="text" name="charge" id="charge" class="formTxt2 validate required"><span class="registItem">円</span>
										</span><span class="registBox33">※税・サービス税込</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">女性限定</div>
									<div class="storeEditForm">
										<span class="formRBox"><input type="radio" class="" name="only_women" value="0" checked>限定なし</span>
										<span class="formRBox"><input type="radio" class="" name="only_women" value="1">女性限定</span>
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">特別プラン</div>
									<div class="storeEditForm">
										<span class="formRBox"><input type="radio" class="" name="special_flg" value="0" checked>通常プラン</span>
										<span class="formRBox"><input type="radio" class="" name="special_flg" value="1">特別プラン</span>
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">プランタイプ</div>
									<div class="storeEditForm">
										<span class="formRBox"><input type="radio" class="" name="etc4" value="0" checked>通常プラン</span>
										<span class="formRBox"><input type="radio" class="" name="etc4" value="1">ゴールド</span>
										<span class="formRBox"><input type="radio" class="" name="etc4" value="2">プラチナ</span>
									</div>
								</div>

								<div id="plan_type_html"></div>

								<?php print $scene_html?>

								<div class="storeEditRow">
									<div class="storeEditCate">料理メニュー</div>
									<div class="storeEditForm">
										<textarea name="menu" id="menu" rows="5" cols="" class="formTxt1 validate required"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">ドリンク</div>
									<div class="storeEditForm">
										<textarea name="drink" id="drink" rows="5" cols="" class="formTxt1 validate required"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">利用可能特典</div>
									<div class="storeEditForm">
										<textarea name="benefits" id="benefits" rows="5" cols="" class="formTxt1 validate"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">利用可能人数（表示用）</div>
									<div class="storeEditForm">
										<textarea name="disp_people_num" id="disp_people_num" rows="5" cols="" class="formTxt1 validate required"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">利用可能人数</div>
									<div class="storeEditForm">
										<input type="text" name="available_num" id="available_num" class="formTxt1 validate required">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">制限時間</div>
									<div class="storeEditForm">
										<textarea name="limit_time" id="limit_time" rows="5" cols="" class="formTxt1 validate"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">支払い方法</div>
									<div class="storeEditForm">
										<textarea name="payment_way" id="payment_way" rows="5" cols="" class="formTxt1 validate required"></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">注意事項</div>
									<div class="storeEditForm">
										<textarea name="notes" id="notes" rows="5" cols="" class="formTxt1 validate required"></textarea>
									</div>
								</div>


								<form action="" name="frm" method="post" id="frm">
									<div class="seat_input_area_1">
										<div class="registTit3">座席</div>
										<div class="storeEditRow">
										<input type="hidden" name="seat_plan_relation_id_1" class="seat_plan_relation_id_1" value="">
											<div class="storeEditRow" id="select_seat_html"></div>
										</div>
										<div class="storeEditRow">
											<div class="storeEditCate">予約タイプ</div>
											<div class="storeEditForm">
												<span class="formRBox"><input type="radio" class="" name="seat_discrimination_1" value="0" checked="checked">卓（部屋）数で予約を取る</span>
												<span class="formRBox"><input type="radio" class="" name="seat_discrimination_1" value="1">人数で予約を取る</span>
											</div>
										</div>
										<div class="storeEditRow">
											<div class="storeEditCate">予約可能人数（卓数）</div>
											<div class="storeEditForm">
												<input type="text" name="available_num_1" id="available_num_1" class="formTxt1 validate required number">
											</div>
										</div>
										<div class="storeEditRow">
											<div class="storeEditCate">利用可能時刻</div>
											<div class="storeEditForm">
											<input type="hidden" id="start_time_1" name="start_time_1" value="00:00" class="form-control input_form validate required" style="width: 400px;" autocomplete="off">
												<select id="start_time_hour" name="start_time_hour" tar="start_time_1" class="" style="display: inline-block; width: 65px;">
													<option value="00" selected>00</option>
													<option value="01">01</option>
													<option value="02">02</option>
													<option value="03">03</option>
													<option value="04">04</option>
													<option value="05">05</option>
													<option value="06">06</option>
													<option value="07">07</option>
													<option value="08">08</option>
													<option value="09">09</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
													<option value="13">13</option>
													<option value="14">14</option>
													<option value="15">15</option>
													<option value="16">16</option>
													<option value="17">17</option>
													<option value="18">18</option>
													<option value="19">19</option>
													<option value="20">20</option>
													<option value="21">21</option>
													<option value="22">22</option>
													<option value="23">23</option>
												</select>時
												<select id="start_time_min" name="start_time_min" tar="start_time_1" class="form-control input_form" style="display: inline-block; width: 65px;">
													<option value="00">00</option>
													<option value="15">15</option>
													<option value="30">30</option>
													<option value="45">45</option>
												</select>分&nbsp;～&nbsp;

												 <input type="hidden" id="lo_time_1" name="lo_time_1" value="00:00" class="validate required"
												style="width: 400px;" autocomplete="off">
												<select id="lo_time_hour" name="lo_time_hour" tar="lo_time_1" class="form-control input_form" style="display: inline-block; width: 65px;">
													<option value="00" selected>00</option>
													<option value="01">01</option>
													<option value="02">02</option>
													<option value="03">03</option>
													<option value="04">04</option>
													<option value="05">05</option>
													<option value="06">06</option>
													<option value="07">07</option>
													<option value="08">08</option>
													<option value="09">09</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
													<option value="13">13</option>
													<option value="14">14</option>
													<option value="15">15</option>
													<option value="16">16</option>
													<option value="17">17</option>
													<option value="18">18</option>
													<option value="19">19</option>
													<option value="20">20</option>
													<option value="21">21</option>
													<option value="22">22</option>
													<option value="23">23</option>
												</select>時
												<select id="lo_time_min" name="lo_time_min" tar="lo_time_1" class="form-control input_form" style="display: inline-block; width: 65px;">
													<option value="00">00</option>
													<option value="15">15</option>
													<option value="30">30</option>
													<option value="45">45</option>
												</select>分
											</div>
										</div>
										<div class="editSeatBtn">
											<button type="button" class="btnBase btnBg1 btnW1 del require_text" name="del_seat_plan_1" id="del_seat_plan_1" num="1" value="" title=""><span class="btnLh2"><i class="fa fa-pencil"></i> この座席を削除する</span></button>
										</div>
									</div>

									<div id="new_form_area"></div>

								</form>
								<div class="storeEditRow">
									<div class="editSeatBtn">
										<button type="button" class="btnBase btnBg1 btnW1 require_text" name="add_form" id="add_form" value="2"><span class="btnLh2"><i class="fa fa-pencil"></i> 座席を追加する</span></button>
									</div>
								</div>
							</div>
						</div>
					</section>

					<section>
						<div class="storeEditBtnBox mT20">
							<button type="button" class="btn btn-primary button_input button_form btnBase btnBg1 btnW1" name='conf' id="conf"><span class="btnLh2"> 確認画面へ進む</span></button>
							<button type="button" class="button_conf button_form btnBase btnBg1 btnW1" name='return' id="return"><span class="btnLh2"> 戻る</span></button>
							<button type="button" class="button_conf button_form btnBase btnBg1 btnW1" name='submit' id="submit"><span class="btnLh2"> 登録</span></button>
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
<input type="hidden" id="img_path1" value="plan_img/">
<input type="hidden" id="img_length1" class="hid_img_length" value="1">
<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
</body>
</html>
