<?php
// 設定ファイル読込
require_once __DIR__ .  '/../../logic/common/common_logic.php';

class jis_common_logic {
    private $common_logic;

    public function __construct() {
        $this->common_logic = new common_logic();
    }


    public function get_date_opt(){
        $opt_y = '';$opt_m = '';$opt_d = '';
        for ($i = 1; $i <= 31; $i++) {
            $n = (strlen($i) == 1 )?'0'.$i: $i;
            if($i <= 12){
                $opt_m .= '<option value="'.$n.'">'.$n.'</option>';
            }
            $opt_d .= '<option value="'.$n.'">'.$n.'</option>';
        }
        for ($j = 1930; $j <= date('Y'); $j++) {
            $opt_y .= '<option value="'.$j.'">'.$j.'</option>';
        }

        return array(
            'opt_y' => $opt_y,
            'opt_m' => $opt_m,
            'opt_d' => $opt_d,
        );
    }

    public function get_time_opt(){

        $m_ar = array();
        for ($i = 0; $i < 12; $i++) {
        	$minu = $i * 5;
        	array_push($m_ar, str_pad($minu, 2, 0, STR_PAD_LEFT));
        }
        $opt_t = '';
        for ($i = 0; $i < 24; $i++) {
            $h = (strlen($i) == 1 )?'0'.$i: $i;
            foreach ($m_ar as $m) {
                $opt_t .= '<option value="'.$h.':'.$m.':00">'.$h.':'.$m.'</option>';
            }
        }

        return array(
            'opt_t' => $opt_t
        );
    }

    public function login($post){


        $mem = $this->common_logic->select_logic("select * from t_member where mail = ? and password = ?", array(
            $post['mail'],
            $this->common_logic->convert_password_encode($post['password']),
        ));
        $ty = 1;

        if($mem == null || $mem == ''){
            $mem = $this->common_logic->select_logic("select * from t_store_basic where mail = ? and password = ?", array(
                $post['mail'],
                $this->common_logic->convert_password_encode($post['password']),
            ));
            $ty = 2;
        }

        if($mem != null && $mem != ''){
            $_SESSION['jis'] = array();
            $_SESSION['jis']['login_member'] = $mem[0];
            unset($_SESSION['jis']['login_member']['password']);
            $_SESSION['jis']['ty'] = $ty;

            if($post['r'] != null && $post['r'] != ''){
            	header("Location: ../../search/reserve.php?trid=".$post['r'] . '&date=' . $post['d']);
                exit();
            }


            if($ty == 1){
                header("Location: ../../mypage_users/");
                exit();
            }elseif($ty == 2){
                header("Location: ../../mypage_agency/");
                exit();
            }



        }else{
            $ad = '';
            if($post['r']  != null && $post['r'] != ''){
            	$ad = '&r=' .$post['r']. '&d=' .$post['d'];

            }
            header("Location: ../../login.php?er=1" . $ad);
            exit();
        }

    }

    public function login_check($type = null, $trid=null, $date=null){

        if($_SESSION['jis']['ty'] == '1'){
            $mem = $this->common_logic->select_logic("select * from t_member where member_id = ? and mail = ? ", array(
                $_SESSION['jis']['login_member']['member_id'],
                $_SESSION['jis']['login_member']['mail'],
            ));
            $ty = 1;

        }elseif($_SESSION['jis']['ty'] == '2'){
            $mem = $this->common_logic->select_logic("select * from t_store_basic where store_basic_id = ? and mail = ?", array(
                $_SESSION['jis']['login_member']['store_basic_id'],
                $_SESSION['jis']['login_member']['mail'],
            ));
            $ty = 2;
        }


        if($mem != null && $mem != ''){
            $_SESSION['jis']['login_member'] = $mem[0];
            unset($_SESSION['jis']['login_member']['password']);
            $_SESSION['jis']['ty'] = $ty;


        }else{
            // 			header("Location:./../login.php?er=99&rd=" .$_SERVER['REQUEST_URI']);
            if($type == 'rsv'){
                header("Location:./../login.php?er=rsv&r=".$trid."&d=".$date);
                exit();
            }
            header("Location:./../login.php?er=99");
            exit();
        }
    }

