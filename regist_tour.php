<?php
session_start();
require_once __DIR__ .  '/../logic/common/jis_common_logic.php';
$jis_common_logic = new jis_common_logic();
$jis_common_logic->login_check();

if($_SESSION['jis']['login_member']['auth_flg'] != 1){
	$script = 'alert("掲載者情報が許可されていないためアクティビティ登録ができません。\n管理者からのご連絡をお待ちください。");location.replace("./")';
}

$opt = $jis_common_logic->get_time_opt();
$cate = $jis_common_logic->create_ca_inp("c", "c", 'jp');
$area = $jis_common_logic->create_ca_inp("c", "a", 'jp');



if($_GET['tid'] != null && $_GET['tid'] != ''){
	$tour = $jis_common_logic->get_tour($_GET['tid']);
}

$lat_lng_array = explode("@", $tour['tour']['schedule']);
if($lat_lng_array [0] == null || $lat_lng_array [0] == '') $lat_lng_array [0] = '35.686773';
if($lat_lng_array [1] == null || $lat_lng_array [1] == '') $lat_lng_array [1] = '139.68815';
$scrpt = $jis_common_logic->create_input_script($tour['tour'], array(
		'ignor' => "title,d_title,d_detail,tranvel,youtube,schedule,meeting_place,note,inclusion,what_to_bring,duration",
		'checkbox' => "category,area,note_agreement_flg,payment_way",
		'radio' => "femeal_only",
		'file' => "img",
		'fileOpt' => array(
				"img" => array(
						"dir" => "../upload_files/tour/",
						"jq_id" => "1",
				),
		)
));
$disp =(strpos($tour['tour']['payment_way'], "2") !== false)? '' : 'style="display: none;"';
$count = (isset($tour['tour_relation'])) ? count($tour['tour_relation']) : 0;
$re_num = array(1 =>"",2 =>"",3 =>"");
$re_num[$count] = 'selected="selected"';
if($count === 0)$re_num = array(1 =>'selected="selected"',2 =>"",3 =>"");


