<?php

namespace VtDirect\Client;

/**
 * 通信先やServer Keyをセットするクラス。
 * 原則、Server Keyのセット以外不要だが、別途VTDirectのモックを用意する場合は、適宜設定を書き換えて利用する
 * Class Setting
 * @package VtDirect\Client
 */
class Setting
{
    const VERSION = "2.1.1";
    private $_serverKey;
    private $_requestHost = "api.veritrans.co.jp";
    private $_useHttpsRequest = true;
    private $_requestHostPort = 443;
    private $_verifySsl = true;
    private $_caCertPath = "";

    /**
     * @param $serverKey string Server Keyをセットする (必須)
     */
    public function SetServerKey($serverKey)
    {
        $this->_serverKey = $serverKey;
    }

    /**
     * @return string セットされたServer Keyを取得する
     */
    public function GetServerKey()
    {
        return $this->_serverKey;
    }

    /**
     * @param $host string 通信先ホストを変更する
     */
    public function SetRequestHost($host)
    {
        $this->_requestHost = $host;
    }

    /**
     * @return string 通信先ホストを取得する
     */
    public function GetRequestHost()
    {
        return $this->_requestHost;
    }

    /**
     * @param $enableSslRequest bool SSL通信を行うかセットする 既定値はTrue
     */
    public function SetHttpsRequestEnabled($enableSslRequest)
    {
        $this->_useHttpsRequest = $enableSslRequest;
    }

    /**
     * @return bool SSL通信を行うかどうか
     */
    public function GetHttpsRequestEnabled()
    {
        return $this->_useHttpsRequest;
    }

    /**
     * @param $port int 通信先ホストのポート番号をセットする 既定値は443
     */
    public function SetRequestPort($port)
    {
        $this->_requestHostPort = $port;
    }

    /**
     * @return int 通信先ホストのポート番号を取得する
     */
    public function GetRequestPort()
    {
        return $this->_requestHostPort;
    }

    /**
     * @param $enableSslVerify bool SSL通信を検証するかどうかをセットする 既定値はTrue CURLOPT_SSL_VERIFYPEERを利用
     */
    public function SetSslVerifyEnabled($enableSslVerify)
    {
        $this->_verifySsl = $enableSslVerify;
    }

    /**
     * @return bool SSL通信を検証するかどうか
     */
    public function GetSslVerifyEnabled()
    {
        return $this->_verifySsl;
    }

    /**
     * 通常は必要なし。値がセットされた場合はCURLOPT_CAINFOに利用する。
     * @param $caCertPath string PEM形式のCA Certsファイルのパスを指定する
     */
    public function SetCACertPath($caCertPath){
        $this->_caCertPath = $caCertPath;
    }

    /**
     * @return string セットしたCA Certsファイルのパスを取得する
     */
    public function GetCACertPath(){
        return $this->_caCertPath;
    }

} 