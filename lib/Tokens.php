<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\TokensParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/TokensParameter.php';

/**
 * Tokens APIにリクエストするクラス
 * Class Tokens
 * @package VtDirect\Client
 */
class Tokens extends Request
{
    private $_apiPath = "/vtdirect/v2/tokens";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "get");
    }

    /**
     * Tokens APIにリクエストを送信するメソッド
     * @param TokensParameter $tokensParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function GetToken(TokensParameter $tokensParameter)
    {
        $response = parent::Request($tokensParameter, "get");
        return $response;
    }

    /**
     * URLにGETパラメータを付与する
     * @param string $url
     * @param TokensParameter $input
     * @return string
     */
    protected function GenerateAbsoluteApiUri($url, $input)
    {
        return $url . "?" . http_build_query(
            array(
                'card_number' => $input->card_number,
                'card_exp_month' => $input->card_exp_month,
                'card_exp_year' => $input->card_exp_year,
                'card_cvv' => $input->card_cvv,
                'client_key' => $input->client_key
            )
        );
    }

}