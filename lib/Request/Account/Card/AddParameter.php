<?php

namespace VtDirect\Client\Request\Account\Card;

/**
 * Account APIにPOSTリクエストするパラメータをセットするクラス
 * Class AddParameter
 * @package VtDirect\Client\Request\Account\Card
 */
class AddParameter {

    /**
     * @var String マーチャントサイト側会員の識別ID(マーチャントが採番したもの) (必須)
     */
    public $account_id;

    /**
     * @var String Tokens APIで取得したToken Id (必須)
     */
    public $token_id;

    /**
     * @var bool ダミー取引かどうか 未指定時はfalse(本番取引)
     */
    public $test_mode;
}