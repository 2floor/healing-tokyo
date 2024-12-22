<?php

namespace VtDirect\Client\Request\Account;

/**
 * Account APIにDELETEリクエストするパラメータをセットするクラス
 * Class DeleteAccountParameter
 * @package VtDirect\Client\Request\Account
 */
class DeleteAccountParameter {

    /**
     * @var String 削除したいAccount Idを指定する (必須)
     */
    public $account_id;

    /**
     * @var bool ダミー要求かどうか 未指定時はfalse(本番要求)
     */
    public $test_mode;
}