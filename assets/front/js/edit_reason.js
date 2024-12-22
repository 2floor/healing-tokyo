
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

////パラメータ取得
//var query = getUrlVars();
//var store_id = query['id'];


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

//検索用ページデフォルト値取得
var now_page_num_def = '';
var get_next_disp_page_def = '';
var page_disp_cnt_def = '';
var where = '';


$(function() {
	//コントローラー呼び出し
	page_ctrl();

	/**
	 * フォーム値取得処理
	 * @param method CT(コントローラ)内での処理判別コードを設定
	 */
	function get_form_prams (method, now_page_num, get_next_disp_page, page_disp_cnt) {

		var fd = new FormData();

		//ファイル名取得処理
		var file_name = get_file_name();

		fd.append('method', method);
		fd.append('edit_del_id', $('#id').val());

		fd.append('reason_why', file_name.why_reason_array);
		fd.append('store_top_title', $('[name=store_top_title]').val());
		fd.append('store_top_detail', $('[name=store_top_detail]').val());
		fd.append('store_top_img', file_name.store_top_img);
		fd.append('coupon_type', $('[name=coupon_type]').val());

		// フォーム入力値返却
		return fd;
	}
	/**
	 * 処理コントローラー
	 */
	function page_ctrl(){

		//初期処理呼び出し
		page_init();

//		$('#conf_text').html('以下の項目はすべて<span class="registTit2">※必須項目</span>です。');
		$('#conf_text').html('');
		$('#conf').show();
		$('#return, #submit').hide();
		$('#return, #conf, #submit').off();
		$('#return, #conf, #submit').on('click', function(){
			var name = $(this).attr('id');
			if(name == 'conf'){
				console.log(get_file_name());
				if(validate()){
					$('#conf').hide();
					$('#return, #submit').show();
					$('html,body').animate({ scrollTop: '.storeEditIn' }, 'fast');
					$('#conf_text').html('<span class="registTit2"><br>以下の内容が登録されます。よろしければ「登録」ボタンをクリックしてください。</span>');
					disp_disabled();
				}else{
					$('html,body').animate({ scrollTop: '.error' }, 'fast');
				}
			}else if(name == 'return'){
				disp_input();
//				$('#conf_text').html('以下の項目はすべて<span class="registTit2">※必須項目</span>です。');
				$('#conf_text').html('');
				$('#conf').show();
				$('#return, #submit').hide();
			}else if(name == 'submit'){
				edit_exection();
				$('#conf').hide();
				$('#return, #submit').show();
			}
		});



	}

	/**
	 * 初期(一覧取得)処理
	 */
	function page_init(){

		//画面TOPへスクロール
		$('html,body').animate({ scrollTop: 0 }, 'fast');

		// メソッド定義
		var form_datas = get_form_prams('init_reason');

		// 初期処理AJAX呼び出し処理
		call_ajax_detail_init(form_datas, true);

	}

	/**
	 * 初期処理AJAX
	 */
	function call_ajax_detail_init(post_data, flg){
		ajax.get(post_data).done(function(result) {
			// 正常終了
			if (result.data.status) {

				console.log(result)

				$('#personal_dir').val('store_id' + result.data.store_basic_id );
				$('#store_top_title').val(result.data.store_top_title);
				$('#store_top_detail').val(result.data.store_top_detail);

				//画像コメント反映

				//親パス
				var par_path = '../upload_files/store/store_id' + $('#id').val() + '/';
				var bool1 = result.data.reason_why != null && result.data.reason_why != '';
				var bool2 = result.data.store_top_img != null && result.data.store_top_img != "";

				if(bool1){
					var reason_why = JSON.parse(result.data.reason_why.replace(/\u2028|\u2029/g, ''));

					//トライナビが選ぶ理由
					var cnt = 1;
					$.each(reason_why, function(key, elem) {

						var path = par_path + 'reason_why/reason_img/'

						var file_no = cnt;
						var title = '';
						var detail = '';

						$.each(elem, function(key_2, elem_2) {
							if(key_2 == 'img' && (elem_2 != null && elem_2 != '')){
								$('span.img_name_' + (parseInt(cnt) - parseInt(1))).text(elem_2)
								$('#img_area' + cnt).append('<img class="storeEditImg2 " src="../upload_files/store/store_id'+result.data.store_basic_id+'/reason_why/reason_img/'+elem_2+'">')



							}else if(key_2 == 'title' && (elem_2 != null && elem_2 != '')){
								title = elem_2;
							}else if(key_2 == 'detail' && (elem_2 != null && elem_2 != '')){
								detail = elem_2;
							}
						});
						$('#reason_why_title_' + cnt).val(title);
						$('#reason_why_detail_' + cnt).val(detail);
						cnt++;
					});
				}
				if(bool2){
					cnt = 3;

					var store_top_img = result.data.store_top_img.split(',');

					//店舗トップ画像（コメント込み）
					$.each(store_top_img, function(key, elem) {
						var path = par_path + 'store_top_img/top_img/';
						$('span.img_name_' + cnt).text(elem)
						var img_cnt = cnt+1;
						$('#img_area' + img_cnt).append('<img class="storeEditImg2 " src="../upload_files/store/store_id'+result.data.store_basic_id+'/store_top_img/top_img/'+elem+'">')

						cnt++
					});

				}

			}else if (!result.data.status && result.data.error_code == 0){
				// PHP返却エラー
				alert(result.data.error_msg);
				location.href = result.data.return_url;
			}

			}).fail(function(result) {
				// 異常終了
				$('body').html(result.responseText);

			});
		}



	/**
	 * 会員情報更新処理
	 */
	function edit_exection(){
		//method定義
		var entry_datas = get_form_prams('edit_reason', null, null, null);
		//ajax呼び出し
		call_ajax_change_state(entry_datas);
	}

	/**
	 * 状態編集更新処理AJAX 更新、登録、削除、公開
	 */
	function call_ajax_change_state (post_data){
		ajax.get(post_data).done(function(result) {
			// 正常終了
			if (result.data.status) {
				// 完了時表示メッセージ
				alert(result.data.msg);
				// ページ再読み込み
				location.reload();

			}else if (!result.data.status && result.data.error_code == 0){
				// PHP返却エラー
				alert(result.data.error_msg);
				location.href = result.data.return_url;
			}

		}).fail(function(result) {
			// 異常終了
			$('body').html(result.responseText);
		});
	}

	/**
	 * チェックボックス複数名取得処理
	 */
	function get_checkbox_value(){
		var checkbox_array = {
				'characteristic_id':'',
				'regular_holiday':'',
				'available_card':'',
		};

		$('input:checkbox').each(function(){
			if($(this).prop('checked')) {
			var name = $(this).attr('name');
			var val = $(this).val();
			checkbox_array[name] += val + ',';
			}
		})


		$.each(checkbox_array, function(key, elem) {
			checkbox_array[key] = elem.substr( 0 , (elem.length-1) );
		});

		var return_array = {
				'characteristic_id': checkbox_array.characteristic_id,
				'regular_holiday': checkbox_array.regular_holiday,
				'available_card': checkbox_array.available_card,
		}

		console.log(return_array);
		return return_array
	}

	/**
	 * ファイル名取得処理
	 */
	function get_file_name(){
		//初期化

		var why_reason_array = {
				'0' : {
					'title': '',
					'detail': '',
					'img': '',
				},
				'1' : {
					'title': '',
					'detail': '',
					'img': '',
				},
				'2' : {
					'title': '',
					'detail': '',
					'img': '',
				},
		};

		var store_top_img = '';
		var why_reason_img_cnt = 0;
		var reason_why_comment_cnt = 0;


		//ファイル名取得
		$('input').each(function(){
			if($(this).attr('type') == 'file'){
				var cnt = $(this).attr('cnt');

				if(cnt != 3 && cnt != 4 && cnt != 5 ){
					if(this.files[0] != undefined){
						why_reason_array[cnt]['img'] = this.files[0].name;
					}else{
						why_reason_array[cnt]['img'] = $('span.img_name_' + cnt).text()
					}
				}else{
					if(this.files[0] != undefined){
						store_top_img += this.files[0].name  + ',';
					}else{
						store_top_img += $('span.img_name_' + cnt).text()  + ',';
					}
				}
			}
		});

		store_top_img = store_top_img.substr( 0 , (store_top_img.length-1) );

		$('.reason_why_comment').each(function(i){
			var name = $(this).attr('name');
			var cnt = $(this).attr('cnt');

			if(name  == 'reason_why_title_' + (parseInt(cnt) + parseInt(1)) ){
				why_reason_array[cnt]['title'] = $(this).val();
			}else if(name  == 'reason_why_detail_' + (parseInt(cnt) + parseInt(1))){
				why_reason_array[cnt]['detail'] = $(this).val();
			}
		});

		//json形式に変換
		why_reason_array = JSON.stringify(why_reason_array);

		var return_array;
		return return_array = {
				'why_reason_array':why_reason_array,
				'store_top_img':store_top_img,
		};
	}




	/**
	 * 一覧表示処理
	 */
	function list_disp_exection(data){
		//一覧表示処理
		$('.list_disp_area').show();

		//動的input area表示
		$('#input_area_created').html(data.input_area_created);

		//入力非表示処理
		$('.input_disp_area').hide();

		//初期HTMLリスト表示
		$('#list_html_area').html(data.html);

		//初期HTMLリスト表示
		$('#admin_authority_tr').html(data.edit_menu_list_html);

	}

	/**
	 * 入力エリアundisable処理(入力画面用)
	 */
	function disp_input() {
		// テキスト入力可処理
		$(":text").removeAttr("disabled");
		$(":text").css(input_form_css);
		$(":text").removeClass('conf_color');

		// パスワード入力可処理
		$(":password").removeAttr("disabled");
		$(":password").css(input_form_css);
		$(":password").removeClass('conf_color');

		// チェックボックス入力可処理
		$("input:checkbox").attr({
			'disabled' : false
		});
		$("input:checkbox").css(input_form_css);
		$("input:checkbox").removeClass('conf_color');

		//セレクトボックス変更可
		$("select").removeAttr("disabled");
		$("select").css(input_form_css);
		$("select").removeClass('conf_color');
		$("select").removeClass('conf_select');

		//テキストエリア変更不可
		$("textarea").removeAttr("disabled");
		$("textarea").css(input_form_css);
		$("textarea").removeClass('conf_color');

		//ラジオボタン活性化
		$('input[type="radio"]').css(input_form_css);
		$('input[type="radio"]').removeAttr("disabled");
		$('input[type="radio"]').removeClass('conf_color');

		//ファイル変更可能処理
		$('input:file').show();
		$('.del_img').show();

		//確認テキスト表示
		$('.conf_text').hide();
		$('.require_text').show();


	}

	/**
	 * 入力エリアdisable処理(確認画面用)
	 */
	function disp_disabled() {


		// テキスト入力不可処理
		$(":text").attr("disabled", "disabled");
		$(":text").css(edit_form_css);
		$(":text").addClass('conf_color');

		// パスワード入力不可処理
		$(":password").attr("disabled", "disabled");
		$(":password").css(edit_form_css);
		$(":password").addClass('conf_color');

		// チェックボックス入力不可処理
		$("input:checkbox").attr({
			'disabled' : true
		});
		$("input:checkbox").css(edit_form_css);
		$("input:checkbox").addClass('conf_color');

		//セレクトボックス変更不可
		$("select").attr("disabled", "disabled");
		$("select").css(edit_form_css);
		$("select").addClass('conf_color');
		$("select").addClass('conf_select');


		//テキストエリア変更不可
		$("textarea").attr("disabled", "disabled");
		$("textarea").css(edit_form_css);
		$("textarea").addClass('conf_color');

		//ラジオボタン非活性化
		$('input[type="radio"]').attr("disabled", "disabled");
		$('input[type="radio"]').css(edit_form_css);
		$('input[type="radio"]').addClass('conf_color');

		//ファイル変更不可処理
		$('input:file').hide();
		$('.del_img').hide();

		//確認テキスト表示
		$('.conf_text').show();
		$('.require_text').hide();

	}


});



