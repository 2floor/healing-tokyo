
<section class="borderBox2">
	<section class="ac-container mT30">

		<!-- fqb Box Large -->
		<div class="acordionBoxL">
			<div class="acordionBoxLLabel js-acordion-label ">
				<h3 class="acordionBoxLLabelTxt"><span class="largeQ">Q</span>会員登録について</h3>
			</div>
			<div class="acordionBoxIn js-acordion-children">

				<!-- fqb Box In -->
				<div class="acordionBoxInBox">
					<div class="acordionBoxInLabel js-acordion-label ty2">
						<span class="miniQ">Q</span>
						<h4 class="acordionBoxInLabelTxt">個人事業主でも、登録できますか？</h4>
					</div>
					<div class="acordionBoxInChild js-acordion-children">
						<span class="miniA">A</span>
						<p class="acordionBoxInChildTxt">登録できますので、画面に沿って、ご登録ください。</p>
					</div>
				</div>

			</div>
		</div>


		<!-- fqb Box Large -->
		<div class="acordionBoxL">
			<div class="acordionBoxLLabel js-acordion-label ">
				<h3 class="acordionBoxLLabelTxt"><span class="largeQ">Q</span>料金について</h3>
			</div>
			<div class="acordionBoxIn js-acordion-children">

				<!-- fqb Box In -->
				<div class="acordionBoxInBox">
					<div class="acordionBoxInLabel js-acordion-label ty2">
						<span class="miniQ">Q</span>
						<h4 class="acordionBoxInLabelTxt">サービス利用料はいくらですか？</h4>
					</div>
					<div class="acordionBoxInChild js-acordion-children">
						<span class="miniA">A</span>
						<p class="acordionBoxInChildTxt">お客様が事業者様で体験できた場合のみ、お客様がお支払いした料金の総額（各種オプション料金含む）の15%がサービス利用料（消費税別）となります。</p>
					</div>
				</div>

			</div>
		</div>


		<!-- fqb Box Large -->
		<div class="acordionBoxL">
			<div class="acordionBoxLLabel js-acordion-label ">
				<h3 class="acordionBoxLLabelTxt"><span class="largeQ">Q</span>予約対応について</h3>
			</div>
			<div class="acordionBoxIn js-acordion-children">

				<!-- fqb Box In -->
				<div class="acordionBoxInBox">
					<div class="acordionBoxInLabel js-acordion-label ty2">
						<span class="miniQ">Q</span>
						<h4 class="acordionBoxInLabelTxt">予約の対応はどうやってやればいいですか？</h4>
					</div>
					<div class="acordionBoxInChild js-acordion-children">
						<span class="miniA">A</span>
						<p class="acordionBoxInChildTxt">
						予約を受け入れできる数をカレンダーに設定の上、お客様の予約が自動的に確定する便利なシステムをご利用ください。<br>
						面倒なメールのやり取りがなくなるので、業務効率が改善されます。</p>
					</div>
				</div>

				<!-- fqb Box In -->
				<div class="acordionBoxInBox">
					<div class="acordionBoxInLabel js-acordion-label ty2">
						<span class="miniQ">Q</span>
						<h4 class="acordionBoxInLabelTxt">在庫設定は面倒ではないでしょうか？</h4>
					</div>
					<div class="acordionBoxInChild js-acordion-children">
						<span class="miniA">A</span>
						<p class="acordionBoxInChildTxt">操作は簡単です、直感的に利用することができます、ご不明の場合はお問い合わせください。</p>
					</div>
				</div>

			</div>
		</div>

	</section>
</section>

<script>
$('.js-acordion-children').hide();
$(function(){
	$('.js-acordion-label').off().on('click', function(){
		$(this).toggleClass('is-open').next('.js-acordion-children').slideToggle();
	});
})
</script>


