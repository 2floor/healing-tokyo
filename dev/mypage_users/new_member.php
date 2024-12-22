<?php

// ini_set( 'display_errors', 1 );
header("Content-type: text/html; charset=utf-8");
session_start();


require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
require_once __DIR__ .  '/../logic/common/common_logic.php';
$jis_common_logic = new jis_common_logic();
$opt = $jis_common_logic->get_date_opt();

$common_logic = new common_logic();
//googleオース認証

$name = '';
$mail = '';

if(strpos($_SERVER['HTTP_REFERER'],'accounts.google.com') !== false){
    $result = $common_logic->google_oauth_logic($_GET['code']);

    $name = $result['given_name'] . ' ' . $result['family_name'];
    $mail = $result['email'];
}


if ($_GET['oauth_t'] == "fb") {

    //設定ファイル
    require_once("../fb_config.php");

    if (isset($_SESSION['facebook_access_token'])) {
        $accessToken = $_SESSION['facebook_access_token'];
        $fb->setDefaultAccessToken($accessToken);

        try {
            //取得するユーザ情報の指定
            $response = $fb->get('/me?fields=id,name,first_name,last_name,email,gender');
            $profile = $response->getGraphUser();

            //ユーザ画像取得
            $UserPicture = $fb->get('/me/picture?redirect=false&height=200');
            $picture = $UserPicture->getGraphUser();

        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $id=$profile['id'];
        $name=$profile['name'];
        $first_name=(isset($profile['first_name'])) ? $profile['first_name'] : '';
        $last_name=(isset($profile['last_name'])) ? $profile['last_name'] : '';
        $email=$profile['email'];
        $gender=(isset($profile['gender'])) ? $profile['gender'] : '';
        $picture_url = $picture['url'];


//         echo "アクセストークン：".$accessToken."";
//         echo "ID：".$id."";
//         echo "名前：".$name."";
//         echo "性別：".$gender."";
//         echo "ファーストネーム：".$first_name."";
//         echo "ラストネーム：".$last_name."";
//         echo "メール：".$email."";//ユーザが未公開・未設定の場合は表示されない
//         echo "<img src=".$picture_url.">";
//         echo "<a href='logout.php'>ログアウト</a>";

        $name = $name;
        $mail = $email;
    }

}

?>
<!DOCTYPE html>
<html lang="ja">
<head>

<?php require_once '../required/html_head.php'?>
<script type="text/javascript" src="../assets/js/validate.js"></script>
<script type="text/javascript" src="../assets/js/plural_file_upload.js"></script>
<script type="text/javascript" src="../assets/js/mail_depricate.js"></script>
<script type="text/javascript" src="../assets/js/form.js"></script>
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
							            <img class="sp-image" src="../assets/front/img/tit_new_member.jpg"/>
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
							            <img class="sp-image" src="../assets/front/img/tit_new_member.jpg"/>
							        </div>
							    </div>
							  </div>
						</section>
					</div>

				</div>
			</div>


			<div class="container1080 cf conf_top">
				<div class="container760">
					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea"><img src="../img/ttl_icon.png" alt="Fuji"> New member registration</h2>
							</div>
						</div>
					</section>

					<section>
						<h3 class="titleUnderline">Information</h3>
						<p class="planDetailCautionTxt noteTextArea">Membership registration (free) is required to use the service.<br>
						If you are not yet a member, please click here for membership registration procedures.</p>


					</section>


					<section class="borderBox">
							<div class="storeEditIn" id="inputFormArea">
								<h4 class="titleBN">Basic information registration</h4>
								<div class="storeEditItem">

								<div class="storeEditRow">
										<div class="storeEditCate">Nationality</div>
										<div class="storeEditForm required_form pos2">
												<select name="nationality" id="nationality" class="formTxt1 validate required">
													<option value="">Please select</option>
													<option value="Japan">Japan</option>
													<option value="British">British</option>
													<option value="Canada">Canada</option>
													<option value="America">America</option>
													<option value="Australia">Australia</option>
													<option value="New Zealand">New Zealand</option>
													<option value="Singapore">Singapore</option>
													<option value="Malaysia">Malaysia</option>
													<option value="China">China</option>
													<option value="Korea">Korea</option>
													<option value="Swiss">Swiss</option>
													<option value="Thailand">Thailand</option>
													<option value="Indonesia">Indonesia</option>
													<option value="Philippines">Philippines</option>
													<option value="Vietnam">Vietnam</option>
													<option value="Other">Other</option>
												</select>
										</div>

										<div class="storeEditForm nationality_othre_form">
											<input type="text" name="nationality_othre" id="nationality_othre" class="formTxt1 validate" value="" placeholder="Country name">
										</div>

									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">Your name</div>
										<div class="storeEditForm required_form">
											<input type="text" name="name" id="name" class="formTxt1 validate required " value="<?php print $name?>">
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">Mail address</div>
										<div class="storeEditForm required_form">
											<input type="text" name="mail" id="mail" class="formTxt1 validate required mail depricate_check" value="<?php print $mail?>">
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">Mail address<br class="hidden-xs">（confi.)</div>
										<div class="storeEditForm required_form">
											<input type="text" name="mail_conf" id="mail_conf" class="formTxt1 validate required mail_conf" value="<?php print $mail?>">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">Password</div>
										<div class="storeEditForm">
											<p>※8 to 20 characters mixing half-width alphabets and half-width numbers.</p>

											<input type="password" name="password" id="password" class="formTxt1 validate required password" value="">

										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">Password（confi.)</div>
										<div class="storeEditForm">
											<input type="password" name="password_conf" id="password_conf" class="formTxt1 validate required password_conf" value="">
										</div>
									</div>


									<div class="storeEditRow">
										<div class="storeEditCate">Address</div>
										<div class="storeEditForm required_form">
											<textarea name="addr" id="addr" class="formTxt1 validate required" value=""></textarea>
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">Phone number</div>
										<div class="storeEditForm required_form">
											<input type="text" name="tel" id="tel" class="formTxt1 validate required" value="" placeholder="+818011112222">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">Sex</div>
										<div class="storeEditForm required_form">
											<label><span class="formRBox"><input type="radio" name="sex" value="0" class="validate" style="width: 15px; height: auto; display: inline;" checked="checked">Male</span></label>
											<label><span class="formRBox"><input type="radio" name="sex" value="1" class="validate" style="width: 15px; height: auto; display: inline;">Female</span></label>
										</div>
									</div>
									<div class="storeEditRow">
										<div class="storeEditCate">Birthday</div>
										<div class="storeEditForm">
											<span class="formRBox">DAY :
												<select class="formTxt1 numberSelect" name="birthday_d">
													<?php print $opt['opt_d']?>
												</select>
											</span>
											<span class="formRBox">MONTH :
												<select class="formTxt1 numberSelect" name="birthday_m">
													<?php print $opt['opt_m']?>
												</select>
											</span>
											<span class="formRBox">YEAR :
												<select class="formTxt1 numberSelect" name="birthday_y">
													<?php print $opt['opt_y']?>
												</select>
											</span>

										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">Icon Image</div>
										<div class="storeEditForm">
											<div id="fileArea1" class="form_btn img_btn">
												<form id="upload_form1" enctype="multipart/form-data" method="post">
													<input type="file" name="file1" id="file1" jq_id="1" cnt="0" class="form_file" col_name="icon">
													<h4 id="status1"></h4>
												</form>
											</div>
												<div id="img_area1"></div>
										</div>
									</div>

									<input type="hidden" name="method" value="member_regist">

									<div class="btnArea">
										<button type="button" class=" btn btnBg1 conf_hide" name="conf">Confirm</button>
										<button type="button" class=" btn btnBgBack conf_show" name="back">Back</button>
										<button type="button" class=" btn btnBg1 conf_show" name="submitBtn">Submit</button>
									</div>
								</div>
							</div>
							<form action="../logic/front/regist_edit_logic.php" name="inputFormArea" method="post"></form>
					</section>
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
	<script type="text/javascript">

	na();
	$('[name=nationality]').on("change", function(){na();});

		function na(){
			if( $('[name=nationality]').val() == 'Other'){
				$('.nationality_othre_form').css("visibility", "visible");
			}else{
				$('.nationality_othre_form').css("visibility", "hidden");
			}
		}
	</script>
<!--#_=_を排除する-->
<script type="text/javascript">
if (window.location.hash && window.location.hash == '#_=_') {
  if (window.history && history.pushState) {
      window.history.pushState("", document.title, window.location.pathname);
  } else {
    // Prevent scrolling by storing the page's current scroll offset
    var scroll = {
        top: document.body.scrollTop,
      left: document.body.scrollLeft
    };
    window.location.hash = '';
    // Restore the scroll offset, should be flicker free
    document.body.scrollTop = scroll.top;
    document.body.scrollLeft = scroll.left;
  }
}
</script>

	<input type="hidden" name="eng_flg" value="on">
	<input type="hidden" id="common_ct_url" value="../controller/admin/common_ct.php">
	<input type="hidden" id="img_path1" value="member/">
	<input type="hidden" id="img_length1" class="hid_img_length" value="1">
	<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
</body>
</html>
