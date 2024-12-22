<?php
# Copyright c VeriTrans Inc. All rights reserved.

// -------------------------------------------------------------------------
// �L�����A���όp���ۋ��I���̎��s����ь��ʉ�ʂ̃T���v��
// -------------------------------------------------------------------------

define('MDK_DIR', '../../tgMdk/');

define('INPUT_PAGE', 'Terminate.php');

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('TRUE_FLAG_CODE', 'true');
define('FALSE_FLAG_CODE', 'false');

define('ERROR_PAGE_TITLE', 'System Error');
define('NORMAL_PAGE_TITLE', '�������');

require_once(MDK_DIR."3GPSMDK.php");

/**
 * ���ID
 */
$order_id = @$_POST["orderId"];

/**
 * �L�����A�I��
 */
$service_option_type = @$_POST["serviceOptionType"];

/**
 * �[�����
 */
$terminal_kind = @$_POST["terminalKind"];

/**
 * ���ϊ�����URL
 */
$successUrl = @$_POST["successUrl"];

/**
 * ���σL�����Z����URL
 */
$cancelUrl = @$_POST["cancelUrl"];

/**
 * ���σG���[��URL
 */
$errorUrl = @$_POST["errorUrl"];

/**
 * pushURL
 */
$pushUrl = @$_POST["pushUrl"];

/**
 * �����I��
 */
 if($service_option_type === "docomo"){
   $force = @$_POST["force"];
 }

/**
 * �K�{�p�����[�^�l�`�F�b�N
 */
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
 }

  /**
  * �v���d���p�����[�^�l�̎w��
  */
 $request_data = new CarrierTerminateRequestDto();

 $request_data->setOrderId($order_id);
 $request_data->setServiceOptionType($service_option_type);
 if ($service_option_type !== "au") {
  $request_data->setTerminalKind($terminal_kind);
  $request_data->setSuccessUrl($successUrl);
  $request_data->setCancelUrl($cancelUrl);
  $request_data->setErrorUrl($errorUrl);
 }
 $request_data->setPushUrl($pushUrl);

 if($service_option_type === "docomo"){
  $request_data->setForce($force);
 }

/**
 * ���{
 */
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
    /**
     * ���X�|���X�R���e���c�擾
     */
    $response_html = mb_convert_encoding($response_data->getResponseContents(), "SJIS", "UTF-8");
    /**
     * �p���ۋ��I�������擾
     */
    $terminateDateTime = $response_data->getTerminateDatetime();
    // ���O
    $test_log = "<!-- vResultCode=" . $txn_result_code . " -->";


    if($response_html){
      if (TXN_SUCCESS_CODE === $txn_status) {
          // ����
          echo $response_html . $test_log;
          exit;
      } else {
          // �G���[�y�[�W�\��
          $page_title = ERROR_PAGE_TITLE;
      }
    }
    else{
      // ����
      if (TXN_SUCCESS_CODE === $txn_status) {
          $terminateDateTime = $response_data->getTerminateDatetime();
      } else if (TXN_PENDING_CODE === $txn_status) {
      // ���s
      } else if (TXN_FAILURE_CODE === $txn_status) {
          $page_title = ERROR_PAGE_TITLE;
      }
    }


 }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
<meta http-equiv="Content-Language" content="ja" />
<title><?php echo $page_title ?></title>
</head>
<body>
<img alt="Payment���S" src="../../WEB-IMG/VeriTrans_Payment.png">
<br><br>
�L�����A���ρF�������<br>
<br>
���ID<br>
<?php echo $result_order_id ?><br>
<br>
����X�e�[�^�X<br>
<?php echo $txn_status ?><br>
<br>
���ʃR�[�h<br>
<?php echo $txn_result_code ?><br>
<br>
<?php if(isset($terminateDateTime)) { ?>
�p���ۋ��I������<br>
<?php echo $terminateDateTime ?><br>
<br>
<?php } ?>
���ʃ��b�Z�[�W<br>
<?php echo mb_convert_encoding($error_message, "SJIS", "UTF-8") ?><br>
<br/>
<img alt="VeriTrans���S" src="../../WEB-IMG/VeriTransLogo_WH.png">
<br>Copyright &copy; VeriTrans Inc. All rights reserved

</body>
</html>

