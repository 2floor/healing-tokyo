<?php

namespace VtDirect\Client;

use VtDirect\Client\Request\Account\AccountMpiChargesParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/Account/AccountMpiChargesParameter.php';

/**
 * Account MPI Charges APIにリクエストするクラス
 * Class AccountMpiCharges
 * @package VtDirect\Client
 */
class AccountMpiCharges extends Request
{

    private $_apiPath = "/vtdirect/v2/account_mpi_charges";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "post");
    }

    /**
     * Account MPI Charges APIにリクエストを送信するメソッド
     * @param AccountMpiChargesParameter $accountMpiChargesParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function AccountMpiCharge(AccountMpiChargesParameter $accountMpiChargesParameter)
    {
        $response = parent::Request($accountMpiChargesParameter);
        return $response;
    }

}