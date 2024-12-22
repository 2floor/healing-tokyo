<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\CreditCardListParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/CreditCardListParameter.php';

/**
 * @deprecated
 * CreditCard/List APIにリクエストするクラス
 * Class CreditCardList
 * @package VtDirect\Client
 */
class CreditCardList extends Request
{

    private $_apiPath = "/vtdirect/v1/creditcard/list";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "post");
    }

    /**
     * CreditCard/List APIにリクエストを送信するメソッド
     * @param CreditCardListParameter $listParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function ListCreditCardBind(CreditCardListParameter $listParameter)
    {
        $response = parent::Request($listParameter);
        return $response;
    }

} 