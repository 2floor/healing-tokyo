<?php

namespace VtDirect\Client;

use Exception;

/**
 * 本ライブラリによる処理で起こりうるネットワーク関連のエラーが発生した場合にスローされる
 * Class VtDirectNetworkException
 * @package VtDirect\Client
 */
class VtDirectNetworkException extends Exception
{

    public function __construct($message, $curlErrorMessage, $curlErrorNo, Exception $previous = null)
    {
        parent::__construct($message . "\r\n" . $curlErrorMessage, (int)$curlErrorNo, $previous);
    }

} 