<?php

namespace VtDirect\Client\Request;

/**
 * Capture APIにリクエストするパラメータをセットするクラス
 * Class CaptureParameter
 * @package VtDirect\Client\Request
 */
class CaptureParameter
{
    /**
     * @var string 与信済み決済のOrder Id
     */
    public $order_id;

    /**
     * @var Integer 売上金額 未指定時は与信金額で売上する
     */
    public $amount;

    /**
     * @var string 取引メモ1 100文字以内
     */
    public $memo1;

    /**
     * @var string キー情報 半角英数256文字以内
     */
    public $free_key;

}