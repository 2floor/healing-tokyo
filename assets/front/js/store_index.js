
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


var ajax2 = {
		get : function(post_data) {
			var defer = $.Deferred();
			$.ajax({
				type : 'POST',
				url : '../cancel_ajax.php',// コントローラURLを取得
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
	function get_form_prams (method) {

		var fd = new FormData();

		//チェックボックス複数名取得処理
		var checkbox_value = get_checkbox_value();

		fd.append('method', method);
		fd.append('edit_del_id', $('#id').val());

//
//		fd.append('name', $('[name=name]').val());
//		fd.append('name_kana', $('[name=name_kana]').val());
//		fd.append('mail', $('[name=mail]').val());
//		fd.append('password', $('[name=password]').val());
//		fd.append('change_pass', $('[name=pass_change_flg]').val());
//
//
//		fd.append('cuisine_genre', $('[name=cuisine_genre]').val());
//		fd.append('area_region', $('[name=area_region]').val());
//		fd.append('area_pref', $('[name=area_pref]').val());
//		fd.append('area', $('[name=area]').val());
//		fd.append('characteristic_id', checkbox_value.characteristic_id);
//		fd.append('plan_type_id', $('[name=plan_type_id]').val());
//		fd.append('dress_flg', $('[name=dress_flg]:checked').val());
//		fd.append('dress_text', $('[name=dress_text]').val());
//		fd.append('child_flg', $('[name=child_flg]:checked').val());
//		fd.append('child_text', $('[name=child_text]').val());
//		fd.append('smoke_type', $('[name=smoke_type]:checked').val());
//		fd.append('smoke_text', $('[name=smoke_text]').val());
//		fd.append('wheelchair_flg', $('[name=wheelchair_flg]:checked').val());
//		fd.append('wheelchair_text', $('[name=wheelchair_text]').val());
//		fd.append('parking_flg', $('[name=parking_flg]:checked').val());
//		fd.append('parking_text', $('[name=parking_text]').val());
//		fd.append('store_name', $('[name=store_name]').val());
//		fd.append('store_name_kana', $('[name=store_name_kana]').val());
//		fd.append('tel', $('[name=tel]').val());
//		fd.append('addr', $('[name=addr]').val());
//		fd.append('url', $('[name=url]').val());
//		fd.append('nearest_station', $('[name=nearest_station]').val());
//		fd.append('access', $('[name=access]').val());
//		fd.append('business_hours', $('[name=business_hours]').val());
//		fd.append('regular_holiday_text', $('[name=regular_holiday_text]').val());
//		fd.append('regular_holiday', checkbox_value.regular_holiday);
//		fd.append('drink_text', $('[name=drink_text]').val());
//		fd.append('service_charge', $('[name=service_charge]').val());
//		fd.append('cansel_charge', $('[name=cansel_charge]').val());
//		fd.append('available_card', checkbox_value.available_card);
//		fd.append('seat_total', $('[name=seat_total]').val());
//		fd.append('start_time', $('[name=start_time]').val());
//		fd.append('start_time_dinner', $('[name=start_time_dinner]').val());
//		fd.append('lo_time', $('[name=lo_time]').val());
//		fd.append('lo_time_dinner', $('[name=lo_time_dinner]').val());



		// フォーム入力値返却
		return fd;
	}
	/**
	 * 処理コントローラー
	 */
	function page_ctrl(){

		//初期処理呼び出し
		page_init();

		$('#conf_text').html('以下の項目はすべて<span class="registTit2">※必須項目</span>です。');
		$('#conf').show();
		$('#return, #submit').hide();
		$('#return, #conf, #submit').off();
		$('#return, #conf, #submit').on('click', function(){
			var name = $(this).attr('id');
			if(name == 'conf'){
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
				$('#conf_text').html('以下の項目はすべて<span class="registTit2">※必須項目</span>です。');
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
		var form_datas = get_form_prams('init_store_index');

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
				if(result.data.personal){
					location.replace("../mypage")
				}


				$('#plan_list_html').html(result.data.plan_html);
				$('#reservation_html').html(result.data.reservation_html);

				//操作アイコン押下時処理
				conf_btn();


				$('.cancel_btn').off();
				$('.cancel_btn').on('click', function(){
					if (confirm('予約をキャンセルします。\r\n元に戻すことはできませんがよろしいですか？') == true) {
						var tar = $(this);
						var cancel_id = $(this).attr('cid');
						var reservation_id = $(this).attr('rid');
						var store_basic_id = $(this).attr('sid');
						var member_id = $(this).attr('mid');

						var fd = new FormData();
						fd.append('action', 'cancel');
						fd.append('cancel_id', cancel_id);
						fd.append('reservation_id', reservation_id );
						fd.append('store_basic_id', store_basic_id );
						fd.append('member_id', member_id );

						ajax2.get(fd).done(function(result) {

							if (result.data.status) {
								alert('キャンセルが完了しました');
								location.reload();
							} else {
								alert(result.data.error_msg);
							}
						}).fail(function(result) {
							// 異常終了
							$('body').html(result.responseText);
						});
					}
				});



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
	 * 操作アイコン押下時処理
	 */
	function conf_btn(){
		$('.conf_btn').off();
		$('.conf_btn').on('click', function(){
			var action = $(this).attr('act');
			var plan_id = $(this).attr('plan_id');
			var day_night_flg = $(this).attr('day_night_flg');
			var title = $(this).attr('p_title');


			if(action == 'edit'){
				// メソッド定義
				var form_datas = get_form_prams('insert_session');
				form_datas.append('SESSION_store_plan_id', plan_id);
				form_datas.append('SESSION_day_night_flg' , day_night_flg);

				// 初期処理AJAX呼び出し処理
				call_ajax_loction_edit_plan(form_datas, true);

			}else if(action == 'release'){
				ret = confirm( title + "を公開します。よろしいですか？");
				if (ret == true){

					if(id != null && id != '' ){
						// 呼び出し前method定義
						var form_data = get_form_prams('release_store_plan');
						form_data.append('plan_id', plan_id);
						form_data.append('day_night_flg', day_night_flg);

						// ajax呼び出し
						call_ajax_change_state(form_data,$(this),action);
					}else{
						$('.seat_input_area_' + $(this).attr('num')).remove();
					}
				}

			}else if(action == 'public'){
				ret = confirm( title + "を非公開にします。よろしいですか？");
				if (ret == true){

					if(id != null && id != '' ){
						// 呼び出し前method定義
						var form_data = get_form_prams('private_store_plan');
						form_data.append('plan_id', plan_id);
						form_data.append('day_night_flg', day_night_flg);

						// ajax呼び出し
						call_ajax_change_state(form_data,$(this),action);
					}else{
						$('.seat_input_area_' + $(this).attr('num')).remove();
					}
				}

			}else if(action == 'delete'){
				ret = confirm( title + "を削除します。よろしいですか？");
				if (ret == true){

					if(id != null && id != '' ){
						// 呼び出し前method定義
						var form_data = get_form_prams('delete_store_plan');
						form_data.append('plan_id', plan_id);
						form_data.append('day_night_flg', day_night_flg);

						// ajax呼び出し
						call_ajax_change_state(form_data);
					}else{
						$('.seat_input_area_' + $(this).attr('num')).remove();
					}
				}

			}
		});

	}



	/**
	 * 会員情報更新処理
	 */
	function edit_exection(){
		//method定義
		var entry_datas = get_form_prams('aa');
		//ajax呼び出し
		call_ajax_change_state(entry_datas);
	}



	/**
	 * 状態編集更新処理AJAX 更新、登録、削除、公開
	 */
	function call_ajax_change_state (post_data, elem, action){
		ajax.get(post_data).done(function(result) {
			// 正常終了
			if (result.data.status) {
				// 完了時表示メッセージ
				alert(result.data.msg);
				// ページ再読み込み
				if(elem != undefined && action != undefined){
					if(action == 'release'){
						$(elem).html('非公開');
						$(elem).attr('act', 'public');
						$(elem).parents('.mypageReservBox').find('.mypageStoreRelease').html('公開中').addClass('now');
					}else if(action == 'public'){
						$(elem).html('公開');
						$(elem).attr('act', 'release');
						$(elem).parents('.mypageReservBox').find('.mypageStoreRelease').html('非公開').removeClass('now');
					}
				}else{
					location.reload();
				}

				conf_btn();

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
	 * 編集ページ遷移ajax
	 */
	function call_ajax_loction_edit_plan (post_data){
		ajax.get(post_data).done(function(result) {
			// 正常終了
			if (result.data.status) {

				location.href = 'plan_edit.php';

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
	 * 時間入力処理
	 */
	function time_picker(){
		var target = '#start_time_hour, #start_time_min, #lo_time_hour, #lo_time_min, #start_time_dinner_hour, #start_time_dinner_min, #lo_time_dinner_hour, #lo_time_dinner_min'

		$(target).off();
		$(target).on('change', function(){
			var tar = $(this).attr('tar');
			var hour = $('#' + tar + '_hour').val();
			var min = $('#' + tar + '_min').val();
			$('#' + tar).val(hour + ':' + min);
		});
	}

	/**
	 * 各種表示系処理
	 */
	function check_disp_change(){

		//ランチ・ディナー時間別
		$('.business_time_text').hide();
		$('.business_time_area').hide();
		$('#lunch_flg').off();
		$('#lunch_flg').on('change', function(){
			if($(this).prop('checked')){
				$('.business_time_text').show();
				$('.business_time_area').show();
			}else{
				$('.business_time_text').hide();
				$('.business_time_area').hide();
				$('#start_time_dinner,#lo_time_dinner').val('00:00')
				$('.business_time_area').find('select').each(function(){
					$(this).val('00');
				});
			}
		});


		$('#start_time_dinner, #start_time, #lo_time_dinner, #lo_time').off();
		$('#start_time_dinner, #start_time, #lo_time_dinner, #lo_time').on('change', function(){
			var id = $(this).attr('id');
			console.log(id +' : ' + $(this).val());
		});

		/**
		 * パスワード変更処理
		 */
		$(".password_input_area").hide();
		$("#change_pass").off();
		$("#change_pass").on('click', function(){
			if($(this).prop('checked')){
				$(".password_input_area").show();
				$('[name=password]').addClass('validate required');
				$('[name=passwordCheck]').addClass('validate required');
				$('#pass_change_flg').val(1)
			}else{
				$(".password_input_area").hide();
				$('[name=password]').removeClass('validate required');
				$('[name=passwordCheck]').removeClass('validate required');
				$('#pass_change_flg').val(0)
			}
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



