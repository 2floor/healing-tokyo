<?php

namespace VtDirect\Client\Request\Account;

/**
 * Account APIにGETリクエストするパラメータをセットするクラス
 * Class GetAccountInfoParameter
 * @package VtDirect\Client\Request\Account
 */
class GetAccountInfoParameter {

    /**
     * @var String 情報を取得したいAccount Idを指定する (必須)
     */
    public $account_id;

    /**
     * @var bool ダミー要求かどうか 未指定時はfalse(本番要求)
     */
    public $test_mode;

} 