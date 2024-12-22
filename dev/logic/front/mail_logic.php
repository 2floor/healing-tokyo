<?php
session_start();
require_once __DIR__ .  '/../../logic/common/common_logic.php';
require_once __DIR__ .  '/../../logic/common/jis_common_logic.php';






$recap = false;

// Check if form was submitted:
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["g-recaptcha-response"])) {
	$recaptcha = htmlspecialchars($_POST["g-recaptcha-response"],ENT_QUOTES,'UTF-8');

	// Build POST request:
	$recaptcha_secret = '6LczQ9oUAAAAABynoGfOr-KC7eihyLGhgL2hhydX';

	$resp = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha}");
	$resp_result = json_decode($resp,true);


	if(intval($resp_result["success"]) !== 1) {
		// Not verified - show form error
		$recap = false;
	}else{
		// Verified - send email
		$recap = true;
	}
}

if(!$recap){
	header("Location:../../contact_comp.php?e=rec");
	exit();
}






$tour_logic = new contact_logic($_POST);
$tour_logic->ct($_POST);

class contact_logic {

	private $common_logic;
	private $jis_common_logic;

	private $from;
	private $from_name;
	private $from_url;
	private $header;
	private $header_adminer;
	private $header_mini;
	private $footer;

	public function __construct($post){
		$this->common_logic = new common_logic();
		$this->jis_common_logic = new jis_common_logic();

		$this->from = 'enquiry@jis-j.com';
		$this->from_name = 'Japan International Services';
		$this->from_url= 'https://jis-j.com';


		$this->header_mini ='
/***********************************************************/
This will be an automatic email.
/***********************************************************/

';
		$this->header = $this->header_mini.'

Hi. '. $post['name'].'

Thanks for contact.
We received your message.

'.$post['name'].'様
お問い合わせいただきまして、誠にありがとうございました。
ご返信までしばらくお待ちくださいませ。

以下、お問い合わせ内容

';

		$this->header_adminer = $this->header_mini.'

'.$post['name'].'様より
お問い合わせがありました。
ご対応よろしくお願いいたします。

以下、お問い合わせ内容

';

		$this->footer ='
*******************************************************
 Japan International Service Co.,Ltd.(JIS)
 2-23-1-218 Yoyogi Shibuya-ku Tokyo 151-0053
 Tel：+81-3-4588-1055
 Fax：+81-3-6300-0887
 E-Mail：enquiry@jis-j.com
 URL：https://www.jis-j.com/
*******************************************************
';
	}

	public function ct($post) {
			$this->contact($post);
	}


	/**
	 * お問い合わせ
	 * @param unknown $post
	 */
	private  function contact($post){

		$mail = $post['mail'];
		$subject = '【'.$this->from_name.'】Received inquiries from the web.' ;
		$subject_adminer = '【'.$this->from_name.'】WEBからのお問い合わせがありました' ;

		$body_in = '
Type　　　　　　　　：　'.$post['type'].'
name　　　　　　　　：　'.$post['name'].'
Mail　　　　　　　　：　'.$post['mail'].'
Phone no　　　　　　：　'.$post['tel'].'
Addless　　　　　　 ：　'.$post['addr'].'
Contents　　　　　　：

'.$post['detail'].'

';


		$body = $this->header.'
'.$body_in.'

'.$this->footer;

		$body_adminer = $this->header_adminer.'

'.$body_in.'

'.$this->footer;

		if ($_SERVER['HTTP_HOST']=='localhost') {
			var_dump($post);
			var_dump($subject);
			var_dump($body);
		} else {
			mb_language ( "Japanese" );
			mb_internal_encoding ( "UTF-8" );

			$header = "Content-Type: text/plain; charset=UTF-8 \n";
			$header .= "Content-Transfer-Encoding: BASE64 \n";
			$header .= "Return-Path: " . $this->from . "\n";
			$header .= "From:" .mb_encode_mimeheader($this->from_name) ."<".$this->from.">\n";
			$header .= "Sender: " . $this->from_name ."\n";
			$header .= "Reply-To: " .mb_encode_mimeheader($this->from_name) ."<".$this->from.">\n";
			$header .= "Organization: " . $this->from . " \n";
			$header .= "X-Sender: " . $this->from . " \n";
			$header .= "X-Priority: 3 \n";

			mb_send_mail($mail, $subject, base64_encode($body), $header);
			mb_send_mail($this->from, $subject_adminer, base64_encode($body_adminer), $header);
		}

		header("Location:../../contact_comp.php");
		exit();


	}


}