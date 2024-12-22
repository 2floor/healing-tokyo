<?php
session_start();
require_once __DIR__ .  '/./required/view_common_include.php';




?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.19/css/intlTelInput.css"/>
<script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<?php require_once __DIR__ .  '/./required/html_head.php';?>
</head>
<body class="fixed-left">
	<!-- Begin page -->
	<div id="wrapper">
		<?php require_once __DIR__ .  '/./required/menu.php';?>
		<!-- ============================================================== -->
		<!-- Start right Content here -->
		<!-- ============================================================== -->
		<div class="content-page">
			<!-- Start content -->
			<div class="content">
				<!-- pageTitle -->
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<h2 class="pageTitle" id="page_title">
								<i class="fa fa-list" aria-hidden="true"></i>
								契約一覧
							</h2>
						</div>
					</div>
				</div>
				<!-- /pageTitle -->

				<!-- Start Data List Area -->
				<div class="disp_area list_show list_disp_area">
					<!-- searchBox -->
					<div class="container table-rep-plugin">
						<div class="searchBox">
							<div class="searchBoxLeft searchArea">
								<div class="searchBox1">
									<div class="searchTxt">
										絞り込み検索
									</div>
									<select class="form-control searchAreaSelect">
									</select>
								</div>
								<div class="searchBox2">
									<div class="input-group">
										<input type="text" id="search_input" name="search_input" class="form-control" placeholder="フリーワードを入力">
										<span class="input-group-btn">
											<button type="button" class="btn waves-effect waves-light btn-primary callSearch">検索</button>
										</span>
									</div>
								</div>
							</div>
							<div class="searchBoxRight">
								<div class="serachW110">
									<button type="button" name="new_entry" class="btn btn-primary waves-effect w-md waves-light m-b-5">新規登録</button>
								</div>
							</div>
						</div>
					</div>
					<!-- searchBox -->

					<!-- pager -->
					<div class="container">
						<div class="listPagerBox">
							<div class="listPagerTxt now_disp_cnt_str">
							</div>
							<div class="listPager">
								<ul class="pagination pager_area">
								</ul>
							</div>
						</div>
					</div>
					<!-- /pager -->

					<!-- list1Col -->
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<div class="card-box">
									<div class="table-wrapper">
										<div class="btn-toolbar">
											<div class="btn-group dropdown-btn-group pull-right">
												<button class="btn btn-default btn-primary" name="colDispChangeAll">すべて表示</button>
												<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
													表示項目
													<span class="caret"></span>
												</button>
												<ul class="dropdown-menu tableColDisp"></ul>
											</div>
										</div>
										<div class="table-responsive">
											<table class="table parts">
												<thead class="tableHeadArea">
													<tr>
														<th>No</th>
														<th>ID</th>
														<th>掲載者名</th>
														<th>情報</th>
														<th>ステータス</th>
														<th>作成日時</th>
														<th>更新日時</th>
														<th>操作</th>
														<th>公開</th>
													</tr>
												</thead>
												<tbody id="list_html_area" class="tableBodyArea">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /list1Col -->

					<!-- pager -->
					<div class="container">
						<div class="listPagerBox">
							<div class="listPagerTxt now_disp_cnt_str">
							</div>
							<div class="listPager">
								<ul class="pagination pager_area">
								</ul>
							</div>
						</div>
					</div>
					<!-- /pager -->
				</div>
				<!-- END Data List Area -->

				<!-- Start Data Edit Area -->
				<div class="disp_area entry_input">
					<!-- btnBox -->
					<div class="container">
						<div class="registBtnBox">
							<div class="registBtnLeft">
								<span class="require_text">必要事項を入力後、[登録]ボタンをクリックしてください。</span>
								<h3 class="conf_text">下記の内容が登録されます。よろしければ登録ボタンを押してください。</h3>
							</div>
							<div class="registBtnRight">
