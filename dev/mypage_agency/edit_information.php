<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
$jis_common_logic = new jis_common_logic();
$opt = $jis_common_logic->get_date_opt();

$scrpt = $jis_common_logic->create_input_script($_SESSION['jis']['login_member'], array(
		'ignor' => "youtube_tag,cd_title,cd_deatil,cdf_title,cdf_detail1,cdf_detail2,trading_hours",
    'radio' => "store_type,bank_type",
    'file' => "img,cdf_img1,cdf_img2,cdf_img3",
    'fileOpt' => array(
        "img" => array(
            "dir" => "../upload_files/store_basic/",
            "jq_id" => "1",
        ),
        "cdf_img1" => array(
            "dir" => "../upload_files/store_basic/",
            "jq_id" => "2",
        ),
        "cdf_img2" => array(
            "dir" => "../upload_files/store_basic/",
            "jq_id" => "3",
        ),
        "cdf_img3" => array(
            "dir" => "../upload_files/store_basic/",
            "jq_id" => "4",
        ),
    )
));
?>



<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once '../required/html_head.php';?>

<script type="text/javascript" src="../assets/js/validate.js"></script>
<script type="text/javascript" src="../assets/js/plural_file_upload.js"></script>
<script type="text/javascript" src="../assets/js/mail_depricate.js"></script>
<script type="text/javascript" src="../assets/js/form.js"></script>
</head>
<body>

	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once '../required/header_out_lower.php';?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->

	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="container1080 cf">
				<div class="container760">

				<?php require_once "member_top.php";?>

					<section>
						<h3 class="titleUnderline">事業者情報管理</h3>
						<div class="storeEditBtnBox">
							<a href="./"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">マイページTOP</span></span></a>
							<a href="regist_tour.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">アクティビティ情報登録</span></span></a>
						</div>

					</section>

					<section class="borderBox" id="inputFormArea">
						<div class="storeEditIn">
							<h4 class="titleBN">基本情報編集<span class="registTit1" id="conf_text">以下の項目はすべて※必須項目です</span></h4>
							<div class="storeEditItem">
							<div class="storeEditRow">
								<div class="storeEditRow">
									<div class="storeEditCate">種別<br>Type</div>
									<div class="storeEditForm required_form">
										<label><span class="formRBox"><input type="radio" name="store_type" value="0" class="validate" style="width: 15px; height: auto; display: inline;">法人</span></label>
										<label><span class="formRBox"><input type="radio" name="store_type" value="1" class="validate" style="width: 15px; height: auto; display: inline;">個人経営</span></label>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">事業者名<br>Company name</div>
									<div class="storeEditForm required_form">
										<input type="text" name="company_name" id="company_name" class="formTxt1 validate required" value=""  placeholder="ジャパン インターナショナル サービス (JIS)">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">事業者名（英語）<br>Company name(En.)</div>
									<div class="storeEditForm required_form">
										<input type="text" name="company_name_eng" id="company_name_eng" class="formTxt1 validate required" value="" placeholder="Japan International Service Co.,Ltd.">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">メールアドレス<br>Mail address</div>
									<div class="storeEditForm required_form">
										<input type="text" name="mail" id="mail" class="formTxt1 validate required " value="" placeholder="info@jis-j.com" own="<?php print $_SESSION['jis']['login_member']['store_basic_id']?>">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">パスワード変更<br>Change Password</div>
									<div class="storeEditForm">
										<label><span class="formRBox"><input type="checkbox" name="password_change" value="0" class="validate" style="width: 15px; height: auto; display: inline;">パスワードを変更する</span></label>
									</div>
								</div>
								<div class="storeEditRow password_change_form">
									<div class="storeEditCate">変更後のパスワード<br>After change</div>
									<div class="storeEditForm">
										<input type="text" name="password" id="password" class="formTxt1 validate required" value="">
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">担当者名<br>Contact name</div>
									<div class="storeEditForm required_form">
										<input type="text" name="contact_name" id="contact_name" class="formTxt1 validate required" value="" placeholder="高橋">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">担当者名(カナ)<br>Contact name(Kana)</div>
									<div class="storeEditForm required_form">
										<input type="text" name="contact_name_kana" id="contact_name_kana" class="formTxt1 validate required" value="" placeholder="タカハシ">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">担当者名（英語）<br>Contact name(En.)</div>
									<div class="storeEditForm">
										<input type="text" name="contact_name_eng" id="contact_name_eng" class="formTxt1 validate required" value="" placeholder="Takahashi">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">電話番号<br>Phone no.</div>
									<div class="storeEditForm required_form">
										<input type="tel" name="tel" id="tel" class="formTxt1 validate required" value="" placeholder="0345881055">
										<p>ハイフンは入れないでください</p>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">FAX<br>FAX no.</div>
									<div class="storeEditForm">
										<input type="tel" name="fax" id="fax" class="formTxt1 validate " value="" placeholder="0363000887">
										<p>ハイフンは入れないでください</p>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">緊急連絡<br>Emergency mobile no</div>
									<div class="storeEditForm required_form">
										<input type="tel" name="emergency_tel" id="emergency_tel" class="formTxt1 validate required" value="" placeholder="08055360555">
										<p>ハイフンは入れないでください</p>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">緊急連絡 担当者名<br>Emergency contact name（英語）</div>
									<div class="storeEditForm">
										<input type="text" name="emergency_contact_name" id="emergency_contact_name" class="formTxt1 validate required" value="" placeholder="Takahashi">
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">事業者所在地<br>Business location<br>（英語）</div>
									<div class="storeEditForm required_form">
										<input type="text" name="location" id="location" class="formTxt1 validate required" value="" placeholder="2-23-1-218 Yoyogi, Shibuya-ku, Tokyo 151-0053">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">営業時間<br>Trading Hours<br>（英語）</div>
									<div class="storeEditForm ">
										<textarea name="trading_hours" rows="3" cols="" class="formTxt1 validate " placeholder="From 10:00 to 19:00"><?php print htmlspecialchars_decode($_SESSION['jis']['login_member']['trading_hours'])?></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">URL</div>
									<div class="storeEditForm">
										<input type="text" name="url" id="url" class="formTxt1 validate " value="" placeholder="https://jis-j.com">
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">事業者紹介画像（三枚まで登録可）</div>
									<div class="storeEditForm required_form">
										<div id="fileArea1" class="form_btn img_btn">
											<form id="upload_form1" enctype="multipart/form-data" method="post">
												<input type="file" name="file1" id="file1" jq_id="1" class="form_file" col_name="img">
												<h4 id="status1"></h4>
											</form>
										</div>
											<div id="img_area1" class="imgPrevBox"></div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">YOUTUBE埋め込みタグ</div>
									<div class="storeEditForm">
										<textarea name="youtube_tag" rows="5" cols="" class="formTxt1 encode" placeholder="<?php print htmlspecialchars("<iflame>～</iflame>")?>の埋め込みタグをご入力ください"><?php print htmlspecialchars_decode($_SESSION['jis']['login_member']['youtube_tag'])?></textarea>
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">事業者詳細タイトル<br>（英語）</div>
									<div class="storeEditForm">
										<textarea name="cd_title" rows="3" cols="" class="formTxt1 comment_area" placeholder="Online-booking sites make enjoying in Japan easier than ever."><?php print htmlspecialchars_decode($_SESSION['jis']['login_member']['cd_title'])?></textarea>
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">事業者詳細<br>ディスクリプション<br>（英語）</div>
									<div class="storeEditForm">
										<textarea name="cd_deatil" rows="3" cols="" class="formTxt1 comment_area" placeholder="Online-booking sites make enjoying in Japan easier than ever."><?php print htmlspecialchars_decode($_SESSION['jis']['login_member']['cd_deatil'])?></textarea>
									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">事業者紹介タイトル<br>（英語）</div>
									<div class="storeEditForm">
										<textarea name="cdf_title" rows="3" cols="" class="formTxt1 comment_area" placeholder="company that is loved by our customers trust."><?php print htmlspecialchars_decode($_SESSION['jis']['login_member']['cdf_title'])?></textarea>
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate ">事業者紹介画像1</div>
									<div class="storeEditForm">
										<div id="fileArea2" class="form_btn img_btn ">
											<form id="upload_form2" enctype="multipart/form-data" method="post">
												<input type="file" name="file2" id="file2" jq_id="2" cnt="1" class="form_file" col_name="cdf_img1">
												<h4 id="status2"></h4>
											</form>
										</div>
											<div id="img_area2" style="max-width: 450px;"></div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">事業者紹介文言1<br>（英語）</div>
									<div class="storeEditForm">
										<textarea name="cdf_detail1" rows="3" cols="" class="formTxt1 comment_area"><?php print htmlspecialchars_decode($_SESSION['jis']['login_member']['cdf_detail1'])?></textarea>
									</div>
								</div>



								<div class="storeEditRow">
									<div class="storeEditCate">事業者紹介画像2</div>
									<div class="storeEditForm">
										<div id="fileArea3" class="form_btn img_btn">
											<form id="upload_form3" enctype="multipart/form-data" method="post">
												<input type="file" name="file3" id="file3" jq_id="3" cnt="2" class="form_file" col_name="cdf_img2">
												<h4 id="status3"></h4>
											</form>
										</div>
											<div id="img_area3" style="max-width: 450px;"></div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">事業者紹介文言2<br>（英語）</div>
									<div class="storeEditForm">
										<textarea name="cdf_detail2" rows="3" cols="" class="formTxt1 comment_area"><?php print htmlspecialchars_decode($_SESSION['jis']['login_member']['cdf_detail2'])?></textarea>
									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">事業者紹介画像3</div>
									<div class="storeEditForm">
										<div id="fileArea4" class="form_btn img_btn">
											<form id="upload_form4" enctype="multipart/form-data" method="post">
												<input type="file" name="file4" id="file4" jq_id="4" cnt="2" class="form_file" col_name="cdf_img3">
												<h4 id="status4"></h4>
											</form>
										</div>
											<div id="img_area4" style="max-width: 450px;"></div>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">事業者紹介文言3<br>（英語）</div>
									<div class="storeEditForm">
										<textarea name="cdf_detail3" rows="3" cols="" class="formTxt1 comment_area"><?php print htmlspecialchars_decode($_SESSION['jis']['login_member']['cdf_detail3'])?></textarea>
									</div>
								</div>



								<div class="storeEditRow">
									<div class="storeEditCate">銀行名<br>Bank detail</div>
									<div class="storeEditForm ">
										<p>JISが領収したアクティビティ費用等のお支払先</p>
										<input type="text" name="bank_name" id="bank_name" class="formTxt1 validate " value="" placeholder="三菱UFJ銀行">
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">支店名<br>Bank detail</div>
									<div class="storeEditForm ">
										<input type="text" name="bank_branch" id="bank_branch" class="formTxt1 validate " value="" placeholder="新宿中央">
									</div>
								</div>

