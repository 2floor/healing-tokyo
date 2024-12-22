<?php
session_start();
require_once __DIR__ .  '/./required/view_common_include.php';
require_once __DIR__ .  '/../logic/common/common_logic.php';
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
$jis_common_logic = new jis_common_logic();
$common_logic = new common_logic();

$category = $jis_common_logic->get_category_html('
<div class="checkbox checkbox-primary radioBox">
	<input id="checkbox/###id###/" type="checkbox" class="validate checkboxRequired" name="category" value="/###id###/">
	<label for="checkbox/###id###/"> /###jp###/ </label>
</div>
');

$area = $jis_common_logic->area_array();
foreach ($area as $id => $a) {
	$area_ch .= '<div class="checkbox checkbox-primary radioBox">
					<input id="checkbox-ar'.$id.'" type="checkbox" class="validate checkboxRequired" name="area" value="'.$id.'">
					<label for="checkbox-ar'.$id.'"> '.$a['jp'].' </label>
				</div>';
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
														<th>アクティビティ名<br>掲載社詳細</th>
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
											タイトル
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate required" name="title" id="title"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											説明タイトル
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate required" name="d_title" id="d_title"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											説明文
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate required" name="d_detail" id="d_detail"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											女性限定
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<select class="form-control"  name="femeal_only" id="femeal_only">
													<option value="0">限定無し</option>
													<option value="1">女性限定</option>
												</select>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											カテゴリー
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<?php print $category?>
											</div>
										</div>
									</div>

									<div class="formRow">
										<div class="formItem">
											エリア
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<?php print $area_ch?>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											大人料金
											<span class="label01 require_text">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="tel" class="form-control validate required"  name="adult_fee" id="adult_fee"value="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											子供料金
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="tel" class="form-control validate"  name="children_fee" id="children_fee"value="0">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											割引率
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="tel" class="form-control validate"  name="discount_rate_setting" id="discount_rate_setting"value="0" placeholder="%">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											子供料金適用年齢
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate "  name="children_age_limit" id="children_age_limit"value="0">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											行程
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate required" name="tranvel" id="tranvel"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											youtubeタグ
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate" name="youtube" id="youtube" placeholder="YouTubeにて 「共有」「埋め込む」をクリックし表示されたコードをコピーペースト "></textarea>
                                                <span class="text-warning">（ここには、YouTubeリンクを最大3つまで入力できます。）</span>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											画像登録(3件)
											<span class="label01">必須</span>
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
											アクセス
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">



<div class="formMapTxt mincho">集合場所にピンを併せてください。</div>
										<input id="pac-input" class="controls" type="text" placeholder="キーワード検索" style="margin-top: 18px;; height: 25px;">
										<div id="map" style="width: 100%; height: 500px"></div>
										<!--     <div id="map"></div> -->

										<div class="mapNumBox">
											<div class="mapNum">
												<div class="mapNumItem">緯度：</div>
												<div class="mapNumTxt">
													<input type="text" name="lat" id="lat" value="" class="formBase formW100" readonly="readonly">
												</div>
											</div>
											<div class="mapNum">
												<div class="mapNumItem">経度：</div>
												<div class="mapNumTxt">
													<input type="text" name="lng" id="lng" value="" class="formBase formW100" readonly="readonly">
												</div>
											</div>

											<input type="hidden" name="schedule" id="schedule" value="" class="formBase formW100" readonly="readonly">


										</div>

											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											集合場所
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate required" name="meeting_place" id="meeting_place"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											キャンセルチャージ
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate " name="note" id="note"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											承諾有無
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="checkbox checkbox-primary radioBox">
													<input id="note_agreement_flg1" type="checkbox" class="validate" name="note_agreement_flg" value="1">
													<label for="note_agreement_flg1"> 承諾必須 </label>
												</div>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											アクティビティ料金に含まれるもの
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate required" name="inclusion" id="inclusion"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											必要な持ち物
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate required" name="what_to_bring" id="what_to_bring"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											全行程実施時間
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate required" name="duration" id="duration"></textarea>
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											お客様からの お支払い方法
											<span class="label01">必須</span>
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<div class="checkbox checkbox-primary radioBox">
													<input id="payment_way1" type="checkbox" class="validate checkboxRequired" name="payment_way" value="0">
													<label for="payment_way1"> 当日現金払い　Cash on the day </label>
												</div>
												<div class="checkbox checkbox-primary radioBox">
													<input id="payment_way3" type="checkbox" class="validate checkboxRequired" name="payment_way" value="2">
													<label for="payment_way3"> 当日カード払い　Credit card on the day </label>
												</div>
												<div class="checkbox checkbox-primary radioBox">
													<input id="payment_way2" type="checkbox" class="validate checkboxRequired" name="payment_way" value="1">
													<label for="payment_way2"> Healing Tokyoが事前カード決済　Healing Tokyo collects advance payments by credit card </label>
												</div>
											</div>
										</div>
									</div>

									<div class="formRow">
										<div class="formItem">
											当日カード払い時、利用可能カード名
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<input type="text" class="form-control validate"  name="card_choice" id="card_choice"value="0" placeholder="">
											</div>
										</div>
									</div>
									<div class="formRow">
										<div class="formItem">
											備考
										</div>
										<div class="formTxt">
											<div class="formIn50">
												<textarea type="text" class="form-control validate " name="remarks" id="remarks"></textarea>
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
<script src="../assets/admin/js/tour.js"></script>




<!-- End Personal script -->
<!-- Start Personal Input -->
<input type="hidden" id="ct_url" value="../controller/admin/tour_ct.php">
<input type="hidden" id="id" value="">
<input type="hidden" id="page_type" value="">
<input type="password" id="before_password" value="" style="display: none;">
<input type="hidden" id="common_ct_url" value="../controller/admin/common_ct.php">
<!--  //ファイル即時アップロード用CT -->
<input type="hidden" id="img_path1" value="tour/">
<input type="hidden" id="img_length1" class="hid_img_length" value="3">
<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
<!-- 現在のページ位置 -->
<input type="hidden" id="now_page_num" value="1">
<!-- 1ページに表示する件数 -->
<input type="hidden" id="page_num" value="1">
<!-- 1ページに表示する件数 -->
<input type="hidden" id="page_disp_cnt" value="10">

<!-- End Personal Input -->
										<script>



    </script>
<!-- 	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC50D68hnfmHwA2uN9fOTlRNbtA5IyxOzc&libraries=places&callback=initAutocomplete" async defer></script> -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7ACG9QL6-NLrLTpRQYJ8EbxZodt8fAug&libraries=places" async defer></script>


</body>
</html>