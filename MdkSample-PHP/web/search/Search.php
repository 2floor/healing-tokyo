<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="ja" />
    <link href="../css/style.css" rel="stylesheet" type="text/css"/>
  <title>VeriTrans 4G - 取引検索 サンプル画面</title>
  <script type="text/javascript">
// onLoadイベント
window.onload = function () {
  initUpopSettleDatetime();
  initDisplay();
}

/**
 * 決済サービスタイプの選択値によってサービス固有項目のエリア表示の切り替える。
 */
function initDisplay() {
  // 決済サービスタイプを取得
  var serviceTypeList = document.getElementsByName("serviceTypeCd[]");
  if (serviceTypeList != null) {
    // 全ての決済サービスタイプの分繰り返し
    for(i = 0; i < serviceTypeList.length; i++){
      var proc = "";

      // チェック状態によって表示、非表示を設定する
      if(serviceTypeList[i].checked == true){
      // チェックON
        proc = "block";
      } else {
      // チェックOFF
        proc = "none";
      }

      // チェックボックスの状態をみて、対象のサービス固有項目のエリアの表示、非表示を切り替える
      var element = document.getElementById(serviceTypeList[i].value);
      if (element != null) {
        element.style.display = proc;
      }
    }
  }
}
/**
 * 銀聯のサービス固有項目[決済日時]のラジオボタンの選択によりテキストのdisabledを変更する。
 * また、入力できない場合はテキストをクリアする。
 */
function initUpopSettleDatetime() {
  var rdo = document.FORM_SEARCH.upop_checked_settleDatetime;
  if (rdo != null) {
    var f = document.FORM_SEARCH;

    for (i = 0; i < rdo.length; i++) {
      if (rdo[i].checked) {
        if (rdo[i].value == "jp") {
          // 日本の場合
          f.upop_settleDatetimeJpFrom.disabled = "";
          f.upop_settleDatetimeJpTo.disabled   = "";
          f.upop_settleDatetimeCnFrom.disabled = "true";
          f.upop_settleDatetimeCnTo.disabled   = "true";

          // 中国側テキストクリア
          f.upop_settleDatetimeCnFrom.value = "";
          f.upop_settleDatetimeCnTo.value   = "";

          return;
        } else {
          // 中国
          f.upop_settleDatetimeJpFrom.disabled = "true";
          f.upop_settleDatetimeJpTo.disabled   = "true";
          f.upop_settleDatetimeCnFrom.disabled = "";
          f.upop_settleDatetimeCnTo.disabled   = "";

          // 日本側テキストクリア
          f.upop_settleDatetimeJpFrom.value = "";
          f.upop_settleDatetimeJpTo.value   = "";

          return;
        }
      }
    }

    f.upop_settleDatetimeJpFrom.disabled = "true";
    f.upop_settleDatetimeJpTo.disabled   = "true";
    f.upop_settleDatetimeCnFrom.disabled = "true";
    f.upop_settleDatetimeCnTo.disabled   = "true";

    f.upop_settleDatetimeJpFrom.value = "";
    f.upop_settleDatetimeJpTo.value   = "";
    f.upop_settleDatetimeCnFrom.value = "";
    f.upop_settleDatetimeCnTo.value   = "";
  }
}
  </script>