    public function create_input_script($data, $option = array('radio' => "",'checkbox' => "",'ignor' => "")){
        $script = '';
        $radio = array_flip(explode(",",$option['radio']));
        $checkbox = array_flip(explode(",",$option['checkbox']));
        $file = array_flip(explode(",",$option['file']));
        $ignor = array_flip(explode(",",$option['ignor']));
        foreach ((array)$data as $name => $value) {
            if(($value == null || $value == '') && $value != 0)continue;
            if(array_key_exists($name, $ignor)){
                continue;
            }elseif(array_key_exists($name, $radio)){
                $script .= '$("[name='.$name.'][value=\''.$value.'\']").prop("checked", true);';
            }elseif(array_key_exists($name, $checkbox)){
                $script .= '$("[name='.$name.']").val(['.$value.']);';
            }elseif(array_key_exists($name, $file)){
                $img_ar = explode(",", $value);
                foreach ($img_ar as $im) {
                	if($im != null && $im != ''){
                		$script .= 'set_img_area("'.$option['fileOpt'][$name]['dir'].$im.'", '.$option['fileOpt'][$name]['jq_id'].');';
                	}
                }
            }else{
                $script .= '$("[name='.$name.']").val("'.$value.'");';
            }
        }

        return $script;
    }


    public function area_array(){
        return array(
            '1' => array(
                'jp' => '東京',
                'eng' => 'Tokyo',
                'tag' =>'red_tag',
            ),
            '2' => array(
                'jp' => '富士山',
                'eng' => 'Mt.FUJI',
                'tag' =>'orange_tag',
            ),
            '3' => array(
                'jp' => '北海道',
                'eng' => 'Hokkaido',
                'tag' =>'orange_tag',
            ),
            '4' => array(
                'jp' => '沖縄',
                'eng' => 'Okinawa',
                'tag' =>'paple_tag',
            ),
            '5' => array(
                'jp' => '大阪',
                'eng' => 'Osaka',
                'tag' =>'orange_tag',
            ),
            '6' => array(
                'jp' => '京都',
                'eng' => 'Kyoto',
                'tag' =>'orange_tag',
            ),
            '7' => array(
                'jp' => '広島',
                'eng' => 'Hiroshima',
                'tag' =>'orange_tag',
            ),
            '8' => array(
                'jp' => 'その他',
                'eng' => 'Other',
                'tag' =>'orange_tag',
            ),
        );
    }

    public function category_array(){
        return array(
            '2' => array(
                'jp' => '観光',
                'eng' => 'Sightseeing'
            ),
            '3' => array(
                'jp' => '体験',
                'eng' => 'Experience'
            ),
            '4' => array(
                'jp' => '温泉・スパ・ヒーリング',
                'eng' => 'Healing'
            ),
            '1' => array(
                'jp' => 'アニメ',
                'eng' => 'Anime'
            ),
            // 				'5' => array(
                // 						'jp' => 'レストラン',
                // 						'eng' => 'Restart'
                // 				),
        );
    }

    public function get_cate_child($dear_id = null ){
        if($dear_id != null){
            $wh = "dear_id = ? and";
            $param = array($dear_id);
        }else{
            $param = array();
        }
        $cate = $this->common_logic->select_logic("select * from t_category where ".$wh." del_flg = 0 and public_flg = 0 ", $param);
        foreach ((array)$cate as $ct) {
            $cate_chi = $this->common_logic->select_logic("select * from t_category where dear_id = ? and del_flg = 0 and public_flg = 0 ", array($ct['category_id']));
            if($cate_chi != null && $cate_chi != ''){
                $cate['child'] = $cate_chi;
            }
        }

        return $cate;
    }

    public function get_category_html($tmp){
        $html = '';
        $cate_oya = $this->common_logic->select_logic("select * from t_category where del_flg = 0 and public_flg = 0 and hierarchy = 0 order by create_at asc", array());
        foreach ((array)$cate_oya as $co) {

            $html .= str_replace(array("/###id###/","/###jp###/","/###eng###/"), array($co['category_id'],$co['category'],$co['category_eng']), $tmp);
            $cate_ko = $this->common_logic->select_logic("select * from t_category where dear_id = ?  and del_flg = 0 and public_flg = 0 order by create_at asc", array($co['category_id']));
            foreach ((array)$cate_ko as $ck) {

                $html .= str_replace(array("/###id###/","/###jp###/","/###eng###/"), array($ck['category_id'],$ck['category'],$ck['category_eng']), $tmp);
                $cate_mago = $this->common_logic->select_logic("select * from t_category where dear_id = ? and del_flg = 0 and public_flg = 0 order by create_at asc", array($ck['category_id']));
                foreach ((array)$cate_mago as $cm) {
                    $html .= str_replace(array("/###id###/","/###jp###/","/###eng###/"), array($cm['category_id'],$cm['category'],$cm['category_eng']), $tmp);
                }
            }
        }

        return $html;
    }

