<?php

use VtDirect\Client\VtDirectException;
use VtDirect\Client\VtDirectNetworkException;

require_once __DIR__ . '\..\..\lib\Tokens.php';
require_once __DIR__ . '\..\..\lib\Charges.php';
require_once __DIR__ . '\..\..\lib\ReCharges.php';
require_once __DIR__ . '\..\..\lib\Status.php';
require_once __DIR__ . '\..\..\lib\Capture.php';
require_once __DIR__ . '\..\..\lib\Cancel.php';
require_once __DIR__ . '\..\..\lib\Cvs.php';

require_once __DIR__ . '\..\..\lib\Account.php';
require_once __DIR__ . '\..\..\lib\AccountCard.php';

require_once __DIR__ . '\..\..\lib\CreditCardList.php';
require_once __DIR__ . '\..\..\lib\CreditCardDestroy.php';

require_once __DIR__ . '\..\..\lib\MpiCharges.php';
require_once __DIR__ . '\..\..\lib\EntryWithMpiCharges.php';
require_once __DIR__ . '\..\..\lib\AccountMpiCharges.php';
require_once __DIR__ . '\..\..\lib\Search.php';

require_once __DIR__ . '\..\..\lib\Request\TokensParameter.php';
require_once __DIR__ . '\..\..\lib\Request\ChargesParameter.php';
require_once __DIR__ . '\..\..\lib\Request\ReChargesParameter.php';
require_once __DIR__ . '\..\..\lib\Request\StatusParameter.php';
require_once __DIR__ . '\..\..\lib\Request\CaptureParameter.php';
require_once __DIR__ . '\..\..\lib\Request\VoidParameter.php';
require_once __DIR__ . '\..\..\lib\Request\CvsParameter.php';

require_once __DIR__ . '\..\..\lib\Request\Account\GetAccountInfoParameter.php';
require_once __DIR__ . '\..\..\lib\Request\Account\CreateAccountParameter.php';
require_once __DIR__ . '\..\..\lib\Request\Account\DeleteAccountParameter.php';
require_once __DIR__ . '\..\..\lib\Request\Account\Card\AddParameter.php';
require_once __DIR__ . '\..\..\lib\Request\Account\Card\DeleteParameter.php';

require_once __DIR__ . '\..\..\lib\Request\CreditCardListParameter.php';
require_once __DIR__ . '\..\..\lib\Request\CreditCardDestroyParameter.php';

require_once __DIR__ . '\..\..\lib\Request\Account\AccountMpiChargesParameter.php';
require_once __DIR__ . '\..\..\lib\Request\Account\EntryWithMpiChargesParameter.php';
require_once __DIR__ . '\..\..\lib\Request\MpiChargesParameter.php';
require_once __DIR__ . '\..\..\lib\Request\SearchParameter.php';

require_once __DIR__ . '\..\..\lib\Setting.php';
require_once __DIR__ . '\..\..\lib\CurlRequest.php';
require_once __DIR__ . '\..\..\lib\HttpRequestInterface.php';
require_once __DIR__ . '\..\..\lib\VtDirectException.php';
require_once __DIR__ . '\..\..\lib\VtDirectNetworkException.php';

