<?php
session_start();
require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/logic/common/common_logic.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/model/t_area_model.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/trynavi/logic/common/trynavi_common_logic.php';

$t_area_model = new t_area_model;
$trynavi_common_logic = new trynavi_common_logic();

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
		"search",
		"drink",
)
;
$dir_name_array = explode('/', $dir_name);
for ($j = 0; $j < count( $dir_name_array ); $j++) {
	for($i = 0; $i < count ( $dir_array ); $i ++) {
		if ($dir_name_array[$j] == $dir_array [$i]) {
			$path = "../";
			break;
		}
	}
}



//エリア生成
if($_SESSION['area_data_all'] != null && $_SESSION['area_data_all'] != ''){
	$area_data_all = $_SESSION['area_data_all'];
}else{
	$_SESSION['area_data_all'] = $t_area_model->get_area_list_all(true);
	$area_data_all = $_SESSION['area_data_all'];
}

$opt_array = array();
$area_chk = '';

function create_opt($data, $hierarchy, $dear_id){
	foreach ($data as $l_v){
		if($l_v['hierarchy'] == $hierarchy && $l_v['dear_id'] == $dear_id){
			if($hierarchy == 1){
				$area_chk .= '
						<li class="dropTtl">'.$l_v['name'].'</li>
						<li class="wid30">
									<ul>';
				$area_chk .= create_opt($data, $hierarchy+1, $l_v['area_id']);
			}else{
				$area_chk .= '			<li><a href="' . $path . 'search/" class="dropIn">'.$l_v['name'].'</a></li>';
				// 				$area_chk .= create_opt($data, $hierarchy+1, $l_v['area_id']);
			}
		}
	}
	return $area_chk . '</ul>';
}

if(isset($area_data_all)){
	foreach ($_SESSION['area_data_all'] as $row2) {
		if($row2['hierarchy'] == 0){
			// 			$area_chk .= '<option value="'.$row2['area_id'].'" hi="'.$row2['hierarchy'].'">'.$row2['name'].'</option>';
			$area_chk .= create_opt($area_data_all, 1, $row2['area_id']);
		}
	}

}

$area_ls = '<ul class="hoverBox navArea">
						<li>
							<ul class="wid60">
								'.$area_chk.'
							</ul>
						</li>
					</ul>';


$genre_array = $trynavi_common_logic->select_cuisine_genre();
$bef = 0;
$genre_html .='<ul class="wid20">
					<li class="dropTtl">ジャンル</li>';
$cf_2 = true;
$cf_3 = true;
$cf_4 = true;
$cf_5 = true;
foreach ($genre_array as $cg_id => $cg_v) {
	if($cg_v['sub'] != 1){
		if($cg_v['sub'] == 2){
			if($cf_2){
				$cf_2 = false;
				$genre_html .='</ul><ul class="wid20">';
				$genre_html .='<li class="dropTtl">人気の和食料理</li>';
			}
		}elseif($cg_v['sub'] == 3){
			if($cf_3){
				$cf_3 = false;
				$genre_html .='</ul><ul class="wid20">';
				$genre_html .='<li class="dropTtl">人気の洋食料理</li>';
			}
		}elseif($cg_v['sub'] == 4){
			if($cf_4){
				$cf_4 = false;
				$genre_html .='</ul><ul class="wid20">';
				$genre_html .='<li class="dropTtl">バー</li>';
			}
		}elseif($cg_v['sub'] == 5){
			if($cf_5){
				$cf_5 = false;
				$genre_html .='</ul><ul class="wid20">';
				$genre_html .='<li class="dropTtl">クラブ</li>';
			}
		}
	}

	if($cg_v['sub'] <= 5 ){
		$genre_html .='<li><a href="' . $path . 'search/?g_id='.$cg_id.'" class="dropIn">'.$cg_v['name'].'</a></li>';
	}

}
$genre_html .='</ul>';


$_SESSION['try_path'] = $path;

//ヘッダーログインリンク変数初期化
$login_link_html ='<a href="'.$path.'mypage/login.php">ログイン</a>';

//ヘッダーユーザー情報変数初期化
$login_member_html = '';

//ログイン状態取得
$login_result = $trynavi_common_logic->chk_login_status();

$_SESSION['try_login_status'] = $login_result;

$mypage_path_html = 'mypage';
if ($_SESSION ['try_login_member_data']['store_basic_id'] != null && $_SESSION ['try_login_member_data']['store_basic_id'] != '') {
	$mypage_path_html = 'mypage_store';
}


// ログイン判定
if ($login_result) {
	$login_link_html ='<a href="javascript:void(0)" class="logout_btn">ログアウト</a>';
	$login_member_html = '
				<li class="try__login-name">こんにちは、<span>'.$_SESSION ['try_login_member_data']['name'].'</span>さん
				</li>
				<li class="try__login-list">
					<p class="try__login-btn">
						<a href="' . $path . $mypage_path_html . '/">
							<i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;マイページ
						</a>
					</p>
				</li>';
}else{

	$login_member_html = '
				<li class="try__login-name">こんにちは、<span>ゲスト</span>さん
				</li>
				<li class="try__login-list">
					<p class="try__login-btn">
						<a href="' . $path . $mypage_path_html . '/">
							<i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;マイページ
						</a>
					</p>
				</li>';
}

print '

<link href="https://fonts.googleapis.com/earlyaccess/sawarabimincho.css" rel="stylesheet" />
<link rel="stylesheet" href="'.$path.'assets/front/css/slick.css" />
<script src="'.$path.'assets/front/js/slick.min.js"></script>
<script>
$(function() {
	$(".slick-box").slick({
		arrows:false,
		variableWidth: true,
		infinite:false,

	});
});
</script>

<script>
	$(function(){
		$(".logout_btn").on("click",function(){
			ret = confirm("ログアウトします。よろしいですか？");
			if (ret == true){
				$.ajax({
					type : "POST",
					url : "'.$path.'controller/front/login_ct.php",//コントローラURLを取得
					dataType: "json",
					data: {
						"method" : "logout",//コントローラ内での処理判断用
					},
				}).done(function(result, datatype){
					alert("ログアウトしました。\r\nTOPページへ移動します。");
					location.href = "'.$path.'";
				}).fail(function(XMLHttpRequest, textStatus, errorThrown) {
					//異常終了時
				});
			}
		});
	});
</script>

