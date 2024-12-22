<?php

namespace VtDirect\Client\Request\Account;

/**
 * Account APIにPOSTリクエストするパラメータをセットするクラス
 * Class CreateAccountParameter
 * @package VtDirect\Client\Request\Account
 */
class CreateAccountParameter {

    /**
     * @var String 作成したいAccount Idを指定する (必須)
     */
    public $account_id;

    /**
     * @var bool ダミー要求かどうか 未指定時はfalse(本番要求)
     */
    public $test_mode;
}