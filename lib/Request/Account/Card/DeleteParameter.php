<?php

namespace VtDirect\Client\Request\Account\Card;

/**
 * Account APIにDELETEリクエストするパラメータをセットするクラス
 * Class DeleteParameter
 * @package VtDirect\Client\Request\Account\Card
 */
class DeleteParameter {

    /**
     * @var String 登録済みのAccount Id (必須)
     */
    public $account_id;

    /**
     * @var String 登録済みのCard Id (必須)
     */
    public $card_id;

    /**
     * @var bool ダミー取引かどうか 未指定時はfalse(本番取引)
     */
    public $test_mode;
}