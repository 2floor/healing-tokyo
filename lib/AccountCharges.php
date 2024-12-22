<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\Account\AccountChargesParameter;
require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/Account/AccountChargesParameter.php';

class AccountCharges extends Request {

    private $_apiPath = "/vtdirect/v2/account_charges";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest);
    }

    /**
     * AccountCharges APIにGETリクエストを送信するメソッド
     * @param AccountChargesParameter $accountChargesParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function ChargeWithCardId(AccountChargesParameter $accountChargesParameter)
    {
        $response = parent::Request($accountChargesParameter, "post");
        return $response;
    }


}