<!-- 								<button type="button" class="btn btn-primary waves-effect w-md waves-light m-b-5">登録する</button> -->
							</div>
						</div>
					</div>
					<!-- /btnBox -->

					<!-- userSetting -->
					<div class="container">
						<div class="row">
							<div class="col-xs-12" id="frm">
								<div class="contentBox">
									<div class="formRow">
										<div class="formItem">
											個人・法人
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="radio radio-primary radioBox">
													<input type="radio" name="store_type" id="radio1" value="0" checked="checked">
													<label for="radio1"> 法人 </label>
												</div>
												<div class="radio radio-primary radioBox">
													<input type="radio" name="store_type" id="radio2" value="1">
													<label for="radio2"> 個人経営 </label>
												</div>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様名
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate required" name="company_name" id="company_name" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様名（英語）
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate" name="company_name_eng" id="company_name_eng" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											担当者名
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate required" name="contact_name" id="contact_name" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											担当者名（カナ）
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate required" name="contact_name_kana" id="contact_name_kana" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											担当者名（英語）
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate " name="contact_name_eng" id="contact_name_eng" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											メールアドレス
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="email" class="form-control validate required mail depricate_check" name="mail" id="mail" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											パスワード<br><span style="font-size: 10px; opacity: 0.7">　編集時は変更したいときのみ入力</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="email" class="form-control validate password" name="password" id="password" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											電話番号
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
                                                <input name="tel" type="tel" id="phone" class="formTxt1 validate required" value="" placeholder=""/>
                                                <input type="hidden" name="country_phone" id="country_phone">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											FAX番号
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="tel" class="form-control validate "  name="fax" id="fax"value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											緊急連絡先(携帯電話番号)
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="tel" class="form-control validate required"  name="emergency_tel" id="emergency_tel"value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											緊急連絡先担当者
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate"  name="emergency_contact_name" id="emergency_contact_name"value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様所在地(英語)
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate required" name="location" id="location" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											URL
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate " name="url" id="url" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											画像（3件）
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="fileupload btn btn-primary btn-bordred waves-effect w-md waves-light">
													<span>
														ファイルを選択
													</span>
													<input type="file" class="upload" name="file1" id="file1" jq_id="1" multiple="multiple">
												</div>
												<button type="button" class="btn btn-info btn-bordred waves-effect w-md waves-light fileSort" jq_id="1" style="display: none;">並び替え</button>
												<!-- Modal -->
												<div id="custom-modal" class="modal-demo">
													<button type="button" class="close" onclick="Custombox.close();">
														<span>&times;</span>
														<span class="sr-only">Close</span>
													</button>
													<h4 class="custom-modal-title">画像並び替え</h4>
													<div class="custom-modal-text">
														<p>ドラッグ&ドロップで並び替えができます。</p>
														<div id="imgSortArea1"></div>
														<button type="button" class="btn btn-info btn-bordred waves-effect w-md waves-light fileSortExe" jq_id="1">並び替えを実行</button>
													</div>
												</div>
												<h4 id="status1"></h4>
												<div id="img_area1" class="prevImgArea"></div>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											Youtubeタグ
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate" name="youtube_tag" id="youtube_tag"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様所在地(日本語)
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate" name="addr" id="addr"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											営業時間・店休日(英語)
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate" name="trading_hours" id="trading_hours"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様トップタイトル(英語)
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate " name="cd_title" id="cd_title"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											トップタイトル詳細補足(英語)
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate " name="cd_deatil" id="cd_deatil"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様紹介タイトル(英語)
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate " name="cdf_title" id="cdf_title"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様紹介画像1
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="fileupload btn btn-primary btn-bordred waves-effect w-md waves-light">
													<span>
														ファイルを選択
													</span>
													<input type="file" class="upload" name="file2" id="file2" jq_id="2" multiple="multiple">
												</div>
												<h4 id="status2"></h4>
												<div id="img_area2" class="prevImgArea"></div>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様紹介文言1(英語)
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate " name="cdf_detail1" id="cdf_detail1"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様紹介画像2
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="fileupload btn btn-primary btn-bordred waves-effect w-md waves-light">
													<span>
														ファイルを選択
													</span>
													<input type="file" class="upload" name="file3" id="file3" jq_id="3" multiple="multiple">
												</div>
												<h4 id="status3"></h4>
												<div id="img_area3" class="prevImgArea"></div>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様紹介文言2(英語)
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate " name="cdf_detail2" id="cdf_detail2"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様紹介画像3
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="fileupload btn btn-primary btn-bordred waves-effect w-md waves-light">
													<span>
														ファイルを選択
													</span>
													<input type="file" class="upload" name="file4" id="file4" jq_id="4" multiple="multiple">
												</div>
												<h4 id="status4"></h4>
												<div id="img_area4" class="prevImgArea"></div>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											事業者様紹介文言3(英語)
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate " name="cdf_detail3" id="cdf_detail3"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											Healing Tokyoからの振込先<br>
											銀行名
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate " name=bank_name id=bank_name value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											銀行支店名
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate " name="bank_branch" id="bank_branch" value="">
											</div>
										</div>
									</div>
									<div class="formRow" style="display: none;">
										<div class="formItem">
											銀行支店コード
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate " name="bank_branch_number" id="bank_branch_number" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											口座種別
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="radio radio-primary radioBox">
													<input type="radio" name="bank_type" id="bank_type1" value="1" checked="checked">
													<label for="bank_type1"> 普通 </label>
												</div>
												<div class="radio radio-primary radioBox">
													<input type="radio" name="bank_type" id="bank_type2" value="2">
													<label for="bank_type2"> 当座 </label>
												</div>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											口座番号
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate " name="bank_number" id="bank_number" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											口座名義
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate " name="bank_meigi" id="bank_meigi" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											閲覧数
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="tel" class="form-control validate required"  name="browse_num" id="browse_num"value="" placeholder="初回登録時「0」（半角）を入力">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											予約総数
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="tel" class="form-control validate required"  name="reserve_num" id="reserve_num"value="" placeholder="初回登録時「0」（半角）を入力">
											</div>
										</div>
									</div>
									<input type="hidden" name="review_point" value="">
									<input type="hidden" name="review_num" value="">
									<input type="hidden" name="review_ave" value="">

									<div class="formRow">
										<div class="formItem">
											メモ
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate" name="etc_comment" id="etc_comment" placeholder="管理者用のメモです。ページには表示されません"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											認証状態
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<select class="form-control"  name="auth_flg" id="auth_flg">
													<option value="0">未認証</option>
													<option value="1">認証済み</option>
													<option value="2">認証不可</option>
												</select>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											会員状態
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<select class="form-control"  name="del_flg" id="del_flg">
													<option value="0">有効</option>
													<option value="1">退会済み</option>
												</select>
											</div>
										</div>
									</div>
									<input type="text" class="form-control " name="google_au" id="google_au" value="" style="display: none; ">
									<input type="text" class="form-control " name="facebook_au" id="facebook_au" value="" style="display: none; ">

									<button type="button" class="btn btn-primary waves-effect w-md waves-light m-b-5 button_input button_form" name='conf' id="conf">確認する</button>
									<button type="button" class="btn btn-inverse waves-effect w-md waves-light m-b-5 button_conf button_form" name='return' id="return">戻る</button>
									<button type="button" class="btn btn-info waves-effect w-md waves-light m-b-5 button_conf button_form" name='submit' id="submit">登録する</button>
								</div>
							</div>
						</div>
					</div>
					<!-- /userSetting -->
				</div>
				<!-- END Data Edit Area -->
				<!-- container -->
			</div>
			<!-- content -->
		</div>

	</div>
	<!-- END wrapper -->
<?php require_once __DIR__ .  '/./required/foot.php';?>
<!-- Start Personal script -->
<script src="../assets/admin/js/store_basic.js"></script>
<script src="../assets/admin/js/mail_depricate.js"></script>
    <script>
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




<!-- End Personal script -->
<!-- Start Personal Input -->
<input type="hidden" id="ct_url" value="../controller/admin/store_basic_ct.php">
<input type="hidden" id="id" value="">
<input type="hidden" id="page_type" value="">
<input type="password" id="before_password" value="" style="display: none;">
<input type="hidden" id="common_ct_url" value="../controller/admin/common_ct.php">
<!--  //ファイル即時アップロード用CT -->
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
<!-- 現在のページ位置 -->
<input type="hidden" id="now_page_num" value="1">
<!-- 1ページに表示する件数 -->
<input type="hidden" id="page_num" value="1">
<!-- 1ページに表示する件数 -->
<input type="hidden" id="page_disp_cnt" value="10">

<!-- End Personal Input -->

</body>
</html>