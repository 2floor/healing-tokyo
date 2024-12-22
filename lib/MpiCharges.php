<?php

namespace VtDirect\Client;
use VtDirect\Client\Request\MpiChargesParameter;

require_once 'Setting.php';
require_once 'HttpRequestInterface.php';
require_once 'Request.php';
require_once 'CurlRequest.php';
require_once 'Request/MpiChargesParameter.php';

/**
 * MPI Charges APIにリクエストするクラス
 * Class MpiCharges
 * @package VtDirect\Client
 */
class MpiCharges extends Request
{

    private $_apiPath = "/vtdirect/v2/mpi_charges";

    public function __construct(Setting $setting, HttpRequestInterface $httpRequest = null)
    {
        parent::__construct($this->_apiPath, $setting, $httpRequest, "post");
    }

    /**
     * MPI Charges APIにリクエストを送信するメソッド
     * @param MpiChargesParameter $mpiChargesParameter
     * @return mixed APIの応答結果JSONをデシリアライズしたオブジェクト
     */
    public function MpiChargeWithToken(MpiChargesParameter $mpiChargesParameter)
    {
        $response = parent::Request($mpiChargesParameter);
        return $response;
    }

}