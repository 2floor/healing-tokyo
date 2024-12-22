<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\CreditCardDestroyParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/CreditCardDestroyParameter.php';

/**
 * @deprecated
 * CreditCard/Destroy APIにリクエストするクラス
 * Class CreditCardDestroy
 * @package VtDirect\Client
 */
class CreditCardDestroy extends Request
{
    private $_apiPath = "/vtdirect/v1/creditcard/destroy";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "post");
    }

    /**
     * CreditCard/Destroy APIにリクエストを送信するメソッド
     * @param CreditCardDestroyParameter $destroyParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function DestroyCreditCardBind(CreditCardDestroyParameter $destroyParameter)
    {
        $response = parent::Request($destroyParameter);
        return $response;
    }

} 