$ex_form = array(1 =>"",2 =>"",3 =>"");
$tour_num = 0;
for ($i = 0; $i < 3; $i++) {
	$n = $i + 1;
	$tri = $tour['tour_relation'][$i]['tour_relation_id'];
	if($tour['tour_relation'][$i]['tour_relation_id'] != null && $tour['tour_relation'][$i]['tour_relation_id'] != ''){
		++$tour_num;
	}
	$scrpt .= "$('[name=tour_relation_id-".$n."]').val('".$tour['tour_relation'][$i]['tour_relation_id']."');";
	$scrpt .= "$('[name=start_date-".$n."]').val('".$tour['tour_relation'][$i]['start_date']."');";
	$scrpt .= "$('[name=end_date-".$n."]').val('".$tour['tour_relation'][$i]['end_date']."');";
	$scrpt .= "$('[name=start_time-".$n."]').val('".$tour['tour_relation'][$i]['start_time']."');";
	$scrpt .= "$('[name=end_time-".$n."]').val('".$tour['tour_relation'][$i]['end_time']."');";
	$scrpt .= "$('[name=holiday_week-".$n."]').val([".$tour['tour_relation'][$i]['holiday_week']."]);";
	$scrpt .= "$('[name=max_number_of_people-".$n."]').val('".$tour['tour_relation'][$i]['max_number_of_people']."');";

	$count_ex = (isset($tour['tour_relation_exception'][$tri])) ? count($tour['tour_relation_exception'][$tri]) + 1 : 0;
	$scrpt .= "$('.exceptionDateWrap[tour=\"".$n."\"]').attr('num', '".$count_ex."');";
	$scrpt .= "$('[name=exception_num-".$n."]').val('".$count_ex."');";

	for ($j = 0; $j < $count_ex; $j++) {
		if($tour['tour_relation_exception'][$tri][$j]['exception_date'] == null || $tour['tour_relation_exception'][$tri][$j]['exception_date'] == '') continue;
		$n2 = $j + 1;


		$btn = (($n2 + 1) == $count_ex)? '<button class="exBtn add">+</button><button class="exBtn rem">-</button>' : '';
		if($btn != null && $btn != '' && $n2 == 1)$btn = '<button class="exBtn add">+</button>';

		$ex_form[$n] .= '
		<div class="exceptionDateArea">
			<input type="hidden" name="tour_relation_exception_id-'.$n.'_'.$n2.'" id="exception_date-'.$n.'_'.$n2.'" class="formTxt1 " placeholder="日付" value="">
			<input type="text" name="exception_date-'.$n.'_'.$n2.'" id="exception_date-'.$n.'_'.$n2.'" class="formTxt1 validate  tour_datepicker" placeholder="日付" value="">
			<input type="number" name="ex_max_number_of_people-'.$n.'_'.$n2.'" id="ex_max_number_of_people-'.$n.'_'.$n2.'" class="formTxt1 validate " placeholder="人数" value="">
			'.$btn.'
		</div>';

		$scrpt .= "$('[name=tour_relation_exception_id-".$n."_".$n2."]').val('".$tour['tour_relation_exception'][$tri][$j]['tour_relation_exception_id']."');";
		$scrpt .= "$('[name=exception_date-".$n."_".$n2."]').val('".$tour['tour_relation_exception'][$tri][$j]['exception_date']."');";
		$scrpt .= "$('[name=ex_max_number_of_people-".$n."_".$n2."]').val('".$tour['tour_relation_exception'][$tri][$j]['max_number_of_people']."');";
	}

	if($count_ex == 1){
		$scrpt .= "$('[name=exception_num-".$n."]').val('1');";
		$ex_form[$n] = '<div class="exceptionDateArea">
						<input type="text" name="exception_date-'.$n.'_1" id="exception_date-'.$n.'_1" class="formTxt1 validate  tour_datepicker" placeholder="日付" value="">
						<input type="number" name="ex_max_number_of_people-'.$n.'_1" id="ex_max_number_of_people-'.$n.'_1" class="formTxt1 validate  " placeholder="人数" value="">
						<button class="exBtn add">+</button>
					</div>';
	}
}
if($tour_num > 0){
	$scrpt .= "$('[name=tour_num]').val('".$tour_num."');";
}


$tx_html = $tour['tour']['tranvel'];
if ($tour['tour']['tranvel'] == "") {
    $tx_html = '1.18:30 pm Meeting and Departure at Uniqlo Shinjuku Nishiguchi(West) Shop
↓
2.18:40-19:25 Omoide-yokocho（Small Restaurant Arcade）
We will provide Japanese style light meal such as Edamame, Yakitori, and one drink.
↓
3.19:30-19:35 Famous Gate for the entrance of Kabuki-cho.
↓
4.19:40-19:45 Godzilla Head at Toho Cinema.
↓
5.20:00-20:20 Shinjuku Golden-gai.（Local Flavor Town）
↓
6.20:30-20:45 Hanazono Shinto Shrine.
↓
7. 20:45-21:00 Tour will be finished at Shinjuku station or Kabuki-cho
*Our guide will help you to find your dinner or more attraction such as Samurai museum.';

}


?>


<!DOCTYPE html>
<html lang="ja">
<head>
<?php require_once '../required/html_head.php';?>

<script type="text/javascript" src="../assets/js/validate.js"></script>
<script type="text/javascript" src="../assets/js/plural_file_upload.js"></script>
<script type="text/javascript" src="../assets/js/form.js"></script>
<script type="text/javascript" src="../assets/js/tour_edit.js?v=1"></script>
<script type="text/javascript">
<?php print $script?>
</script>
<style type="text/css">
#pac-input{
font-size: 16px;
}
</style>
</head>
<body>
	<!--▼▼▼▼▼ header ▼▼▼▼▼-->
