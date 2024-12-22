<?php

namespace VtDirect\Client;

use VtDirect\Client\Request\SearchParameter;
require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/SearchParameter.php';

class Search extends Request
{
    private $_apiPath = "/vtdirect/v2/search";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest);
    }

    /**
     * Search APIにリクエストを送信するメソッド
     * @param SearchParameter $searchParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     * @throws VtDirectException JSONデシリアライズに失敗したときや、不明なHttpMethodを指定されたときに投げられる例外
     */
    public function GetOrderTransactionInformation(SearchParameter $searchParameter)
    {
        $response = parent::Request($searchParameter, "get");
        return $response;
    }

    /**
     * URLにGETパラメータを付与する
     * @param string $url
     * @param SearchParameter $input
     * @return string
     */
    protected function GenerateGetApiUri($url, $input)
    {
        return $url . "?" . http_build_query(
            array(
                'test_mode' => ($input->test_mode) ? "true" : "false",
                'order_id' => $input->order_id,
                'request_id' => $input->request_id
            )
        );
    }

}