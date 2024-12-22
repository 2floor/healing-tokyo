<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\VoidParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/VoidParameter.php';

/**
 * Void APIにリクエストするクラス
 * Class Void
 * @package VtDirect\Client
 */
class Cancel extends Request
{
    private $_apiPath = "/vtdirect/v2/void";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "post");
    }

    /**
     * Void APIにリクエストを送信するメソッド
     * @param VoidParameter $voidParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function VoidOrder(VoidParameter $voidParameter)
    {
        $response = parent::Request($voidParameter);
        return $response;
    }
} 