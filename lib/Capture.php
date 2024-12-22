<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\CaptureParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/CaptureParameter.php';

/**
 * Capture APIにリクエストするクラス
 * Class Capture
 * @package VtDirect\Client
 */
class Capture extends Request
{
    private $_apiPath = "/vtdirect/v2/capture";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "post");
    }

    /**
     * Capture APIにリクエストを送信するメソッド
     * @param CaptureParameter $captureParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function CaptureOrder(CaptureParameter $captureParameter)
    {
        $response = parent::Request($captureParameter);
        return $response;
    }


}