<?php require_once '../required/header_out_lower.php';?>
	<!--▲▲▲▲▲ header ▲▲▲▲▲-->
	<div itemprop="articleBody" class="try__articleBody">
		<div id="wrap1080">
			<div class="container1080 cf">
				<div class="container760">

					<?php require_once "./member_top.php"?>

					<section>
						<h3 class="titleUnderline">アクティビティ情報管理</h3>
						<div class="storeEditBtnBox">
							<a href="edit_information.php"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">事業者様情報管理</span></span></a>
							<a href="./"><span class="btnBase btnBg1 btnW1"><span class="btnLh2">マイページTOP</span></span></a>

						</div>
					</section>

					<section class="borderBox">
						<div class="storeEditIn" id="inputFormArea">
							<h4 class="titleBN">アクティビティ情報登録<span class="registTit1" id="conf_text"></span></h4>
							<div class="storeEditItem">
								<div class="storeEditRow">
									<div class="storeEditCate">ステータス<br>Status</div>
									<div class="storeEditForm">
											<select name="public_flg" id="public_flg" class="formTxt1 validate required">
														<option value="0">公開</option>
												<option value="1">下書き</option>
											</select>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">アクティビティ<br>タイトル<br>Tour title</div>
									<div class="storeEditForm">
										<textarea name="title" id="title" rows="5" cols="" class="formTxt1 validate required " placeholder="SHINJUKU WALKING TOUR *Great Photo Spots in Kabuki-cho!"><?php print $tour['tour']['title']?></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">説明文タイトル<br>Description title</div>
									<div class="storeEditForm">
										<textarea name="d_title" id="d_title" rows="5" cols="" class="formTxt1 validate required encode" placeholder="SHINJUKU WALKING TOUR *Great Photo Spots in Kabuki-cho!"><?php print $tour['tour']['d_title']?></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">説明文<br>Description</div>
									<div class="storeEditForm">
										<textarea name="d_detail" id="d_detail" rows="5" cols="" class="formTxt1 validate required encode"  placeholder="Discover the fantastic part of Shinjuku, which is the biggest ward of Tokyo, on an about 2.5 hours walking tour. Enjoying the neon lights, local..."><?php print $tour['tour']['d_detail']?></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">女性限定<br>Women only</div>
									<div class="storeEditForm">
										<label><span class="formRBox"><input type="radio" name="femeal_only" value="0" class="validate" style="width: 15px; height: auto; display: inline;" checked="checked">限定なし</span></label>
										<label><span class="formRBox"><input type="radio" name="femeal_only" value="1" class="validate" style="width: 15px; height: auto; display: inline;">女性限定</span></label>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">カテゴリー<br>Category</div>
									<div class="storeEditForm">
										<?php print $cate?>
										<p>※複数選択可能</p>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">エリア<br>Area</div>
									<div class="storeEditForm">
										<?php print $area?>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">大人料金<br>Adult fee</div>
									<div class="storeEditForm">
										<input type="tel" name="adult_fee" id="adult_fee" class="formTxt1 validate required number moneyChange" placeholder="3500" >Yen
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">子供料金<br>Child fee</div>
									<div class="storeEditForm">
										<input type="tel" name="children_fee" id="children_fee" class="formTxt1 validate required number moneyChange" value="0">Yen
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">子供料金適用年齢<br>Child fee applicable age</div>
									<div class="storeEditForm">
										<input type="text" name="children_age_limit" id="children_age_limit" class="formTxt1 validate  " placeholder="3 to 11 years" value="">
										<span  style="	position: absolute;bottom: -13px;left: 12px;font-size: 13px; ">※子供料金が適用される年齢を記載してください</span>
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">割引率設定<br>Discount rate setting</div>
									<div class="storeEditForm" style="position: relative">
										<input type="number" name="discount_rate_setting" id="discount_rate_setting" class="formTxt1 validate required number moneyChange"  placeholder="不要な場合は0を入力してください" maxlength="2">%
										<span  style="	position: absolute;bottom: -6px;left: 12px;font-size: 13px; ">※「5」と入力した場合各料金から5%割引されます。</span>
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">適用価格<br>Applicable price</div>
									<div class="storeEditForm">
										<input type="tel" name="apply_price_ablut" id="apply_price_ablut" class="formTxt1 validate  number" value="0" readonly="readonly">Yen
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">適用価格(子供)<br>Child price</div>
									<div class="storeEditForm">
										<input type="tel" name="apply_price_child" id="apply_price_child" class="formTxt1 validate  number" value="0" readonly="readonly">Yen
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">行程<br>Itinerary</div>
									<div class="storeEditForm">
										<textarea name="tranvel" id="tranvel" rows="5" cols="" class="formTxt1 validate required encode" placeholder="18:30 pm Meeting and Departure at Uniqlo Shinjuku Nishiguchi(West) Shop
