
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

var ajax_common = {
		get : function(post_data) {
			var defer = $.Deferred();
			$.ajax({
				type : 'POST',
				url : $('#common_ct_url').val(),// コントローラURLを取得
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
		/**
		 * jpostal設定
		 */
		$('#zip').jpostal({//郵便番号1つめのIDを設定
			postcode : [
				'#zip',//郵便番号1つめのIDを設定
			],
			address : {
				'#pref'  : '%3',//都道府県のIDを設定
				'#add1'  : '%4%5',//住所のIDを設定
			}
		});

		/**
		 * deskpicker設定
		 */
		$.datepicker.setDefaults({
		    changeYear: true,
		    changeMonth: true,
		    buttonImageOnly: false,
		    dateFormat:'yy-mm-dd'
		  });

		$("[name=start_date]").datepicker();


		$('[name=inputSubmit]').on('click',function(){
			if (validate()) {
				$('#frm').submit();
			}
		})
	}

	$('input[type="file"]').off();
	$('input[type="file"]').on('change', function(){
		var fd = new FormData();
		fd.append('method', 'img_upload');
		fd.append('path', $('[name=img_path]').val());
		fd.append('file1', $(this).prop("files")[0]);
		ajax_common.get(fd).done(function(result) {
			if (!result.data.status) {
				alert('画像の取得に失敗しました。')
			}
		}).fail(function(result) {
			// 異常終了
			$('body').html(result.responseText);
		});

	});
});