<div class="hidden-xs">
	<div class="try__header-line-wrap">
		<div class="try__header-line">
			<ul class="try__header-line-list">
				<li><a href="' . $path . 'ad/">初めての方</a></li>
				<li><a href="' . $path . 'mypage/conf.php">登録変更・退会</a></li>
				<li><a href="' . $path . 'contact/help.php">ヘルプ・お問い合わせ</a></li>
				<li>'.$login_link_html.'</li>
			</ul>
		</div>
	</div>
	<div class="try__header-ttl-wrap">
		<div class="try__header-ttl cf">
			<p class="try__header-ttl-logo">
				<a href="' . $path . 'index.php">
					<img alt="" src="' . $path . 'assets/front/img/top_logo.png">
				</a>
			</p>
			<ul class="try__header-ttl-link">
				'.$login_member_html.'
			</ul>
		</div>
	</div>
	<div class="menuBorder">
		<div class="try__menu-wrap">


			<ul class="try__menu" id="fade-in">
				<li class=""><a href="' . $path . 'index.php" class="try__menu-current1">
						<img src="' . $path . 'assets/front/img/header_name.png" alt="TRYNAVI TOKYO">
					</a>
				</li>
				<li><a href="' . $path . 'lunch/" class="try__menu-current">
						<span class="navTxt1 ffMintyo">ランチ</span>
					</a>
					<ul class="hoverBox navLunch">
						<li>
							<ul class="wid20">
								<li class="dropTtl">人気キーワード</li>
								<li><a href="' . $path . 'search/?t=0&c_n=13" class="dropIn">テラス</a></li>
								<li><a href="' . $path . 'search/?t=0&p_n=10" class="dropIn">個室</a></li>
								<li><a href="' . $path . 'search/?t=0&p_n=6" class="dropIn">高層階</a></li>
								<li><a href="' . $path . 'search/?t=0&p_n=11" class="dropIn">ホテル</a></li>
								<li><a href="' . $path . 'search/?t=0&p_n=4" class="dropIn">一軒家</a></li>
								<li><a href="' . $path . 'search/?t=0&p_n=7" class="dropIn">有名シェフ</a></li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">エリア</li>
								<li class="wid50">
									<ul>
										<li><a href="' . $path . 'search/?t=0&ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=5" class="dropIn">赤坂・虎ノ門</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=6" class="dropIn">六本木・麻布十番</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=7" class="dropIn">渋谷・原宿</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=8" class="dropIn">青山・表参道</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=10" class="dropIn">代官山・中目黒</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=11" class="dropIn">汐留・新橋</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=12" class="dropIn">お台場</a></li>
									</ul>
								</li>
								<li class="wid50">
									<ul>
										<li><a href="' . $path . 'search/?t=0&ar=13" class="dropIn">新宿</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=15" class="dropIn">四谷・市ヶ谷</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=19" class="dropIn">池袋</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=20" class="dropIn">品川・天王洲</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=34" class="dropIn">横浜・みなとみらい</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=41" class="dropIn">舞浜・浦安</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=42" class="dropIn">幕張</a></li>
										<li><a href="' . $path . 'search/?t=0&ar=43" class="dropIn">千葉市</a></li>
										<li><a href="' . $path . 'search/?t=0" class="dropIn">全エリアを見る</a></li>
									</ul>
								</li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">トライナビサービス</li>
								<li>
									<div class="c__layout-table-btn">
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=0&p_t=2">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/lunch_top_img1.jpg" alt="" width="212">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">プラチナランチ</p>
														</div>
													</a>
												</div>
											</div>
										</div>
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=0&p_t=1">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/lunch_top_img3.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">ゴールドランチ</p>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li><a href="' . $path . 'dinner/" class="try__menu-current">
						<span class="navTxt1 ffMintyo">ディナー</span>
					</a>
					<ul class="hoverBox navDinner">
						<li>
							<ul class="wid20">
								<li class="dropTtl">人気キーワード</li>
								<li><a href="' . $path . 'search/?t=1&p_n=1" class="dropIn">夜景</a></li>
								<li><a href="' . $path . 'search/?t=1&p_n=10" class="dropIn">個室</a></li>
								<li><a href="' . $path . 'search/?t=1&p_n=6" class="dropIn">高層階</a></li>
								<li><a href="' . $path . 'search/?t=1&p_n=11" class="dropIn">ホテル</a></li>
								<li><a href="' . $path . 'search/?t=1&p_n=4" class="dropIn">一軒家</a></li>
								<li><a href="' . $path . 'search/?t=1&p_n=7" class="dropIn">有名シェフ</a></li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">エリア</li>
								<li class="wid50">
									<ul>
										<li><a href="' . $path . 'search/?t=1&ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=5" class="dropIn">赤坂・虎ノ門</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=6" class="dropIn">六本木・麻布十番</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=7" class="dropIn">渋谷・原宿</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=8" class="dropIn">青山・表参道</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=10" class="dropIn">代官山・中目黒</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=11" class="dropIn">汐留・新橋</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=12" class="dropIn">お台場</a></li>
									</ul>
								</li>
								<li class="wid50">
									<ul>
										<li><a href="' . $path . 'search/?t=1&ar=13" class="dropIn">新宿</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=15" class="dropIn">四谷・市ヶ谷</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=19" class="dropIn">池袋</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=20" class="dropIn">品川・天王洲</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=34" class="dropIn">横浜・みなとみらい</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=41" class="dropIn">舞浜・浦安</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=42" class="dropIn">幕張</a></li>
										<li><a href="' . $path . 'search/?t=1&ar=43" class="dropIn">千葉市</a></li>
										<li><a href="' . $path . 'search/?t=1" class="dropIn">全エリアを見る</a></li>
									</ul>
								</li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">トライナビサービス</li>
								<li>
									<div class="c__layout-table-btn">
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=1&p_t=2">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/dinner_top_img1.jpg" alt="" width="212">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">プラチナディナー</p>
														</div>
													</a>
												</div>
											</div>
										</div>
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=1&p_t=1">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/dinner_top_img3.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">ゴールドディナー</p>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
								</li>

							</ul>
						</li>
					</ul>
				</li>
				<li><a href="' . $path . 'drink/" class="try__menu-current">
						<span class="navTxt1 ffMintyo">フリードリンク</span>
					</a>
					<ul class="hoverBox navNomi">
						<li>
							<ul class="wid20">
								<li class="dropTtl">人気キーワード</li>
								<li><a href="' . $path . 'search/?t=0&p_n=1" class="dropIn">ランチ</a></li>
								<li><a href="' . $path . 'search/?t=1&p_n=1" class="dropIn">ディナー</a></li>
								<li><a href="' . $path . 'search/?t=2&p_n=1" class="dropIn">バー</a></li>
								<li><a href="' . $path . 'search/?t=3&p_n=1" class="dropIn">クラブ</a></li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">エリア</li>
								<li class="wid50">
									<ul>
										<li><a href="' . $path . 'search/?t=4&ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=5" class="dropIn">赤坂・虎ノ門</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=6" class="dropIn">六本木・麻布十番</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=7" class="dropIn">渋谷・原宿</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=8" class="dropIn">青山・表参道</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=10" class="dropIn">代官山・中目黒</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=11" class="dropIn">汐留・新橋</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=12" class="dropIn">お台場</a></li>
									</ul>
								</li>
								<li class="wid50">
									<ul>
										<li><a href="' . $path . 'search/?t=4&ar=13" class="dropIn">新宿</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=15" class="dropIn">四谷・市ヶ谷</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=19" class="dropIn">池袋</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=20" class="dropIn">品川・天王洲</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=34" class="dropIn">横浜・みなとみらい</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=41" class="dropIn">舞浜・浦安</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=42" class="dropIn">幕張</a></li>
										<li><a href="' . $path . 'search/?t=4&ar=43" class="dropIn">千葉市</a></li>
										<li><a href="' . $path . 'search/?t=4" class="dropIn">全エリアを見る</a></li>
									</ul>
								</li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">トライナビサービス</li>
								<li>
									<div class="c__layout-table-btn">
										<!--<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=4&p_t=2">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/bar_top_img1.jpg" alt="" width="212">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">プラチナセット</p>
														</div>
													</a>
												</div>
											</div>
										</div>-->
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=4&p_t=2">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/bar_top_img2.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">プラチナフリードリンク</p>
														</div>
													</a>
												</div>
											</div>
										</div>
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=4&p_t=1">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/bar_top_img3.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">ゴールドフリードリンク</p>
														</div>
													</a>
												</div>
											</div>
										</div>
																	</div>
								</li>
								<li>
									<div class="c__layout-table-btn">
										<!--<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="#">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/bar_top_img4.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">ゴールドサービス</p>
														</div>
													</a>
												</div>
											</div>
										</div>-->
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li><a href="' . $path . 'bar/" class="try__menu-current">
						<span class="navTxt1 ffMintyo">バー</span>
					</a>
					<ul class="hoverBox navBar">
						<li>
							<ul class="wid20">
								<li class="dropTtl">人気キーワード</li>
								<li><a href="' . $path . 'search/?t=2&p_n=5" class="dropIn">隠れ家</a></li>
								<li><a href="' . $path . 'search/?t=2&p_n=14" class="dropIn">カウンター</a></li>
								<li><a href="' . $path . 'search/?t=2&p_n=15" class="dropIn">お一人様</a></li>
								<li><a href="' . $path . 'search/?t=2&p_n=16" class="dropIn">モルトウィスキー</a></li>
								<li><a href="' . $path . 'search/?t=2&p_n=17" class="dropIn">有名店</a></li>
								<li><a href="' . $path . 'search/?t=2&p_n=18" class="dropIn">朝までオープン</a></li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">エリア</li>
								<li class="wid50">
									<ul>
										<li><a href="' . $path . 'search/?t=2&ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=5" class="dropIn">赤坂・虎ノ門</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=6" class="dropIn">六本木・麻布十番</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=7" class="dropIn">渋谷・原宿</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=8" class="dropIn">青山・表参道</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=10" class="dropIn">代官山・中目黒</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=11" class="dropIn">汐留・新橋</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=12" class="dropIn">お台場</a></li>
									</ul>
								</li>
								<li class="wid50">
									<ul>
										<li><a href="' . $path . 'search/?t=2&ar=13" class="dropIn">新宿</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=15" class="dropIn">四谷・市ヶ谷</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=19" class="dropIn">池袋</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=20" class="dropIn">品川・天王洲</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=34" class="dropIn">横浜・みなとみらい</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=41" class="dropIn">舞浜・浦安</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=42" class="dropIn">幕張</a></li>
										<li><a href="' . $path . 'search/?t=2&ar=43" class="dropIn">千葉市</a></li>
										<li><a href="' . $path . 'search/?t=2" class="dropIn">全エリアを見る</a></li>
									</ul>
								</li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">トライナビサービス</li>
								<li>
									<div class="c__layout-table-btn">
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?p_t=2&t=2">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/bar_top_img1.jpg" alt="" width="212">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">プラチナセット</p>
														</div>
													</a>
												</div>
											</div>
										</div>
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?p_t=1&t=2">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/bar_top_img4.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">ゴールドセット</p>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
								</li>

							</ul>

							<!--<ul class="wid20">
								<li class="dropTtl">ジャンル</li>
								<li><a href="' . $path . 'search/?t=2&g_id=25 class="dropIn">オーセンティックバー</a></li>
								<li><a href="' . $path . 'search/?t=2&g_id=26" class="dropIn">ショットバー</a></li>
								<li><a href="' . $path . 'search/?t=2&g_id=27" class="dropIn">スタンディングバー</a></li>
								<li><a href="' . $path . 'search/?t=2&g_id=28" class="dropIn">ミュージックバー</a></li>
								<li><a href="' . $path . 'search/?t=2&g_id=29" class="dropIn">アミューズメントバー</a></li>
								<li><a href="' . $path . 'search/?t=2&g_id=30" class="dropIn">特定酒バー</a></li>
							</ul>-->
						</li>
					</ul>
				</li>
				<li><a href="' . $path . 'club/" class="try__menu-current">
						<span class="navTxt1 ffMintyo">クラブ</span>
					</a>
					<ul class="hoverBox navClub">
						<li>
							<ul class="wid20">
								<li class="dropTtl">人気キーワード</li>
								<li><a href="' . $path . 'search/?t=3&p_n=19" class="dropIn">カラオケ</a></li>
								<li><a href="' . $path . 'search/?t=3&p_n=20" class="dropIn">ピアノ</a></li>
								<li><a href="' . $path . 'search/?t=3&p_n=21" class="dropIn">会員制</a></li>
								<li><a href="' . $path . 'search/?t=3&p_n=14" class="dropIn">カウンター</a></li>
								<li><a href="' . $path . 'search/?t=3&p_n=23" class="dropIn">ボックス</a></li>
								<li><a href="' . $path . 'search/?t=3&p_n=23" class="dropIn">有名ママ</a></li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">エリア</li>
								<li class="wid50">
									<ul>
										<li><a href="' . $path . 'search/?t=3&ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=5" class="dropIn">赤坂・虎ノ門</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=6" class="dropIn">六本木・麻布十番</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=7" class="dropIn">渋谷・原宿</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=8" class="dropIn">青山・表参道</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=10" class="dropIn">代官山・中目黒</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=11" class="dropIn">汐留・新橋</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=12" class="dropIn">お台場</a></li>
									</ul>
								</li>
								<li class="wid50">
									<ul>
										<li><a href="' . $path . 'search/?t=3&ar=13" class="dropIn">新宿</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=15" class="dropIn">四谷・市ヶ谷</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=19" class="dropIn">池袋</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=20" class="dropIn">品川・天王洲</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=34" class="dropIn">横浜・みなとみらい</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=41" class="dropIn">舞浜・浦安</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=42" class="dropIn">幕張</a></li>
										<li><a href="' . $path . 'search/?t=3&ar=43" class="dropIn">千葉市</a></li>
										<li><a href="' . $path . 'search/?t=3" class="dropIn">全エリアを見る</a></li>
									</ul>
								</li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">トライナビサービス</li>
								<li>
									<div class="c__layout-table-btn">
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?p_t=2&t=3">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/bar_top_img1.jpg" alt="" width="212">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">プラチナサービス</p>
														</div>
													</a>
												</div>
											</div>
										</div>
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?p_t=1&t=3">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/bar_top_img4.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">ゴールドサービス</p>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
								</li>

							</ul>

							<!--<ul class="wid20">
								<li class="dropTtl">在籍人数</li>
								<li><a href="' . $path . 'search/?t=3&e6=0" class="dropIn">1～5名</a></li>
								<li><a href="' . $path . 'search/?t=3&e6=1" class="dropIn">6～10名</a></li>
								<li><a href="' . $path . 'search/?t=3&e6=2" class="dropIn">11～30名</a></li>
								<li><a href="' . $path . 'search/?t=3&e6=3" class="dropIn">31～50名</a></li>
								<li><a href="' . $path . 'search/?t=3&e6=4" class="dropIn">51名～</a></li>
							</ul>
							<ul class="wid20">
								<li class="dropTtl">平均年齢</li>
								<li><a href="' . $path . 'search/?t=3&e7=0" class="dropIn">18～22歳</a></li>
								<li><a href="' . $path . 'search/?t=3&e7=1" class="dropIn">23～27歳</a></li>
								<li><a href="' . $path . 'search/?t=3&e7=2" class="dropIn">28～32歳</a></li>
								<li><a href="' . $path . 'search/?t=3&e7=3" class="dropIn">33～37歳</a></li>
								<li><a href="' . $path . 'search/?t=3&e7=4" class="dropIn">38歳～</a></li>
							</ul>-->

						</li>
					</ul>
				</li>
				<li><span class="navTxt1 ffMintyo">エリア</span>

					<ul class="hoverBox navArea">
						<li>
							<ul class="wid60">
								<li class="dropTtl">東京</li>
								<li class="wid30">
									<ul>
										<li><a href="' . $path . 'search/?ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
										<li><a href="' . $path . 'search/?ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
										<li><a href="' . $path . 'search/?ar=5" class="dropIn">赤坂・虎ノ門</a></li>
										<li><a href="' . $path . 'search/?ar=6" class="dropIn">六本木・麻布十番</a></li>
										<li><a href="' . $path . 'search/?ar=7" class="dropIn">渋谷・原宿</a></li>
										<li><a href="' . $path . 'search/?ar=8" class="dropIn">青山・表参道</a></li>
										<li><a href="' . $path . 'search/?ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
										<li><a href="' . $path . 'search/?ar=10" class="dropIn">代官山・中目黒</a></li>
										<li><a href="' . $path . 'search/?ar=11" class="dropIn">汐留・新橋</a></li>
										<li><a href="' . $path . 'search/?ar=12" class="dropIn">お台場</a></li>
									</ul>
								</li>
								<li class="wid30">
									<ul>
										<li><a href="' . $path . 'search/?ar=13" class="dropIn">新宿</a></li>
										<li><a href="' . $path . 'search/?ar=14" class="dropIn">飯田橋・神楽坂</a></li>
										<li><a href="' . $path . 'search/?ar=15" class="dropIn">四ツ谷・市ヶ谷</a></li>
										<li><a href="' . $path . 'search/?ar=16" class="dropIn">高田馬場・早稲田</a></li>
										<li><a href="' . $path . 'search/?ar=17" class="dropIn">神田・秋葉原</a></li>
										<li><a href="' . $path . 'search/?ar=18" class="dropIn">御茶ノ水・水道橋</a></li>
										<li><a href="' . $path . 'search/?ar=19" class="dropIn">池袋・目白</a></li>
										<li><a href="' . $path . 'search/?ar=20" class="dropIn">品川・天王洲</a></li>
										<li><a href="' . $path . 'search/?ar=21" class="dropIn">目黒</a></li>
										<li><a href="' . $path . 'search/?ar=22" class="dropIn">五反田・大崎</a></li>
									</ul>
								</li>
								<li class="wid30">
									<ul>
										<li><a href="' . $path . 'search/?ar=23" class="dropIn">二子玉川</a></li>
										<li><a href="' . $path . 'search/?ar=24" class="dropIn">下北沢・三軒茶屋</a></li>
										<li><a href="' . $path . 'search/?ar=25" class="dropIn">吉祥寺・三鷹</a></li>
										<li><a href="' . $path . 'search/?ar=26" class="dropIn">中野・高円寺</a></li>
										<li><a href="' . $path . 'search/?ar=27" class="dropIn">自由が丘</a></li>
										<li><a href="' . $path . 'search/?ar=28" class="dropIn">上野・浅草</a></li>
										<li><a href="' . $path . 'search/?ar=29" class="dropIn">築地・門前仲町</a></li>
										<li><a href="' . $path . 'search/?ar=30" class="dropIn">押上・両国・錦糸町</a></li>
										<li><a href="' . $path . 'search/?ar=31" class="dropIn">東陽町</a></li>
										<li><a href="' . $path . 'search/?ar=32" class="dropIn">葛西</a></li>
									</ul>
								</li>
							</ul>
							<ul class="wid20">
								<li class="dropTtl">神奈川・千葉・埼玉</li>
								<li><a href="' . $path . 'search/?ar=34" class="dropIn">横浜・みなとみらい</a></li>
								<li><a href="' . $path . 'search/?ar=35" class="dropIn">新横浜</a></li>
								<li><a href="' . $path . 'search/?ar=36" class="dropIn">たまプラーザ</a></li>
								<li><a href="' . $path . 'search/?ar=37" class="dropIn">湘南・鎌倉</a></li>
								<li><a href="' . $path . 'search/?ar=38" class="dropIn">川崎</a></li>
								<li><a href="' . $path . 'search/?ar=40" class="dropIn">新浦安</a></li>
								<li><a href="' . $path . 'search/?ar=41" class="dropIn">舞浜・浦安</a></li>
								<li><a href="' . $path . 'search/?ar=42" class="dropIn">幕張</a></li>
								<li><a href="' . $path . 'search/?ar=43" class="dropIn">千葉市</a></li>
								<li><a href="' . $path . 'search/?ar=45" class="dropIn">浦和・大宮</a></li>
							</ul>
							<!--
							<ul class="wid20">
								<li class="dropTtl">人気のエリア</li>
								<li><a href="' . $path . 'search/?ar=46" class="dropIn">丸ビル</a></li>
								<li><a href="' . $path . 'search/?ar=47" class="dropIn">新丸ビル</a></li>
								<li><a href="' . $path . 'search/?ar=48" class="dropIn">銀座三越</a></li>
								<li><a href="' . $path . 'search/?ar=49" class="dropIn">マロニエゲート</a></li>
								<li><a href="' . $path . 'search/?ar=50" class="dropIn">六本木ヒルズ</a></li>
								<li><a href="' . $path . 'search/?ar=51" class="dropIn">東京ミッドタウン</a></li>
								<li><a href="' . $path . 'search/?ar=52" class="dropIn">東京スカイツリータウン (R)</a></li>
								<li><a href="' . $path . 'search/?ar=53" class="dropIn">渋谷ヒカリエ</a></li>
								<li><a href="' . $path . 'search/?ar=54" class="dropIn">サンシャインシティ</a></li>
								<li><a href="' . $path . 'search/?ar=55" class="dropIn">虎ノ門ヒルズ</a></li>
								<li><a href="' . $path . 'search/?ar=56" class="dropIn">ディズニー周辺</a></li>
							</ul>
							-->
						</li>
					</ul>
				</li>

				<li><span class="navTxt1 ffMintyo">ジャンル</span>
					<ul class="hoverBox navGenre">
						<li>
							'.$genre_html.'
							<!--
							<ul class="wid40">
								<li class="dropTtl">トライナビサービス</li>
								<li>
									<div class="c__layout-table-btn">
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=0">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/top_img1.jpg" alt="" width="212">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">ランチ</p>
														</div>
													</a>
												</div>
											</div>
										</div>
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=1">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/top_img2.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">ディナー</p>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="c__layout-table-btn">
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=2">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/top_img3.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">バー</p>
														</div>
													</a>
												</div>
											</div>
										</div>
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=3">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/top_img4.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">クラブ</p>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
							-->
						</li>
					</ul>
				</li>

				<li><span class="navTxt1 ffMintyo">キーワード</span>
					<ul class="hoverBox navKeyword">
						<li>
							<ul class="wid20">
								<li class="dropTtl">シーン</li>
								<li><a href="' . $path . 'search/?s_n=10" class="dropIn">記念日・誕生日</a></li>
								<li><a href="' . $path . 'search/?s_n=9" class="dropIn">女子会</a></li>
								<li><a href="' . $path . 'search/?s_n=8" class="dropIn">デート</a></li>
								<li><a href="' . $path . 'search/?s_n=7" class="dropIn">プロポーズ</a></li>
								<li><a href="' . $path . 'search/?s_n=6" class="dropIn">接待・会合</a></li>
								<li><a href="' . $path . 'search/?s_n=5" class="dropIn">合コン</a></li>
								<li><a href="' . $path . 'search/?s_n=4" class="dropIn">歓送迎会</a></li>
								<li><a href="' . $path . 'search/?s_n=2" class="dropIn">二次会</a></li>
							</ul>
							<ul class="wid20">
								<li class="dropTtl">人気キーワード</li>
								<li><a href="' . $path . 'search/?c_n=1" class="dropIn">夜景</a></li>
								<li><a href="' . $path . 'search/?c_n=6" class="dropIn">個室</a></li>
								<li><a href="' . $path . 'search/?c_n=10" class="dropIn">高層階</a></li>
								<li><a href="' . $path . 'search/?c_n=11" class="dropIn">ホテル</a></li>
								<li><a href="' . $path . 'search/?c_n=4" class="dropIn">一軒家</a></li>
								<li><a href="' . $path . 'search/?c_n=7" class="dropIn">有名シェフ</a></li>
								<li><a href="' . $path . 'search/?c_n=19" class="dropIn">カラオケ</a></li>
								<li><a href="' . $path . 'search/?c_n=23" class="dropIn">有名ママ</a></li>
							</ul>
							<ul class="wid20">
								<li class="dropTtl">年間ランキング</li>
								<li><a href="' . $path . 'search/ranking.php?t_z=0" class="dropIn">ランチ</a></li>
								<li><a href="' . $path . 'search/ranking.php?t_z=1" class="dropIn">ディナー</a></li>
								<li><a href="' . $path . 'search/ranking.php?t_z=4" class="dropIn">フリードリンク</a></li>
								<li><a href="' . $path . 'search/ranking.php?t_z=2" class="dropIn">バー</a></li>
								<li><a href="' . $path . 'search/ranking.php?t_z=3" class="dropIn">クラブ</a></li>
							</ul>
							<ul class="wid40">
								<li class="dropTtl">トライナビサービス</li>
								<li>
									<div class="c__layout-table-btn">
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=0">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/top_img1.jpg" alt="" width="212">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">ランチ</p>
														</div>
													</a>
												</div>
											</div>
										</div>
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=1">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/top_img2.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">ディナー</p>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li>
									<div class="c__layout-table-btn">
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=2">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/top_img3.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">バー</p>
														</div>
													</a>
												</div>
											</div>
										</div>
										<div class="cmm__table-cell">
											<div class="c__btn-balancer">
												<div class="cmsi__panel-link">
													<a href="' . $path . 'search/?t=3">
														<div class="cmp__listtxt-ph">
															<img src="' . $path . 'assets/front/img/top_img4.jpg" alt="">
														</div>
														<div class="c__txt-box">
															<p class="cmp__listtxt-txt">クラブ</p>
														</div>
													</a>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>

		</div>
	</div>