<!-- 								<div class="storeEditRow"> -->
<!-- 									<div class="storeEditCate">支店コード<br>Bank detail</div> -->
<!-- 									<div class="storeEditForm "> -->
										<input type="hidden" name="bank_branch_number" id="bank_branch_number" class="formTxt1 validate " value="0">
<!-- 									</div> -->
<!-- 								</div> -->

								<div class="storeEditRow">
									<div class="storeEditCate">口座種別<br>Bank detail</div>
									<div class="storeEditForm ">
										<label><span class="formRBox"><input type="radio" name="bank_type" value="1" class="validate" style="width: 15px; height: auto; display: inline;" checked="checked">普通</span></label>
										<label><span class="formRBox"><input type="radio" name="bank_type" value="2" class="validate" style="width: 15px; height: auto; display: inline;">当座</span></label>
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">口座番号<br>Bank detail</div>
									<div class="storeEditForm ">
										<input type="text" name="bank_number" id="bank_number" class="formTxt1 validate " value="">
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">口座名義<br>Bank detail</div>
									<div class="storeEditForm ">
										<input type="text" name="bank_meigi" id="bank_meigi" class="formTxt1 validate " value="" placeholder="株式会社 ジャパンインターナショナルサービス 代表取締役 髙橋利幸">
									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">英語翻訳依頼<br></div>
									<div class="storeEditForm">
										<label><span class="formRBox"><input type="checkbox" name="offer" value="1" class="validate" style="width: 15px; height: auto; display: inline;">翻訳を依頼する</span></label>
									</div>
								</div>

								<input type="hidden" name="method" value="store_basic_edit">

							</div>
							<form action="../logic/front/regist_edit_logic.php" name="inputFormArea" method="post"></form>

							<div class="btnArea">
								<button type="button" class=" btn btnBg1 conf_hide" name="preview" prev_for="../search/agency_detail.php">プレビュー</button>
								<button type="button" class=" btn btnBg1 conf_hide" name="conf">確認する</button>
								<button type="button" class=" btn btnBgBack conf_show" name="back">戻る</button>
								<button type="button" class=" btn btnBg1 conf_show" name="submitBtn">登録する</button>
							</div>


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



	<script type="text/javascript">
	<?php print $scrpt?>
	if($(this).prop('checked') == true){
		$('.password_change_form').show().find('[name=password]').addClass('required');
	}else{
		$('.password_change_form').hide().find('[name=password]').removeClass('required');
	}
	$('[name=password_change]').off().on('click', function(){
		if($(this).prop('checked') == true){
			$('.password_change_form').show().find('[name=password]').addClass('required');
		}else{
			$('.password_change_form').hide().find('[name=password]').removeClass('required');
		}
	})
	</script>

	<input type="hidden" id="common_ct_url" value="../controller/admin/common_ct.php">
	<input type="hidden" id="img_path1" value="store_basic/">
	<input type="hidden" id="img_length1" class="hid_img_length" value="3">
	<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
	<input type="hidden" id="img_path2" value="store_basic/">
	<input type="hidden" id="img_length2" class="hid_img_length" value="1">
	<input type="hidden" id="img_type2" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
	<input type="hidden" id="img_path3" value="store_basic/">
	<input type="hidden" id="img_length3" class="hid_img_length" value="1">
	<input type="hidden" id="img_type3" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
	<input type="hidden" id="img_path4" value="store_basic/">
	<input type="hidden" id="img_length4" class="hid_img_length" value="1">
	<input type="hidden" id="img_type4" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">

	<script type="text/javascript" src="../assets/js/kankyou_conv.js"></script>


</body>
</html>
