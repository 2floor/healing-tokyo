<?php

namespace VtDirect\Client\Request\Account;

class AccountChargesParameter {

    /**
     * @var String マーチャントサイトで採番したOrder Id (必須)
     */
    public $order_id;

    /**
     * @var String 登録済みのAccount Id (必須)
     */
    public $account_id;

    /**
     * @var String 登録済みのCard Id (必須)
     */
    public $card_id;

    /**
     * @var int 決済金額 (必須)
     */
    public $gross_amount;

    /**
     * @var bool 与信と同時に売上するかどうか 未指定の場合は与信のみ
     */
    public $with_capture;

    /**
     * @var bool ダミー取引かどうか 未指定時はfalse(本番取引)
     */
    public $test_mode;

    /**
     * @var string 取引メモ1 100文字以内
     */
    public $memo1;

    /**
     * @var string キー情報 半角英数256文字以内
     */
    public $free_key;

    /**
     * @var string 支払種別情報
     */
    public $jpo;

}