</head>
<body>
  <img alt="Paymentロゴ" src="../WEB-IMG/VeriTrans_Payment.png"/><hr/>
  <div class="system-message">
    <font size="2">
    本画面はVeriTrans4G 取引検索のサンプル画面です。<br/>
    お客様ECサイトのショッピングカートとVeriTrans4Gとを連動させるための参考、例としてご利用ください。<br/>
    また、本画面ではサンプルとして基本的なパラメータを表示させています。<br/>
    その他のパラメータについては開発ガイドをご参照ください。<br/>
    </font>
  </div>

  <div class="lhtitle">取引検索</div>
  <form name="FORM_SEARCH" method="post" action="./SearchExec.php">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="ititletop">決済サービスタイプ</td>
        <td class="ivaluetop">
          <table border="0">
            <tr>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_card" value="card" onclick="initDisplay();">&nbsp;<label for="for_card">カード</label></td>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_mpi" value="mpi" onclick="initDisplay();">&nbsp;<label for="for_mpi">MPI</label></td>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_em" value="em" onclick="initDisplay();">&nbsp;<label for="for_em">電子マネー</label></td>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_cvs" value="cvs" onclick="initDisplay();">&nbsp;<label for="for_cvs">コンビニ</label></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_bank" value="bank" onclick="initDisplay();">&nbsp;<label for="for_bank">銀行</label></td>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_paypal" value="paypal" onclick="initDisplay();">&nbsp;<label for="for_paypal">PayPal</label></td>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_saison" value="saison" onclick="initDisplay();">&nbsp;<label for="for_saison">Saison</label></td>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_upop" value="upop" onclick="initDisplay();">&nbsp;<label for="for_upop">銀聯ネット決済(UPOP)</label></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_alipay" value="alipay" onclick="initDisplay();">&nbsp;<label for="for_alipay">Alipay決済</label></td>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_carrier" value="carrier" onclick="initDisplay();">&nbsp;<label for="for_carrier">キャリア</label></td>
              <td colspan="2"><input type="checkbox" name="serviceTypeCd[]" id="for_oricosc" value="oricosc" onclick="initDisplay();">&nbsp;<label for="for_oricosc">ショッピングクレジット</label></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_rakuten" value="rakuten" onclick="initDisplay();">&nbsp;<label for="for_rakuten">楽天ID決済</label></td>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_recruit" value="recruit" onclick="initDisplay();">&nbsp;<label for="for_recruit">リクルート</label></td>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_linepay" value="linepay" onclick="initDisplay();">&nbsp;<label for="for_linepay">LINE Pay</label></td>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_masterpass" value="masterpass" onclick="initDisplay();">&nbsp;<label for="for_masterpass">MasterPass決済</label></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="serviceTypeCd[]" id="for_virtualacc" value="virtualacc" onclick="initDisplay();">&nbsp;<label for="for_virtualacc">銀行振込決済</label></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="ititle">取引ID</td>
        <td class="ivalue"><input type="text" name="orderId" maxlength="100" size="30" value=""></td>
      </tr>
      <tr>
        <td class="ititle">リクエストID</td>
        <td class="ivalue"><input type="text" name="requestId" maxlength="128" size="70"></td>
      </tr>
      <tr>
        <td class="ititle">コマンド</td>
        <td class="ivalue">
          <table border="0">
            <tr>
              <td><input type="checkbox" name="command[]" id="for_Authorize" value="Authorize"> <label for="for_Authorize">Authorize</label></td>
              <td><input type="checkbox" name="command[]" id="for_ReAuthorize" value="ReAuthorize"> <label for="for_ReAuthorize">ReAuthorize</label></td>
              <td><input type="checkbox" name="command[]" id="for_Capture" value="Capture"> <label for="for_Capture">Capture</label></td>
              <td><input type="checkbox" name="command[]" id="for_Cancel" value="Cancel"> <label for="for_Cancel">Cancel</label></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="command[]" id="for_Refund" value="Refund"> <label for="for_Refund">Refund</label></td>
              <td><input type="checkbox" name="command[]" id="for_Retry" value="Retry"> <label for="for_Retry">Retry</label></td>
              <td><input type="checkbox" name="command[]" id="for_Verify" value="Verify"> <label for="for_Verify">Verify</label></td>
              <td><input type="checkbox" name="command[]" id="for_Terminate" value="Terminate"> <label for="for_Terminate">Terminate</label></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="command[]" id="for_Remove" value="Remove"> <label for="for_Remove">Remove</label></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="ititle">ステータスコード</td>
        <td class="ivalue">
          <table border="0">
            <tr>
              <td><input type="checkbox" name="mstatus[]" id="for_success" value="success"> <label for="for_success">success</label></td>
              <td><input type="checkbox" name="mstatus[]" id="for_failure" value="failure"> <label for="for_failure">failure</label></td>
              <td><input type="checkbox" name="mstatus[]" id="for_pending" value="pending"> <label for="for_pending">pending</label></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="ititle">オーダー決済状態</td>
        <td class="ivalue">
          <table border="0">
            <tr>
              <td><input type="checkbox" name="orderStatus[]" id="for_end" value="end"> <label for="for_end">end</label></td>
              <td><input type="checkbox" name="orderStatus[]" id="for_end_presentation" value="end_presentation"> <label for="for_end_presentation">end_presentation</label></td>
              <td><input type="checkbox" name="orderStatus[]" id="for_pending2" value="pending"> <label for="for_pending2">pending</label></td>
              <td><input type="checkbox" name="orderStatus[]" id="for_expired" value="expired"> <label for="for_expired">expired</label></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="orderStatus[]" id="for_error" value="error"> <label for="for_error">error</label></td>
              <td><input type="checkbox" name="orderStatus[]" id="for_validation_error" value="validation_error"> <label for="for_validation_error">validation_error</label></td>
              <td colspan="2"><input type="checkbox" name="orderStatus[]" id="for_initial" value="initial"> <label for="for_initial">initial</label></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="ititle">取引日時(From～To)</td>
        <td class="ivalue">
          <input type="text" name="txnDatatimeFrom" maxlength="12" size="13">
          ～
          <input type="text" name="txnDatatimeTo" maxlength="12" size="13">
          &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font>
        </td>
      </tr>
      <tr>
        <td class="ititle">金額(From～To)</td>
        <td class="ivalue">
          <input type="text" name="amountFrom" maxlength="12" size="13">
          ～
          <input type="text" name="amountTo" maxlength="12" size="13">
        </td>
      </tr>
      <tr>
        <td class="ititle">最新トランザクションのみ</td>
        <td class="ivalue"><input type="checkbox" name="isNewerTxn" id="for_newerTxn" value="true" checked >&nbsp;<label for="for_newerTxn">最新トランザクションのみ</label></td>
      </tr>
    </table>
    <br/>

    <div id="card">
      <div class="lhtitle">サービス固有項目（カード）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">3DﾄﾗﾝｻﾞｸｼｮﾝID</td>
          <td class="ivaluetop"><input type="text" name="card_dddTransactionId" maxlength="28" size="30"></td>
        </tr>
      </table>
      <br/>
    </div>

    <div id="mpi">
      <div class="lhtitle">サービス固有項目（MPI）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">3DﾄﾗﾝｻﾞｸｼｮﾝID</td>
          <td class="ivaluetop"><input type="text" name="mpi_res3dTransactionId" maxlength="28" size="30"></td>
        </tr>
        <tr>
          <td class="ititle">3Dﾄﾗﾝｻﾞｸｼｮﾝｽﾃｰﾀｽ</td>
          <td class="ivalue"><input type="text" name="mpi_res3dTransactionStatus" maxlength="1" size="2"></td>
        </tr>
        <tr>
          <td class="ititle">ECI</td>
          <td class="ivalue"><input type="text" name="mpi_res3dEci" maxlength="2" size="3"></td>
        </tr>
      </table>
      <br/>
    </div>

    <div id="em">
      <div class="lhtitle">サービス固有項目（電子マネー）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">電子マネー種別</td>
          <td class="ivaluetop">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="em_emType[]" id="for_edy" value="edy">&nbsp;<label for="for_edy">edy</label></td>
                <td><input type="checkbox" name="em_emType[]" id="for_suica" value="suica">&nbsp;<label for="for_suica">suica</label></td>
                <td><input type="checkbox" name="em_emType[]" id="for_waon" value="waon">&nbsp;<label for="for_waon">waon</label></td>
                <td><input type="checkbox" name="em_emType[]" id="for_tcc" value="tcc">&nbsp;<label for="for_tcc">nanaco</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">支払/受取期限</td>
          <td class="ivalue">
            <input type="text" name="em_settlementLimitFrom" maxlength="12" size="13">
            ～
            <input type="text" name="em_settlementLimitTo" maxlength="12" size="13">
            &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font>
          </td>
        </tr>
        <tr>
          <td class="ititle">支払完了日時</td>
          <td class="ivalue">
            <input type="text" name="em_completeDatetimeFrom" maxlength="12" size="13">
            ～
            <input type="text" name="em_completeDatetimeTo" maxlength="12" size="13">
            &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font>
          </td>
        </tr>
        <tr>
          <td class="ititle">受付番号</td>
          <td class="ivalue"><input type="text" name="em_receiptNo" maxlength="64" size="75"></td>
        </tr>
      </table>
      <br/>
    </div>

    <div id="cvs">
      <div class="lhtitle">サービス固有項目（コンビニ）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">コンビニタイプ</td>
          <td class="ivaluetop">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="cvs_cvsType[]" id="for_sej" value="sej"> <label for="for_sej">ｾﾌﾞﾝｲﾚﾌﾞﾝ</label></td>
                <td><input type="checkbox" name="cvs_cvsType[]" id="for_econ" value="econ"> <label for="for_econ">ﾛｰｿﾝ､ﾌｧﾐﾘｰﾏｰﾄ&nbsp;etc...</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="cvs_cvsType[]" id="for_other" value="other"> <label for="for_other">ｻｰｸﾙKｻﾝｸｽ､ﾃﾞｲﾘｰﾔﾏｻﾞｷ&nbsp;etc...</label></td>
                <td>&nbsp;</td>
                </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">支払期限</td>
          <td class="ivalue">
            <input type="text" name="cvs_payLimitFrom" maxlength="12" size="13">
            ～
            <input type="text" name="cvs_payLimitTo" maxlength="12" size="13">
            &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font>
          </td>
        </tr>
        <tr>
          <td class="ititle">支払期限日時</td>
          <td class="ivalue">
            <input type="text" name="cvs_payLimitDatetimeFrom" maxlength="12" size="13">
            ～
            <input type="text" name="cvs_payLimitDatetimeTo" maxlength="12" size="13">
            &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font>
          </td>
        </tr>
        <tr>
          <td class="ititle">入金受付日</td>
          <td class="ivalue">
            <input type="text" name="cvs_paidDatetimeFrom" maxlength="12" size="13">
            ～
            <input type="text" name="cvs_paidDatetimeTo" maxlength="12" size="13">
            &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font>
          </td>
        </tr>
      </table>
      <br/>
    </div>

    <div id="bank">
      <div class="lhtitle">サービス固有項目（銀行）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">支払期限</td>
          <td class="ivaluetop">
            <input type="text" name="bank_payLimitFrom" maxlength="12" size="13">
            ～
            <input type="text" name="bank_payLimitTo" maxlength="12" size="13">
            &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font>
          </td>
        </tr>
        <tr>
          <td class="ititle">収納日時</td>
          <td class="ivalue">
            <input type="text" name="bank_receivedDatetimeFrom" maxlength="12" size="13">
            ～
            <input type="text" name="bank_receivedDatetimeTo" maxlength="12" size="13">
            &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font>
          </td>
        </tr>
        <tr>
          <td class="ititle">収納機関番号</td>
          <td class="ivalue"><input type="text" name="bank_shunoKikanNo" maxlength="8" size="9"></td>
        </tr>
        <tr>
          <td class="ititle">お客様番号</td>
          <td class="ivalue"><input type="text" name="bank_customerNo" maxlength="20" size="21"></td>
        </tr>
      </table>
      <br/>
    </div>

    <div id="paypal">
      <div class="lhtitle">サービス固有項目（PayPal）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">支払日時</td>
          <td class="ivaluetop">
            <input type="text" name="paypal_paymentDatetimeFrom" maxlength="12" size="13">
            ～
            <input type="text" name="paypal_paymentDatetimeTo" maxlength="12" size="13">
            &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font><br>
          </td>
        </tr>
        <tr>
          <td class="ititle">請求番号</td>
          <td class="ivalue"><input type="text" name="paypal_invoiceId" maxlength="127" size="30"></td>
        </tr>
        <tr>
          <td class="ititle">顧客番号</td>
          <td class="ivalue"><input type="text" name="paypal_payerId" maxlength="13" size="14"></td>
        </tr>
      </table>
      <br/>
    </div>

    <div id="saison">
      <div class="lhtitle">サービス固有項目（Saison）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">合計決済金額(From～To)</td>
          <td class="ivaluetop">
            <input type="text" name="saison_totalAmountFrom" maxlength="8" size="9">
            ～
            <input type="text" name="saison_totalAmountTo" maxlength="8" size="9">
          </td>
        </tr>
        <tr>
          <td class="ititle">ウォレット決済金額(From～To)</td>
          <td class="ivalue">
            <input type="text" name="saison_walletAmountFrom" maxlength="8" size="9">
            ～
            <input type="text" name="saison_walletAmountTo" maxlength="8" size="9">
          </td>
        </tr>
        <tr>
          <td class="ititle">カード決済金額(From～To)</td>
          <td class="ivalue">
            <input type="text" name="saison_cardAmountFrom" maxlength="8" size="9">
            ～
            <input type="text" name="saison_cardAmountTo" maxlength="8" size="9">
          </td>
        </tr>
      </table>
      <br/>
    </div>

    <div id="upop">
    <div class="lhtitle">サービス固有項目（UPOP）</div>
    <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="ititletop">決済日時(日本)</td>
      <td class="ivaluetop"><input type="radio"
        name="upop_checked_settleDatetime" value="jp"
        onChange="initUpopSettleDatetime();"
        onDblClick="this.checked=false;initUpopSettleDatetime();"> <input
        type="text" name="upop_settleDatetimeJpFrom" size="16"
        maxlength="12"> ～ <input type="text"
        name="upop_settleDatetimeJpTo" size="16" maxlength="12">
        &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font><br>
        &nbsp;&nbsp;<font size="2" color="red">※ダブルクリックすると選択を解除できます</font>
        </td>
    </tr>
    <tr>
      <td class="ititle">決済日時(中国)</td>
      <td class="ivalue"><input type="radio"
        name="upop_checked_settleDatetime" value="cn"
        onChange="initUpopSettleDatetime();"
        onDblClick="this.checked=false;initUpopSettleDatetime();"> <input
        type="text" name="upop_settleDatetimeCnFrom" size="16"
        maxlength="12"> ～ <input type="text"
        name="upop_settleDatetimeCnTo" size="16" maxlength="12">
        &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font><br>
        &nbsp;&nbsp;<font size="2" color="red">※ダブルクリックすると選択を解除できます</font>
      </td>
    </tr>
    <tr>
      <td class="ititle">詳細取引決済状態</td>
      <td class="ivalue">
        <table border="0" style="width: 1024">
        <tr>
        <td width="25%"><input type="checkbox" name="detailOrderType[]"	value="a0">与信請求</td>
        <td width="25%"><input type="checkbox" name="detailOrderType[]"	value="a">与信請求成功</td>
        <td width="25%"><input type="checkbox" name="detailOrderType[]"	value="ax">与信請求失敗</td>
        <td width="25%"><input type="checkbox" name="detailOrderType[]" value="av">与信請求の取消</td>
        </tr>
        <tr>
        <td><input type="checkbox" name="detailOrderType[]" value="pa">売上</td>
        <td><input type="checkbox" name="detailOrderType[]" value="pav">売上の取消</td>
        <td><input type="checkbox" name="detailOrderType[]" value="par">返金</td>
        <td><input type="checkbox" name="detailOrderType[]" value="pard">返金(残金なし）</td>
        </tr>
        <tr>
        <td><input type="checkbox" name="detailOrderType[]" value="ac0">与信売上請求</td>
        <td><input type="checkbox" name="detailOrderType[]" value="ac">与信売上請求成功</td>
        <td><input type="checkbox" name="detailOrderType[]" value="acx">与信売上請求失敗</td>
        <td><input type="checkbox" name="detailOrderType[]" value="acv">与信売上請求の取消</td>
        </tr>
        <tr>
        <td colspan="2"><input type="checkbox" name="detailOrderType[]"	value="acr">返金(与信売上の返金，残りの返金可能金額は1円以上の場合)</td>
        <td colspan="2"><input type="checkbox" name="detailOrderType[]" value="acrd">返金(与信売上の返金，残りの返金可能金額は0円になった場合)</td>
        </tr>
        </table>
      </td>
    </tr>
    </table>
    <br />
    </div>

    <div id="alipay">
      <div class="lhtitle">サービス固有項目（Alipay）</div>
      <table border="0" cellpadding="0" cellspacing="0" style="width: 768px;">
        <tr>
          <td class="ititletop">詳細取引決済状態</td>
           <td class="ivaluetop">
             <table border="0" >
               <tr>
                 <td>
                   <input type="checkbox" name="alipayDetailOrderType[]" value="payment_request">決済請求
                   <input type="checkbox" name="alipayDetailOrderType[]" value="payment">決済請求成功
                 </td>
                 <td>
                   <input type="checkbox" name="alipayDetailOrderType[]" value="refund_request">返金申込み請求
                   <input type="checkbox" name="alipayDetailOrderType[]" value="refund">返金成功
                 </td>
               </tr>
             </table>
           </td>
        </tr>
        <tr>
          <td class="ititle">決済種別</td>
          <td class="ivalue" style="width:540px;"> 
            <input type="checkbox" name="alipay_payType[]" value="0">オンライン
            <input type="checkbox" name="alipay_payType[]" value="1">バーコード(店舗スキャン型)
            <input type="checkbox" name="alipay_payType[]" value="2">バーコード(消費者スキャン型)
          </td>
        </tr>
        <tr>
           <td class="ititle">決済センターとの取引ID</td>
           <td class="ivalue"> <input
             type="text" name="alipay_centerTradeId" size="35"
             maxlength="64">
          </td>
        </tr>
        <tr>
          <td class="ititle">支払日時</td>
          <td class="ivalue"> <input
            type="text" name="alipay_paymentTimeFrom" size="16"
            maxlength="12"> ～ <input type="text"
            name="alipay_paymentTimeTo" size="16" maxlength="12">
            &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font>
          </td>
        </tr>
        <tr>
          <td class="ititle">清算日時</td>
          <td class="ivalue"> <input
            type="text" name="alipay_settlementTimeFrom" size="16"
            maxlength="12"> ～ <input type="text"
            name="alipay_settlementTimeTo" size="16" maxlength="12">
            &nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDDhhmm</font>
          </td>
        </tr>
      </table>
      <br />
    </div>

    <div id="carrier">
      <div class="lhtitle">サービス固有項目（キャリア）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">詳細取引決済状態</td>
          <td class="ivaluetop">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="carrier_detailOrderType[]" id="for_DetailOrderType_Init" value="Init"> <label for="for_DetailOrderType_Init">init</label></td>
                <td><input type="checkbox" name="carrier_detailOrderType[]" id="for_DetailOrderType_Auth" value="Auth"> <label for="for_DetailOrderType_Auth">与信</label></td>
                <td><input type="checkbox" name="carrier_detailOrderType[]" id="for_DetailOrderType_Deregistration" value="Deregistration"> <label for="for_DetailOrderType_Deregistration">抹消</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailOrderType[]" id="for_DetailOrderType_Terminate" value="Terminate"> <label for="for_DetailOrderType_Terminate">継続終了</label></td>
                <td><input type="checkbox" name="carrier_detailOrderType[]" id="for_DetailOrderType_PostAuth" value="PostAuth"> <label for="for_DetailOrderType_PostAuth">売上</label></td>
                <td><input type="checkbox" name="carrier_detailOrderType[]" id="for_DetailOrderType_VoidPostAuth" value="VoidPostAuth"> <label for="for_DetailOrderType_VoidPostAuth">取消(売上)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailOrderType[]" id="for_DetailOrderType_VoidAuth" value="VoidAuth"> <label for="for_DetailOrderType_VoidAuth">取消(与信)</label></td>
                <td><input type="checkbox" name="carrier_detailOrderType[]" id="for_DetailOrderType_AuthCapture" value="AuthCapture"> <label for="for_DetailOrderType_AuthCapture">与信売上</label></td>
                <td><input type="checkbox" name="carrier_detailOrderType[]" id="for_DetailOrderType_VoidAuthCapture" value="VoidAuthCapture"> <label for="for_DetailOrderType_VoidAuthCapture">取消(与信売上)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailOrderType[]" id="for_DetailOrderType_ExpiredAuth" value="ExpiredAuth"> <label for="for_DetailOrderType_ExpiredAuth">与信有効期限切れ</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">キャリアサービスタイプ</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="carrier_crServiceType[]" id="for_Au" value="au"> <label for="for_Au">au</label></td>
                <td><input type="checkbox" name="carrier_crServiceType[]" id="for_Docomo" value="docomo"> <label for="for_Docomo">docomo</label></td>
                <td><input type="checkbox" name="carrier_crServiceType[]" id="for_SbKtai" value="sb_ktai"> <label for="for_SbKtai">ソフトバンクまとめて支払い（B）</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_crServiceType[]" id="for_SbMatomete" value="sb_matomete"> <label for="for_SbMatomete">ソフトバンクまとめて支払い（A）</label></td>
                <td><input type="checkbox" name="carrier_crServiceType[]" id="for_SBikkuri" value="s_bikkuri"> <label for="for_SBikkuri">S!まとめて支払い</label></td>
                <td><input type="checkbox" name="carrier_crServiceType[]" id="for_Flets" value="flets"> <label for="for_Flets">フレッツまとめて支払い</label></td>
              </tr>
            </table><br/>
            <font size="2" color="red">※ソフトバンクまとめて支払い（B）：旧ソフトバンクケータイ支払い
              <br/>※ソフトバンクまとめて支払い（A）：旧ソフトバンクまとめて支払い
            </font>
          </td>
        </tr>
        <tr>
          <td class="ititle">課金種別</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="radio" name="carrier_accountingType" value="0" onDblClick="this.checked=false;"><label for="for_AcctountingType_0">都度</label></td>
                <td><input type="radio" name="carrier_accountingType" value="1" onDblClick="this.checked=false;"><label for="for_AcctountingType_1">継続</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">商品タイプ</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="carrier_itemType[]" id="for_ItemType_0" value="0"> <label for="for_ItemType_0">デジタルコンテンツ</label></td>
                <td><input type="checkbox" name="carrier_itemType[]" id="for_ItemType_1" value="1"> <label for="for_ItemType_1">物販</label></td>
                <td><input type="checkbox" name="carrier_itemType[]" id="for_ItemType_2" value="2"> <label for="for_ItemType_2">役務</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">継続状態フラグ</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="carrier_mpStatus[]" id="for_MpStatus_1" value="1"> <label for="for_MpStatus_1">継続中</label></td>
                <td><input type="checkbox" name="carrier_mpStatus[]" id="for_MpStatus_8" value="8"> <label for="for_MpStatus_8">登録抹消</label></td>
                <td><input type="checkbox" name="carrier_mpStatus[]" id="for_MpStatus_9" value="9"> <label for="for_MpStatus_9">継続終了</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">端末種別</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="carrier_terminalKind[]" id="for_TerminalKind_0" value="0"> <label for="for_TerminalKind_0">PC</label></td>
                <td><input type="checkbox" name="carrier_terminalKind[]" id="for_TerminalKind_1" value="1"> <label for="for_TerminalKind_1">スマートフォン</label></td>
                <td><input type="checkbox" name="carrier_terminalKind[]" id="for_TerminalKind_2" value="2"> <label for="for_TerminalKind_2">フィーチャーフォン</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">詳細コマンドタイプ</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_Init" value="Init"> <label for="for_DetailCommandType_Init">Init</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_PreOpenId" value="PreOpenId"> <label for="for_DetailCommandType_PreOpenId">PreOpenId</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_PostOpenId" value="PostOpenId"> <label for="for_DetailCommandType_PostOpenId">PostOpenId</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_PreAuth" value="PreAuth"> <label for="for_DetailCommandType_PreAuth">PreAuth</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_Auth" value="Auth"> <label for="for_DetailCommandType_Auth">Auth</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_MAuth" value="MAuth"> <label for="for_DetailCommandType_MAuth">MAuth</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_Deregistration" value="Deregistration"> <label for="for_DetailCommandType_Deregistration">Deregistration</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_UserTerminatePreOpenId" value="UserTerminatePreOpenId"> <label for="for_DetailCommandType_UserTerminatePreOpenId">UserTerminatePreOpenId</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_UserTerminatePostOpenId" value="UserTerminatePostOpenId"> <label for="for_DetailCommandType_UserTerminatePostOpenId">UserTerminatePostOpenId</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_UserTerminatePreAuth" value="UserTerminatePreAuth"> <label for="for_DetailCommandType_UserTerminatePreAuth">UserTerminatePreAuth</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_UserTerminate" value="UserTerminate"> <label for="for_DetailCommandType_UserTerminate">UserTerminate</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_TerminateReq" value="TerminateReq"> <label for="for_DetailCommandType_TerminateReq">TerminateReq</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_Terminate" value="Terminate"> <label for="for_DetailCommandType_Terminate">Terminate</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_PostAuthReq" value="PostAuthReq"> <label for="for_DetailCommandType_PostAuthReq">PostAuthReq</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_PostAuth" value="PostAuth"> <label for="for_DetailCommandType_PostAuth">PostAuth</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_RefundPostAuthReq" value="RefundPostAuthReq"> <label for="for_DetailCommandType_RefundPostAuthReq">RefundPostAuthReq</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_RefundPostAuth" value="RefundPostAuth"> <label for="for_DetailCommandType_RefundPostAuth">RefundPostAuth</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_VoidPostAuthReq" value="VoidPostAuthReq"> <label for="for_DetailCommandType_VoidPostAuthReq">VoidPostAuthReq</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_VoidPostAuth" value="VoidPostAuth"> <label for="for_DetailCommandType_VoidPostAuth">VoidPostAuth</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_VoidAuthReq" value="VoidAuthReq"> <label for="for_DetailCommandType_VoidAuthReq">VoidAuthReq</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_VoidAuth" value="VoidAuth"> <label for="for_DetailCommandType_VoidAuth">VoidAuth</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_AuthCapture" value="AuthCapture"> <label for="for_DetailCommandType_AuthCapture">AuthCapture</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_EmuAuth" value="EmuAuth"> <label for="for_DetailCommandType_EmuAuth">EmuAuth</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_EmuPostAuthReq" value="EmuPostAuthReq"> <label for="for_DetailCommandType_EmuPostAuthReq">EmuPostAuthReq</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_EmuPostAuth" value="EmuPostAuth"> <label for="for_DetailCommandType_EmuPostAuth">EmuPostAuth</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_RefundAuthCaptureReq" value="RefundAuthCaptureReq"> <label for="for_DetailCommandType_RefundAuthCaptureReq">RefundAuthCaptureReq</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_RefundAuthCapture" value="RefundAuthCapture"> <label for="for_DetailCommandType_RefundAuthCapture">RefundAuthCapture</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_VoidAuthCaptureReq" value="VoidAuthCaptureReq"> <label for="for_DetailCommandType_VoidAuthCaptureReq">VoidAuthCaptureReq</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_VoidAuthCapture" value="VoidAuthCapture"> <label for="for_DetailCommandType_VoidAuthCapture">VoidAuthCapture</label></td>
                <td><input type="checkbox" name="carrier_detailCommandType[]" id="for_DetailCommandType_ExpiredAuth" value="ExpiredAuth"> <label for="for_DetailCommandType_ExpiredAuth">ExpiredAuth</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">初回課金年月日</td>
          <td class="ivalue"><input type="text" name="carrier_mpFirstDate" size="10" maxlength="8">&nbsp;&nbsp;<font size="2" color="red">形式：YYYYMMDD</font></td>
        </tr>
        <tr>
          <td class="ititle">継続課金日</td>
          <td class="ivalue"><input type="text" name="carrier_mpDay" size="3" maxlength="2">&nbsp;&nbsp;<font size="2" color="red">1～31または99（月末）</font></td>
        </tr>
        <tr>
          <td class="ititle">商品番号</td>
          <td class="ivalue"><input type="text" name="carrier_itemId" maxlength="18" size="20" value=""></td>
        </tr>
      </table>
      <br/>
    </div>
    <div id="oricosc">
      <div class="lhtitle">サービス固有項目（ショッピングクレジット）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">注文番号</td>
          <td class="ivaluetop"><input type="text" name="oricosc_oricoOrderNo" maxlength="20" size="20"></td>
        </tr>
        <tr>
          <td class="ititle">支払金額合計(From～To)</td>
          <td class="ivalue">
            <input type="text" name="oricosc_amountFrom" maxlength="8" size="9">
            ～
            <input type="text" name="oricosc_amountTo" maxlength="8" size="9">
          </td>
        </tr>
        <tr>
          <td class="ititle">商品価格合計(税込)(From～To)</td>
          <td class="ivalue">
            <input type="text" name="oricosc_totalItemAmountFrom" maxlength="8" size="9">
            ～
            <input type="text" name="oricosc_totalItemAmountTo" maxlength="8" size="9">
          </td>
        </tr>
      </table>
      <br/>
    </div>
    <div id="rakuten">
      <div class="lhtitle">サービス固有項目（楽天ID決済）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">詳細オーダー決済状態</td>
          <td class="ivaluetop">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_Init" value="Init"> <label for="rakuten_DetailOrderType_Init">init</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_Auth" value="Auth"> <label for="rakuten_DetailOrderType_Auth"></label>与信</td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_PostAuthReq" value="PostAuthReq"> <label for="rakuten_DetailOrderType_PostAuthReq"></label>売上要求</td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_PostAuth" value="PostAuth"> <label for="rakuten_DetailOrderType_PostAuth">売上</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_PostAuthFail" value="PostAuthFail"> <label for="rakuten_DetailOrderType_PostAuthFail">売上失敗</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_VoidPostAuthReq" value="VoidPostAuthReq"> <label for="rakuten_DetailOrderType_VoidPostAuthReq">取消要求(売上)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_VoidPostAuth" value="VoidPostAuth"> <label for="rakuten_DetailOrderType_VoidPostAuth">取消(売上)</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_ChangePostAuthReq" value="ChangePostAuthReq"> <label for="rakuten_DetailOrderType_ChangePostAuthReq">変更要求(売上)</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_ChangePostAuth" value="ChangePostAuth"> <label for="rakuten_DetailOrderType_ChangePostAuth">変更(売上)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_VoidAuthReq" value="VoidAuthReq"> <label for="rakuten_DetailOrderType_VoidAuthReq">取消要求(与信)</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_VoidAuth" value="VoidAuth"> <label for="rakuten_DetailOrderType_VoidAuth">取消(与信)</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_ChangeAuthReq" value="ChangeAuthReq"> <label for="rakuten_DetailOrderType_ChangeAuthReq">変更要求(与信)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_ChangeAuth" value="ChangeAuth"> <label for="rakuten_DetailOrderType_ChangeAuth">変更(与信)</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_AuthCapture" value="AuthCapture"> <label for="rakuten_DetailOrderType_AuthCapture">与信売上</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_AuthCaptureFail" value="AuthCaptureFail"> <label for="rakuten_DetailOrderType_AuthCaptureFail">与信売上失敗</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_VoidAuthCaptureReq" value="VoidAuthCaptureReq"> <label for="rakuten_DetailOrderType_VoidAuthCaptureReq">取消要求(与信売上)</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_VoidAuthCapture" value="VoidAuthCapture"> <label for="rakuten_DetailOrderType_VoidAuthCapture">取消(与信売上)</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_ChangeAuthCaptureReq" value="ChangeAuthCaptureReq"> <label for="rakuten_DetailOrderType_ChangeAuthCaptureReq">変更要求(与信売上)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_ChangeAuthCapture" value="ChangeAuthCapture"> <label for="rakuten_DetailOrderType_ChangeAuthCapture">変更(与信売上)</label></td>
                <td><input type="checkbox" name="rakuten_detailOrderType[]" id="rakuten_DetailOrderType_ExpiredAuth" value="ExpiredAuth"> <label for="rakuten_DetailCommandType_ExpiredAuth">与信無効</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">詳細コマンドタイプ名</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_Init" value="Init"> <label for="rakuten_DetailCommandType_Init">init</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_Accept" value="Accept"> <label for="rakuten_DetailCommandType_Accept">受付</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_PreAuth" value="PreAuth"> <label for="rakuten_DetailCommandType_PreAuth">決済認可</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_Auth" value="Auth"> <label for="rakuten_DetailCommandType_Auth"></label>与信</td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_AuthFail" value="AuthFail"> <label for="rakuten_DetailCommandType_AuthFail"></label>与信失敗</td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_PostAuthReq" value="PostAuthReq"> <label for="rakuten_DetailCommandType_PostAuthReq">売上要求</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_PostAuth" value="PostAuth"> <label for="rakuten_DetailCommandType_PostAuth">売上</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_PostAuthFail" value="PostAuthFail"> <label for="rakuten_DetailCommandType_PostAuthFail">売上失敗</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_VoidPostAuthReq" value="VoidPostAuthReq"> <label for="rakuten_DetailCommandType_VoidPostAuthReq">取消要求(売上)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_VoidPostAuth" value="VoidPostAuth"> <label for="rakuten_DetailCommandType_VoidPostAuth">取消(売上)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_ChangePostAuthReq" value="ChangePostAuthReq"> <label for="rakuten_DetailCommandType_ChangePostAuthReq">変更要求(売上)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_ChangePostAuth" value="ChangePostAuth"> <label for="rakuten_DetailCommandType_ChangePostAuth">変更(売上)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_VoidAuthReq" value="VoidAuthReq"> <label for="rakuten_DetailCommandType_VoidAuthReq">取消要求(与信)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_VoidAuth" value="VoidAuth"> <label for="rakuten_DetailCommandType_VoidAuth">取消(与信)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_ChangeAuthReq" value="ChangeAuthReq"> <label for="rakuten_DetailCommandType_ChangeAuthReq">変更要求(与信)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_ChangeAuth" value="ChangeAuth"> <label for="rakuten_DetailCommandType_ChangeAuth">変更(与信)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_AuthCapture" value="AuthCapture"> <label for="rakuten_DetailCommandType_AuthCapture">与信売上</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_AuthCaptureFail" value="AuthCaptureFail"> <label for="rakuten_DetailCommandType_AuthCaptureFail">与信売上失敗</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_EmuAuth" value="EmuAuth"> <label for="rakuten_DetailCommandType_EmuAuth">与信(与信売上Emu)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_EmuPostAuthReq" value="EmuPostAuthReq"> <label for="rakuten_DetailCommandType_EmuPostAuthReq">売上要求(与信売上Emu)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_EmuPostAuth" value="EmuPostAuth"> <label for="rakuten_DetailCommandType_EmuPostAuth">売上(与信売上Emu)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_EmuPostAuthFail" value="EmuPostAuthFail"> <label for="rakuten_DetailCommandType_EmuPostAuthFail">売上失敗(与信売上Emu)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_VoidAuthCaptureReq" value="VoidAuthCaptureReq"> <label for="rakuten_DetailCommandType_VoidAuthCaptureReq">取消要求(与信売上)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_VoidAuthCapture" value="VoidAuthCapture"> <label for="rakuten_DetailCommandType_VoidAuthCapture">取消(与信売上)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_ChangeAuthCaptureReq" value="ChangeAuthCaptureReq"> <label for="rakuten_DetailCommandType_ChangeAuthCaptureReq">変更要求(与信売上)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_ChangeAuthCapture" value="ChangeAuthCapture"> <label for="rakuten_DetailCommandType_ChangeAuthCapture">変更(与信売上)</label></td>
                <td><input type="checkbox" name="rakuten_detailCommandType[]" id="rakuten_DetailCommandType_ExpiredAuth" value="ExpiredAuth"> <label for="rakuten_DetailCommandType_ExpiredAuth">与信無効</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">商品番号</td>
          <td class="ivalue"><input type="text" name="rakuten_itemId" maxlength="100" size="20" value=""></td>
        </tr>
      </table>
      <br/>
    </div>
    <div id="recruit">
      <div class="lhtitle">サービス固有項目(リクルートかんたん支払い）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">詳細オーダー決済状態</td>
          <td class="ivaluetop">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_Init" value="Init"> <label for="recruit_DetailOrderType_Init">init</label></td>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_Auth" value="Auth"> <label for="recruit_DetailOrderType_Auth"></label>与信</td>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_PostAuth" value="PostAuth"> <label for="recruit_DetailOrderType_PostAuth">売上</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_VoidPostAuth" value="VoidPostAuth"> <label for="recruit_DetailOrderType_VoidPostAuth">取消(売上)</label></td>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_ChangePostAuth" value="ChangePostAuth"> <label for="recruit_DetailOrderType_ChangePostAuth">変更(売上)</label></td>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_VoidAuth" value="VoidAuth"> <label for="recruit_DetailOrderType_VoidAuth">取消(与信)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_ChangeAuth" value="ChangeAuth"> <label for="recruit_DetailOrderType_ChangeAuth">変更(与信)</label></td>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_AuthCapture" value="AuthCapture"> <label for="recruit_DetailOrderType_AuthCapture">与信売上</label></td>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_VoidAuthCapture" value="VoidAuthCapture"> <label for="recruit_DetailOrderType_VoidAuthCapture">取消(与信売上)</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_ChangeAuthCapture" value="ChangeAuthCapture"> <label for="recruit_DetailOrderType_ChangeAuthCapture">変更(与信売上)</label></td>
                <td><input type="checkbox" name="recruit_detailOrderType[]" id="recruit_DetailOrderType_ExpiredAuth" value="ExpiredAuth"> <label for="recruit_DetailOrderType_ExpiredAuth">与信無効</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">詳細コマンドタイプ名</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_Init" value="Init"> <label for="recruit_DetailCommandType_Init">init</label></td>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_PreAuth" value="PreAuth"> <label for="recruit_DetailCommandType_PreAuth">PreAuth</label></td>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_Auth" value="Auth"> <label for="recruit_DetailCommandType_Auth"></label>Auth</td>
              </tr>
              <tr>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_PostAuthReq" value="PostAuthReq"> <label for="recruit_DetailCommandType_PostAuthReq">PostAuthReq</label></td>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_PostAuth" value="PostAuth"> <label for="recruit_DetailCommandType_PostAuth">PostAuth</label></td>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_VoidPostAuth" value="VoidPostAuth"> <label for="recruit_DetailCommandType_VoidPostAuth">VoidPostAuth</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_ChangePostAuth" value="ChangePostAuth"> <label for="recruit_DetailCommandType_ChangePostAuth">ChangePostAuth</label></td>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_VoidAuth" value="VoidAuth"> <label for="recruit_DetailCommandType_VoidAuth">VoidAuth</label></td>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_EmuAuth" value="EmuAuth"> <label for="recruit_DetailCommandType_EmuAuth">EmuAuth</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_EmuPostAuthReq" value="EmuPostAuthReq"> <label for="recruit_DetailCommandType_EmuPostAuthReq">EmuPostAuthReq</label></td>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_EmuPostAuth" value="EmuPostAuth"> <label for="recruit_DetailCommandType_EmuPostAuth">EmuPostAuth</label></td>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_VoidAuthCapture" value="VoidAuthCapture"> <label for="recruit_DetailCommandType_VoidAuthCapture">VoidAuthCapture</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_ChangeAuthCapture" value="ChangeAuthCapture"> <label for="recruit_DetailCommandType_ChangeAuthCapture">ChangeAuthCapture</label></td>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_ExpiredAuth" value="ExpiredAuth"> <label for="recruit_DetailCommandType_ExpiredAuth">ExpiredAuth</label></td>
                <td><input type="checkbox" name="recruit_detailCommandType[]" id="recruit_DetailCommandType_ExtendAuth" value="ExtendAuth"> <label for="recruit_DetailCommandType_ExtendAuth">ExtendAuth</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">商品番号</td>
          <td class="ivalue"><input type="text" name="recruit_itemId" maxlength="100" size="20" value=""></td>
        </tr>
      </table>
      <br/>
    </div>
    <div id="linepay">
      <div class="lhtitle">サービス固有項目(LINE Pay）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">詳細オーダー決済状態</td>
          <td class="ivaluetop">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="linepay_detailOrderType[]" id="linepay_DetailOrderType_Init" value="Init"> <label for="linepay_DetailOrderType_Init">init</label></td>
                <td><input type="checkbox" name="linepay_detailOrderType[]" id="linepay_DetailOrderType_Auth" value="Auth"> <label for="linepay_DetailOrderType_Auth">与信</label></td>
                <td><input type="checkbox" name="linepay_detailOrderType[]" id="linepay_DetailOrderType_PostAuth" value="PostAuth"> <label for="linepay_DetailOrderType_PostAuth">売上</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="linepay_detailOrderType[]" id="linepay_DetailOrderType_VoidPostAuth" value="VoidPostAuth"> <label for="linepay_DetailOrderType_VoidPostAuth">取消(売上)</label></td>
                <td><input type="checkbox" name="linepay_detailOrderType[]" id="linepay_DetailOrderType_VoidAuth" value="VoidAuth"> <label for="linepay_DetailOrderType_VoidAuth">取消(与信)</label></td>
                <td><input type="checkbox" name="linepay_detailOrderType[]" id="linepay_DetailOrderType_AuthCapture" value="AuthCapture"> <label for="linepay_DetailOrderType_AuthCapture">与信売上</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="linepay_detailOrderType[]" id="linepay_DetailOrderType_VoidAuthCapture" value="VoidAuthCapture"> <label for="linepay_DetailOrderType_VoidAuthCapture">取消(与信売上)</label></td>
                <td><input type="checkbox" name="linepay_detailOrderType[]" id="linepay_DetailOrderType_ExpiredAuth" value="ExpiredAuth"> <label for="linepay_DetailCommandType_ExpiredAuth">与信無効</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">詳細コマンドタイプ名</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_Init" value="Init"> <label for="linepay_DetailCommandType_Init">init</label></td>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_PreAuth" value="PreAuth"> <label for="linepay_DetailCommandType_PreAuth">PreAuth</label></td>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_QuitAuth" value="QuitAuth"> <label for="linepay_DetailCommandType_QuitAuth">QuitAuth</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_Auth" value="Auth"> <label for="linepay_DetailCommandType_Auth">Auth</label></td>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_PostAuth" value="PostAuth"> <label for="linepay_DetailCommandType_PostAuth">PostAuth</label></td>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_VoidPostAuth" value="VoidPostAuth"> <label for="linepay_DetailCommandType_VoidPostAuth">VoidPostAuth</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_VoidAuth" value="VoidAuth"> <label for="linepay_DetailCommandType_VoidAuth">VoidAuth</label></td>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_AuthFail" value="AuthFail"> <label for="linepay_DetailCommandType_AuthFail">AuthFail</label></td>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_AuthCapture" value="AuthCapture"> <label for="linepay_DetailCommandType_AuthCapture">AuthCapture</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_VoidAuthCapture" value="VoidAuthCapture"> <label for="linepay_DetailCommandType_VoidAuthCapture">VoidAuthCapture</label></td>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_AuthCaptureFail" value="AuthCaptureFail"> <label for="linepay_DetailCommandType_AuthCaptureFail">AuthCaptureFail</label></td>
                <td><input type="checkbox" name="linepay_detailCommandType[]" id="linepay_DetailCommandType_ExpiredAuth" value="ExpiredAuth"> <label for="linepay_DetailCommandType_ExpiredAuth">ExpiredAuth</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">商品番号</td>
          <td class="ivalue"><input type="text" name="linepay_itemId" maxlength="64" size="20" value=""></td>
        </tr>
      </table>
      <br/>
    </div>
    <div id="masterpass">
      <div class="lhtitle">サービス固有項目（MasterPass）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">詳細オーダー決済状態</td>
          <td class="ivaluetop">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="masterpass_detailOrderType[]" id="masterpass_DetailOrderType_Init" value="Init"> <label for="masterpass_DetailOrderType_Init">init</label></td>
                <td><input type="checkbox" name="masterpass_detailOrderType[]" id="masterpass_DetailOrderType_Auth" value="Auth"> <label for="masterpass_DetailOrderType_Auth"></label>与信</td>
                <td><input type="checkbox" name="masterpass_detailOrderType[]" id="masterpass_DetailOrderType_PostAuth" value="PostAuth"> <label for="masterpass_DetailOrderType_PostAuth">売上</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="masterpass_detailOrderType[]" id="masterpass_DetailOrderType_VoidPostAuth" value="VoidPostAuth"> <label for="masterpass_DetailOrderType_VoidPostAuth">取消(売上)</label></td>
                <td><input type="checkbox" name="masterpass_detailOrderType[]" id="masterpass_DetailOrderType_VoidAuth" value="VoidAuth"> <label for="masterpass_DetailOrderType_VoidAuth">取消(与信)</label></td>
                <td><input type="checkbox" name="masterpass_detailOrderType[]" id="masterpass_DetailOrderType_AuthCapture" value="AuthCapture"> <label for="masterpass_DetailOrderType_AuthCapture">与信売上</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="masterpass_detailOrderType[]" id="masterpass_DetailOrderType_VoidAuthCapture" value="VoidAuthCapture"> <label for="masterpass_DetailOrderType_VoidAuthCapture">取消(与信売上)</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">詳細コマンドタイプ名</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="masterpass_detailCommandType[]" id="masterpass_DetailCommandType_Init" value="Init"> <label for="masterpass_DetailCommandType_Init">Init</label></td>
                <td><input type="checkbox" name="masterpass_detailCommandType[]" id="masterpass_DetailCommandType_Login" value="Login"> <label for="masterpass_DetailCommandType_Login">Login</label></td>
                <td><input type="checkbox" name="masterpass_detailCommandType[]" id="masterpass_DetailCommandType_LoginNotify" value="LoginNotify"> <label for="masterpass_DetailCommandType_LoginNotify">LoginNotify</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="masterpass_detailCommandType[]" id="masterpass_DetailCommandType_Auth" value="Auth"> <label for="masterpass_DetailCommandType_Auth"></label>Auth</td>
                <td><input type="checkbox" name="masterpass_detailCommandType[]" id="masterpass_DetailCommandType_PostAuth" value="PostAuth"> <label for="masterpass_DetailCommandType_PostAuth">PostAuth</label></td>
                <td><input type="checkbox" name="masterpass_detailCommandType[]" id="masterpass_DetailCommandType_VoidPostAuth" value="VoidPostAuth"> <label for="masterpass_DetailCommandType_VoidPostAuth">VoidPostAuth</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="masterpass_detailCommandType[]" id="masterpass_DetailCommandType_VoidAuth" value="VoidAuth"> <label for="masterpass_DetailCommandType_VoidAuth">VoidAuth</label></td>
                <td><input type="checkbox" name="masterpass_detailCommandType[]" id="masterpass_DetailCommandType_AuthCapture" value="AuthCapture"> <label for="masterpass_DetailCommandType_AuthCapture">AuthCapture</label></td>
                <td><input type="checkbox" name="masterpass_detailCommandType[]" id="masterpass_DetailCommandType_VoidAuthCapture" value="VoidAuthCapture"> <label for="masterpass_DetailCommandType_VoidAuthCapture">VoidAuthCapture</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">商品番号</td>
          <td class="ivalue"><input type="text" name="masterpass_itemId" maxlength="64" size="20" value=""></td>
        </tr>
        <tr>
          <td class="ititle">仕向け先コード</td>
          <td class="ivalue"><input type="text" name="masterpass_acquirerCode" maxlength="2" size="3" value=""></td>
        </tr>
      </table>
      <br/>
    </div>
    <div id="virtualacc">
      <div class="lhtitle">サービス固有項目（銀行振込決済）</div>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="ititletop">詳細オーダー決済状態</td>
          <td class="ivaluetop">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="virtualacc_detailOrderType[]" id="virtualacc_DetailOrderType_Init" value="Init"> <label for="virtualacc_DetailOrderType_Init">init</label></td>
                <td><input type="checkbox" name="virtualacc_detailOrderType[]" id="virtualacc_DetailOrderType_Auth" value="Auth"> <label for="virtualacc_DetailOrderType_Auth"></label>決済申込</td>
                <td><input type="checkbox" name="virtualacc_detailOrderType[]" id="virtualacc_DetailOrderType_Reconcile" value="Reconcile"> <label for="virtualacc_DetailOrderType_Reconcile">消込済</label></td>
                <td><input type="checkbox" name="virtualacc_detailOrderType[]" id="virtualacc_DetailOrderType_VoidAuth" value="VoidAuth"> <label for="virtualacc_DetailOrderType_VoidAuth">取消</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">詳細コマンドタイプ名</td>
          <td class="ivalue">
            <table border="0">
              <tr>
                <td><input type="checkbox" name="virtualacc_detailCommandType[]" id="virtualacc_DetailCommandType_Init" value="Init"> <label for="virtualacc_DetailCommandType_Init">Init</label></td>
                <td><input type="checkbox" name="virtualacc_detailCommandType[]" id="virtualacc_DetailCommandType_Auth" value="Auth"> <label for="virtualacc_DetailCommandType_Auth"></label>Auth</td>
                <td><input type="checkbox" name="virtualacc_detailCommandType[]" id="virtualacc_DetailCommandType_DepositEntry" value="DepositEntry"> <label for="virtualacc_DetailCommandType_DepositEntry">DepositEntry</label></td>
                <td><input type="checkbox" name="virtualacc_detailCommandType[]" id="virtualacc_DetailCommandType_DepositReverse" value="DepositReverse"> <label for="virtualacc_DetailCommandType_DepositReverse">DepositReverse</label></td>
              </tr>
              <tr>
                <td><input type="checkbox" name="virtualacc_detailCommandType[]" id="virtualacc_DetailCommandType_Reconcile" value="Reconcile"> <label for="virtualacc_DetailCommandType_Reconcile">Reconcile</label></td>
                <td><input type="checkbox" name="virtualacc_detailCommandType[]" id="virtualacc_DetailCommandType_UndoReconcile" value="UndoReconcile"> <label for="virtualacc_DetailCommandType_UndoReconcile">UndoReconcile</label></td>
                <td><input type="checkbox" name="virtualacc_detailCommandType[]" id="virtualacc_DetailCommandType_VoidAuth" value="VoidAuth"> <label for="virtualacc_DetailCommandType_VoidAuth">VoidAuth</label></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="ititle">登録時振込人名</td>
          <td class="ivalue"><input type="text" name="virtualacc_entryTransferName" maxlength="64" size="80" value=""></td>
        </tr>
        <tr>
          <td class="ititle">登録時振込番号</td>
          <td class="ivalue"><input type="text" name="virtualacc_entryTransferNumber" maxlength="5" size="10" value=""></td>
        </tr>
        <tr>
          <td class="ititle">口座番号</td>
          <td class="ivalue"><input type="text" name="virtualacc_accountNumber" maxlength="7" size="10" value=""></td>
        </tr>
      </table>
      <br/>
    </div>
    <input type="submit" name="search" value="  検索  ">&nbsp;&nbsp;<font size="2" color="red">※２回以上クリックしないでください。</font>
  </form>
  <a href="../AdminMenu.php">管理メニューへ戻る</a>
  <hr/>
  <img alt='VeriTransロゴ' src='../WEB-IMG/VeriTransLogo_WH.png'>&nbsp; Copyright &copy; VeriTrans Inc. All rights reserved
</body>
</html>
