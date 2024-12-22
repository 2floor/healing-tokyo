<?php
session_start();
require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/common/common_constant.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/jis_common_logic.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/logic/common/common_logic.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_characteristic_model.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/jis/model/t_plan_type_model.php';

$dir_name = dirname ( $_SERVER ["SCRIPT_NAME"] );
$path = "./";
// 下記array内に下層フォルダのディレクトリを記述
$dir_array = array (
		"policy",
		"lunch",
		"dinner",
		"bar",
		"club",
		"company",
		"mypage",
		"contact",
		"mypage_store",
		"search"
)
;
$dir_name_array = explode('/', $dir_name);
$outside = 1;
for ($j = 0; $j < count( $dir_name_array ); $j++) {
	for($i = 0; $i < count ( $dir_array ); $i ++) {
		if($dir_name_array[$j] == "search"){
			$outside = 0;
		}
		if ($dir_name_array[$j] == $dir_array [$i]) {
			$path = "../";
			break;
		}
	}
}

// 来店日月セレクトボックスHTML生成
$yoyaku_month_html = "";
$jis_common_logic = new jis_common_logic();
$common_logic = new common_logic();
for($i = 0; $i < 3; $i ++) {
	$result = $common_logic->select_logic_no_param('select date_add(now(), interval '.$i.' month) as add_month') ;
	$add_month_array = explode('-', $result[0]['add_month']);
	$yoyaku_month_html .= '<option value="' . $add_month_array[0].$add_month_array[1] . '">' . $add_month_array[0].'年'.$add_month_array[1].'月' . '</option>';
}

// レストランの特徴取得
$t_characteristic_model = new t_characteristic_model ();
$result = $t_characteristic_model->get_characteristic ();
$characteristic_html = '';
for($i = 0; $i < count ( $result ); $i ++) {
	$row = $result [$i];

	$set_chk = '';
	if ($_GET['c_n'] != null && $_GET['c_n'] != '' && $_GET['c_n'] == $row ['characteristic_id']) {
		$set_chk = 'checked';
	}
	$characteristic_html .= '
									<label>
										<input type="checkbox" name="char_name" value="' . $row ['characteristic_id'] . '" class="" '.$set_chk.'>
										' . $row ['char_name'] . '
									</label>';
}

// プランタイプ取得
$t_plan_type_model = new t_plan_type_model ();
$plan_result = $t_plan_type_model->get_plan_type_data ();
$plan_html = '';
for($i = 0; $i < count ( $plan_result ); $i ++) {
	$row = $plan_result [$i];
	$plan_html .= '
									<label>
										<input type="checkbox" name="plan_name" value="' . $row ['plan_type_id'] . '" class="">
										' . $row ['plan_name'] . '
									</label>';
}

//遷移元からの情報継承処理
$type_set_html = '
		<script>
		$(function(){';
//遷移元からの情報、ランチ、ディナー選択状態設定
if ($_GET['type'] != null && $_GET['type'] != '') {
	$type_set_html .= '
				$("[name=time_zone]").val(["'.$_GET['type'].'"]);
			';
}

if ($_GET['d'] != null && $_GET['d'] != '') {
	$type_set_html .= '
				$("#d'.$_GET['d'].'").attr("checked", true);
			';
}

//シーン取得
$scene_html = $jis_common_logic->scene_plan_get();
if ($_GET['d'] != null && $_GET['d'] != '') {
	$type_set_html .= '
				$("#d'.$_GET['d'].'").attr("checked", true);
			';
}


//エリア指定時
if ($_GET['ar'] != null && $_GET['ar'] != '') {
// 	$type_set_html .= '
// 		$("[name=area_chkbox]").val(['.$_GET['ar'].']);
// 		var select_area_chkbox = $("[name=area_chkbox]:checked").map(function() {
// 			return $(this).attr("jq_str");
// 		}).get();

// 		var select_area_html = "";
// 		for (var i = 0; i < select_area_chkbox.length; i++) {
// 			select_area_html += "<span class=\'formRBox\' id=\'select_area_disp\'>" + select_area_chkbox[i] + "</span>";
// 		}

// 		if (select_area_html == "") {
// 			select_area_html = "<span class=\'formRBox\'>指定なし</span>";
// 		}

// 		$("#select_area_str").html(select_area_html);
// 	';
}

$type_set_html .= '
		});
		</script>';

