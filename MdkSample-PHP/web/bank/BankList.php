<?php
# Copyright © VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// 金融機関一覧の検索のサンプル
// -------------------------------------------------------------------------

?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="ja" />
                <title>VeriTrans 4G - 決済金融機関一覧</title>
        <link href="../css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
      <img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"/><hr/>
      <div class="system-message">
      <font size="2">本画面はVeriTrans4G 決済金融機関一覧の取得サンプル画面です。<br/>お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>また、本画面では基本的なパラメータのみを表示させていますので、開発ガイドも合わせてご参照してください。<br/>
      </font>
      </div>
     <font size="2">
       <a href="../AdminMenu.php">管理メニューへ戻る</a>
     </font>
     <center>
       <td><font color="#000000" size="5" >決済金融機関一覧</font></td>
       <br></br>
       <table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
         <thead>
           <tr>
             <th bgcolor="#6495ED"><font color="#FFFFFF">銀行コード</font></th>
             <th bgcolor="#6495ED"><font color="#FFFFFF">銀行名</font></th>
           </tr>
         </thead>
           <?php

             /**
             * MDK配置ディレクトリ
             */
             define('MDK_DIR', '../tgMdk/');

             require_once(MDK_DIR."3GPSMDK.php");

             /**
             * 検索要求パラメータの設定
             */
             $request_data = new SearchRequestDto();
             $request_data->setMasterNames("bankFinancialInstInfo");

             /**
              * 検索処理実行
              */
             $transaction = new TGMDK_Transaction();
             $response_data = $transaction->execute($request_data);
             $masterInfos[] = $response_data->getMasterInfos();
             $masterInfo = $masterInfos[0]->getMasterInfo();
             $masters = $masterInfo[0]->getMasters();
             $bankFinancials = $masters->getBankFinancialInstInfo();

             foreach($bankFinancials as $value) {
                $dv_code = $value->getDeviceCode();

                 if( "01" == $dv_code) {
                     $bank_code = $value->getBankCode();
                     $bank_name = $value->getBankName();
           ?>
         <tr>
         <td><div align="center"><?php echo $bank_code ?></div></td>
         <td><div align="left"><?php echo $bank_name ?></div></td>
         </tr>
           <?php
                 }
             }
           ?>
       </table>
     </center>
     <br/>
     <font size="2">
       <a href="../AdminMenu.php">管理メニューへ戻る</a>
     </font>
     <hr>
     <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
    </body>
</html>
