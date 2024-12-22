<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\Account\EntryWithChargesParameter;
require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/Account/EntryWithChargesParameter.php';

class EntryWithCharges extends Request {

    private $_apiPath = "/vtdirect/v2/entry_with_charges";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest);
    }

    /**
     * EntryWithCharges APIにGETリクエストを送信するメソッド
     * @param Request\Account\EntryWithChargesParameter $entryWithChargesParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function ChargeWithEntry(EntryWithChargesParameter $entryWithChargesParameter)
    {
        $response = parent::Request($entryWithChargesParameter, "post");
        return $response;
    }


}