    public function create_ca_inp($ty, $ca, $je = 'eng'){
        if($ca == "a"){
            $data = $this->area_array();
            $name="area";
        }elseif($ca == "c"){
            $cate_d = $this->category_array();
            $name="category";

            $data = array();
            foreach ((array)$cate_d as $ca_id => $ca) {
                $data[$ca_id] = $ca;
                $ca_chi = $this->get_cate_child($ca_id);
                foreach ((array)$ca_chi as $cf => $cc) {
                    if($cf === 'child'){
                        foreach ((array)$cc as $ccc) {
                            $data[$ccc['category_id']]['jp'] = $ccc['category'];
                            $data[$ccc['category_id']]['eng'] = $ccc['category_eng'];
                        }
                    }else{
                        $data[$cc['category_id']]['jp'] = $cc['category'];
                        $data[$cc['category_id']]['eng'] = $cc['category_eng'];
                    }
                }
            }

        }

        if($ty == 'o'){
            $base = '<option value="/###value###/">/###str###/</option>';
        }elseif($ty == 'c'){
            $base = '<label><span class="formRBox"><input type="checkbox" name="/###name###/" value="/###value###/" class="validate" style="width: 15px; height: auto; display: inline;">/###str###/</span></label>';
        }

        foreach ($data as $id => $d){
            $re .= str_replace(array('/###value###/','/###str###/','/###name###/'), array($id, $d[$je], $name), $base);
        }

        return $re;
    }

    public function get_tour($tid, $trid_flg = false){
        if($trid_flg){
            $b = $this->common_logic->select_logic("select `tour_id` from t_tour_relation where tour_relation_id = ? ", array($tid));
            $tid = $b[0]['tour_id'];
        }
        $tour = $this->common_logic->select_logic("select * from t_tour where tour_id = ? ", array($tid));
        $tour_re = $this->common_logic->select_logic("select * from t_tour_relation where tour_id = ? ", array($tid));
        $tour_re_ex = array();
        foreach ((array)$tour_re as $tr) {
            $tour_re_ex[$tr['tour_relation_id']] = $this->common_logic->select_logic("select * from t_tour_relation_exception where tour_relation_id = ? ", array($tr['tour_relation_id']));
        }

        return array(
            'tour' => $tour[0],
            'tour_relation' => $tour_re,
            'tour_relation_exception' => $tour_re_ex,
        );
    }

    public function get_tour_id($tid){
        $tour = $this->common_logic->select_logic("select `tour_id` from t_tour where tour_id = ? ", array($tid));
        $tour_re = array();
        $tour_re_ar = $this->common_logic->select_logic("select `tour_relation_id` from t_tour_relation where tour_id = ? ", array($tid));
        $tour_re_ex = array();
        foreach ((array)$tour_re_ar as $tr) {
            $tour_re[$tr['tour_relation_id']] = true;
            $tour_re_ex_ar = $this->common_logic->select_logic("select `tour_relation_exception_id` from t_tour_relation_exception where tour_relation_id = ? ", array($tr['tour_relation_id']));
            $tour_re_ex[$tr['tour_relation_id']] = array();
            foreach ((array)$tour_re_ex_ar as $ter) {
                $tour_re_ex[$tr['tour_relation_id']][$ter['tour_relation_exception_id']] = true;
            }
        }

        return array(
            'tour' => array($tour[0]['tour_id'] => true),
            'tour_relation' => $tour_re,
            'tour_relation_exception' => $tour_re_ex,
        );
    }


    public function tour_relation_ex_ar_conv($tour_relation_ex){
        $tour_relation_ex_ar_conv = array();
        foreach ((array)$tour_relation_ex as $tre){
            $tour_relation_ex_ar_conv[$tre['exception_date']] = $tre;
        }
        return $tour_relation_ex_ar_conv;
    }


    public function get_store_basic($sbid){
        $store = $this->common_logic->select_logic("select * from t_store_basic where store_basic_id = ? and auth_flg = 1 and del_flg = 0 ", array($sbid));
        return $store[0];
    }



    public function get_reserve_detail($rid) {
        $reserve = $this->common_logic->select_logic("select * from t_reservation where reservation_id = ? ", array($rid));
        $bookin_number = $this->common_logic->zero_padding($reserve[0]['member_id'], 10) . "-" .$this->common_logic->zero_padding($reserve[0]['reservation_id'], 10);
        $tour = $this->get_tour($reserve[0]['tour_relation_id'], true);

        $reserve[0]['tour'] = $tour['tour'];
        $reserve[0]['bookin_number'] = $bookin_number;
        return $reserve[0];
    }

