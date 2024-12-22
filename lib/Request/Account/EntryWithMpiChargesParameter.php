<?php

namespace VtDirect\Client\Request\Account;

class EntryWithMpiChargesParameter {

    /**
     * @var string Tokens APIで取得したToken Id (必須)
     */
    public $token_id;

    /**
     * @var string マーチャントサイトで採番したOrder Id (必須)
     */
    public $order_id;

    /**
     * @var String マーチャントサイト側会員の識別ID(マーチャントが採番したもの) (必須)
     */
    public $account_id;

    /**
     * @var int 決済金額 (必須)
     */
    public $gross_amount;

    /**
     * @var string "mpi-complete", "mpi-company", "mpi-merchant"のいずれか (必須)
     */
    public $service_option_type;

    /**
     * @var string 本人認証結果Push通知の送信先マーチャントサイトURI 未指定の場合は送信しない
     */
    public $push_uri;

    /**
     * @var string 本人認証実施後のリダイレクト(POST)先マーチャントサイトURL (必須)
     */
    public $redirection_uri;

    /**
     * @var string マーチャントサイトの環境変数から取得したブラウザの HTTP User Agent ヘッダ (必須)
     */
    public $http_user_agent;

    /**
     * @var string マーチャントサイトの環境変数から取得したブラウザの HTTP Accept ヘッダ (必須)
     */
    public $http_accept;

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

    /**
     * @var bool 仮登録フラグ
     */
    public $temp_registration;

}