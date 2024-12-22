<?php
# Copyright(C) 2012 VeriTrans Inc., Ltd. All right reserved.
// -------------------------------------------------------------------------
// VeriTrans 4G - UPOP決済与信サンプル画面
// -------------------------------------------------------------------------

$order_id = "dummy".time();
$price = "10";
$config_file = "../env4sample.ini";

if (is_readable($config_file)) {
    $env_info = @parse_ini_file($config_file, true);
    $termUrl = $env_info["UPOP"]["term.url"];
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
// get  consumer ip adress
$ip=getRealIpAddr() ;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<title>VeriTrans 4G - UPOP決済与信サンプル画面</title>
<link href="../css/style.css?1286186298" media="all" rel="stylesheet"
    type="text/css">
</head>
<body>
    <script type="text/javascript">
        function reDrawing(frm, action) {
            frm.action = action;
            frm.method = "POST";
            frm.submit();
        }
    </script>
    <img alt='Paymentロゴ' src='../WEB-IMG/VeriTrans_Payment.png'>
    <hr />
    <div class="system-message">
        <font size="2"> 本画面はVeriTrans4G UPOP決済の取引サンプル画面です。<br />
            お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br />
            また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br />
        </font>
    </div>
    <?php
    if (!empty($warning)) {
        echo $warning."<br><br>";
    }
    ?>
    <table>

        <tr>
            <td>
                <div class="lhtitle">UPOP決済：決済請求</div>
            </td>
            <td><img src='../WEB-IMG/upop.gif'/>
        
        </tr>

    </table>
    <form name="FORM_AUTH" method="post" action="AuthorizeExec.php">
        <table border="0" cellpadding="0" cellspacing="0">

            <tr>
                <td class="ititletop">取引ID</td>
                <td class="ivaluetop"><?php echo $order_id ?>&nbsp;&nbsp;<input
                    type="hidden" name="orderId" value="<?php echo $order_id ?>"><input
                    type="button" value="取引ID更新" onclick="reDrawing(FORM_AUTH, 'Authorize.php');"></td>
            </tr>
            <tr>
                <td class="ititle">金額</td>
                <td class="ivalue"><input type="text" maxlength='8' size="8"
                    name="amount" value="<?php echo $price?>">
                </td>
            </tr>

            <tr>
                <td class="ititle">与信方法</td>
                <td class="ivalue"><select name="withCapture">
                        <option value="false"
                        <?php if ("false" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>与信のみ(与信成功後に売上処理を行う必要があります)</option>
                        <option value="true"
                        <?php if ("true" == htmlspecialchars(@$_POST["withCapture"])) { echo " selected"; } ?>>与信売上(与信と同時に売上処理も行います)</option>
                </select>
                </td>
            </tr>

            <tr>
                <td></td>
                <td><input type="hidden" name="termUrl"
                    value="<?php echo $termUrl?>">
                </td>
            </tr>

            <tr>
                <td></td>
                <td><input type="hidden" name="customerIp" value="<?php echo $ip?>">&nbsp;&nbsp;</td>
            </tr>

            <tr>
                <td colspan="2"><input type="submit" value="購入">&nbsp;&nbsp;<font
                    size="2" color="red">※２回以上クリックしないでください。</font></td>
            </tr>

        </table>
    </form>
    <a href="../PaymentMethodSelect.php">決済サンプルのトップメニューへ戻る</a>&nbsp;&nbsp;

    <hr>
    <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy;
    VeriTrans Inc. All rights reserved

</body>
</html>
