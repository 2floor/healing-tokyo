<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 管理メニュー画面のサンプル
// -------------------------------------------------------------------------
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>取引管理メニューサンプル</title>
<link href="./css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='./WEB-IMG/VeriTrans_Payment.png'><hr>
<div class="system-message">
<font size="2">
本画面はVeriTrans4G 取引管理用のメニューのサンプル画面です。<br/>
お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<div class="lhtitle">各種管理メニュー</div>
<table border="1" cellpadding="0" cellspacing="0">
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">カード取引</td></tr>
  <tr><td width="400"><a href="./card/Capture.php">売上請求</a></td></tr>
  <tr><td width="400"><a href="./card/Cancel.php">取消請求</a></td></tr>
  <tr><td width="400"><a href="./card/ReAuthorize.php">再与信請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">MPI取引</td></tr>
  <tr><td width="400"><a href="./mpi/ReAuthorize.php">再与信請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">コンビニ取引</td></tr>
  <tr><td width="400"><a href="./cvs/Cancel.php">取消請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">電子マネー取引</td></tr>
  <tr><td width="400"><a href="./em/Cancel.php">取消請求</a></td></tr>
  <tr><td width="400"><a href="./em/Refund.php">返金請求</a></td></tr>
  <tr><td width="400"><a href="./em/Remove.php">カード情報削除</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">PayPal取引</td></tr>
  <tr><td width="400"><a href="./paypal/Capture.php">売上請求</a></td></tr>
  <tr><td width="400"><a href="./paypal/Cancel.php">取消請求</a></td></tr>
  <tr><td width="400"><a href="./paypal/Refund.php">返金請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">永久不滅ポイント取引</td></tr>
  <tr><td width="400"><a href="./saison/Cancel.php">取消請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">銀聯ネット決済(UPOP)取引</td></tr>
  <tr><td width="400"><a href="./upop/Capture.php">売上請求</a></td></tr>
  <tr><td width="400"><a href="./upop/Cancel.php">取消請求</a></td></tr>
  <tr><td width="400"><a href="./upop/Refund.php">返金請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">Alipay決済取引</td></tr>
  <tr><td width="400"><a href="./alipay/Confirm.php">確認請求</a></td></tr>
  <tr><td width="400"><a href="./alipay/Refund.php">返金請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">銀行取引</td></tr>
  <tr><td width="400"><a href="./bank/BankList.php">決済金融機関一覧</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">キャリア決済</td></tr>
  <tr><td width="400"><a href="./carrier/Capture.php">売上請求</a></td></tr>
  <tr><td width="400"><a href="./carrier/Cancel.php">取消請求</a></td></tr>
  <tr><td width="400"><a href="./carrier/Terminate_Admin.php">継続課金終了請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">楽天ID決済</td></tr>
  <tr><td width="400"><a href="./rakuten/Capture.php">売上請求</a></td></tr>
  <tr><td width="400"><a href="./rakuten/Cancel.php">取消請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">リクルートかんたん支払い</td></tr>
  <tr><td width="400"><a href="./recruit/Capture.php">売上請求</a></td></tr>
  <tr><td width="400"><a href="./recruit/Cancel.php">取消請求</a></td></tr>
  <tr><td width="400"><a href="./recruit/ExtendAuth.php">与信期限延長請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">LINE Pay</td></tr>
  <tr><td width="400"><a href="./linepay/Capture.php">売上請求</a></td></tr>
  <tr><td width="400"><a href="./linepay/Cancel.php">取消請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">MasterPass決済</td></tr>
  <tr><td width="400"><a href="./masterpass/Capture.php">売上請求</a></td></tr>
  <tr><td width="400"><a href="./masterpass/Cancel.php">取消請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">銀行振込決済</td></tr>
  <tr><td width="400"><a href="./virtualacc/Cancel.php">取消請求</a></td></tr>
  <tr><td width="400"><a href="./virtualacc/DepositEntry.php">入金請求</a></td></tr>
  <tr><td width="400"><a href="./virtualacc/DepositReverse.php">入金取消請求</a></td></tr>
  <tr><td width="400"><a href="./virtualacc/Reconcile.php">消込請求</a></td></tr>
  <tr><td width="400"><a href="./virtualacc/UndoReconcile.php">消込取消請求</a></td></tr>
</table>
</td>
</tr>
<tr>
<td>
<table boder="0" cellpadding="0" cellspacing="5">
  <tr><td width="400" bgcolor="#33aaff">検索機能</td></tr>
  <tr><td width="400"><a href="./search/Search.php">各種検索</a></td></tr>
</table>
</td>
</tr>
</table>
<br>
<ul class="flinkmenu">
  <li><a href="./PaymentMethodSelect.php">消費者向け決済メニューサンプルはこちら</a></li>
  <li><a href="./PayNowIdMenu.php">PayNowIDメニューサンプルはこちら</a></li>
</ul>
<hr>
<img alt='VeriTransロゴ' src='./WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
