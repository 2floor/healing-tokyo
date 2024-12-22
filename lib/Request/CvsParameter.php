<?php

namespace VtDirect\Client\Request;

/**
 * CVS APIにリクエストするパラメータをセットするクラス
 * Class CvsParameter
 * @package VtDirect\Client\Request
 */
class CvsParameter {

    /**
     * @var string マーチャントサイトで採番したOrder Id (必須)
     */
    public $order_id;

    /**
     * @var string "sej"か"econ"と指定する (必須)
     * セブンイレブン:"sej"
     * ローソン・ファミリーマート・ミニストップ・セイコーマート:"econ"
     */
    public $option_type;

    /**
     * @var string 電話番号をハイフンなし数字のみの10～11桁で指定する (必須)
     */
    public $tel;

    /**
     * @var int 決済金額 (必須)
     */
    public $gross_amount;

    /**
     * @var string 姓 全角20バイト以内 (必須)
     */
    public $name1;

    /**
     * @var string 名 全角20バイト以内 (必須)
     */
    public $name2;

    /**
     * @var bool ダミー取引かどうか 未指定時はfalse(本番取引)
     */
    public $test_mode;

    /**
     * @var string 支払期限を数字8桁のyyyymmddで指定 未指定時は既定値が利用される
     */
    public $pay_limit;

    /**
     * @var string 取引メモ1 100文字以内
     */
    public $memo1;

    /**
     * @var string キー情報 半角英数256文字以内
     */
    public $free_key;

} 