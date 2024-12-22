<?php
/**
 * ヴェリトランス決済ロジック
 *
 */
class veritrans{

	const DUMMY_PAYMENT_FLAG = "1";//ダミー決済フラグ(本番時0を設定)

	const GET_HASH_URL = 'https://pay.veritrans.co.jp/web1/commodityRegist.action'; //暗号鍵取得用
	const SETTLEMENT_URL = 'https://pay.veritrans.co.jp/web1/deviceCheck.action'; //Web リンクサーバー転送用
	const MERCHANT_ID = 'A100000800000001101197';
	const HASHSEED = '6d05a9af8d538a561507b22788741a52969eb920046ea08b6bdfcfab9ba7c2e2';
	const CARD_INSTALLMENT_JPO = '10'; //カード支払区分（一括）
	const LINK_PAYMENT_FLAG = NULL;//リンク生成フラグ
	const SETTLEMENT_TYPE = "01";//決済種別（カード決済）
	const LINK_EXP_DATETIME_ADD = '30'; //リンク有効期限(minute加算)
	const LANG_ENABLE_FLAG = '1';
	const LANG = 'en';

	const FINISH_PAYMENT_ACCESS_URL = 'https://credit.jis-j.com/dev/logic/common/veritrans_result.php';//決済結果通知URL
	const FINISH_PAYMENT_RETURN_URL = 'https://jis-j.com/dev/search/reserve_comp.php';//決済後URL

	private $merchanthash;
	private $counter;
	private $order_id;
	private $session_id;//セッションID
	private $amount;//金額
	private $link_exp_datetime;



	public function __construct(){
		$this->counter = 1;

		$this->merchanthash;
		$this->order_id;
		$this->session_id;
		$this->amount;

		$this->link_exp_datetime = date('YmdHis', strtotime(date('YmdHis') ." + ".self::LINK_EXP_DATETIME_ADD." minutes"));

	}



	/**
	 * マーチャントハッシュ生成
	 */
	private function create_merchanthash(){
		if(!isset($this->order_id)){
			echo "order_idが設定されていません。";
			exit();
		}
		if(!isset($this->amount)){
			echo "amountが設定されていません。";
			exit();
		}
		$this->merchanthash = bin2hex(mhash(MHASH_SHA512, implode(",",array(
				self::HASHSEED,
				self::MERCHANT_ID,
				self::SETTLEMENT_TYPE,
				$this->order_id,
				$this->amount,
		))));

		return true;
	}


	private function connectByPost($url, $argary) {
		$query_string = http_build_query($argary);
		$options = array (
				'http' => array (
						'method' => 'POST',
						'header' => 'Content-type: application/x-www-form-urlencoded',
						'content' => $query_string,
						'ignore_errors' => true,
						'protocol_version' => '1.1'
				),
				'ssl' => array (
						'verify_peer' => false,
						'verify_peer_name' => false
				)
		);
		$contents = @file_get_contents($url, false, stream_context_create($options));

		$cont = explode("\n", $contents);

		$url = '';
		$MERCHANT_ENCRYPTION_KEY = '';
		$BROWSER_ENCRYPTION_KEY = '';
		$error = '';
		foreach ($cont as $v) {
			if($v == null || $v == '' )continue;
			if(strpos($v, "VTW_START_URL") !== false){
				$url = str_replace("VTW_START_URL=", "", $v);
			}elseif(strpos($v, "ERROR_MESSAGE") !== false){
				$error = str_replace("ERROR_MESSAGE=", "", $v);
			}elseif(strpos($v, "MERCHANT_ENCRYPTION_KEY") !== false){
				$MERCHANT_ENCRYPTION_KEY = str_replace("MERCHANT_ENCRYPTION_KEY=", "", $v);
			}elseif(strpos($v, "BROWSER_ENCRYPTION_KEY") !== false){
				$BROWSER_ENCRYPTION_KEY = str_replace("BROWSER_ENCRYPTION_KEY=", "", $v);
			}
		}

		//エラー発生
		if($error != null && $error != ''){
			echo $error;
			exit();
		}

		$link_settlement = false;
		if($BROWSER_ENCRYPTION_KEY != null && $BROWSER_ENCRYPTION_KEY != '' ){
			$url = '<input type="hidden" name="ORDER_ID" value="'.$this->order_id.'">';
			$url .= '<input type="hidden" name="MERCHANT_ID" value="'.self::MERCHANT_ID.'">';
			$url .= '<input type="hidden" name="BROWSER_ENCRYPTION_KEY" value="'.str_replace(array("\r","\n","\r\n"), "", $BROWSER_ENCRYPTION_KEY).'">';
			$link_settlement = true;
		}


		return array(
				"url" => $url,
				"link_settlement" => $link_settlement,
				"session_id" => $this->session_id,
				"link_exp_datetime" => $this->link_exp_datetime,
		);
	}


	private function create_ses($nLengthRequired = 40) {
		$sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
		mt_srand ();
		$sRes = "";
		for($i = 0; $i < $nLengthRequired; $i ++) $sRes .= $sCharList {mt_rand ( 0, strlen ( $sCharList ) - 1 )};
		return $sRes;
	}


	public function set_key_param($order_id, $amount){
		$this->order_id = $order_id;
		$this->amount = $amount;
		$this->session_id = $this->create_ses();
		$this->create_merchanthash();
	}

	/**
	 * 暗号鍵生成
	 */
	public function create_key($check_flg = false) {
		$params = array(
				"MERCHANT_ID" => self::MERCHANT_ID,
				"ORDER_ID" => $this->order_id,
				"MERCHANTHASH" => $this->merchanthash,
				"SESSION_ID" => $this->session_id,
				"AMOUNT" => $this->amount,
				"LINK_PAYMENT_FLAG" => self::LINK_PAYMENT_FLAG,
				"FINISH_PAYMENT_RETURN_URL" => self::FINISH_PAYMENT_RETURN_URL,
				"LINK_EXP_DATETIME" => $this->link_exp_datetime,
				"FINISH_PAYMENT_ACCESS_URL" => self::FINISH_PAYMENT_ACCESS_URL,
				"CARD_INSTALLMENT_JPO" => self::CARD_INSTALLMENT_JPO,
				"DUMMY_PAYMENT_FLAG" => self::DUMMY_PAYMENT_FLAG,
				"SETTLEMENT_TYPE" => self::SETTLEMENT_TYPE,
				"LANG_ENABLE_FLAG" => self::LANG_ENABLE_FLAG,
				"LANG" => self::LANG,
		);
		if($check_flg) return $params;
		return  $this->connectByPost(self::GET_HASH_URL, $params);
	}

}