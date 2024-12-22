<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\ChargesParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/ChargesParameter.php';

/**
 * Charges APIにリクエストするクラス
 * Class Charges
 * @package VtDirect\Client
 */
class Charges extends Request
{

    private $_apiPath = "/vtdirect/v2/charges";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "post");
    }

    /**
     * Charges APIにリクエストを送信するメソッド
     * @param ChargesParameter $chargesParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function ChargeWithToken(ChargesParameter $chargesParameter)
    {
        $response = parent::Request($chargesParameter);
        return $response;
    }

}