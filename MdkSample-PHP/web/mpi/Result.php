<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// カード決済(3D認証付き)認証結果画面のサンプル
// -------------------------------------------------------------------------

/**
 * MDK配置ディレクトリ
 */
define('MDK_DIR', '../tgMdk/');

require_once(MDK_DIR."3GPSMDK.php");

  $conf = TGMDK_Config::getInstance();
  $array = $conf->getConnectionParameters();
  $merchant_cc_id = $array[TGMDK_Config::MERCHANT_CC_ID];
  $merchant_pw = $array[TGMDK_Config::MERCHANT_SECRET_KEY];
  $charset = "UTF-8";

  $check_result = TGMDK_AuthHashUtil::checkAuthHash(@$_POST, $merchant_cc_id, $merchant_pw, $charset);
  $warning = null;
  if (!isset($check_result) || $check_result == false) {
    $warning = "<font color='#ff0000'><b>【パラメータ改竄】パラメータ情報が改竄されています。</b></font><br/><br/>";
  } else {
    echo "<!-- vAuthInfo check is OK -->";
  }
?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="ja" />
        <title>認証結果ページ</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
  </head>
  <body><img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"><hr/>
    <div class="system-message">
    <font size="2">
    本画面はVeriTrans4G カード決済与信(3D認証付き)の取引サンプル画面です。<br/>
    お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
    </font>
    </div>

    <?php
      if (!empty($warning)) {
        echo $warning."<br><br>";
      }
    ?>

    <div class="lhtitle">カード決済与信(3D認証付き)：取引結果</div>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="rititletop">取引ID</td>
        <td class="rivaluetop"><?php echo htmlspecialchars(@$_POST["OrderId"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">リクエストID</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["RequestId"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">MPI取引ステータス</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["mpiMstatus"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">カード取引ステータス</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["cardMstatus"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">結果コード</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["vResultCode"]) ?><br/></td>
      </tr>
      <!--
      <tr>
        <td class="rititle">通貨単位</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["reqCurrencyUnit"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">トランザクションタイプ</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["cardTransactionType"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">センター要求日時</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["centerRequestDate"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">センター応答日時</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["centerResponseDate"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">接続先カード接続センター</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["connectedCenterId"]) ?><br/></td>
      </tr>
      -->
      <tr>
        <td class="rititle">カード番号</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["reqCardNumber"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">取引金額</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["reqAmount"]) ?><br/></td>
      </tr>
      <!--
      <tr>
        <td class="rititle">仕向け先コード</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["acquirerCode"]) ?><br/></td>
      </tr>
      -->
      <tr>
        <td class="rititle">承認番号</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["authCode"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">3Dメッセージバージョン</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["dddMessageVersion"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">3DトランザクションID</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["dddTransactionId"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">3Dトランザクションステータス</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["dddTransactionStatus"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">3D CAVVアルゴリズム</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["dddCavvAlgorithm"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">3D CAVV</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["dddCavv"]) ?><br/></td>
      </tr>
      <tr>
        <td class="rititle">3D ECI</td>
        <td class="rivalue"><?php echo htmlspecialchars(@$_POST["dddEci"]) ?><br/></td>
      </tr>
    </table>

<br/>

    <a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

    <hr>
    <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
  </body>
</html>
