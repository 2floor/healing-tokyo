<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
$jis_common_logic = new jis_common_logic();
$opt = $jis_common_logic->get_date_opt();
$jis_common_logic->login_check();

$scrpt = $jis_common_logic->create_input_script($_SESSION['jis']['login_member'], array(
		'radio' => "sex",
		'file' => "icon",
		'fileOpt' => array(
				"icon" => array(
						"dir" => "../upload_files/member/",
						"jq_id" => "1",
				)
		)
));

list($burth_y,$burth_m,$burth_d) = explode("-", $_SESSION['jis']['login_member']['birthday']);

$scrpt .= "$('[name=nationality]').val('".$_SESSION['jis']['login_member']['nationality']."');";
$scrpt .= "$('[name=birthday_y]').val('".$burth_y."');";
$scrpt .= "$('[name=birthday_m]').val('".$burth_m."');";
$scrpt .= "$('[name=birthday_d]').val('".$burth_d."');";

?>
<!DOCTYPE html>
<html lang="ja">
<head>

<?php require_once '../required/html_head.php'?>
<script type="text/javascript" src="../assets/js/validate.js"></script>
<script type="text/javascript" src="../assets/js/plural_file_upload.js"></script>
<script type="text/javascript" src="../assets/js/mail_depricate.js"></script>
<script type="text/javascript" src="../assets/js/form.js"></script>
<link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.19/css/intlTelInput.css"/>
<script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
</head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
	<?php require_once "../required/header_out_lower.php"?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->


	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">

			<div class="container1080 cf conf_top">
				<div class="container760">
					<?php require_once "./member_top.php"?>
					<section>
						<h3 class="titleUnderline">Information</h3>


					</section>


					<section class="borderBox">
							<div class="storeEditIn" id="inputFormArea">
								<h4 class="titleBN">Basic information editting</h4>
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
										<div class="storeEditCate">First Name</div>
										<div class="storeEditForm required_form">
											<input type="text" name="name" id="name" class="formTxt1 validate required " value="">
										</div>
									</div>
                                    <div class="storeEditRow">
                                        <div class="storeEditCate">Family Name</div>
                                        <div class="storeEditForm required_form">
                                            <input type="text" name="last_name" id="last_name" class="formTxt1 validate required " value="">
                                        </div>
                                    </div>
									<div class="storeEditRow">
										<div class="storeEditCate">Mail address</div>
										<div class="storeEditForm required_form">
											<input type="text" name="mail" id="mail" class="formTxt1 validate required mail depricate_check" value="" own="<?php print $_SESSION['jis']['login_member']['member_id']?>">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">Password</div>
										<div class="storeEditForm">
											<p>※Please fill out this form to change your password.</p>
											<input type="password" name="password" id="password" class="formTxt1 validate password half_width" value="">

										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">Password（confi.)</div>
										<div class="storeEditForm">
											<input type="password" name="password_conf" id="password_conf" class="formTxt1 validate password_conf half_width" value="">
										</div>
									</div>


									<div class="storeEditRow">
										<div class="storeEditCate">Address</div>
										<div class="storeEditForm required_form">
											<input type="text" name="addr" id="addr" class="formTxt1 validate required" value="">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">Tel</div>
                                        <div class="storeEditForm required_form">
                                            <input name="tel" type="text" id="phone" class="formTxt1 validate required" value="" placeholder="+818011112222"/>
                                            <input type="hidden" name="country_phone" id="country_phone">
                                        </div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">Gender</div>
										<div class="storeEditForm required_form">
											<label><span class="formRBox"><input type="radio" name="sex" value="0" class="validate" style="width: 15px; height: auto; display: inline;">Male</span></label>
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

									<input type="hidden" name="method" value="member_edit">

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
		<?php print $scrpt?>

    // new intl-tel-input
    const input = document.querySelector("#phone");
    const countryPhoneInput = document.querySelector("#country_phone");

    const iti = window.intlTelInput(input, {
        separateDialCode: true,
        initialCountry: "auto",
        geoIpLookup: function (callback) {
            fetch('https://ipinfo.io/json?token=<YOUR_TOKEN>')
                .then(resp => resp.json())
                .then(data => callback(data.country))
                .catch(() => callback('US'));
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    });

    input.addEventListener("countrychange", function () {
        const countryCode = iti.getSelectedCountryData().dialCode;
        countryPhoneInput.value = countryCode;
        localStorage.setItem("selectedCountry", iti.getSelectedCountryData().iso2);
    });

    document.addEventListener("DOMContentLoaded", function () {
        const savedCountry = localStorage.getItem("selectedCountry");
        if (savedCountry) {
            iti.setCountry(savedCountry);
        }
    });

    const countryData = window.intlTelInputGlobals.getCountryData();
    const dialCodeToFind = $('input[name="country_phone"]').val();
    let countryISO2 = null;

    for (const country of countryData) {
        if (country.dialCode === dialCodeToFind) {
            countryISO2 = country.iso2;
            break;
        }
    }

    if (countryISO2) {
        iti.setCountry(countryISO2);
    }

    </script>


	<input type="hidden" name="eng_flg" value="on">
	<input type="hidden" id="common_ct_url" value="../controller/admin/common_ct.php">
	<input type="hidden" id="img_path1" value="member/">
	<input type="hidden" id="img_length1" class="hid_img_length" value="1">
	<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
</body>
</html>