class RequestTest extends PHPUnit_Framework_TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    private $_setting;

    public function setUp()
    {
        $this->_setting = new \VtDirect\Client\Setting();
        $this->_setting->SetServerKey("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx");
        $this->_setting->SetHttpsRequestEnabled(false);
        $this->_setting->SetRequestHost("localhost");
        $this->_setting->SetRequestPort(8080);
        $this->_setting->SetSslVerifyEnabled(false);
    }

    public function testFixUrl1()
    {
        $tokens = new \VtDirect\Client\Tokens($this->_setting);
        $url = $tokens->GenerateApiUrl("/vtdirect/v2/tokens");
        $this->assertEquals("http://localhost:8080/vtdirect/v2/tokens", $url);
    }

    public function testFixUrl2()
    {
        $tokens = new \VtDirect\Client\Tokens($this->_setting);
        $url = $tokens->GenerateApiUrl("vtdirect/v2/tokens/");
        $this->assertEquals("http://localhost:8080/vtdirect/v2/tokens", $url);
    }

    public function testTokensWithMockFail1()
    {
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->once())
            ->method('SendRequest')->withAnyParameters()
            ->will($this->throwException(new VtDirectException("mock exception", -1)));
        $tokens = new \VtDirect\Client\Tokens($this->_setting, $mock);
        $input = new \VtDirect\Client\Request\TokensParameter();
        $input->card_number = "4111111111111111";
        $input->card_exp_month = "12";
        $input->card_exp_year = "2015";
        $input->card_cvv = "1234";
        $input->client_key = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
        try {
            $tokens->GetToken($input);
        } catch (VtDirectException $ex) {
            $this->assertEquals("mock exception", $ex->getMessage());
        }
    }

    public function testTokensWithMockParam()
    {
        $input = new \VtDirect\Client\Request\TokensParameter();
        $input->card_number = "4111111111111111";
        $input->card_exp_month = "12";
        $input->card_exp_year = "2015";
        $input->card_cvv = "1234";
        $input->client_key = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";

        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/tokens?card_number=" .
                    "$input->card_number&card_exp_month=$input->card_exp_month&card_exp_year=$input->card_exp_year" .
                    "&card_cvv=$input->card_cvv&client_key=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"token_id":"dummy"},"code":"VD00","status":"success","message":"Success request new token"}'));
        $tokens = new \VtDirect\Client\Tokens($this->_setting, $mock);
        $response = $tokens->GetToken($input);
        $this->assertEquals("dummy", $response["data"]["token_id"]);
    }

    public function testTokensWithMockDecodeError()
    {
        $input = new \VtDirect\Client\Request\TokensParameter();
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')->withAnyParameters()
            ->will(
                $this->returnValue(
                    'dummy({"data":{"token_id":"dummy"},"code":"VD00","status":"success","message":"Success request new token"})'));
        $tokens = new \VtDirect\Client\Tokens($this->_setting, $mock);
        try {
            $tokens->GetToken($input);
        } catch (VtDirectException $ex) {
            $this->assertStringStartsWith("Could not decode from JSON to php object.", $ex->getMessage());
        }
    }

    public function testTokensWithMockNot200Error()
    {
        $input = new \VtDirect\Client\Request\TokensParameter();
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')->withAnyParameters()
            ->will($this->throwException(new VtDirectException("Http status error occurred.", 302)));
        $tokens = new \VtDirect\Client\Tokens($this->_setting, $mock);
        try {
            $tokens->GetToken($input);
        } catch (VtDirectException $ex) {
            $this->assertStringStartsWith("Http status error occurred.", $ex->getMessage());
            $this->assertEquals(302, $ex->getCode());
        }
    }

    public function testTokensWithMockNetworkError()
    {
        $input = new \VtDirect\Client\Request\TokensParameter();
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')->withAnyParameters()
            ->will($this->throwException(new VtDirectNetworkException("Could not connect.", "test", 56)));
        $tokens = new \VtDirect\Client\Tokens($this->_setting, $mock);
        try {
            $tokens->GetToken($input);
        } catch (VtDirectNetworkException $ex) {
            $this->assertStringStartsWith("Could not connect.\r\ntest", $ex->getMessage());
            $this->assertEquals(56, $ex->getCode());
        }
    }

    /*
        public function testTokensWithLocalHttp()
        {
            $setting = new \VtDirect\Client\Setting();
            $input = new \VtDirect\Client\Request\TokensParameter();
            $input->card_number = "4111111111111111";
            $input->card_exp_month = "12";
            $input->card_exp_year = "2015";
            $input->card_cvv = "1234";
            $input->client_key = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
            $tokens = new \VtDirect\Client\Tokens($setting);
            $response = $tokens->GetToken($input);
        }
    */

    public function testChargesWithMock()
    {
        $setting = new \VtDirect\Client\Setting();
        $setting->SetServerKey("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx");
        $input = new \VtDirect\Client\Request\ChargesParameter();
        $input->order_id = "2013-08-10-000001";
        $input->token_id = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx-411111-1111";
        $input->gross_amount = 2480;
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/charges"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"code":"VD00","status":"success","message":"dummy"}'));
        $charges = new \VtDirect\Client\Charges($this->_setting, $mock);
        $response = $charges->ChargeWithToken($input);
        $this->assertEquals("dummy", $response["message"]);
    }

    public function testChargesWithMockDecodeError()
    {
        $input = new \VtDirect\Client\Request\ChargesParameter();
        $input->gross_amount = 100;
        $input->order_id = uniqid();
        $input->token_id = "dummy";
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->withAnyParameters()
            ->will($this->returnValue('dummy{"code":"VD00","status":"success","message":"dummy"}'));
        $charges = new \VtDirect\Client\Charges($this->_setting, $mock);
        try {
            $charges->ChargeWithToken($input);
        } catch (VtDirectException $ex) {
            $this->assertStringStartsWith("Could not decode from JSON to php object.", $ex->getMessage());
        }
    }

    public function testReChargesWithMock()
    {
        $setting = new \VtDirect\Client\Setting();
        $setting->SetServerKey("#{serverKey}");
        $input = new \VtDirect\Client\Request\ReChargesParameter();
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v1/recharges"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"code":"VD00","status":"success","message":"dummy"}'));
        $api = new \VtDirect\Client\ReCharges($this->_setting, $mock);
        $response = $api->ReChargeWithRegisterId($input);
        $this->assertEquals("dummy", $response["message"]);
    }

    public function testCaptureWithMock()
    {
        $setting = new \VtDirect\Client\Setting();
        $setting->SetServerKey("#{serverKey}");
        $input = new \VtDirect\Client\Request\CaptureParameter();
        $input->order_id = "2013-07-23-0014";
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/capture"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"code":"VD00","status":"success","message":"dummy"}'));
        $api = new \VtDirect\Client\Capture($this->_setting, $mock);
        $response = $api->CaptureOrder($input);
        $this->assertEquals("dummy", $response["message"]);
    }

    public function testVoidWithMock()
    {
        $input = new \VtDirect\Client\Request\VoidParameter();
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/void"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"code":"VD00","status":"success","message":"dummy"}'));
        $api = new \VtDirect\Client\Cancel($this->_setting, $mock);
        $response = $api->VoidOrder($input);
        $this->assertEquals("dummy", $response["message"]);
    }

    public function testStatusWithMock()
    {
        $setting = new \VtDirect\Client\Setting();
        $setting->SetServerKey("#{serverKey}");
        $input = new \VtDirect\Client\Request\StatusParameter();
        $input->order_id = "2013-07-05-0004";
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v1/status"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"code":"VD00","status":"success","message":"dummy"}'));
        $api = new \VtDirect\Client\Status($this->_setting, $mock);
        $response = $api->GetOrderStatus($input);
        $this->assertEquals("dummy", $response["message"]);
    }

    public function testCreditCardListWithMock()
    {
        $setting = new \VtDirect\Client\Setting();
        $setting->SetServerKey("#{serverKey}");
        $input = new \VtDirect\Client\Request\CreditCardListParameter();
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v1/creditcard/list"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"code":"VD00","status":"success","message":"dummy"}'));
        $api = new \VtDirect\Client\CreditCardList($this->_setting, $mock);
        $response = $api->ListCreditCardBind($input);
        $this->assertEquals("dummy", $response["message"]);
    }

    public function testCreditCardDestroyWithMock()
    {
        $input = new \VtDirect\Client\Request\CreditCardDestroyParameter();
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v1/creditcard/destroy"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"code":"VD00","status":"success","message":"dummy"}'));
        $api = new \VtDirect\Client\CreditCardDestroy($this->_setting, $mock);
        $response = $api->DestroyCreditCardBind($input);
        $this->assertEquals("dummy", $response["message"]);
    }

    public function testCvsWithMock()
    {
        $input = new \VtDirect\Client\Request\CvsParameter();
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/cvs"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"mstatus":"success","vresult_code":"D001H00100000000","url":"https://example.com/pay/p_paymain.aspx?odrno\u003dxxxxx","receipt_no":"303002","code":"Q000","status":"success","message":"Success do cvs authorize transaction"}'));
        $api = new \VtDirect\Client\Cvs($this->_setting, $mock);
        $response = $api->PaymentAtCvs($input);
        $this->assertEquals("Success do cvs authorize transaction", $response["message"]);
    }

    public function testAccountGetWithMock()
    {
        $input = new VtDirect\Client\Request\Account\GetAccountInfoParameter();
        $input->account_id = 'test';
        $input->test_mode = false;
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/account?test_mode=false&account_id=test"),
                $this->equalTo("get"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"account_id":"dummy54911aa6596f6","cards":[]},"mstatus":"success","vresult_code":"X001000000000000","code":"Q000","status":"success","message":"Card information query was successful"}'));
        $api = new \VtDirect\Client\Account($this->_setting, $mock);
        $response = $api->GetAccountInfo($input);
        $this->assertEquals('Card information query was successful', $response["message"]);
    }

    public function testAccountGetWithMockTestMode()
    {
        $input = new VtDirect\Client\Request\Account\GetAccountInfoParameter();
        $input->account_id = 'test';
        $input->test_mode = true;
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/account?test_mode=true&account_id=test"),
                $this->equalTo("get"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"account_id":"dummy54911aa6596f6","cards":[]},"mstatus":"success","vresult_code":"X001000000000000","code":"Q000","status":"success","message":"Card information query was successful"}'));
        $api = new \VtDirect\Client\Account($this->_setting, $mock);
        $response = $api->GetAccountInfo($input);
        $this->assertEquals('Card information query was successful', $response["message"]);
    }

    public function testAccountPostWithMock()
    {
        $input = new VtDirect\Client\Request\Account\CreateAccountParameter();
        $input->account_id = 'test';
        $input->test_mode = false;

        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/account"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"account_id":"dummy54911aa6596f6"},"mstatus":"success","vresult_code":"X001000000000000","code":"Q000","status":"success","message":"Account add request was successful"}'));
        $api = new \VtDirect\Client\Account($this->_setting, $mock);
        $response = $api->CreateAccount($input);
        $this->assertEquals('Account add request was successful', $response["message"]);

    }

    public function testAccountDeleteWithMock()
    {
        $input = new VtDirect\Client\Request\Account\DeleteAccountParameter();
        $input->account_id = 'test';
        $input->test_mode = false;

        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/account?test_mode=false&account_id=test"),
                $this->equalTo("delete"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"account_id":"dummy54911aa6596f6"},"mstatus":"success","vresult_code":"X001000000000000","code":"Q000","status":"success","message":"Account delete request was successful"}'));
        $api = new \VtDirect\Client\Account($this->_setting, $mock);
        $response = $api->DeleteAccount($input);
        $this->assertEquals('Account delete request was successful', $response["message"]);

    }

    public function testAccountDeleteWithMockTestMode()
    {
        $input = new VtDirect\Client\Request\Account\DeleteAccountParameter();
        $input->account_id = 'test';
        $input->test_mode = true;

        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/account?test_mode=true&account_id=test"),
                $this->equalTo("delete"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"account_id":"dummy54911aa6596f6"},"mstatus":"success","vresult_code":"X001000000000000","code":"Q000","status":"success","message":"Account delete request was successful"}'));
        $api = new \VtDirect\Client\Account($this->_setting, $mock);
        $response = $api->DeleteAccount($input);
        $this->assertEquals('Account delete request was successful', $response["message"]);

    }


    public function testAccountCardPostWithMock()
    {
        $input = new VtDirect\Client\Request\Account\Card\AddParameter();
        $input->account_id = 'test';
        $input->token_id = 'token';
        $input->test_mode = false;

        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/account_card"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"account_id":"dummy5491267aef1b5","card_brand":"VISA","card_number":"411111********11","card_expire":"12/2015","card_id":"8RJ5A0CY3MD4CN740UWBRBHGV"},"mstatus":"success","vresult_code":"X001000000000000","code":"Q000","status":"success","message":"Request to register the card information to the account was successful"}'));
        $api = new \VtDirect\Client\AccountCard($this->_setting, $mock);
        $response = $api->AddCard($input);
        $this->assertEquals('Request to register the card information to the account was successful', $response["message"]);

    }


    public function testAccountCardDeleteWithMock()
    {
        $input = new VtDirect\Client\Request\Account\Card\DeleteParameter();
        $input->account_id = 'test';
        $input->card_id = 'test';
        $input->test_mode = false;

        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/account_card?test_mode=false&account_id=test&card_id=test"),
                $this->equalTo("delete"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"account_id":"dummy5491267aef1b5"},"mstatus":"success","vresult_code":"X001000000000000","code":"Q000","status":"success","message":"Request to delete card from account was successful"}'));
        $api = new \VtDirect\Client\AccountCard($this->_setting, $mock);
        $response = $api->DeleteCard($input);
        $this->assertEquals('Request to delete card from account was successful', $response["message"]);

    }

    public function testAccountCardDeleteWithMockTestMode()
    {
        $input = new VtDirect\Client\Request\Account\Card\DeleteParameter();
        $input->account_id = 'test';
        $input->card_id = 'test';
        $input->test_mode = true;

        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/account_card?test_mode=true&account_id=test&card_id=test"),
                $this->equalTo("delete"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"account_id":"dummy5491267aef1b5"},"mstatus":"success","vresult_code":"X001000000000000","code":"Q000","status":"success","message":"Request to delete card from account was successful"}'));
        $api = new \VtDirect\Client\AccountCard($this->_setting, $mock);
        $response = $api->DeleteCard($input);
        $this->assertEquals('Request to delete card from account was successful', $response["message"]);

    }


    public function testMpiChargeWithMock()
    {
        $input = new VtDirect\Client\Request\MpiChargesParameter();
        $input->token_id = 'test';
        $input->order_id = 'test';
        $input->gross_amount = 128;
        $input->service_option_type = 'mpi-complete';
        $input->push_uri = 'http://example.com';
        $input->redirection_uri = 'http://example.com';
        $input->http_user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko";
        $input->http_accept = "text/html, application/xhtml+xml, */*";
        $input->test_mode = false;

        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/mpi_charges"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"order_id":"ordere_i875ksizs93","gross_amount":100,"with_capture":false,"service_option_type":"mpi-complete","response_contents":"\u003c!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"\u003e\n\u003cHTML\u003e\n\u003cHEAD\u003e\n\u003cMETA http-equiv\u003d\"Cache-Control\" content\u003d\"no-store, no-cache\"\u003e\n\u003cMETA http-equiv\u003d\"Pragma\" content\u003d\"no-cache\"\u003e\n\u003cMETA http-equiv\u003d\"Expires\" content\u003d\"0\"\u003e\n\u003cMETA http-equiv\u003d\"Content-Type\" content\u003d\"text/html; charset\u003dUTF-8\" /\u003e\n\u003c/HEAD\u003e\n\u003cSCRIPT language\u003d\"javascript\" type\u003d\"text/javascript\"\u003e\n\u003c!--\nfunction OnLoadEvent(){\n document.getElementById(\"continue\").disabled \u003d true;\n document.getElementById(\"downloadForm\").submit();\n}\n// --\u003e\n\u003c/SCRIPT\u003e\n\u003cBODY onLoad\u003d\"OnLoadEvent();\"\u003e\n\u003cFORM id\u003d\"downloadForm\" name\u003d\"downloadForm\" action\u003d\"http://10.112.62.166:80/3DDummyAcs/acceptor\" method\u003d\"POST\" onSubmit\u003d\"document.getElementById(\u0027continue\u0027).disabled\u003dtrue; return true;\"\u003e\n\u003cBR\u003e\u003cBR\u003e\u003cCENTER\u003e\n\u003cH4\u003eRedirecting to 3D-Secure Authentication...\u003cBR\u003e\n\u003cimg src\u003d\"http://10.112.62.161/tercerog/img/mpi/auth_description.gif\"\u003e\u003cBR\u003e\n\u003cINPUT type\u003d\"submit\" id\u003d\"continue\" name\u003d\"continue\" value\u003d\"Continue\"\u003e\n\u003c/H4\u003e\n\u003c/CENTER\u003e\n\u003cINPUT type\u003d\"hidden\" name\u003d\"PaReq\" value\u003d\"4111xxxxxxxxxx\"\u003e\n\u003cINPUT type\u003d\"hidden\" name\u003d\"TermUrl\" value\u003d\"http://10.112.62.166:80/tercerog/webinterface/GWTripartiteCommandRcv\"\u003e\n\u003cINPUT type\u003d\"hidden\" name\u003d\"MD\" value\u003d\"QTEwMDAwMDAwMDAwMDAwMTA2OTk5MWNj-MjAxNDEyMTgwMTM2NTQ4MzU*-OTI1ZWMxZDgzYTZjOGZhY2IwNGJjYTlmYTVmMGJlNWIxYjdjMzk4MGFiYWE2ODhiOWI1OWRkZjRlN2JkYWJlNw**\u003d\u003dVJIvtgpwPqYAAC7i2hwAAAAE\"\u003e\n\u003c/FORM\u003e\n\u003c/BODY\u003e\n\u003c/HTML\u003e\n","res_corporation_id":"05","res_brand_id":"4"},"mstatus":"success","vresult_code":"G001H00100000000","code":"Q000","status":"success","message":"mpi authorize request was successful"}'));
        $api = new \VtDirect\Client\MpiCharges($this->_setting, $mock);
        $response = $api->MpiChargeWithToken($input);
        $this->assertEquals('mpi authorize request was successful', $response["message"]);

    }

    public function testEntryWithMpiChargeWithMock()
    {
        $input = new VtDirect\Client\Request\Account\EntryWithMpiChargesParameter();
        $input->token_id = 'test';
        $input->order_id = 'test';
        $input->account_id = 'test';
        $input->gross_amount = 128;
        $input->service_option_type = 'mpi-complete';
        $input->push_uri = 'http://example.com';
        $input->redirection_uri = 'http://example.com';
        $input->http_user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko";
        $input->http_accept = "text/html, application/xhtml+xml, */*";
        $input->test_mode = false;

        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/entry_with_mpi_charges"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"order_id":"TEST-0345","gross_amount":100,"with_capture":true,"service_option_type":"mpi-merchant","account_id":"TEST-1243","response_contents":"\u003c!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"\u003e\n\u003cHTML\u003e\n\u003cHEAD\u003e\n\u003cMETA http-equiv\u003d\"Cache-Control\" content\u003d\"no-store, no-cache\"\u003e\n\u003cMETA http-equiv\u003d\"Pragma\" content\u003d\"no-cache\"\u003e\n\u003cMETA http-equiv\u003d\"Expires\" content\u003d\"0\"\u003e\n\u003cMETA http-equiv\u003d\"Content-Type\" content\u003d\"text/html; charset\u003dUTF-8\" /\u003e\n\u003c/HEAD\u003e\n\u003cSCRIPT language\u003d\"javascript\" type\u003d\"text/javascript\"\u003e\n\u003c!--\nfunction OnLoadEvent(){\n document.getElementById(\"continue\").disabled \u003d true;\n document.getElementById(\"downloadForm\").submit();\n}\n// --\u003e\n\u003c/SCRIPT\u003e\n\u003cBODY onLoad\u003d\"OnLoadEvent();\"\u003e\n\u003cFORM id\u003d\"downloadForm\" name\u003d\"downloadForm\" action\u003d\"http://10.112.62.166:80/3DDummyAcs/acceptor\" method\u003d\"POST\" onSubmit\u003d\"document.getElementById(\u0027continue\u0027).disabled\u003dtrue; return true;\"\u003e\n\u003cBR\u003e\u003cBR\u003e\u003cCENTER\u003e\n\u003cH4\u003eRedirecting to 3D-Secure Authentication...\u003cBR\u003e\n\u003cimg src\u003d\"http://10.112.62.161/tercerog/img/mpi/auth_description.gif\"\u003e\u003cBR\u003e\n\u003cINPUT type\u003d\"submit\" id\u003d\"continue\" name\u003d\"continue\" value\u003d\"Continue\"\u003e\n\u003c/H4\u003e\n\u003c/CENTER\u003e\n\u003cINPUT type\u003d\"hidden\" name\u003d\"PaReq\" value\u003d\"4111xxxxxxxxxx\"\u003e\n\u003cINPUT type\u003d\"hidden\" name\u003d\"TermUrl\" value\u003d\"http://10.112.62.166:80/tercerog/webinterface/GWTripartiteCommandRcv\"\u003e\n\u003cINPUT type\u003d\"hidden\" name\u003d\"MD\" value\u003d\"QTEwMDAwMDAwMDAwMDAwMTA2OTk5MWNj-MjAxNDEyMTgwMjQ1MDIzMzM*-MDIxNmQyM2I0YzdmODZhYTQ1NTk2ZGIwYmNmNTFjYTNhZTFlZjJlMjZjMjk4NDAwOTNlMWYyOWJkOTljN2QzZg**\u003d\u003dVJI-rQpwPqYAADB7FGcAAAAH\"\u003e\n\u003c/FORM\u003e\n\u003c/BODY\u003e\n\u003c/HTML\u003e\n","res_corporation_id":"05","res_brand_id":"4"},"mstatus":"success","vresult_code":"G001H001X0010000","code":"Q000","status":"success","message":"mpi authorize request was successful"}'));
        $api = new \VtDirect\Client\EntryWithMpiCharges($this->_setting, $mock);
        $response = $api->EntryWithMpiCharge($input);
        $this->assertEquals('mpi authorize request was successful', $response["message"]);

    }

    public function testAccountMpiChargeWithMock()
    {
        $input = new VtDirect\Client\Request\Account\AccountMpiChargesParameter();
        $input->order_id = 'test';
        $input->account_id = 'test';
        $input->card_id = 'test';
        $input->gross_amount = 128;
        $input->service_option_type = 'mpi-complete';
        $input->push_uri = 'http://example.com';
        $input->redirection_uri = 'http://example.com';
        $input->http_user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko";
        $input->http_accept = "text/html, application/xhtml+xml, */*";
        $input->test_mode = false;

        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendPostRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/account_mpi_charges"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"data":{"order_id":"TEST-1487","gross_amount":100,"with_capture":false,"service_option_type":"mpi-complete","account_id":"TEST-4761","card_id":"94IKOXQB6FLN5E8DGFQC3KB7A","response_contents":"\u003c!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"\u003e\n\u003cHTML\u003e\n\u003cHEAD\u003e\n\u003cMETA http-equiv\u003d\"Cache-Control\" content\u003d\"no-store, no-cache\"\u003e\n\u003cMETA http-equiv\u003d\"Pragma\" content\u003d\"no-cache\"\u003e\n\u003cMETA http-equiv\u003d\"Expires\" content\u003d\"0\"\u003e\n\u003cMETA http-equiv\u003d\"Content-Type\" content\u003d\"text/html; charset\u003dUTF-8\" /\u003e\n\u003c/HEAD\u003e\n\u003cSCRIPT language\u003d\"javascript\" type\u003d\"text/javascript\"\u003e\n\u003c!--\nfunction OnLoadEvent(){\n document.getElementById(\"continue\").disabled \u003d true;\n document.getElementById(\"downloadForm\").submit();\n}\n// --\u003e\n\u003c/SCRIPT\u003e\n\u003cBODY onLoad\u003d\"OnLoadEvent();\"\u003e\n\u003cFORM id\u003d\"downloadForm\" name\u003d\"downloadForm\" action\u003d\"http://10.112.62.166:80/3DDummyAcs/acceptor\" method\u003d\"POST\" onSubmit\u003d\"document.getElementById(\u0027continue\u0027).disabled\u003dtrue; return true;\"\u003e\n\u003cBR\u003e\u003cBR\u003e\u003cCENTER\u003e\n\u003cH4\u003eRedirecting to 3D-Secure Authentication...\u003cBR\u003e\n\u003cimg src\u003d\"http://10.112.62.161/tercerog/img/mpi/auth_description.gif\"\u003e\u003cBR\u003e\n\u003cINPUT type\u003d\"submit\" id\u003d\"continue\" name\u003d\"continue\" value\u003d\"Continue\"\u003e\n\u003c/H4\u003e\n\u003c/CENTER\u003e\n\u003cINPUT type\u003d\"hidden\" name\u003d\"PaReq\" value\u003d\"4111xxxxxxxxxx\"\u003e\n\u003cINPUT type\u003d\"hidden\" name\u003d\"TermUrl\" value\u003d\"http://10.112.62.166:80/tercerog/webinterface/GWTripartiteCommandRcv\"\u003e\n\u003cINPUT type\u003d\"hidden\" name\u003d\"MD\" value\u003d\"QTEwMDAwMDAwMDAwMDAwMTA2OTk5MWNj-MjAxNDEyMTgwMjU3NTM0OTI*-YzdmOTM5NzYwZGFlYTVhMTZmNzA1NTlmN2U2NWQzZDMwMjVkZDRlYTA4N2ViNmNiMWJjMjdlYTBmMjcyYzFjYg**\u003d\u003dVJJCsQpwPqYAAC7n3OQAAAAO\"\u003e\n\u003c/FORM\u003e\n\u003c/BODY\u003e\n\u003c/HTML\u003e\n","res_corporation_id":"05","res_brand_id":"4"},"mstatus":"success","vresult_code":"G001HA01X0010000","code":"Q000","status":"success","message":"mpi authorize request was successful"}'));
        $api = new \VtDirect\Client\AccountMpiCharges($this->_setting, $mock);
        $response = $api->AccountMpiCharge($input);
        $this->assertEquals('mpi authorize request was successful', $response["message"]);

    }


    public function testSearchWithMock()
    {
        $setting = new \VtDirect\Client\Setting();
        $setting->SetServerKey("#{serverKey}");
        $input = new \VtDirect\Client\Request\SearchParameter();
        $input->order_id = "2013-07-05-0004";
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/search?test_mode=false&order_id=" . $input->order_id),
                $this->equalTo("get"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"code":"VD00","status":"success","message":"dummy"}'));
        $api = new \VtDirect\Client\Search($this->_setting, $mock);
        $response = $api->GetOrderTransactionInformation($input);
        $this->assertEquals("dummy", $response["message"]);
    }

    public function testSearchWithMockTestMode()
    {
        $setting = new \VtDirect\Client\Setting();
        $setting->SetServerKey("#{serverKey}");
        $input = new \VtDirect\Client\Request\SearchParameter();
        $input->order_id = "2013-07-05-0004";
        $input->test_mode = true;
        $mock = $this->getMock('\VtDirect\Client\HttpRequestInterface');
        $mock->expects($this->any())
            ->method('SendRequest')
            ->with(
                $this->equalTo("http://localhost:8080/vtdirect/v2/search?test_mode=true&order_id=" . $input->order_id),
                $this->equalTo("get"),
                $this->equalTo("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
            )
            ->will($this->returnValue('{"code":"VD00","status":"success","message":"dummy"}'));
        $api = new \VtDirect\Client\Search($this->_setting, $mock);
        $response = $api->GetOrderTransactionInformation($input);
        $this->assertEquals("dummy", $response["message"]);
    }


}
 