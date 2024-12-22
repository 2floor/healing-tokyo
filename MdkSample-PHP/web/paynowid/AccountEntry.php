<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 会員入会処理サンプル画面
// -------------------------------------------------------------------------
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - 会員入会処理サンプル画面</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'><hr />
    <div class="system-message">
      <font size="2"> 本画面はVeriTrans4G 会員入会処理のサンプル画面です。<br />
      お客様ECサイトとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
      また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br />
      </font>
    </div>
<?php
  if (!empty($warning)) {
    echo $warning."<br><br>";
  }
?>
    <div class="lhtitle">会員入会処理</div>
    <form name="FORM_PAY_NOW_ID" method="post" action="AccountEntryExec.php">
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="thl" colspan="2">入会情報</td>
        </tr>
        <tr>
          <td class="ititle">会員ID</td>
          <td class="ivalue">
            <input type="text" size="50" name="accountId" value="<?php if (isset($_POST["accountId"])) {echo htmlspecialchars($_POST["accountId"]);} ?>" maxLength="100">
          </td>
        </tr>
        <tr>
          <td class="ititle">入会年月日</td>
          <td class="ivalue">
            <input type="text" size="8" name="createDate" value="<?php if (isset($_POST["createDate"])) {echo htmlspecialchars($_POST["createDate"]);} ?>" maxLength="8">&nbsp;&nbsp;
            <font size="2" color="red">※形式:YYYYMMDD</font>
          </td>
        </tr>
        <tr>
          <td class="ititle">入会処理区分</td>
          <td class="ivalue">
            <font size="2">
              <input type="radio" name="entryKbn" value="1">新規入会
              <input type="radio" name="entryKbn" value="2">再入会
              <br/>
              <font color="red">&nbsp;&nbsp;※再入会は一度退会した会員に同一PayNowIDを割り当てる場合にご利用ください。</font>
            </font>
          </td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
          <td colspan="2"><input type="submit" value="実行">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font></td>
        </tr>
      </table>
    </form>
    <a href="../PayNowIdMenu.php">PayNowIDサンプルのトップメニューへ戻る</a>&nbsp;&nbsp;
    <hr>
    <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>
