<?php

namespace VtDirect\Client;

use VtDirect\Client\Request\Account\EntryWithMpiChargesParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/Account/EntryWithMpiChargesParameter.php';

/**
 * Entry with MPI Charges APIにリクエストするクラス
 * Class EntryWithMpiCharges
 * @package VtDirect\Client
 */
class EntryWithMpiCharges extends Request
{

    private $_apiPath = "/vtdirect/v2/entry_with_mpi_charges";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "post");
    }

    /**
     * Entry with MPI Charges APIにリクエストを送信するメソッド
     * @param EntryWithMpiChargesParameter $entryWithMpiChargesParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function EntryWithMpiCharge(EntryWithMpiChargesParameter $entryWithMpiChargesParameter)
    {
        $response = parent::Request($entryWithMpiChargesParameter);
        return $response;
    }

}