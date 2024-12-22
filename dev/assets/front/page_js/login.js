
/**
 * フォームの表示、非表示処理はassets/admin/js/common.jsの共通関数を読み込んでます。
 *
 * ページの状態
 * 一覧表示：.list_show
 * 新規登録入力：.entry_input
 * 新規登録確認：.entry_conf
 * 編集入力：.edit_input
 * 編集確認：.edit_conf
 * 削除確認：.del_conf
 *
 * 表示状態
 * 一覧表示：.list_show_disp
 * 新規登録入力：.entry_input
 * 新規登録確認：.entry_conf
 * 編集入力：.edit_input
 * 編集確認：.edit_conf
 * 削除確認：.del_conf
 */
//登録できる最大件数
const MAX_ENTRY_CNT = 19;

//入力画面入力フォーム背景色設定
var input_form_css = {
		'background-color':'#fff',
		'border-width': '1px',
		'color':'#000',
		'border':'1px solid rgba(0, 0, 0, 0.2)'
	};

//確認画面入力フォームCSS設定
var edit_form_css = {
		'background-color':'#fff',
		'color':'#000',
		'border':'none'
	};

/**
 * Ajax実行
 */
var ajax = {
		get : function(post_data) {
			var defer = $.Deferred();
			$.ajax({
				type : 'POST',
				url : $('#ct_url').val(),// コントローラURLを取得
				data : post_data,
				processData : false,
				contentType : false,
				dataType : 'json',
				success : defer.resolve,
				error : defer.reject,
			});
			return defer.promise();
		}
};

$(function() {
	//コントローラー呼び出し
	page_ctrl();

	/**
	 * フォーム値取得処理
	 * @param method CT(コントローラ)内での処理判別コードを設定
	 */
	function get_form_prams(method) {

		var fd = new FormData();
		fd.append('method', method);
		fd.append('mail', $('[name=mail]').val());
		fd.append('pass', $('[name=password]').val());
		fd.append('mail_conf', $('[name=mail_conf]').val());
		fd.append('b_y', $('[name=b_y]').val());
		fd.append('b_m', $('[name=b_m]').val());
		fd.append('b_d', $('[name=b_d]').val());

		// フォーム入力値返却
		return fd;
	}
	/**
	 * 処理コントローラー
	 */
	function page_ctrl(){
//	    $("#formID").validationEngine();

		//初期処理呼び出し
		page_init();
	}

	/**
	 * 初期処理
	 */
	function page_init(){

		//画面TOPへスクロール
		$('html,body').animate({ scrollTop: 0 }, 'fast');

		//ログイン処理
		$('[name=login]').off();
		$('[name=login]').on('click',function(){
			if (validate()) {
				// メソッド定義
				var form_datas = get_form_prams('login');

				// 初期処理AJAX呼び出し処理
				call_ajax_login(form_datas);
			}
		});

		//リマインダー処理
		$('[name=reminder]').off();
		$('[name=reminder]').on('click',function(){
			if (validate()) {
				// メソッド定義
				var form_datas = get_form_prams('reminder');

				// 初期処理AJAX呼び出し処理
				call_ajax_reminder(form_datas);
			}
		});
	}

	/**
	 * ログイン処理AJAX
	 */
	function call_ajax_login(post_data){
		ajax.get(post_data).done(function(result) {

			console.log(result)

			if (result.data.status) {

				if (result.data.store_flg) {
					//店舗側マイペへ
					location.href = '../mypage_store/';
				} else {
					//一般ユーザーマイペへ
					location.href = './';
				}
			} else {
				alert(result.data.error_msg);
			}
		}).fail(function(result) {
			// 異常終了
			$('body').html(result.responseText);
		});
	}

	/**
	 * リマインダー処理AJAX
	 */
	function call_ajax_reminder(post_data){
		ajax.get(post_data).done(function(result) {
			if (result.data.status) {
				location.replace('./reminder_comp.php');
			} else {
				alert(result.data.error_msg);
			}
		}).fail(function(result) {
			// 異常終了
			$('body').html(result.responseText);
		});
	}
});



