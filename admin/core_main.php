<?php
session_start();
require_once __DIR__ .  '/./required/view_common_include.php';
require_once __DIR__ .  '/../logic/common/common_logic.php';
$common_logic = new common_logic();
$cate = $common_logic->select_logic("select * from m_code where code = 'category' and `del_flg` = 0", array());
$c_opt = "";
foreach ((array)$cate as $c) {
	$c_opt .= '<option value="'.$c['code_id'].'">'.$c['description1'].'</option>';
}


$cate = '<div class="formRow">
				<div class="formItem">
					カテゴリー
					<span class="label01">必須</span>
				</div>
				<div class="formTxt">
					<div class="formIn50">
						<select class="form-control"  name="category" id="category">
							'.$c_opt.'
						</select>
					</div>
				</div>
			</div>';

if ($_GET['page_disp_cnt'] == null || $_GET['page_disp_cnt'] == "") {
	$_GET['page_disp_cnt'] = 10;
}

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
										<input type="text" id="search_input" name="search_input" class="form-control" placeholder="フリーワードを入力" autocomplete="off">
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
							<select name="disp_val" id="disp_val" class="form-control" style="width: auto; margin-left: 20px;">
								<option value="10">10</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
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
														<th>タイトル</th>
														<th>画像</th>
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
									<?php // print $cate /* カテゴリ選択HTML */?>
									<div class="formRow">
										<div class="formItem">
											タイトル
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate required" name="article_title_jap" id="article_title_jap" value="" autocomplete="off">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											詳細
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea class="form-control validate required" name="article_text" id="article_text" style="    min-height: 270px;"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											画像

										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="fileupload btn btn-primary btn-bordred waves-effect w-md waves-light">
													<span>
														ファイルを選択
													</span>
													<input type="file" class="upload" name="file1" id="file1" jq_id="1" multiple="multiple">
												</div>
												<!-- <button type="button" class="btn btn-info btn-bordred waves-effect w-md waves-light fileSort" jq_id="1" style="display: none;">並び替え</button>-->
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
											公開状態
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<select class="form-control"  name="public_flg" id="public_flg">
													<option value="0">公開</option>
													<option value="1">非公開（下書き）</option>
												</select>
											</div>
										</div>
									</div>
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
<script src="../assets/admin/js/core_main.js"></script>




<!-- End Personal script -->
<!-- Start Personal Input -->
<input type="hidden" id="ct_url" value="../controller/admin/core_main_ct.php">
<input type="hidden" id="id" value="">
<input type="hidden" id="page_type" value="">
<input type="password" id="before_password" value="" style="display: none;">
<input type="hidden" id="common_ct_url" value="../controller/admin/common_ct.php">
<!--  //ファイル即時アップロード用CT -->
<input type="hidden" id="img_path1" value="core_main/">
<input type="hidden" id="img_length1" class="hid_img_length" value="1">
<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
<!-- 現在のページ位置 -->
<input type="hidden" id="now_page_num" value="1">
<!-- 1ページに表示する件数 -->
<input type="hidden" id="page_num" value="1">
<!-- 1ページに表示する件数 -->
<input type="hidden" id="page_disp_cnt" value="<?php print $_GET['page_disp_cnt'] ?>">

<!-- End Personal Input -->

<script>
$(function(){

	$("#disp_val").val("<?php print $_GET['page_disp_cnt'] ?>");

	$("[name=disp_val]").change(function(){
		location.href = "core_main.php?page_disp_cnt=" + $(this).val();
	});
})
</script>

</body>
</html>