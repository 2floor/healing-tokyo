<?php

namespace VtDirect\Client;

use VtDirect\Client\Request\Account\Card\AddParameter;
use VtDirect\Client\Request\Account\Card\DeleteParameter;
require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/Account/Card/AddParameter.php';
require_once 'Request/Account/Card/DeleteParameter.php';

class AccountCard extends Request {

    private $_apiPath = "/vtdirect/v2/account_card";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest);
    }

    /**
     * AccountCard APIにPOSTリクエストを送信するメソッド
     * @param AddParameter $addParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     * @throws VtDirectException JSONデシリアライズに失敗したときや、不明なHttpMethodを指定されたときに投げられる例外
     */
    public function AddCard(AddParameter $addParameter){
        $response = parent::Request($addParameter, "post");
        return $response;
    }

    /**
     * AccountCard APIにDELETEリクエストを送信するメソッド
     * @param DeleteParameter $deleteParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     * @throws VtDirectException JSONデシリアライズに失敗したときや、不明なHttpMethodを指定されたときに投げられる例外
     */
    public function DeleteCard(DeleteParameter $deleteParameter){
        $response = parent::Request($deleteParameter, "delete");
        return $response;
    }

    /**
     * URLにパラメータを付与する
     * @param string $url
     * @param DeleteParameter $input
     * @return string
     */
    protected function GenerateDeleteApiUri($url, $input)
    {
        return $url . "?" . http_build_query(
            array(
                'test_mode' => ($input->test_mode) ? "true" : "false",
                'account_id' => $input->account_id,
                'card_id' => $input->card_id
            )
        );
    }


}
