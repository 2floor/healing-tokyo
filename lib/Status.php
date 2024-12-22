<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\StatusParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/StatusParameter.php';

/**
 * @deprecated
 * Status APIにリクエストするクラス
 * Class Status
 * @package VtDirect\Client
 */
class Status extends Request
{
    private $_apiPath = "/vtdirect/v1/status";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "post");
    }

    /**
     * Status APIにリクエストを送信するメソッド
     * @param StatusParameter $statusParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function GetOrderStatus(StatusParameter $statusParameter)
    {
        $response = parent::Request($statusParameter);
        return $response;
    }
} 