<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// PayNowIDメニュー画面のサンプル
// -------------------------------------------------------------------------

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - PayNowIDサービス利用サンプルメニュー画面</title>
<link href="./css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img alt='Paymentロゴ' src='./WEB-IMG/VeriTrans_Payment.png'><hr/>

<div class="system-message">
<font size="2">
本画面はVeriTrans4G PayNowIDサービス利用サンプルのメニュー画面です。<br/>
お客様ECサイトとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
</font>
</div>
<div class="lhtitle">PayNowIDサービス利用サンプルメニュー</div>
<table border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <table boder="0" cellpadding="0" cellspacing="5">
        <tr><td width="400" bgcolor="#33aaff">会員入会サンプル</td></tr>
        <tr><td width="400"><a href="./paynowid/AccountEntry.php">会員入会</a></td></tr>
        <tr><td width="400"><a href="./paynowid/EntryAndCard.php">決済＋会員入会</a></td></tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table boder="0" cellpadding="0" cellspacing="5">
        <tr><td width="400" bgcolor="#33aaff">会員機能サンプル</td></tr>
        <tr><td width="400"><a href="./paynowid/AccountWithdraw.php">会員退会</a></td></tr>
        <tr><td width="400"><a href="./paynowid/CardManage.php">会員カード管理</a></td></tr>
        <tr><td width="400"><a href="./paynowid/Recurring.php">継続課金管理(カード払い)</a></td></tr>
        <tr><td width="400"><a href="./paynowid/RecurringTerminate.php">継続課金停止(カード払い)</a></td></tr>
        <tr><td width="400"><a href="./paynowid/CardAuthorize.php">カード決済-本人認証無し(PayNowIDカード情報利用)</a></td></tr>
        <tr><td width="400"><a href="./paynowid/MpiAuthorize.php">カード決済-3D認証有り(PayNowIDカード情報利用)</a></td></tr>
      </table>
    </td>
  </tr>
</table>
<br/>
<ul class="flinkmenu">
  <li><a href="./PaymentMethodSelect.php">消費者向け決済メニューサンプルはこちら</a></li>
  <li><a href="./AdminMenu.php">管理者向け決済メニューサンプルはこちら</a></li>
</ul>
<hr/>
<img alt='VeriTransロゴ' src='./WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