    public function get_tax() {
        $tax = $this->common_logic->select_logic("select * from m_code where code = 'tax' ", array());
        return (float)$tax[0]['description1'];
    }

    public function add_tax($price ) {
        $tax = $this->get_tax();
        return  $price  + ceil($price * $tax) ;
    }
    public function calc_discount($price ,$dicouint) {
        return ceil($price * (1- ($dicouint/100)));
    }

    public function cash_recent_view($tour_id){
        if(empty($_SESSION['jis'])) $_SESSION['jis'] = array();
        if(empty($_SESSION['jis']['recent'])) $_SESSION['jis']['recent'] = array();
        $new_flg= true;
        foreach ($_SESSION['jis']['recent'] as $k => $id) {
            if($id == $tour_id){
                array_splice($_SESSION['jis']['recent'], $k, 1);
                $_SESSION['jis']['recent'] = array_values($_SESSION['jis']['recent']);
                $new_flg = false;
                break;
            }
        }
        if($new_flg){
        	$tour = $this->common_logic->select_logic("select * from t_tour where tour_id = ? ", array($tour_id));
        	$store = $this->common_logic->select_logic("select * from t_store_basic where store_basic_id = ? ", array($tour[0]['store_basic_id']));
        	$this->common_logic->update_logic("t_store_basic", " where store_basic_id = ? ", array('browse_num'), array((int)$store[0]['browse_num'] + 1, $store[0]['store_basic_id']));
        }
        array_unshift($_SESSION['jis']['recent'], $tour_id);
    }




