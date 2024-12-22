<?php

namespace VtDirect\Client\Request;

/**
 * Void APIにリクエストするパラメータをセットするクラス
 * Class VoidParameter
 * @package VtDirect\Client\Request
 */
class VoidParameter
{
    /**
     * @var string 決済済みのOrder Id (必須)
     */
    public $order_id;


    /**
     * @var Integer カードキャンセル金額 未指定時は全額キャンセル
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