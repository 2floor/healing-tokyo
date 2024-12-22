
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

/**
 * POST遷移用
 *
 */
var postForm = function(url, data) {
    var $form = $('<form/>', {'action': url, 'method': 'post'});
    for(var key in data) {
            $form.append($('<input/>', {'type': 'hidden', 'name': key, 'value': data[key]}));
    }
    $form.appendTo(document.body);
    $form.submit();
};


$(function() {
	//コントローラー呼び出し
	page_ctrl();

	/**
	 * フォーム値取得処理
	 * @param method CT(コントローラ)内での処理判別コードを設定
	 */
	function get_form_prams(method, from_id) {

		//対象フォーム設定
		var $form = $('#' + from_id);

		//フォームの値を&区切りの文字列で取得
		var query = $form.serialize();

		//フォームの値をObjectで取得
		var param = $form.serializeArray();

		var fd = new FormData();
		//フォームの値を取得FormDataに設定
		$($form.serializeArray()).each(function(i, v) {
			$type = $('[name='+v.name+']').attr('type');
			if ($type != 'radio' && $type != 'checkbox') {
				//text,textarea,select設定
				fd.append(v.name, v.value)
			} else if($type == 'radio'){
				//ラジオボタン設定
				fd.append(v.name, $('[name='+v.name+']:checked').val())
			} else if ($type == 'checkbox') {
				//チェックボックス設定(配列)
				var area = $('[name='+v.name+']:checked').map(function() {
					return $(this).val();
				}).get();
				fd.append(v.name, area)
			}
			console.log(v.name);
		});

		//独自のパラメータやtype=fileがある場合はここでFormDataに追加
		//method設定
		fd.append('method', method);

		// フォーム入力値返却
		return fd;
	}
	/**
	 * 処理コントローラー
	 */
	function page_ctrl(){
		//初期処理呼び出し
		page_init();
	}

	/**
	 * 初期処理
	 */
	function page_init(){

		//画面TOPへスクロール
		$('html,body').animate({ scrollTop: 0 }, 'fast');

		//個人、店舗表示切替
		chage_public_status();

		//個人、店舗選択変更処理
		$('[name=public_flg]').change(function() {
			chage_public_status();
		});

		$('[name=inputSubmit]').on('click',function(){
			if (validate()) {
				//メールアドレス重複チェック
				chk_mail_address();
			}
		})

		$('[name=editSubmit]').on('click',function(){
			if (validate()) {
				//メールアドレス重複チェック
				chk_edit_mail_address();
			}
		})
	}

	/**
	 * メール重複チェック
	 */
	function chk_mail_address(){
		var fd = get_form_prams('chk_mail', 'frm');
		ajax.get(fd).done(function(result) {
			// 正常終了
			if(result.data.status){
				$('#frm').submit();
			} else {
				$('#mail_chk_msg').html('<span class="error"><label>既に登録されているメールアドレスです。</label></span>');
				$('#mail').css("background","#FFCCCC");
				$(".error label").css("color","red");
				$('html,body').animate({ scrollTop: $("span.error:first").offset().top-250 });
			}
		}).fail(function(aa) {
			// 異常終了
//			console.log(aa)
		});
	}

	/**
	 * メール重複チェック
	 */
	function chk_edit_mail_address(){
		var fd = get_form_prams('edit_chk_mail', 'frm');
		ajax.get(fd).done(function(result) {
			// 正常終了
			if(result.data.status){
				$('#frm').submit();
			} else {
				$('#mail_chk_msg').html('<span class="error"><label>既に登録されているメールアドレスです。</label></span>');
				$('#mail').css("background","#FFCCCC");
				$(".error label").css("color","red");
				$('html,body').animate({ scrollTop: $("span.error:first").offset().top-250 });
			}
		}).fail(function(aa) {
			// 異常終了
//			console.log(aa)
		});
	}

	/**
	 * 登録種別表示変更処理
	 */
	function chage_public_status(){
		var public_flg = $('[name=public_flg]:checked').val();

		if (public_flg == '0') {
			$('.private_form').show();
			$('.store_form').hide();
			$('.store_form').removeClass('required');
			$('.private_form').addClass('required');
		} else {
			$('.private_form').hide();
			$('.store_form').show();
			$('.store_form').addClass('required');
			$('.private_form').removeClass('required');
		}
	}


});



