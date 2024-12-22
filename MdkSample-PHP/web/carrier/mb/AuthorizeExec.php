<?php
# Copyright c VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// �L�����A���ς̎��s����ь��ʉ�ʂ̃T���v��
// -------------------------------------------------------------------------

define('MDK_DIR', '../../tgMdk/');

define('INPUT_PAGE', 'Authorize.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '�������');

require_once(MDK_DIR."3GPSMDK.php");

// is dummy mode?
// is dummy mode?
$config = TGMDK_Config::getInstance();
$conf   = $config->getServiceParameters();
if (isset($conf)) {
    $dummyReq = $conf["DUMMY_REQUEST"];
}

// ���ID
$order_id = @$_POST["orderId"];
// �L�����A�I��
$service_option_type = @$_POST["serviceOptionType"];
// �x�����z
$payment_amount = @$_POST["amount"];
// �[�����
$terminal_kind = @$_POST["terminalKind"];
// ���i�^�C�v
$item_type = @$_POST["itemType"];
// �s�x�p���敪
$accounting_type = @$_POST["accountingType"];
// ����ۋ��N����
$mpFirstDate = @$_POST["mpFirstDate"];
// �p���ۋ���
$mpDay = @$_POST["mpDay"];

// ���ϊ�����URL
$successUrl = @$_POST["successUrl"];
// ���σL�����Z����URL
$cancelUrl = @$_POST["cancelUrl"];
// ���σG���[��URL
$errorUrl = @$_POST["errorUrl"];
// pushURL
$pushUrl = @$_POST["pushUrl"];
// openID
$openId = @$_POST["openId"];

// �^�M���@
$is_with_capture = @$_POST["withCapture"];
if($accounting_type==0){
  if ("1" == $is_with_capture) {
    $is_with_capture = TRUE_FLAG_CODE;
  } else {
    $is_with_capture = FALSE_FLAG_CODE;
  }
}

// 3D�Z�L���A�� sb_ktai ���ΏۊO�Ȃ̂ŁA�ݒ肵�Ȃ�
// ���i���͓��̓t�B�[���h��p�ӂ��Ă��܂���

// ���i�ԍ�
if(isset($_POST["itemId"]) && trim($_POST["itemId"])){
  $item_id = @$_POST["itemId"];
}

//�T�[�o�����w��
 if (empty($order_id)){
  $warning =  "<font color='#ff0000'><b>�K�{���ځF���ID���w�肳��Ă��܂���</b></font>";
  include_once(INPUT_PAGE);
  exit;
  //�T�[�o�����w��
 } else if (empty($service_option_type)) {
  $warning =  "<font color='#ff0000'><b>�K�{���ځF�L�����A���I������Ă��܂���</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (empty($payment_amount)) {
  $warning =  "<font color='#ff0000'><b>�K�{���ځF���z���w�肳��Ă��܂���</b></font>";
  include_once(INPUT_PAGE);
  exit;
 } else if (isset($accounting_type)===false) {
  $warning =  "<font color='#ff0000'><b>�K�{���ځF�s�x�p���敪���I������Ă��܂���</b></font>";
  include_once(INPUT_PAGE);
  exit;
 }

// �v���d���p�����[�^�l�̎w��
$request_data = new CarrierAuthorizeRequestDto();

$request_data->setServiceOptionType($service_option_type);
$request_data->setOrderId($order_id);
$request_data->setAmount($payment_amount);
$request_data->setTerminalKind($terminal_kind);
$request_data->setAccountingType($accounting_type);
$request_data->setItemType($item_type);
if($accounting_type==0){
  $request_data->setWithCapture($is_with_capture);
} elseif($accounting_type==1){
  $request_data->setMpFirstDate($mpFirstDate);
  $request_data->setMpDay($mpDay);
}
$request_data->setSuccessUrl($successUrl);
$request_data->setCancelUrl($cancelUrl);
$request_data->setErrorUrl($errorUrl);
// set push url in only dummy mode.
if ($dummyReq === "1") {
  $request_data->setPushUrl($pushUrl);
}

if(isset($item_id)){
  $request_data->setItemId($item_id);
}

if($service_option_type === "docomo" || $service_option_type === "au"){
   $request_data->setOpenId($openId);
}
if($service_option_type === "s_bikkuri") {
    $sbUid = "dummyUID";
    $headers = getallheaders();
    while (list ($header, $value) = each ($headers)) {
        if ($header === "x-jphone-uid") {
            $sbUid = $value;
        }
    }
    $request_data->setSbUid($sbUid);
}

// ���{
 $transaction = new TGMDK_Transaction();
 $response_data = $transaction->execute($request_data);

 //�\�����Ȃ���O
 if (!isset($response_data)) {
  $page_title = ERROR_PAGE_TITLE;
 //�z�艞���̎擾
 } else {
  $page_title = NORMAL_PAGE_TITLE;

    /**
     * ���ID�擾
     */
    $result_order_id = $response_data->getOrderId();
    /**
     * ���ʃR�[�h�擾
     */
    $txn_status = $response_data->getMStatus();
    /**
     * �ڍ׃R�[�h�擾
     */
    $txn_result_code = $response_data->getVResultCode();
    /**
     * �G���[���b�Z�[�W�擾
     */
    $error_message = $response_data->getMerrMsg();
    /**
     * redirect URL�擾
     */
    $redirect_url = $response_data->getRedirectUrl();

  // ���O
  $test_log = "<!-- vResultCode=" . $txn_result_code . " -->";

  if (TXN_SUCCESS_CODE === $txn_status) {
      // ����
      if (empty($redirect_url) === false) {
          header("Location: " . $response_data->getRedirectUrl(), true, 301);
          exit;
      } else {
          header("Content-type: text/html; charset=Shift-JIS");
          $response_html = mb_convert_encoding($response_data->getResponseContents(), "SJIS", "UTF-8");
          echo $response_html . $test_log;
          exit;
      }
  } else {
      // �G���[�y�[�W�\��
      $html = createErrorPage($response_data);
      print $html . $test_log;
      exit;
  }
 }


 function createErrorPage($response) {

 $html = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title>�G���[�y�[�W</title>
</head>
<body>
<img alt="Payment���S" src="../../WEB-IMG/VeriTrans_Payment.png">
<br>
�L�����A���ρF�������<br>
<br/>
���ID<br>
'.$response->getOrderId().'<br>
<br>
����X�e�[�^�X<br>
'.$response->getMStatus().'<br>
<br>
���ʃR�[�h<br>
'.$response->getVResultCode().'<br>
<br>
���ʃ��b�Z�[�W<br>
'.mb_convert_encoding($response->getMerrMsg(), "SJIS", "UTF-8").'<br>
<br>

<img alt="VeriTrans���S" src="../../WEB-IMG/VeriTransLogo_WH.png"><br>
Copyright &copy; VeriTrans Inc. All rights reserved
</body></html>';

 return $html;
}
?>

