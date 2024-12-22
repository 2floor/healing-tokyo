<?php

namespace VtDirect\Client;

/**
 * Http要求のインターフェイス
 * Class HttpRequestInterface
 * @package VtDirect\Client
 */
interface HttpRequestInterface
{

    function SendRequest($url, $method, $serverKey = null, $requestBody = null);

    function SendPostRequest($url, $serverKey, $requestBody);

} 