</div>

<script>
$(function() {
	$(window).on("load", function(){
		if(location.hash == "#shin"){
			$("html, body").animate({scrollTop : $(".shin").offset().top - 70});
		}
	});
	//SP用ヘッダー
	$(".spmenu_btn").on("click", function() {
		//$(this).next().slideToggle();
		$(this).toggleClass("active");

	    //パネルをアニメーションでトグル出来るようにする
	    $(".spmenu").animate({width: "toggle"}, 300);
		$("body,html").toggleClass("fixed");
	});
	$(".spmenu_btn2").on("click", function() {

		$(".spmenu_btn").toggleClass("active");

	    //パネルをアニメーションでトグル出来るようにする
	    $(".spmenu").animate({width: "toggle"}, 300);
		$("body,html").toggleClass("fixed");
	});

	  // 親メニュー処理
	  $(".spmenu2").click(function() {
	    // メニュー表示/非表示
	    $(this).next("ul").slideToggle("fast");
	  });

	  // 子メニュー処理
	  $("li").click(function(e) {
	    // メニュー表示/非表示
	    $(this).children("ul").slideToggle("fast");
	    e.stopPropagation();
	  });

});
</script>

<header class="visible-xs headerSp">
	<div class="headerLogoSp" style="float:left"><a href="'.$path.'index.php"><img alt="トライナビ" src="'.$path.'assets/front/img/top_logo2.png"></a></div>
	<div class="spHeadBtnBox">
		<div class="spHeadBtn"><a href="'.$path.'search"><img alt="検索" src="'.$path.'assets/front/img/sp_search.png"></a></div>
		<div class="spHeadBtn"><a href="'.$path.$mypage_path_html .'"><img alt="マイページ" src="'.$path.'assets/front/img/sp_mypage.png"></a></div>
	</div>




    <span class="spmenu_btn">
		<img alt="MENU" src="'.$path.'assets/front/img/sp_menu.png">
	</span>
    <div class="spmenu">
        <nav>
            <ul>
                <li class="list_ab2 spmenu_btn2">
                    <i class="fa fa-window-close-o" aria-hidden="true"></i> Close
                </li>
                <li class="list_ab">
                    TRYNAVI Menu
                </li>
                <li>
                    <a href="'.$path.'">TRYNAVIトップ</a>
                </li>
                <li class="list_ab">
                    ジャンル予約
                </li>
                <li>
                    <a href="#">
						<span style="padding-top:10px;padding-left:10px;padding-right:10px;"><img alt="ランチ" src="'.$path.'assets/front/img/sp_menu_j1.png"></span><span style="margin-bottom:9px;display: inline-block;">ランチ</span>
					</a>
					<ul class="spmenu2" style="display:none;">
						<li><a href="'.$path.'lunch/">ランチTOP</a></li>
						<li><a href="'.$path.'lunch/#shin">新着プラン</a></li>
						<li><a href="#">人気のエリア</a>
							<ul style="display:none;">
								<li><a href="'.$path.'search/?t=0&ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
								<li><a href="'.$path.'search/?t=0&ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
								<li><a href="'.$path.'search/?t=0&ar=5" class="dropIn">赤坂・虎ノ門</a></li>
								<li><a href="'.$path.'search/?t=0&ar=6" class="dropIn">六本木・麻布十番</a></li>
								<li><a href="'.$path.'search/?t=0&ar=7" class="dropIn">渋谷・原宿</a></li>
								<li><a href="'.$path.'search/?t=0&ar=8" class="dropIn">青山・表参道</a></li>
								<li><a href="'.$path.'search/?t=0&ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
								<li><a href="'.$path.'search/?t=0&ar=10" class="dropIn">代官山・中目黒</a></li>
								<li><a href="'.$path.'search/?t=0&ar=11" class="dropIn">汐留・新橋</a></li>
								<li><a href="'.$path.'search/?t=0&ar=12" class="dropIn">お台場</a></li>
								<li><a href="'.$path.'search/?t=0&ar=13" class="dropIn">新宿</a></li>
								<li><a href="'.$path.'search/?t=0&ar=15" class="dropIn">四谷・市ヶ谷</a></li>
								<li><a href="'.$path.'search/?t=0&ar=19" class="dropIn">池袋</a></li>
								<li><a href="'.$path.'search/?t=0&ar=20" class="dropIn">品川・天王洲</a></li>
								<li><a href="'.$path.'search/?t=0&ar=34" class="dropIn">横浜・みなとみらい</a></li>
								<li><a href="'.$path.'search/?t=0&ar=41" class="dropIn">舞浜・浦安</a></li>
								<li><a href="'.$path.'search/?t=0&ar=42" class="dropIn">幕張</a></li>
								<li><a href="'.$path.'search/?t=0&ar=43" class="dropIn">千葉市</a></li>
							</ul>
						</li>
					</ul>

                </li>
                <li>
                    <a href="#">
						<span style="padding-top:10px;padding-left:10px;padding-right:10px;"><img alt="ディナー" src="'.$path.'assets/front/img/sp_menu_j2.png"></span><span style="margin-bottom:9px;display: inline-block;">ディナー</span>
					</a>
					<ul class="spmenu2" style="display:none;">
						<li><a href="'.$path.'dinner/">ディナーTOP</a></li>
						<li><a href="'.$path.'dinner/#shin">新着プラン</a></li>
						<li><a href="#">人気のエリア</a>
							<ul style="display:none;">
								<li><a href="'.$path.'search/?t=1&ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
								<li><a href="'.$path.'search/?t=1&ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
								<li><a href="'.$path.'search/?t=1&ar=5" class="dropIn">赤坂・虎ノ門</a></li>
								<li><a href="'.$path.'search/?t=1&ar=6" class="dropIn">六本木・麻布十番</a></li>
								<li><a href="'.$path.'search/?t=1&ar=7" class="dropIn">渋谷・原宿</a></li>
								<li><a href="'.$path.'search/?t=1&ar=8" class="dropIn">青山・表参道</a></li>
								<li><a href="'.$path.'search/?t=1&ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
								<li><a href="'.$path.'search/?t=1&ar=10" class="dropIn">代官山・中目黒</a></li>
								<li><a href="'.$path.'search/?t=1&ar=11" class="dropIn">汐留・新橋</a></li>
								<li><a href="'.$path.'search/?t=1&ar=12" class="dropIn">お台場</a></li>
								<li><a href="'.$path.'search/?t=1&ar=13" class="dropIn">新宿</a></li>
								<li><a href="'.$path.'search/?t=1&ar=15" class="dropIn">四谷・市ヶ谷</a></li>
								<li><a href="'.$path.'search/?t=1&ar=19" class="dropIn">池袋</a></li>
								<li><a href="'.$path.'search/?t=1&ar=20" class="dropIn">品川・天王洲</a></li>
								<li><a href="'.$path.'search/?t=1&ar=34" class="dropIn">横浜・みなとみらい</a></li>
								<li><a href="'.$path.'search/?t=1&ar=41" class="dropIn">舞浜・浦安</a></li>
								<li><a href="'.$path.'search/?t=1&ar=42" class="dropIn">幕張</a></li>
								<li><a href="'.$path.'search/?t=1&ar=43" class="dropIn">千葉市</a></li>
							</ul>
						</li>
					</ul>
                </li>
                <li>
                    <a href="#">
						<span style="padding-top:10px;padding-left:10px;padding-right:10px;"><img alt="フリードリンク" src="'.$path.'assets/front/img/sp_menu_j3.png"></span><span style="margin-bottom:9px;display: inline-block;">フリードリンク</span>
					</a>
					<ul class="spmenu2" style="display:none;">
						<li><a href="'.$path.'#shin">新着プラン</a></li>
						<li><a href="#">人気のエリア</a>
							<ul style="display:none;">
								<li><a href="'.$path.'search/?p_n=1&ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=5" class="dropIn">赤坂・虎ノ門</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=6" class="dropIn">六本木・麻布十番</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=7" class="dropIn">渋谷・原宿</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=8" class="dropIn">青山・表参道</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=10" class="dropIn">代官山・中目黒</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=11" class="dropIn">汐留・新橋</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=12" class="dropIn">お台場</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=13" class="dropIn">新宿</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=15" class="dropIn">四谷・市ヶ谷</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=19" class="dropIn">池袋</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=20" class="dropIn">品川・天王洲</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=34" class="dropIn">横浜・みなとみらい</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=41" class="dropIn">舞浜・浦安</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=42" class="dropIn">幕張</a></li>
								<li><a href="'.$path.'search/?p_n=1&ar=43" class="dropIn">千葉市</a></li>
							</ul>
						</li>
					</ul>
                </li>
                <li>
                    <a href="#">
						<span style="padding-top:10px;padding-left:10px;padding-right:10px;"><img alt="バー" src="'.$path.'assets/front/img/sp_menu_j4.png"></span><span style="margin-bottom:9px;display: inline-block;">バー</span>
					</a>
					<ul class="spmenu2" style="display:none;">
						<li><a href="'.$path.'bar/">バーTOP</a></li>
						<li><a href="'.$path.'bar/#shin">新着プラン</a></li>
						<li><a href="#">人気のエリア</a>
							<ul style="display:none;">
								<li><a href="'.$path.'search/?t=2&ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
								<li><a href="'.$path.'search/?t=2&ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
								<li><a href="'.$path.'search/?t=2&ar=5" class="dropIn">赤坂・虎ノ門</a></li>
								<li><a href="'.$path.'search/?t=2&ar=6" class="dropIn">六本木・麻布十番</a></li>
								<li><a href="'.$path.'search/?t=2&ar=7" class="dropIn">渋谷・原宿</a></li>
								<li><a href="'.$path.'search/?t=2&ar=8" class="dropIn">青山・表参道</a></li>
								<li><a href="'.$path.'search/?t=2&ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
								<li><a href="'.$path.'search/?t=2&ar=10" class="dropIn">代官山・中目黒</a></li>
								<li><a href="'.$path.'search/?t=2&ar=11" class="dropIn">汐留・新橋</a></li>
								<li><a href="'.$path.'search/?t=2&ar=12" class="dropIn">お台場</a></li>
								<li><a href="'.$path.'search/?t=2&ar=13" class="dropIn">新宿</a></li>
								<li><a href="'.$path.'search/?t=2&ar=15" class="dropIn">四谷・市ヶ谷</a></li>
								<li><a href="'.$path.'search/?t=2&ar=19" class="dropIn">池袋</a></li>
								<li><a href="'.$path.'search/?t=2&ar=20" class="dropIn">品川・天王洲</a></li>
								<li><a href="'.$path.'search/?t=2&ar=34" class="dropIn">横浜・みなとみらい</a></li>
								<li><a href="'.$path.'search/?t=2&ar=41" class="dropIn">舞浜・浦安</a></li>
								<li><a href="'.$path.'search/?t=2&ar=42" class="dropIn">幕張</a></li>
								<li><a href="'.$path.'search/?t=2&ar=43" class="dropIn">千葉市</a></li>
							</ul>
						</li>
					</ul>
                </li>
				<li>
                    <a href="#">
						<span style="padding-top:10px;padding-left:10px;padding-right:10px;"><img alt="クラブ" src="'.$path.'assets/front/img/sp_menu_j5.png"></span><span style="margin-bottom:9px;display: inline-block;">クラブ</span>
					</a>
					<ul class="spmenu2" style="display:none;">
						<li><a href="'.$path.'club/">クラブTOP</a></li>
						<li><a href="'.$path.'club/#shin">新着プラン</a></li>
						<li><a href="#">人気のエリア</a>
							<ul style="display:none;">
								<li><a href="'.$path.'search/?t=3&ar=3" class="dropIn">東京・丸の内・日本橋</a></li>
								<li><a href="'.$path.'search/?t=3&ar=4" class="dropIn">銀座・日比谷・有楽町</a></li>
								<li><a href="'.$path.'search/?t=3&ar=5" class="dropIn">赤坂・虎ノ門</a></li>
								<li><a href="'.$path.'search/?t=3&ar=6" class="dropIn">六本木・麻布十番</a></li>
								<li><a href="'.$path.'search/?t=3&ar=7" class="dropIn">渋谷・原宿</a></li>
								<li><a href="'.$path.'search/?t=3&ar=8" class="dropIn">青山・表参道</a></li>
								<li><a href="'.$path.'search/?t=3&ar=9" class="dropIn">恵比寿・広尾・白金台</a></li>
								<li><a href="'.$path.'search/?t=3&ar=10" class="dropIn">代官山・中目黒</a></li>
								<li><a href="'.$path.'search/?t=3&ar=11" class="dropIn">汐留・新橋</a></li>
								<li><a href="'.$path.'search/?t=3&ar=12" class="dropIn">お台場</a></li>
								<li><a href="'.$path.'search/?t=3&ar=13" class="dropIn">新宿</a></li>
								<li><a href="'.$path.'search/?t=3&ar=15" class="dropIn">四谷・市ヶ谷</a></li>
								<li><a href="'.$path.'search/?t=3&ar=19" class="dropIn">池袋</a></li>
								<li><a href="'.$path.'search/?t=3&ar=20" class="dropIn">品川・天王洲</a></li>
								<li><a href="'.$path.'search/?t=3&ar=34" class="dropIn">横浜・みなとみらい</a></li>
								<li><a href="'.$path.'search/?t=3&ar=41" class="dropIn">舞浜・浦安</a></li>
								<li><a href="'.$path.'search/?t=3&ar=42" class="dropIn">幕張</a></li>
								<li><a href="'.$path.'search/?t=3&ar=43" class="dropIn">千葉市</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li>
                    <a href="#">
						<span style="margin: 9px 0;display: inline-block;">ジャンル・料理名</span>
					</a>
					<ul class="spmenu2" style="display:none;">
						<li>
		                    <a href="'.$path.'search/?g_id=0">フレンチ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=1">イタリアン</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=2">各国料理</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=3">和食・日本料理</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=4">鉄板焼き・焼肉</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=5">中華・中国料理</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=6">エスニック</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=7">韓国料理</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=8">スペイン料理</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=9">バイキング</a>
		                </li>

						<li>
		                    <a href="'.$path.'search/?g_id=10">寿司</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=11">刺身</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=12">天ぷら・天婦羅</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=13">しゃぶしゃぶ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=14">高級寿司</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=15">パスタ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=16">ピザ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=17">リゾット</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=18">チーズ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=19">ローストビーフ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=20">ステーキ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=23">チョコフォンデュ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=22">パンケーキ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=24">オーガニック</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=25">オーセンティックバー</a>
		                </li>


						<li>
		                    <a href="'.$path.'search/?g_id=25">オーセンティックバー</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=26">ショットバー</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=27">スタンディングバー</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=28">ミュージックバー</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=29">アミューズメントバー</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=30">特定酒バー</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=37">エンタメバー</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=31">クラブ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=32">ニュークラブ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=33">キャバクラ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=34">ガールズバー</a>
		                </li>

						<li>
		                    <a href="'.$path.'search/?g_id=35">ミニクラブ</a>
		                </li>
						<li>
		                    <a href="'.$path.'search/?g_id=36">スナック</a>
		                </li>
					</ul>
				</li>
				<li>
                    <a href="#">
						<span style="margin: 9px 0;display: inline-block;">キーワード</span>
					</a>
					<ul class="spmenu2" style="display:none;">

						<li>
		                    <a href="#">
								<span style="margin-bottom:5px;display: inline-block;">シーン</span>
							</a>
							<ul class="spmenu2" style="display:none;">
								<li>
				                    <a href="'.$path.'search/?s_n=10">記念日・誕生日</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?s_n=8">デート</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?s_n=6">接待・食事会</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?s_n=4">歓送迎会</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?s_n=9">女子会</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?s_n=7">プロポーズ</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?s_n=5">合コン</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?s_n=3">二次会</a>
				                </li>
							</ul>
						</li>
						<li>
		                    <a href="#">
								<span style="margin-bottom:5px;display: inline-block;">こだわり</span>
							</a>
							<ul class="spmenu2" style="display:none;">
								<li>
				                    <a href="'.$path.'search/?c_n=1">夜景</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?c_n=2">個室</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?c_n=3">高層階</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?c_n=4">ホテル</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?c_n=5">隠れ家</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?c_n=7">有名シェフ</a>
				                </li>
							</ul>
						</li>
						<li>
		                    <a href="#">
								<span style="margin-bottom:5px;display: inline-block;">年間ランキング</span>
							</a>
							<ul class="spmenu2" style="display:none;">
								<li>
				                    <a href="'.$path.'search/?t_z=1">ランチ</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?t_z=2">ディナー</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?t_z=3">バー</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?t_z=4">クラブ</a>
				                </li>
								<li>
				                    <a href="'.$path.'search/?t_z=4">フリードリンク</a>
				                </li>
							</ul>
						</li>
					</ul>
				</li>
                <li class="list_ab">
                    マイページ
                </li>
				<li>
                    <a href="'.$path.'mypage/">マイページ</a>
                </li>
				<li>
                    <a href="'.$path.'mypage/reservation.php">予約確認・変更・キャンセル</a>
                </li>
				<li>
                    <a href="'.$path.'mypage/">お気に入りリスト</a>
                </li>
				<li>
                    <a href="'.$path.'mypage/">最近見たプラン</a>
                </li>
                <li class="list_ab">
                    ヘルプ・サポート
                </li>
				<li>
                    <a href="'.$path.'company/whats.php">トライナビについて</a>
                </li>
				<li>
                    <a href="#">
						<span style="margin-bottom:5px;display: inline-block;">サポート</span>
					</a>
					<ul class="spmenu2" style="display:none;">
						<li>
		                    <a href="'.$path.'contact/help.php">ヘルプ・サポート</a>
		                </li>
						<li>
		                    <a href="http://www.endo-ri.co.jp/" target="_blank">会社概要</a>
		                </li>
						<li>
		                    <a href="'.$path.'policy/agreement.php">会員規約</a>
		                </li>
						<li>
		                    <a href="'.$path.'policy/privacypolicy.php">個人情報保護方針</a>
		                </li>
						<li>
		                    <a href="'.$path.'policy/">ウェブサイトポリシー</a>
		                </li>
						<li>
		                    <a href="'.$path.'company/sitemap.php">サイトマップ</a>
		                </li>
						<li>
		                    <a href="'.$path.'company/ad.php">トライナビの取材申込みについて</a>
		                </li>
						<li>
		                    <a href="'.$path.'contact/index.php">お問い合わせ</a>
		                </li>
						<li>
		                    <a href="'.$path.'company/ad_k.php">広告掲載</a>
		                </li>
						<li>
		                    <a href="'.$path.'company/publish.php">トライナビ予約の新規無料掲載について</a>
		                </li>
					</ul>
				</li>
				<li>
                    <a href="'.$path.'">ログアウト</a>
                </li>
                <li class="list_ab2 spmenu_btn2">
                    <i class="fa fa-window-close-o" aria-hidden="true"></i> Close
                </li>
            </ul>
        </nav>
    </div>
</header>

';
?>

<script>
$(document).ready(function() {
	if(location.pathname != "/") {
	var $path = location.href.split('/');
	var $endPath = $path.slice($path.length-2,$path.length-1);
	$('ul.try__menu li a[href$="'+$endPath+'/"]').parent().addClass('active');
	}
	});
</script>