↓
										18:40-19:25 Omoide-yokocho（Small Restaurant Arcade）
										We will provide Japanese style light meal such as Edamame, Yakitori, and one drink.
										↓
										19:30-19:35 Famous Gate for the entrance of Kabuki-cho.
										↓
										19:40-19:45 Godzilla Head at Toho Cinema.
										↓
										20:00-20:20 Shinjuku Golden-gai.（Local Flavor Town）
										↓
										20:30-20:45 Hanazono Shinto Shrine.
										↓
										 20:45-21:00 Tour will be finished at Shinjuku station or Kabuki-cho
										*Our guide will help you to find your dinner or more attraction such as Samurai museum."><?php print htmlspecialchars_decode($tour['tour']['tranvel'])?></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">YOUTUBE埋め込みタグ</div>
									<div class="storeEditForm">
										<textarea name="youtube" id="youtube" rows="5" cols="" class="formTxt1 validate encode"  placeholder="YOUTUBEにて「共有ボタン」をクリックいただいた後、「＜＞埋め込む」にて埋め込みタグを発行いただきこちらへ貼り付けてください"><?php print htmlspecialchars_decode($tour['tour']['youtube'])?></textarea>
                                        <span class="text-warning">（ここには、YouTubeリンクを最大3つまで入力できます。）</span>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">画像<br>(三枚まで登録可)<br>Img</div>
									<div class="storeEditForm">
										<div id="fileArea1" class="form_btn img_btn">
											<form id="upload_form1" enctype="multipart/form-data" method="post">
												<input type="file" name="file1" id="file1" jq_id="1" cnt="0" class="form_file" col_name="img">
												<h4 id="status1"></h4>
											</form>
										</div>
											<div id="img_area1" class="imgPrevBox"></div>
									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">集合場所<br>Meeting place</div>
									<div class="storeEditForm">
										<textarea name="meeting_place" id="meeting_place" rows="5" cols="" class="formTxt1 validate required" placeholder="Shinjuku Palette 1-1-1 Nishi-Shinjuku, Shinjuku-ku, Tokyo Uniqlo Shinjuku Nishiguchi(West) Shop Main entrance."><?php print $tour['tour']['meeting_place']?></textarea>
									</div>
								</div>


								<div class="storeEditRow">
									<div class="storeEditCate">アクセス<br>Access</div>
									<div class="storeEditForm">
										<div class="formMapTxt mincho">キーワードまたは場所を入力して検索してください。地図上のピンで位置調整することも可能です。</div>
										<input id="pac-input" class="controls" type="text"
											placeholder="キーワード検索"
											style="margin-top: 10px;; height: 40px; width: 200px;">
										<div id="map" style="width: 100%; height: 500px"></div>
									<!--     <div id="map"></div> -->
									<script>

	function initAutocomplete() {
// 		var okayamaTheLegend = new google.maps.LatLng(34.666358, 133.918576);
		var icon = {
				icon: 'img/map-icon.png',
			};

		var map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: <?php print $lat_lng_array[0]?>, lng: <?php print $lat_lng_array[1]?>},
			zoom: 16,
			mapTypeId: 'roadmap',
				styles: [{
					stylers: [
					{
						saturation: -70 // 彩度
					}, {
						lightness: 20 // 明度
					}, {
						gamma: 0.5 // ガンマ
					}
				]
			}]
		});

		// Create the search box and link it to the UI element.
		var input = document.getElementById('pac-input');
		var searchBox = new google.maps.places.SearchBox(input);
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

		// Bias the SearchBox results towards current map's viewport.
		map.addListener('bounds_changed', function() {
			searchBox.setBounds(map.getBounds());
			var pos = map.getCenter();
			var lat = pos.lat();
			var lng = pos.lng();

		});

		var pos = map.getCenter();
		var lat = pos.lat();
		var lng = pos.lng();
		var markers = [];
		// Listen for the event fired when the user selects a prediction and retrieve
		// more details for that place.
		searchBox.addListener('places_changed', function() {
			var places = searchBox.getPlaces();

			if (places.length == 0) {
				return;
			}


			// Clear out the old markers.
			markers.forEach(function(marker) {
				marker.setMap(null);
			});

			markers = [];


			// For each place, get the icon, name and location.
			var bounds = new google.maps.LatLngBounds();

			places.forEach(function(place) {
				if (!place.geometry) {
					return;
				}

// 				drawMarkerCenterInit(map, pos)

				if (place.geometry.viewport) {
					// Only geocodes have viewport.
					bounds.union(place.geometry.viewport);
				} else {
					bounds.extend(place.geometry.location);
				}
			});
			map.fitBounds(bounds);
		});


		// Clear out the old markers.
		markers.forEach(function(marker) {
			marker.setMap(null);
		});

		markers = [];


		$('#lat').val(lat)
		$('#lng').val(lng)
		var mark = drawMarkerCenterInit(map, pos)
			var latlng = lat + '@' + lng;
			$("#schedule").val(latlng);

		// Event
		map.addListener( "center_changed", function ( argument ) {
			// Clear out the old markers.
			markers.forEach(function(marker) {
				marker.setMap(null);
			});

			markers = [];
			var pos = map.getCenter();
			var lat = pos.lat();
			var lng = pos.lng();

			$('#lat').val(lat)
			$('#lng').val(lng)

			var latlng = lat + '@' + lng;
			$("#schedule").val(latlng);

			mark.setPosition(pos);
			mark.setTitle('map center: ' + pos);
		} ) ;
	}

	function drawMarkerCenterInit(myMap,pos){

		var markerCenter = new google.maps.Marker({
			position: pos,
			map: myMap,
			size: new google.maps.Size(10, 10),
			title: 'map center:' + pos, // アイコンのタイトル (中心の経緯度を設定)
// 			icon:{url: 'img/map-icon.png',scaledSize: new google.maps.Size(60, 60)
// 			}, // アイコン画像を指定
	});

    return markerCenter;
}


    </script>
									<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC50D68hnfmHwA2uN9fOTlRNbtA5IyxOzc&libraries=places&callback=initAutocomplete" async defer></script>
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





								<div class="storeEditRow">
									<div class="storeEditCate">キャンセルポリシー<br>Cancellation policy</div>
									<div class="storeEditForm">
										<textarea name="note" id="note" rows="5" cols="" class="formTxt1 validate encode" placeholder="3 days before:30%
