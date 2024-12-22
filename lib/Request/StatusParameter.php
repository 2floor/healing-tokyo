<?php

namespace VtDirect\Client\Request;

/**
 * @deprecated
 * Status APIにリクエストするパラメータをセットするクラス
 * Class StatusParameter
 * @package VtDirect\Client\Request
 */
class StatusParameter
{
    /**
     * @var string 決済済みのOrder Id (必須)
     */
    public $order_id;
} 