$html = $jis_common_logic->create_area_array('', true);
$_SESSION['try_area_modal_html'] = $html;

$genre_array = $jis_common_logic->select_cuisine_genre();
$bef = 0;
$genre_input .='<p class="search_ttl">ジャンル</p>';
$cf_2 = true;
$cf_3 = true;
$cf_4 = true;
$cf_5 = true;
foreach ($genre_array as $cg_id => $cg_v) {
	if($cg_v['sub'] != 1){
		if($cg_v['sub'] == 2){
			if($cf_2){
				$cf_2 = false;
				$genre_input .='<div class="modal_border"></div>
						<p class="search_ttl">人気の和食料理</p>';
			}
		}elseif($cg_v['sub'] == 3){
			if($cf_3){
				$cf_3 = false;
				$genre_input .='<div class="modal_border"></div>
						<p class="search_ttl">人気の洋食料理</p>';
			}
		}elseif($cg_v['sub'] == 4){
			if($cf_4){
				$cf_4 = false;
				$genre_input .='<div class="modal_border"></div>
						<p class="search_ttl">バー</p>';
			}
		}elseif($cg_v['sub'] == 5){
			if($cf_5){
				$cf_5 = false;
				$genre_input .='<div class="modal_border"></div>
						<p class="search_ttl">クラブ</p>';
			}
		}
	}

	if($cg_v['sub'] <= 5 ){
		$genre_input .= '<label>
			<input type="checkbox" name="cuisine_genre" value="'.$cg_id.'" class="" jq_str="'.$cg_v['name'].'">
			'.$cg_v['name'].'
		</label>';
	}

}

?>
<?php print $type_set_html?>

