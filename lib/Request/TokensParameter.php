<?php

namespace VtDirect\Client\Request;

/**
 * Tokens APIにリクエストするパラメータをセットするクラス
 * Class TokensParameter
 * @package VtDirect\Client\Request
 */
class TokensParameter
{
    /**
     * @var string セキュリティコード (必須)
     */
    public $card_cvv;
    /**
     * @var string カード有効期限(月) 2文字 (必須)
     */
    public $card_exp_month;
    /**
     * @var string カード有効期限(年) 4文字 (必須)
     */
    public $card_exp_year;
    /**
     * @var string カード番号 ハイフンは利用不可 (必須)
     */
    public $card_number;
    /**
     * @var string Client Key (必須)
     */
    public $client_key;
}
