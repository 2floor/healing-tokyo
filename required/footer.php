<?php $path_r = $jaha_path;
$pref_ar_base = explode(",", "北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,山梨県,長野県,富山県,石川県,福井県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県");
$pref_link = '';
foreach ($pref_ar_base as $pref) {
	$sl = ($_GET['pref'] == $pref)? 'selected="selected"' : "";
	$pref_link .= '<a href="category/jaha-koushi/?pref='.$pref.'" '.$sl.'><i class="fas fa-caret-right fc-green"></i>'.$pref.'</a>';
}


?>

	<footer>
		<div class="conWrap">
			<div class="i2FooterInner">
				<div class="i2FooterInnerLogoArea">
					<div class="i2FooterInnerLogo">
						<img alt="一般社団法人日本ハッピーライフ協会" src="<?php print $path_r ?>assets/img/footer_logo.png">
						<span>〒260-0025<br>千葉県千葉市中央区問屋町3-1<br>TEL:043-247-1115</span>
					</div>
				</div>
				<div class="i2FooterInnerMenuArea">
					<div class="i2FooterInnerMenu">
						<span class="i2FooterInnerMenuTtl">SITEMAP</span>
						<a href="<?php print $path_r ?>" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>HOME</a>
						<a href="<?php print $path_r ?>jaha/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>JAHAについて</a>
						<a href="<?php print $path_r ?>category/news/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>直営校ブログ</a>
						<a href="https://jahanavi.jp/" target="_blank" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>JAHAnavi</a>
						<a href="http://jahayoga.shop/" target="_blank" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>ヨガウェアJAHA</a>
						<a href="<?php print $path_r ?>association/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>協会概要</a>
					</div>
					<div class="i2FooterInnerMenu">
						<span class="i2FooterInnerMenuTtl">インストラクター養成</span>
						<a href="<?php print $path_r ?>yoga-koushi/linklist/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>JAHA資格講座一覧</a>
						<a href="<?php print $path_r ?>category/news/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>資格認定者一覧</a>
						<a href="<?php print $path_r ?>contact-koushi/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>養成講座お申込み</a>
						<a href="<?php print $path_r ?>yoga-koushi/slim-yoga/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>骨盤スリムヨガ</a>
						<a href="<?php print $path_r ?>yoga-koushi/curriculum-bc-massage/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>ベビーチャクラマッサージ認定講座</a>
						<a href="<?php print $path_r ?>yoga-koushi/kids-yoga/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>リトル＆キッズヨガ</a>
						<a href="<?php print $path_r ?>yoga-koushi/slim-yoga-dvd/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>骨盤スリムヨガ通信講座要</a>
						<a href="<?php print $path_r ?>yoga-koushi/dvd-course/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>ベビーヨガ通信講座</a>
						<a href="<?php print $path_r ?>yoga-koushi/slim-yoga-trainer/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>骨盤スリムヨガトレーナー</a>
						<a href="<?php print $path_r ?>yoga-koushi/jaha-trainer/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>ベビママヨガトレーナー</a>
						<a href="<?php print $path_r ?>yoga-koushi/kids-yoga-trainer/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>キッズヨガトレーナー</a>
						<a href="<?php print $path_r ?>yoga-koushi/practice-support/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>開業サポート</a>
					</div>
					<div class="i2FooterInnerMenu">
						<span class="i2FooterInnerMenuTtl">レッスン案内</span>
						<a href="<?php print $path_r ?>yoga-koushi/linklist/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>レッスン各種一覧</a>
						<a href="<?php print $path_r ?>yoga-course/private-lessons/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>出張ヨガ・オフィスヨガ</a>
						<a href="<?php print $path_r ?>yoga-course/pregnancy/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>妊活ヨガ</a>
						<a href="<?php print $path_r ?>yoga-course/maternity/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>マタニティヨガ</a>
						<a href="<?php print $path_r ?>yoga-course/baby-chakra-massage/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>ベビーチャクラマッサージ</a>
						<a href="<?php print $path_r ?>yoga-course/baby/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>ベビーヨガ＆ママヨガ</a>
						<a href="<?php print $path_r ?>yoga-course/lone/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>子連れヨガ</a>
						<a href="<?php print $path_r ?>yoga-course/kids-yoga/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>リトル＆キッズヨガ</a>
						<a href="<?php print $path_r ?>yoga-course/yoga/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>YOGA</a>
						<a href="<?php print $path_r ?>yoga-koushi/beginner/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>ベビママヨガ初級講座</a>
					</div>
					<div class="i2FooterInnerMenu">
						<span class="i2FooterInnerMenuTtl">レッスン予約</span>
						<a href="<?php print $path_r ?>withchildren/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>スタジオヨガ予約</a>
						<a href="<?php print $path_r ?>withchildren/?ct=0" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>オンラインヨガ予約</a>
						<a href="<?php print $path_r ?>studio/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>JAHAヨガスタジオ概要</a>
						<a href="<?php print $path_r ?>babiesrus/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>トイザらスベビーヨガ</a>
						<a href="<?php print $path_r ?>babypark/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>ベビーパークベビーヨガ</a>
						<a href="https://jahanavi.jp/lesson" target="_blank" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>JAHAnavi Lesson</a>
					</div>
					<div class="i2FooterInnerMenu">
						<span class="i2FooterInnerMenuTtl">レッスン予約</span>
						<a href="<?php print $path_r ?>yoga-course/pregnancy/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>骨盤スリムヨガ</a>
						<a href="<?php print $path_r ?>yoga-course/baby/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>ベビーヨガ&ママヨガ</a>
						<a href="<?php print $path_r ?>yoga-course/kids-yoga/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>リトル＆キッズヨガ</a>
						<a href="<?php print $path_r ?>yoga-course/baby-chakra-massage/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>ベビーチャクラ</a>
						<a href="<?php print $path_r ?>withchildren/" class="i2FooterInnerMenuLink"><i class="fas fa-caret-right fc-green"></i>オンライン</a>
					</div>
				</div>
			</div>
			<div class="i2footerPrefWrap">
				<div class="i2footerPref">
					<span class="i2FooterInnerMenuTtl">JAHA認定校一覧</span>
				</div>
				<div class="i2footerPrefLink">
					<?php print $pref_link?>
				</div>
			</div>

		</div>
		<div class="copywrite">
			<p>© 一般社団法人日本ハッピーライフ協会（JAHA）ヨガで繋がる幸せ,2020 All Rights Reserved.</p>
		</div>
	</footer>
	<div class="toTop">
		<div></div>
	</div>
	<a href="<?php print $path_r ?>category/news/" class="float-blog">
		新着ブログ
	</a>
	<a href="<?php print $path_r ?>yoga-koushi/linklist/" class="float-kouza">
		資格講座一覧
	</a>

<script>
$(function(){$('.lowerFaqAArea').hide();$('.lowerFaqQTtlArea').off().on('click', function(){$(this).next('.lowerFaqAArea').slideToggle();});});
$(function(){$('.toTop').off().on('click', function(){$("html,body").animate({scrollTop:0});});});
</script>

<!-- レントラックスASP ITPタグ
<script type="text/javascript">
(function(callback){
var script = document.createElement("script");
script.type = "text/javascript";
script.src = "https://www.rentracks.jp/js/itp/rt.track.js?t=" + (new Date()).getTime();
if ( script.readyState ) {
script.onreadystatechange = function() {
if ( script.readyState === "loaded" || script.readyState === "complete" ) {
script.onreadystatechange = null;
callback();
}
};
} else {
script.onload = function() {
callback();
};
}
document.getElementsByTagName("head")[0].appendChild(script);
}(function(){}));
</script>
 -->