<link rel="stylesheet" href="<?php print $path?>search/new_search.css" />
<script type="text/javascript" src="<?php print $path?>assets/front/page_js/new_store_search.js"></script>
				<div class="search_ttl_area">
					<p class="search_big_ttl"><i class="fa fa-search" aria-hidden="true"></i>レストランを検索<span>する</span></p>
				</div>
				<div class="search_tbl">
					<div class="search_tbl_col search_tbl_col_large spVi" se-ty="SDate">
						<i class="fa fa-calendar" aria-hidden="true"></i>
						<span class="search_res">日付</span>
						<span class="SBright">
							<i class="fa fa-caret-down" aria-hidden="true"></i>
						</span>
					</div>
					<div class="search_tbl_col search_tbl_col_small spUnvi" se-ty="STime">
						<i class="fa fa-clock-o" aria-hidden="true"></i>
						<span class="search_res">時間帯</span>
						<span class="SBright">
							<i class="fa fa-caret-down" aria-hidden="true"></i>
						</span>
					</div>
					<div class="search_tbl_col search_tbl_col_small spVi" se-ty="SNum">
						<i class="fa fa-user" aria-hidden="true"></i>
						<span class="search_res">人数</span>
						<span class="SBright">
							<i class="fa fa-caret-down" aria-hidden="true"></i>
						</span>
					</div>
					<div class="search_tbl_col search_tbl_col_small spVi" se-ty="SArea">
						<i class="fa fa-globe" aria-hidden="true"></i>
						<span class="search_res">エリア</span>
						<span class="SBright">
							<i class="fa fa-caret-down" aria-hidden="true"></i>
						</span>
					</div>
					<div class="search_tbl_col search_tbl_col_mid spVi" se-ty="SGenre">
						<i class="fa fa-glass" aria-hidden="true"></i>
						<span class="search_res">ジャンル</span>
						<span class="SBright">
							<i class="fa fa-caret-down" aria-hidden="true"></i>
						</span>
					</div>
					<div class="search_tbl_col search_tbl_col_mid spUnvi" se-ty="SEtc">
						<i class="fa fa-search" aria-hidden="true"></i>
						<span class="search_res">予算・他</span>
						<span class="SBright">
							<i class="fa fa-caret-down" aria-hidden="true"></i>
						</span>
					</div>
					<button class="search_btn" id="search_btn">
						検索する
					</button>
					<span class="clearFix"></span>
				</div>
				<form action="" name="frm" method="post" id="frm">
					<div class="search_min_modal">
						<div class="search_min_modal_layer"></div>
						<div class="spViOnly close_modal">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
						<div id="date_modal" class="SDate search_min_modal_in smmM">
							<div class="calendar"></div>
							<input type="hidden" id="dateCal" name="dateCal" value="">
							<input type="hidden" name="year" id="year">
								<?php //print $yoyaku_month_html?>
							<input type="hidden" name="day" id="day">
							<input type="hidden" name="date_select" id="date_select_jq">
							<div class="modal_border"></div>
							<div class="search_btn_area">
								<button type="button" class="reset_modal">日付未定</button>
								<button type="button" class="set_modal">設定</button>
							</div>
						</div>
						<div id="time_modal" class="STime search_min_modal_in smmS">
							<p class="search_ttl">時間帯</p>
							<label><input type="radio" name="time_zone" value="0">ランチ</label>
							<label><input type="radio" name="time_zone" value="1">ディナー</label>
							<label><input type="radio" name="time_zone" value="2">バー</label>
							<label><input type="radio" name="time_zone" value="3">クラブ</label>
							<div class="modal_border"></div>
							<p class="search_ttl">入店時間</p>
							<select name="in_time" class="search_inline_select">
								<?php print TIME_OPTION_HTML?>
							</select>
							～
							<select name="out_time" class="search_inline_select">
								<?php print TIME_OPTION_HTML?>
							</select>
							<div class="modal_border"></div>
							<div class="search_btn_area">
								<button type="button" class="reset_modal">リセット</button>
								<button type="button" class="set_modal">設定</button>
							</div>
						</div>
						<div id="num_modal" class="SNum search_min_modal_in smmS">
							<p class="search_ttl">人数</p>
							<select name="min_cnt" class="search_inline_select">
								<?php print ST_PERSON_OPTION_HTML?>
							</select>
							～
							<select name="max_cnt" class="search_inline_select">
								<?php print END_PERSON_OPTION_HTML?>
							</select>
							<div class="modal_border"></div>
							<div class="search_btn_area">
								<button type="button" class="reset_modal">リセット</button>
								<button type="button" class="set_modal">設定</button>
							</div>
						</div>
						<div id="area_modal" class="SArea search_min_modal_in smmL">
							<p class="search_ttl">エリア</p>
							<?php print $html['area_modal']?>
							<div class="modal_border"></div>
							<div class="search_btn_area">
								<button type="button" class="reset_modal">リセット</button>
								<button type="button" class="set_modal">設定</button>
							</div>
						</div>
						<div id="date_modal" class="SGenre search_min_modal_in smmL">
							<?php print $genre_input?>
							<div class="modal_border"></div>
							<div class="search_btn_area">
								<button type="button" class="reset_modal">リセット</button>
								<button type="button" class="set_modal">設定</button>
							</div>
						</div>
						<div id="date_modal" class="SEtc search_min_modal_in smmL">

							<div class="club_only">

								<p class="search_ttl">在籍人数</p>
								<label>
									<input type="checkbox" name="etc6" value="0" class=""  jq_str="1～5名">
									1～5名
								</label>
								<label>
									<input type="checkbox" name="etc6" value="1" class=""  jq_str="6～10名">
									6～10名
								</label>
								<label>
									<input type="checkbox" name="etc6" value="2" class=""  jq_str="11～30名">
									11～30名
								</label>
								<label>
									<input type="checkbox" name="etc6" value="3" class=""  jq_str="31～50名">
									31～50名
								</label>
								<label>
									<input type="checkbox" name="etc6" value="4" class=""  jq_str="51名～">
									51名～
								</label>
								<div class="modal_border"></div>

								<p class="search_ttl">平均年齢</p>
								<label>
									<input type="checkbox" name="etc7" value="0" class=""  jq_str="18～22歳">
									18～22歳
								</label>
								<label>
									<input type="checkbox" name="etc7" value="1" class=""  jq_str="23～27歳">
									23～27歳
								</label>
								<label>
									<input type="checkbox" name="etc7" value="2" class=""  jq_str="28～32歳">
									28～32歳
								</label>
								<label>
									<input type="checkbox" name="etc7" value="3" class=""  jq_str="33～37歳">
									33～37歳
								</label>
								<label>
									<input type="checkbox" name="etc7" value="4" class=""  jq_str="38歳～">
									38歳～
								</label>
								<div class="modal_border"></div>

							</div>
							<p class="search_ttl">シーン</p>
							<?php print $scene_html?>
							<div class="modal_border"></div>

							<p class="search_ttl">レストランの特徴</p>
							<?php print $characteristic_html?>
							<div class="modal_border"></div>

							<p class="search_ttl">座席</p>
							<label>
								<input type="checkbox" name="seat_type" value="0" class="">
								窓際
							</label>
							<label>
								<input type="checkbox" name="seat_type" value="1" class="">
								テラス席
							</label>
							<label>
								<input type="checkbox" name="seat_type" value="2" class="">
								ソファ席
							</label>
							<label>
								<input type="checkbox" name="seat_type" value="3" class="">
								個室
							</label>
							<label>
								<input type="checkbox" name="seat_type" value="4" class="">
								半個室
							</label>
							<label>
								<input type="checkbox" name="seat_type" value="5" class="">
								カウンター
							</label>
							<div class="modal_border"></div>

							<p class="search_ttl">プラン内容</p>
							<?php print $plan_html?>
							<div class="modal_border"></div>

							<p class="search_ttl">設備</p>
							<label>
								<input type="checkbox" name="dress_flg" value="1" class="">
								ドレスコードあり
							</label>
							<label>
								<input type="checkbox" name="dress_flg" value="0" class="">
								ドレスコードなし
							</label>
							<label>
								<input type="checkbox" name="child_flg" value="0" class="">
								お子様OK
							</label>
							<label>
								<input type="checkbox" name="wheelchair_flg" value="0" class="">
								車椅子対応可
							</label>
							<label>
								<input type="checkbox" name="parking_flg" value="0" class="">
								駐車場あり
							</label>
							<div class="modal_border"></div>

							<p class="search_ttl">たばこ</p>
							<label>
								<input type="radio" class="" name="smoke_type" value="9" checked="checked">
								どちらでもよい
							</label>
							<label>
								<input type="radio" class="" name="smoke_type" value="0">
								禁煙希望
							</label>
							<label>
								<input type="radio" class="" name="smoke_type" value="1">
								喫煙希望
							</label>
							<label>
								<input type="radio" class="" name="smoke_type" value="2">
								分煙希望
							</label>
							<div class="modal_border"></div>

							<p class="search_ttl">jisサービス</p>
							<label>
								<input type="radio" class="" name="p_type" value="" checked>
								すべて
							</label>
							<label>
								<input type="radio" class="" name="p_type" value="0">
								通常
							</label>
							<label>
								<input type="radio" class="" name="p_type" value="1">
								ゴールド
							</label>
							<label>
								<input type="radio" class="" name="p_type" value="2">
								プラチナ
							</label>
							<div class="modal_border"></div>

							<div class="search_btn_area">
								<button type="button" class="reset_modal">リセット</button>
								<button type="button" class="set_modal">設定</button>
							</div>
						</div>
					</div>
				</form>
				<div class="visible-xs">
					<section class="topBox2">
						<div class="p__panel-link">
							<div class="c__layout-table-btn">
								<div class="cmm__table-cell grid3 line_right">
								<a href="<?php print $path?>mypage/"><img alt="予約確認・変更・キャンセル" src="<?php print $path?>assets/front/img/spicon01.png"><span class="scIcon">予約確認・<br>変更・キャンセル</span></a>
								</div>
								<div class="cmm__table-cell grid3 line_right">
								<a href="<?php print $path?>search/history.php"><img alt="最近見た履歴" src="<?php print $path?>assets/front/img/spicon02.png"><span class="scIcon">最近見た<br>履歴</span></a>
								</div>
								<div class="cmm__table-cell grid3 line_right2">
								<a href="<?php print $path?>mypage/"><img alt="お気に入りリスト" src="<?php print $path?>assets/front/img/spicon03.png"><span class="scIcon">お気に入り<br>リスト</span></a>
								</div>
							</div>
						</div>
					</section>
				</div>


	<input type="hidden" id="sct_url" value="<?php print $path?>controller/front/search_ct.php">
	<input type="hidden" id="search_type" value="<?php print $GET_['type']?>">
	<input type="hidden" id="outside" value="<?php print $outside?>">
	<input type="hidden" id="index_path" value="<?php print $path?>search/index.php">
</body>
</html>