    public function create_pdf($post){
        $resevation = $this->common_logic->select_logic("select * from t_reservation where reservation_id = ? ", array($post['reservation_id']));
        $tour = $this->get_tour($resevation[0]['tour_relation_id']);

        $bookin_number = $this->common_logic->zero_padding($resevation[0]['member_id'], 10) . "-" .$this->common_logic->zero_padding($resevation[0]['reservation_id'], 10);

        //ヘッダーにはこれをお忘れなく。
        header('Access-Control-Allow-Origin: *');

        $canvas = $post["image"];

        $image_data = $dir.'/' .$filename;

//         $payment_way ='';
//         if($resevation[0]['payment_way'] != 1){
//             $payment_way = "Cash payment on site";
//         }else{
//             $payment_way = "Cash payment on site";
//         }




        $rsv = $this->get_reserve_detail($post['reservation_id']);

        if($rsv['men_num'] == null || $rsv['men_num'] == '' || $rsv['men_num'] == '0') $rsv['men_num'] = "0&ensp;&emsp;&thinsp;&zwnj;&zwj;&lrm;&rlm;";
        if($rsv['women_num'] == null || $rsv['women_num'] == '' || $rsv['women_num'] == '0') $rsv['women_num'] = "0&ensp;&emsp;&thinsp;&zwnj;&zwj;&lrm;&rlm;";
        if($rsv['children_num'] == null || $rsv['children_num'] == '' || $rsv['children_num'] == '0') $rsv['children_num'] = "0&ensp;&emsp;&thinsp;&zwnj;&zwj;&lrm;&rlm;";

        $a_price = number_format(( ($rsv['men_num'] + $rsv['women_num'])  * $rsv['adult_fee'] ));
        if($a_price == null || $a_price == '' || $a_price == '0')$a_price = "0&ensp;&emsp;&thinsp;&zwnj;&zwj;&lrm;&rlm;";
        $c_price = number_format(( ($rsv['children_num'] ) * $rsv['children_fee'] ));
        if($c_price == null || $c_price == '' || $c_price == '0')$c_price = "0&ensp;&emsp;&thinsp;&zwnj;&zwj;&lrm;&rlm;";


        $store = $this->common_logic->select_logic("select * from t_store_basic where store_basic_id = ? ", array($rsv['tour']['store_basic_id']));



        if(strpos($rsv['payment_way'], "1") !== false ){
        	$payment_way = 'Cash on site';
        }elseif(strpos($rsv['payment_way'], "3") !== false ){
        	$payment_way  = 'Credit card('.$rsv['tour']['card_choice'].')';
        }elseif(strpos($rsv['payment_way'], "2") !== false ){
        	$payment_way = 'Immediate payment by credit card';
        }

        list($lat,$lng) = explode("@", $rsv['tour']['schedule']);


        $map = '<div class="storeEditRow">
			<div class="storeEditCate">Access</div>
			<div class="storeEditForm">
<img src="https://maps.googleapis.com/maps/api/staticmap?center='.$lat.','.$lng.'&size=640x480&sensor=false&zoom=14&markers='.$lat.','.$lng.'&key=AIzaSyC50D68hnfmHwA2uN9fOTlRNbtA5IyxOzc">
			<div id="map" style="width: 100%; height: 500px"></div>
			<script>

			function initAutocomplete() {
		// 		var okayamaTheLegend = new google.maps.LatLng(34.666358, 133.918576);
				var icon = {
						icon: \'img/map-icon.png\',
					};

				var map = new google.maps.Map(document.getElementById(\'map\'), {
					center: {lat: 35.686773, lng: 139.68815},
					zoom: 16,
					mapTypeId: \'roadmap\',
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
				var input = document.getElementById(\'pac-input\');
				var searchBox = new google.maps.places.SearchBox(input);
				map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

				map.addListener(\'bounds_changed\', function() {
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
				searchBox.addListener(\'places_changed\', function() {
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


				$(\'#lat\').val(lat)
				$(\'#lng\').val(lng)
				var mark = drawMarkerCenterInit(map, pos)
					var latlng = lat + \'@\' + lng;
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

					$(\'#lat\').val(lat)
					$(\'#lng\').val(lng)

					var latlng = lat + \'@\' + lng;
					$("#schedule").val(latlng);

					mark.setPosition(pos);
					mark.setTitle(\'map center: \' + pos);
				} ) ;
			}

			function drawMarkerCenterInit(myMap,pos){

				var markerCenter = new google.maps.Marker({
					position: pos,
					map: myMap,
					size: new google.maps.Size(10, 10),
					title: \'map center:\' + pos, // アイコンのタイトル (中心の経緯度を設定)
		// 			icon:{url: \'img/map-icon.png\',scaledSize: new google.maps.Size(60, 60)
		// 			}, // アイコン画像を指定
			});

		    return markerCenter;
		}


		    </script>
				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC50D68hnfmHwA2uN9fOTlRNbtA5IyxOzc&libraries=places&callback=initAutocomplete" async defer></script>
				</div>
			</div>';


        $html = '
<html lang="ja"><head>
<meta charset="UTF-8">
<html lang="ja">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="./../assets/front/css/base.css" type="text/css" media="screen,print">
<link rel="stylesheet" href="./../assets/front/css/top-prts.css">
<link rel="stylesheet" href="./../assets/front/css/special-prts.css">
<link rel="stylesheet" href="./../assets/front/css/pc.css">
<link rel="stylesheet" href="./../assets/front/css/restaurant-top.css">
<link rel="stylesheet" href="./../assets/css/footer.css">
<link rel="stylesheet" href="./../assets/css/layout.css">
<link rel="stylesheet" href="./../assets/css/style.css">

</head>
<body style="width: 210mm ; heught:297mm;" >
	<div itemprop="articleBody" class="try__articleBody"style="width: 210mm ; heught:297mm;">
		<div id="">
			<div class="cf">
				<div class="container760" style="width: 210mm ; heught:297mm;">
					<section>
						<div class="prts__contents_19">
							<div class="cmsi__head">
								<h2 class="cmp__head__title jisTtlArea">Reservation</h2>
							</div>
							<div class="mypageTopNameBox">
							</div>
						</div>
					</section>
					<section>
						<h3 class="titleUnderline">Booking details</h3>
					</section>
					<section class="borderBox">
						<div class="storeEditIn">
							<br>

Booking ref:<br>
'.$rsv['order_id'].'<br>
Title:<br>
'. str_replace(array(" ","　", "【", "】") , array(" ", " ", "[", "]"), $rsv['tour_name']).'<br>
Date,Time:<br>
'. date("d/M/Y H:i", strtotime($rsv['come_date'])).'<br>
Operator:<br>
'. $store[0]['company_name_eng'].'<br>
Emergency contact:<br>
'. $store[0]['emergency_tel'].'<br>
Male:<br>
'. (String)$rsv['men_num'].'<br>
Female:<br>
'. (String)$rsv['women_num'].'<br>
Child:<br>
'. (String)$rsv['children_num'].'<br>
Adult fee(JPY):<br>
'. (String)$a_price.'<br>
Child fee(JPY):<br>
'. (String)$c_price.'<br>
Total fee(JPY):<br>
'. number_format($rsv['total']).'<br>
Payment method:<br>
'.$payment_way.'<br>
<br>
<br>
Activity meeting Point<br>
Please copy and paste the bellow address into Google Map.<br>
'.$rsv['tour']['meeting_place'].'<br>
<br>
<br>
Your Information.<br>
name:<br>
'. $rsv['name'].'<br>
Tel:<br>
'. $rsv['tel'].'<br>
<br><br>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</body>
</html>';

        // 		echo $html;exit();

        $fp = fopen ( __DIR__ . 'sample.html', 'wb' );
        if ($fp) {
            if (flock ( $fp, LOCK_EX )) {
                if (fwrite ( $fp, $html ) === FALSE) {
                } else {
                    // print($data.'をファイルに書き込みました');
                    // $aaa = '54654';
                    // $aaa = '54654';
                }
                flock ( $fp, LOCK_UN );
            }

            fclose ( $fp );
        }

        // mpdfライブラリ
        include(__DIR__." /../../mpdf60/mpdf.php");

        $mpdf = new mPDF('ja', "A4", 9, null, 0, 0, 10, 10);

        // 			// utf8でエラーが起こらないようにする
        // 			$mpdf->ignore_invalid_utf8 = true;
        // 			//css定義
        // 			$main_css  = file_get_contents(__DIR__ . '/../../assets/front/css/base.css');
        // 			$main_css .= file_get_contents(__DIR__ . '/../../assets/front/css/top-prts.css');
        // 			$main_css .= file_get_contents(__DIR__ . '/../../assets/front/css/special-prts.css');
        // 			$main_css .= file_get_contents(__DIR__ . '/../../assets/front/css/pc.css');
        // 			$main_css .= file_get_contents(__DIR__ . '/../../assets/front/css/restaurant-top.css');
        // 			$main_css .= file_get_contents(__DIR__ . '/../../assets/css/footer.css');
        // 			$main_css .= file_get_contents(__DIR__ . '/../../assets/css/layout.css');
        // 			$main_css .= file_get_contents(__DIR__ . '/../../assets/css/style.css');
        // 			$main_css = mb_convert_encoding($main_css, "UTF-8");
        // 			$mpdf->WriteHTML( $main_css, 1);
        // 			$mpdf->WriteHTML( $html, 2);

        file_put_contents(__DIR__ . '/sample.html', $html);

        $html_doc = new DOMDocument();
        libxml_use_internal_errors( true );
        $html_doc->loadHTMLFile(__DIR__ . '/sample.html');
        libxml_clear_errors();

        // PDFファイルにHTMLをセット
        $mpdf->WriteHTML( $html_doc->saveHTML());

        $mpdf->Output();
        exit();

        // PDFを出力
        // 			$mpdf->Output(__DIR__ . 'sample.pdf', 'F');
        header('Content-Type: application/force-download');
        header('Content-Length: '.filesize(__DIR__ . '/sample.pdf'));
        header('Content-Disposition: attachment; filename="'.__DIR__ . '/sample.pdf'.'"');
        readfile(__DIR__ . '/sample.pdf');

        // 			$_SESSION['out_file_name'] = $file_name.'.pdf';
        // 			$_SESSION['out_file_path'] = $return_dir.'/'.$file_name.'.pdf';


        return array(
            'status' => true,
            'pdf_file_name' => $_SESSION['out_file_name'],
            'return_dir' => $_SESSION['out_file_path'],
        );
    }


    public function get_review_point($store_basic_id){
    	$review = $this->common_logic->select_logic("
			SELECT
				SUM(`review_point`) as `sum`,
				COUNT(`review_id`) as `num`,
				COUNT(`reply` != '' or null) as `ans`
			FROM
				`t_review`
			WHERE
				`store_id` = ?
				AND `del_flg` = 0
				AND `public_flg` = 0
			", array($store_basic_id));

    	if($review[0]['num'] > 0) $av = $review[0]['sum'] / $review[0]['num'];
    	else $av = 0;
    	$star = str_repeat("★", round($av)) . str_repeat("☆",( 5 - round($av) ));

    	$html = '<dt class="disIB">
					<span class="detailStarArea">
					'.$star.'
				</span> <span class="searchKuchi2">
					<span class="fp10">'.number_format($review[0]['num']).' customer reviews | '.number_format($review[0]['ans']).' answer question</span>
					</span>
				</dt>';

    	return $html;


    }





}
