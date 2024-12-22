<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\Account\CreateAccountParameter;
use VtDirect\Client\Request\Account\DeleteAccountParameter;
use VtDirect\Client\Request\Account\GetAccountInfoParameter;
require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/Account/GetAccountInfoParameter.php';
require_once 'Request/Account/CreateAccountParameter.php';
require_once 'Request/Account/DeleteAccountParameter.php';

/**
 * Account APIにリクエストするクラス
 * Class Account
 * @package VtDirect\Client
 */
class Account extends Request
{
    private $_apiPath = "/vtdirect/v2/account";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest);
    }

    /**
     * Account APIにGETリクエストを送信するメソッド
     * @param GetAccountInfoParameter $getAccountInfoParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     * @throws VtDirectException JSONデシリアライズに失敗したときや、不明なHttpMethodを指定されたときに投げられる例外
     */
    public function GetAccountInfo(GetAccountInfoParameter $getAccountInfoParameter)
    {
        $response = parent::Request($getAccountInfoParameter, "get");
        return $response;
    }

    /**
     * @param CreateAccountParameter $createAccountParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     * @throws VtDirectException JSONデシリアライズに失敗したときや、不明なHttpMethodを指定されたときに投げられる例外
     */
    public function CreateAccount(CreateAccountParameter $createAccountParameter){
        $response = parent::Request($createAccountParameter, "post");
        return $response;
    }

    /**
     * @param DeleteAccountParameter $deleteAccountParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     * @throws VtDirectException JSONデシリアライズに失敗したときや、不明なHttpMethodを指定されたときに投げられる例外
     */
    public function DeleteAccount(DeleteAccountParameter $deleteAccountParameter){
        $response = parent::Request($deleteAccountParameter, "delete");
        return $response;
    }

    /**
     * URLにGETパラメータを付与する
     * @param string $url
     * @param GetAccountInfoParameter $input
     * @return string
     */
    protected function GenerateGetApiUri($url, $input)
    {
        return $url . "?" . http_build_query(
            array(
                'test_mode' => ($input->test_mode) ? "true" : "false",
                'account_id' => $input->account_id
            )
        );
    }

    /**
     * URLにパラメータを付与する
     * @param string $url
     * @param DeleteAccountParameter $input
     * @return string
     */
    protected function GenerateDeleteApiUri($url, $input)
    {
        return $url . "?" . http_build_query(
            array(
                'test_mode' => ($input->test_mode) ? "true" : "false",
                'account_id' => $input->account_id
            )
        );
    }


}