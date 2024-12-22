<?php

namespace VtDirect\Client\Request;

/**
 * Search APIにリクエストするパラメータをセットするクラス
 * Class SearchParameter
 * @package VtDirect\Client\Request
 */
class SearchParameter {

    /**
     * @var string 決済済みのOrder Id (必須・本人認証結果取得時は不要)
     */
    public $order_id;

    /**
     * @var string 本人認証結果取得のためのRequest Id (本人認証結果取得時は必須)
     */
    public $request_id;

    /**
     * @var bool ダミー要求かどうか trueを指定した場合は検索対象にダミー取引も含まれる
     */
    public $test_mode;


}