<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\ReChargesParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/ReChargesParameter.php';

/**
 * @deprecated
 * ReCharges APIにリクエストするクラス
 * Class ReCharges
 * @package VtDirect\Client
 */
class ReCharges extends Request
{
    private $_apiPath = "/vtdirect/v1/recharges";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "post");
    }

    /**
     * ReCharges APIにリクエストを送信するメソッド
     * @param ReChargesParameter $reChargesParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function ReChargeWithRegisterId(ReChargesParameter $reChargesParameter)
    {
        $response = parent::Request($reChargesParameter);
        return $response;
    }

}