The day before:50%
On the day: 100%
"><?php print $tour['tour']['note']?></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">承諾有無<br>Acceptance</div>
									<div class="storeEditForm">
										<label><span class="formRBox"><input type="checkbox" name="note_agreement_flg" value="1" class="validate encode" style="width: 15px; height: auto; display: inline;">承諾必須</span></label>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">アクティビティ料金<br>に含まれるもの<br>Inclusion</div>
									<div class="storeEditForm">
										<textarea name="inclusion" id="inclusion" rows="5" cols="" class="formTxt1 validate required encode" placeholder="English speaking tour assistant. Light meal and one drink."><?php print $tour['tour']['inclusion']?></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">必要な持ち物<br>What to bring </div>
									<div class="storeEditForm">
										<textarea name="what_to_bring" id="what_to_bring" rows="5" cols="" class="formTxt1 validate required encode"  placeholder="Camera"><?php print $tour['tour']['what_to_bring']?></textarea>
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">全行程実施時間<br>Duration</div>
									<div class="storeEditForm">
										<textarea name="duration" id="duration" rows="5" cols="" class="formTxt1 validate required encode"  placeholder="Approx 2.5 hours"><?php print $tour['tour']['duration']?></textarea>
									</div>
								</div>
								<div class="storeEditRow">
									<div class="storeEditCate">お客様からの<br>お支払い方法<br>Payment method</div>
									<div class="storeEditForm">
										<label><span class="formRBox"><input type="checkbox" name="payment_way" value="0" class="validate" style="width: 15px; height: auto; display: inline;">現地現金払い　Cash on site</span></label>
										<p class="formBoxSmall">サービス完了後、月末締めにてHealing Tokyoよりコミッション分を、ご請求致します。</p>
										<label><span class="formRBox"><input type="checkbox" name="payment_way" value="2" class="validate card_choice_chk" style="width: 15px; height: auto; display: inline;">現地カード払い　Credit card on site</span></label>
										<p class="formBoxSmall">サービス完了後、月末締めにてHealing Tokyoよりコミッション分を、ご請求致します。</p>
										<input type="text" name="card_choice" id="card_choice" class="formTxt1 validate " value="" placeholder="利用可能カード名を入力してください" <?php print $disp?>>
										<label><span class="formRBox"><input type="checkbox" name="payment_way" value="1" class="validate" style="width: 15px; height: auto; display: inline;">クレジットカード決済　Advance collection by Healing Tokyo</span></label>
										<p class="formBoxSmall">Healing Tokyoにてカード決済 (Healing Tokyoにてクレジットカード代行決済 (カード決済手数料3%を頂きます。サービス完了後、月末締めにて、Healing Tokyoより 事業者様へ コミッションを引いて、お支払い致します。）</p>
									</div>
								</div>

								<hr style="display: block; border: 1px solid #DDD;margin: 20px 0;">

								<div class="storeEditRow">
									<div class="storeEditCate">アクティビティ<br>部数</div>
									<div class="storeEditForm">
										<select name="tour_num" id="tour_num" class="formTxt1 validate required">
											<option value="1" <?php print $re_num[1]?>>1部</option>
											<option value="2" <?php print $re_num[2]?>>2部</option>
											<option value="3" <?php print $re_num[3]?>>3部</option>
										</select>
									</div>
								</div>

								<div class="tour_num_1">
									<br>
									<h5>第一部</h5>
									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>受付開始日</div>
										<div class="storeEditForm">
											<input type="text" name="start_date-1" id="start_date-1" class="formTxt1 validate required tour_datepicker" placeholder="アクティビティ予約を開始する日付を入力してください" value="">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>受付終了日</div>
										<div class="storeEditForm">
											<input type="text" name="end_date-1" id="end_date-1" class="formTxt1 validate required tour_datepicker" placeholder="アクティビティ予約を終了する日付を入力してください" value="">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>開始時間</div>
										<div class="storeEditForm">
											<select name="start_time-1" id="start_time-1" class="formTxt1 validate required " >
												<?php print $opt['opt_t'];?>
											</select>
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>終了時間</div>
										<div class="storeEditForm">
											<select name="end_time-1" id="end_time-1" class="formTxt1 validate required " >
												<?php print $opt['opt_t'];?>
											</select>
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">予約可能人数</div>
										<div class="storeEditForm">
											<input type="number" name="max_number_of_people-1" id="max_number_of_people-1" class="formTxt1 validate required " placeholder="1日の予約可能人数を入力してください" value="">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>受付不可曜日</div>
										<div class="storeEditForm">
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-1" value="0" class="validate" style="width: 15px; height: auto; display: inline;">日</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-1" value="1" class="validate" style="width: 15px; height: auto; display: inline;">月</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-1" value="2" class="validate" style="width: 15px; height: auto; display: inline;">火</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-1" value="3" class="validate" style="width: 15px; height: auto; display: inline;">水</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-1" value="4" class="validate" style="width: 15px; height: auto; display: inline;">木</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-1" value="5" class="validate" style="width: 15px; height: auto; display: inline;">金</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-1" value="6" class="validate" style="width: 15px; height: auto; display: inline;">土</span></label>
											<p class="formBoxSmall">アクティビティを開催しない曜日を選択してください</p>
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">例外</div>
										<div class="storeEditForm">
											<input type="hidden" name="exception_num-1" value="1">
											 <div class="exceptionDateWrap" num="1" tour="1">
												<?php print $ex_form[1]?>
											</div>
											<p class="formBoxSmall">別途受付可能人数が変更のある日程とその人数を入力してください<br>※受付不可の場合は人数に「0」を入力</p>
										</div>
									</div>

								</div>

								<div class="tour_num_2">
									<br>
									<h5>第二部</h5>
									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>受付開始日</div>
										<div class="storeEditForm">
											<input type="text" name="start_date-2" id="start_date-2" class="formTxt1 validate  tour_datepicker" placeholder="アクティビティ予約を開始する日付を入力してください" value="">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>受終了日</div>
										<div class="storeEditForm">
											<input type="text" name="end_date-2" id="end_date-2" class="formTxt1 validate  tour_datepicker" placeholder="アクティビティ予約を終了する日付を入力してください" value="">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>開始時間</div>
										<div class="storeEditForm">
											<select name="start_time-2" id="start_time-2" class="formTxt1 validate  " >
												<?php print $opt['opt_t'];?>
											</select>
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>終了時間</div>
										<div class="storeEditForm">
											<select name="end_time-2" id="end_time-2" class="formTxt1 validate  " >
												<?php print $opt['opt_t'];?>
											</select>
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">予約可能人数</div>
										<div class="storeEditForm">
											<input type="number" name="max_number_of_people-2" id="max_number_of_people-2" class="formTxt1 validate  " placeholder="1日の予約可能人数を入力してください" value="">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>受付不可曜日</div>
										<div class="storeEditForm exceptionDateWrap" num="3">
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-2" value="0" class="validate" style="width: 15px; height: auto; display: inline;">日</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-2" value="1" class="validate" style="width: 15px; height: auto; display: inline;">月</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-2" value="2" class="validate" style="width: 15px; height: auto; display: inline;">火</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-2" value="3" class="validate" style="width: 15px; height: auto; display: inline;">水</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-2" value="4" class="validate" style="width: 15px; height: auto; display: inline;">木</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-2" value="5" class="validate" style="width: 15px; height: auto; display: inline;">金</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-2" value="6" class="validate" style="width: 15px; height: auto; display: inline;">土</span></label>
											<p class="formBoxSmall">アクティビティを開催しない曜日を選択してください</p>
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">例外</div>
										<div class="storeEditForm">
											<input type="hidden" name="exception_num-2" value="1">
											 <div class=" exceptionDateWrap" num="2" tour="2">
												<?php print $ex_form[2]?>
											</div>
											<p class="formBoxSmall">別途受付可能人数が変更のある日程とその人数を入力してください<br>※受付不可の場合は人数に「0」を入力</p>
										</div>
									</div>

								</div>

								<div class="tour_num_3">
									<br>
									<h5>第三部</h5>
									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>受付開始日</div>
										<div class="storeEditForm">
											<input type="text" name="start_date-3" id="start_date-3" class="formTxt1 validate  tour_datepicker" placeholder="アクティビティ予約を開始する日付を入力してください" value="">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>受終了日</div>
										<div class="storeEditForm">
											<input type="text" name="end_date-3" id="end_date-3" class="formTxt1 validate  tour_datepicker" placeholder="アクティビティ予約を終了する日付を入力してください" value="">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>開始時間</div>
										<div class="storeEditForm">
											<select name="start_time-3" id="start_time-3" class="formTxt1 validate  " >
												<?php print $opt['opt_t'];?>
											</select>
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>終了時間</div>
										<div class="storeEditForm">
											<select name="end_time-3" id="end_time-3" class="formTxt1 validate  " >
												<?php print $opt['opt_t'];?>
											</select>
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">予約可能人数</div>
										<div class="storeEditForm">
											<input type="number" name="max_number_of_people-3" id="max_number_of_people-3" class="formTxt1 validate  " placeholder="1日の予約可能人数を入力してください" value="">
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">アクティビティ<br>受付不可曜日</div>
										<div class="storeEditForm">
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-3" value="0" class="validate" style="width: 15px; height: auto; display: inline;">日</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-3" value="1" class="validate" style="width: 15px; height: auto; display: inline;">月</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-3" value="2" class="validate" style="width: 15px; height: auto; display: inline;">火</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-3" value="3" class="validate" style="width: 15px; height: auto; display: inline;">水</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-3" value="4" class="validate" style="width: 15px; height: auto; display: inline;">木</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-3" value="5" class="validate" style="width: 15px; height: auto; display: inline;">金</span></label>
											<label><span class="formRBox"><input type="checkbox" name="holiday_week-3" value="6" class="validate" style="width: 15px; height: auto; display: inline;">土</span></label>
											<p class="formBoxSmall">アクティビティを開催しない曜日を選択してください</p>
										</div>
									</div>

									<div class="storeEditRow">
										<div class="storeEditCate">例外</div>
										<div class="storeEditForm">
											<input type="hidden" name="exception_num-3" value="1">
											<div class=" exceptionDateWrap" num="2" tour="3">
												<?php print $ex_form[3]?>
											</div>
											<p class="formBoxSmall">別途受付可能人数が変更のある日程とその人数を入力してください<br>※受付不可の場合は人数に「0」を入力</p>
										</div>
									</div>

								</div>


								<hr style="display: block; border: 1px solid #DDD;margin: 20px 0;">

								<div class="storeEditRow">
									<div class="storeEditCate">備考(管理用)<br>※公開されません</div>
									<div class="storeEditForm">
										<textarea name="remarks" id="remarks" rows="5" cols="" class="formTxt1 validate " placeholder="メモとしてご利用ください"><?php print htmlspecialchars_decode($tour['tour']['remarks'])?></textarea>
									</div>
								</div>

								<div class="storeEditRow">
									<div class="storeEditCate">翻訳依頼<br></div>
									<div class="storeEditForm">
										<label><span class="formRBox"><input type="checkbox" name="honyaku" value="1" class="validate" style="width: 15px; height: auto; display: inline;">翻訳依頼をする</span></label>
										<p class="formBoxSmall">※　英訳をご希望の方は下記「翻訳依頼をする」にチェックを入れてください<br>Healing Tokyo側で翻訳し公開いたします</p>
									</div>
								</div>

								<input type="hidden" name="method" value="tour_regist">

							</div>

							<form action="../logic/front/regist_edit_logic.php" name="inputFormArea" method="post"></form>

							<div class="btnArea">
								<button type="button" class=" btn btnBg1 conf_hide" name="preview" prev_for="../search/plan.php?sbid=<?php print $_SESSION['jis']['login_member']['store_basic_id']?>">プレビューを見る</button>
								<button type="button" class=" btn btnBg1 conf_hide" name="conf">確認する</button>
								<button type="button" class=" btn btnBgBack conf_show" name="back">入力に戻る</button>
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

	<input type="hidden" id="common_ct_url" value="../controller/admin/common_ct.php">
	<input type="hidden" id="img_path1" value="tour/">
	<input type="hidden" id="img_length1" class="hid_img_length" value="3">
	<input type="hidden" id="img_type1" class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">
	<input type="hidden" id="sbid"  value="<?php print $_SESSION['jis']['login_member']['store_basic_id']?>">
<script type="text/javascript">
<?php print $scrpt?>
</script>

<script type="text/javascript">
$(function(){
	calculation();
	$('.moneyChange').on("keyup blur change", function(){
		calculation($(this));
	});
	function calculation($elem){
		if($elem != undefined){
			if($elem.attr("name") == 'adult_fee'){
				$('[name=children_fee]').val($elem.val());
			}
		}

		var	 discount_rate_setting = $("[name=discount_rate_setting]").val();
		var adult_fee = $('[name=adult_fee]').val();
		var children_fee = $('[name=children_fee]').val();

		var apply_price_ablut = Math.ceil(adult_fee * ( 1 - (discount_rate_setting / 100) ) )  ;
		var apply_price_child = Math.ceil(children_fee * ( 1 - (discount_rate_setting / 100) ) )  ;
		$('[name=apply_price_ablut]').val(apply_price_ablut);
		$('[name=apply_price_child]').val(apply_price_child);
	}

	if($(".card_choice_chk").prop("checked") === true){
		$('#card_choice').show();
	}else{
		$('#card_choice').hide();
	}
	$('.card_choice_chk').off().on('click', function(){
		if($(this).prop("checked") === true){
			$('#card_choice').show();
		}else{
			$('#card_choice').hide();
		}
	});
});
</script>

</body>
</html>
