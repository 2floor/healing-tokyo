<?php

namespace VtDirect\Client;

use Exception;

/**
 * 本ライブラリによる処理で起こりうるエラーが発生した場合にスローされる
 * Class VtDirectException
 * @package VtDirect\Client
 */
class VtDirectException extends Exception
{
    public function __construct($message, $code, Exception $previous = null)
    {
        parent::__construct($message, (int)$code, $previous);
    }
} 