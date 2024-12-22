
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

		var query = getUrlVars();
		var fd = new FormData();
		fd.append('method', method);
		fd.append('txt', query['r']);
		fd.append('pass', $('[name=password]').val());
		fd.append('pass_conf', $('[name=password_conf]').val());

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

		//リマインダー処理
		$('[name=pw_change]').off();
		$('[name=pw_change]').on('click',function(){
			if (validate()) {
				// メソッド定義
				var form_datas = get_form_prams('pw_change');

				// 初期処理AJAX呼び出し処理
				call_ajax_pw_change(form_datas);
			}
		});
	}

	/**
	 * リマインダー処理AJAX
	 */
	function call_ajax_pw_change(post_data){
		ajax.get(post_data).done(function(result) {

			if (result.data.status) {
				alert('パスワードの再設定が完了しました。\r\nログイン画面からログインして下さい')
				location.replace('./login.php');
			} else {
				alert(result.data.error_msg);
			}
		}).fail(function(result) {
			// 異常終了
			$('body').html(result.responseText);
		});
	}

	/**
	 * クエリストリングを取得(例： var  auery = getUrlVars();query['name'])
	 *
	 * @returns {Array}
	 */
	function getUrlVars() {
		var vars = [], hash;
		var hashes = window.location.href.slice(
				window.location.href.indexOf('?') + 1).split('&');
		for (var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}
});



