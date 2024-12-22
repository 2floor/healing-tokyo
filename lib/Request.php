<?php

namespace VtDirect\Client;

/**
 * VT-Direct APIにリクエストするための基底クラス。
 * 各APIごとに本クラスを継承したクラスを用意すること。
 * Class Request
 * @package VtDirect\Client
 */
abstract class Request
{
    private $_serverKey;
    private $_apiPath;
    private $_host;
    private $_https;
    private $_port;
    private $_method;
    private $_httpRequest;

    /**
     * @param string $apiPath APIのパス
     * @param Setting $setting Settingクラスのインスタンス
     * @param HttpRequestInterface $httpRequest
     * @param string $method get,post,put,deleteなど
     */
    public function __construct($apiPath, Setting $setting, HttpRequestInterface $httpRequest = null, $method = "post")
    {
        if ($httpRequest == null) $httpRequest = new CurlRequest(
            $setting->GetSslVerifyEnabled(), $setting->GetCACertPath(), Setting::VERSION);
        $this->_httpRequest = $httpRequest;
        $this->_serverKey = $setting->GetServerKey();
        $this->_apiPath = $apiPath;
        $this->_host = $setting->GetRequestHost();
        $this->_https = $setting->GetHttpsRequestEnabled();
        $this->_port = $setting->GetRequestPort();
        $this->_method = $method;
    }

    /**
     * @param $path string APIのパス
     * @return string APIのURL
     */
    public function GenerateApiUrl($path)
    {
        if (preg_match('/\A\//', $path) == 0) {
            $path = "/" . $path;
        }

        if (preg_match('/\/\z/', $path) == 1) {
            $path = rtrim($path, "/");
        }
        $path = ($this->_https ? "https://" : "http://") . $this->_host . ":" . (string)$this->_port . $path;
        return $path;
    }

    /**
     * @param mixed $input JSONシリアライズ可能なリクエストパラメータクラスのインスタンス
     * @param string $method コンストラクタで指定したHttpMethodを書き換えたい場合はここで指定。未指定時は"post"
     * @return mixed VTDirectからの応答結果JSONをデシリアライズしたオブジェクト
     * @throws VtDirectException JSONデシリアライズに失敗したときや、不明なHttpMethodを指定されたときに投げられる例外
     * @throws VtDirectNetworkException Curl関連のエラーが発生した場合に投げられる例外
     */
    protected function Request($input, $method = "post")
    {
        $url = $this->GenerateApiUrl($this->_apiPath);
        $apiUrl = $this->GenerateAbsoluteApiUri($url, $input);
        $this->_method = $method;
        $response = null;
        switch (strtolower($this->_method)) {
            case "get" :
                $uri = $this->GenerateGetApiUri($apiUrl, $input);
                $response = $this->_httpRequest->SendRequest($uri, "get", $this->_serverKey);
                break;
            case "delete":
                $uri = $this->GenerateDeleteApiUri($apiUrl, $input);
                $response = $this->_httpRequest->SendRequest($uri, "delete", $this->_serverKey);
                break;
            case "post" :
            case "put" :
                $response = $this->_httpRequest->SendPostRequest($apiUrl, $this->_serverKey, $this->GetRequestBody($input));
                break;
            default:
                throw new VtDirectException("Unexpected method was specified. -> " . $this->_method, -1);
        }
        $responseObject = json_decode($response, true);
        $canDecode = json_last_error();
        if ($canDecode == JSON_ERROR_NONE) {
            return $responseObject;
        } else {
            throw new VtDirectException("Could not decode from JSON to php object. -> \r\n" . $response,
                json_last_error());
        }
    }

    /**
     * @param $url string APIのURL
     * @param $input mixed JSONシリアライズ可能なリクエストパラメータクラスのインスタンス
     * @return string APIのURLに必要な引数や追加パラメータが連結されたURL
     */
    protected function GenerateAbsoluteApiUri($url, $input)
    {
        return $url;
    }

    /**
     * @param $url String APIのURL
     * @param $input mixed リクエストパラメータクラスのインスタンス
     * @return mixed APIのURLに必要なQuery Stringが連結されたURL
     */
    protected function GenerateGetApiUri($url, $input)
    {
        return $url;
    }

    /**
     * @param $url String APIのURL
     * @param $input mixed リクエストパラメータクラスのインスタンス
     * @return mixed APIのURLに必要なQuery Stringが連結されたURL
     */
    protected function GenerateDeleteApiUri($url, $input){
        return $url;
    }

    /**
     * @param $input mixed JSONシリアライズ可能なリクエストパラメータクラスのインスタンス
     * @return string $inputをシリアライズしたJSON文字列
     * @throws VtDirectException シリアライズに失敗した場合に投げられる例外
     */
    protected function GetRequestBody($input)
    {
        $json = json_encode($input);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new VtDirectException("Could not encode to JSON.", json_last_error());
        }
        return $json;
    }

} 