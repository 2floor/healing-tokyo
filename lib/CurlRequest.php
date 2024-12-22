<?php

namespace VtDirect\Client;

/**
 * Curlを利用したリクエストの実装クラス
 * Class CurlRequest
 * @package VtDirect\Client
 */
class CurlRequest implements HttpRequestInterface
{

    private $_verifySsl;
    private $_clientVersion;
    private $_caCertPath;

    public function __construct($verifySsl = true, $caCertPath = "", $clientVersion = "")
    {
        $this->_verifySsl = $verifySsl;
        $this->_clientVersion = $clientVersion;
        $this->_caCertPath = $caCertPath;
    }

    public function SendRequest($url, $method, $serverKey = null, $requestBody = null)
    {
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8',
            'User-Agent: ' . 'VTDirect/v2 PhpBindings/' . $this->_clientVersion
        );
        if ($serverKey != null) {
            array_push($headers, 'Authorization: Basic ' . base64_encode($serverKey));
        }
        switch (strtolower($method)) {
            case "get" :
                return $this->CurlRequest("get", $url, $headers);
                break;
            case "post" :
                array_push($headers, 'Content-Type: application/json; charset=utf-8');
                return $this->CurlRequest("post", $url, $headers, $requestBody);
                break;
            case "put" :
                return $this->CurlRequest("put", $url, $headers, $requestBody);
                break;
            case "delete" :
                return $this->CurlRequest("delete", $url, $headers);
                break;
            default :
                return $this->CurlRequest("post", $url, $headers, $requestBody);
                break;
        }
    }

    public function SendPostRequest($url, $serverKey, $requestBody)
    {
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8',
            'User-Agent: ' . 'VTDirect/v2 PhpBindings/' . $this->_clientVersion,
            'Authorization: Basic ' . base64_encode($serverKey)
        );
        $body = $requestBody;
        return $this->CurlRequest("post", $url, $headers, $body);
    }

    public function CurlRequest($method, $url, $headers = null, $body = null)
    {
                $curl = curl_init();
        $options = array();
        switch (strtolower($method)) {
            case "get" :
                $options[CURLOPT_HTTPGET] = true;
                break;
            case "post" :
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = $body;
                break;
            case "put" :
                $options[CURLOPT_PUT] = true;
                break;
            case "delete" :
                $options[CURLOPT_CUSTOMREQUEST] = "DELETE";
                break;
            default :
                $options[CURLOPT_POST] = true;
                break;
        }
        $options[CURLOPT_URL] = $url;
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_CONNECTTIMEOUT] = 30;
        $options[CURLOPT_TIMEOUT] = 130;
        if ($headers != null) $options[CURLOPT_HTTPHEADER] = $headers;
        $options[CURLOPT_SSL_VERIFYPEER] = $this->_verifySsl;
        //$options[CURLOPT_SSLVERSION] = 6;
        $options[CURLOPT_HEADER] = false;
        if ($this->_caCertPath !== "") $options[CURLOPT_CAINFO] = $this->_caCertPath;

        $options[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;

        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        $errorNo = curl_errno($curl);
        if ($errorNo != 0) {
            $errorMessage = curl_error($curl);
            curl_close($curl);

            // Throw exception
            throw $this->HandleCurlError($errorNo, $errorMessage);
        } else {
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($status_code != 200) {
                throw new VtDirectNetworkException("Http status error occurred.", curl_error($curl), $status_code);
            } else {
                return $response;
            }

        }
    }

    public function HandleCurlError($errorNo, $errorMessage)
    {
        $message = null;
        switch ($errorNo) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_COULDNT_RESOLVE_PROXY:
            case CURLE_RECV_ERROR:
                $message = "Could not connect.";
                break;
            case CURLE_SSL_CACERT:
            case CURLE_SSL_CERTPROBLEM:
            case CURLE_SSL_CIPHER:
            case CURLE_SSL_CONNECT_ERROR:
            case CURLE_SSL_ENGINE_NOTFOUND:
            case CURLE_SSL_ENGINE_SETFAILED:
            case CURLE_SSL_PEER_CERTIFICATE:
                $message = "Could not verify SSL certificate.";
                break;
            case CURLE_HTTP_NOT_FOUND:
            case CURLE_HTTP_PORT_FAILED:
            case CURLE_HTTP_POST_ERROR:
            case CURLE_HTTP_RANGE_ERROR:
                $message = "Http error occurred.";
                break;
            case CURLE_OPERATION_TIMEOUTED:
                $message = "Operation timeout occurred.";
                break;
            default:
                $message = "Unexpected error occurred.";
        }
        return new VtDirectNetworkException($message, $errorMessage, $errorNo);
    }

} 