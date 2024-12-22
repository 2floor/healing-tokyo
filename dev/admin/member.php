<?php
session_start();
require_once __DIR__ .  '/./required/view_common_include.php';




?>
<!DOCTYPE html>
<html>
<head>
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
														<th>会員名</th>
														<th>情報</th>
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
											氏名
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate required" name="name" id="name" value="">
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
												<input type="email" class="form-control validate required mail depricate_check" name="mail" id="mail" own="" value="">
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
												<input type="tel" class="form-control validate required"  name="tel" id="tel"value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											性別
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="radio radio-primary radioBox">
													<input type="radio" name="sex" id="radio1" value="0" checked="checked">
													<label for="radio1"> 男性 </label>
												</div>
												<div class="radio radio-primary radioBox">
													<input type="radio" name="sex" id="radio2" value="1">
													<label for="radio2"> 女性 </label>
												</div>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											生年月日
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="input-group">
													<input type="text" class="form-control" placeholder="yyyy-mm-dd" name="birthday" id="birthday">
													<span class="input-group-addon bg-primary b-0 text-white">
														<i class="ti-calendar"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											国籍
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate required" name="nationality" id="nationality" value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											住所
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate " name="addr" id="addr" value="">
											</div>
										</div>
									</div>

									<div class="formRow">
										<div class="formItem">
											アイコン
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
<script src="../assets/admin/js/member.js"></script>
<script src="../assets/admin/js/mail_depricate.js"></script>




<!-- End Personal script -->
<!-- Start Personal Input -->
<input type="hidden" id="ct_url" value="../controller/admin/member_ct.php">
<input type="hidden" id="id" value="">
<input type="hidden" id="page_type" value="">
<input type="password" id="before_password" value="" style="display: none;">
<input type="hidden" id="common_ct_url" value="../controller/admin/common_ct.php">
<!--  //ファイル即時アップロード用CT -->
<input type="hidden" id="img_path1" value="member/">
<input type="hidden" id="img_length1" class="hid_img_length" value="9999999999">
<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
<!-- 現在のページ位置 -->
<input type="hidden" id="now_page_num" value="1">
<!-- 1ページに表示する件数 -->
<input type="hidden" id="page_num" value="1">
<!-- 1ページに表示する件数 -->
<input type="hidden" id="page_disp_cnt" value="10">

<!-- End Personal Input -->

</body>
</html>