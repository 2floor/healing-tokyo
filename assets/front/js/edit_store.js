
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

		//チェックボックス複数名取得処理
		var checkbox_value = get_checkbox_value();

		fd.append('method', method);
		fd.append('edit_del_id', $('#id').val());


		fd.append('name', $('[name=name]').val());
		fd.append('name_kana', $('[name=name_kana]').val());
		fd.append('mail', $('[name=mail]').val());
		fd.append('password', $('[name=password]').val());
		fd.append('change_pass', $('[name=pass_change_flg]').val());


		fd.append('cuisine_genre', $('[name=cuisine_genre]').val());
		fd.append('area_region', $('[name=area_region]').val());
		fd.append('area_pref', $('[name=area_pref]').val());
		fd.append('area', $('[name=area]').val());
		fd.append('characteristic_id', checkbox_value.characteristic_id);
		fd.append('plan_type_id', $('[name=plan_type_id]').val());
		fd.append('dress_flg', $('[name=dress_flg]:checked').val());
		fd.append('dress_text', $('[name=dress_text]').val());
		fd.append('child_flg', $('[name=child_flg]:checked').val());
		fd.append('child_text', $('[name=child_text]').val());
		fd.append('smoke_type', $('[name=smoke_type]:checked').val());
		fd.append('smoke_text', $('[name=smoke_text]').val());
		fd.append('wheelchair_flg', $('[name=wheelchair_flg]:checked').val());
		fd.append('wheelchair_text', $('[name=wheelchair_text]').val());
		fd.append('parking_flg', $('[name=parking_flg]:checked').val());
		fd.append('parking_text', $('[name=parking_text]').val());
		fd.append('store_name', $('[name=store_name]').val());
		fd.append('store_name_kana', $('[name=store_name_kana]').val());
		fd.append('tel', $('[name=tel]').val());
		fd.append('addr', $('[name=addr]').val());
		fd.append('url', $('[name=url]').val());
		fd.append('nearest_station', $('[name=nearest_station]').val());
		fd.append('access', $('[name=access]').val());
		fd.append('business_hours', $('[name=business_hours]').val());
		fd.append('regular_holiday_text', $('[name=regular_holiday_text]').val());
		fd.append('regular_holiday', checkbox_value.regular_holiday);
		fd.append('drink_text', $('[name=drink_text]').val());
		fd.append('service_charge', $('[name=service_charge]').val());
		fd.append('cansel_charge', $('[name=cansel_charge]').val());
		fd.append('available_card', checkbox_value.available_card);
		fd.append('seat_total', $('[name=seat_total]').val());
		fd.append('start_time', $('[name=start_time]').val());
		fd.append('start_time_dinner', $('[name=start_time_dinner]').val());
		fd.append('lo_time', $('[name=lo_time]').val());
		fd.append('lo_time_dinner', $('[name=lo_time_dinner]').val());
		fd.append('etc6', $('#etc6').val());
		fd.append('etc7', $('#etc7').val());



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
//				if(validate()){
					$('#conf').hide();
					$('#return, #submit').show();
					$('html,body').animate({ scrollTop: '.storeEditIn' }, 'fast');
					$('#conf_text').html('<span class="registTit2"><br>以下の内容が登録されます。よろしければ「登録」ボタンをクリックしてください。</span>');
					disp_disabled();
//				}else{
//					$('html,body').animate({ scrollTop: '.error' }, 'fast');
//				}
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
		var form_datas = get_form_prams('init_store');

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

				$('#input_area_created').html(result.data.input_area_created);

				//一覧表示処理呼び出し
				list_disp_exection(result.data);

				$('#cuisine_genre').val(result.data.cuisine_genre);
				$('#area_region').val(result.data.area_region);
				$('#area_pref').val(result.data.area_pref);
				$('#area').val(result.data.area);
				var characteristic_id = result.data.characteristic_id.split(',');
				$('[name=characteristic_id]').val(characteristic_id);
				$('#plan_type_id').val(result.data.plan_type_id);
				$('[name=dress_flg]').val([result.data.dress_flg]);
				$('#dress_text').val(result.data.dress_text);
				$('[name=child_flg]').val([result.data.child_flg]);
				$('#child_text').val(result.data.child_text);
				$('[name=smoke_type]').val([result.data.smoke_type]);
				$('#smoke_text').val(result.data.smoke_text);
				$('[name=wheelchair_flg]').val([result.data.wheelchair_flg]);
				$('#wheelchair_text').val(result.data.wheelchair_text);
				$('[name=parking_flg]').val([result.data.parking_flg]);
				$('#parking_text').val(result.data.parking_text);
				$('#store_name').val(result.data.store_name);
				$('#store_name_kana').val(result.data.store_name_kana);
				$('#tel').val(result.data.tel);
				$('#addr').val(result.data.addr);
				$('#url').val(result.data.url);
				$('#nearest_station').val(result.data.nearest_station);
				$('#access').val(result.data.access);
				$('#business_hours').val(result.data.business_hours);
				$('#regular_holiday_text').val(result.data.regular_holiday_text);
				var regular_holiday = result.data.regular_holiday.split(',');
				$('[name=regular_holiday]').val(regular_holiday);
				$('#drink_text').val(result.data.drink_text);
				$('#service_charge').val(result.data.service_charge);
				$('#cansel_charge').val(result.data.cansel_charge);
				var available_card = result.data.available_card.split(',');
				$('[name=available_card]').val(available_card);
				$('#seat_total').val(result.data.seat_total);

				//時刻系処理
				if(result.data.start_time != null && result.data.start_time != ""){
					var start_time = result.data.start_time.split(':');
					var start_time_dinner = result.data.start_time_dinner.split(':');
					var lo_time = result.data.lo_time.split(':');
					var lo_time_dinner = result.data.lo_time_dinner.split(':');

					console.log((lo_time[0] != '00' || lo_time[1] != '00') || (lo_time_dinner[0] != '00' || lo_time_dinner[1] != '00'));
					if( (lo_time[0] != '00' || lo_time[1] != '00') || (lo_time_dinner[0] != '00' || lo_time_dinner[1] != '00') ){
						$('.business_time_text').show();
						$('.business_time_area').show();
						$('[name=lunch_flg]').prop('checked', true);
					}

					$('#start_time_hour').val(start_time[0]);
					$('#start_time_min').val(start_time[1]);
					$('#start_time').val(result.data.start_time);
					$('#start_time_dinner_hour').val(start_time_dinner[0]);
					$('#start_time_dinner_min').val(start_time_dinner[1]);
					$('#start_time_dinner').val(result.data.start_time_dinner);
					$('#lo_time_hour').val(lo_time[0]);
					$('#lo_time_min').val(lo_time[1]);
					$('#lo_time').val(result.data.lo_time);
					$('#lo_time_dinner_hour').val(lo_time_dinner[0]);
					$('#lo_time_dinner_min').val(lo_time_dinner[1]);
					$('#lo_time_dinner').val(result.data.lo_time_dinner);
				}

				$('#etc6').val(result.data.etc6);
				$('#etc7').val(result.data.etc7);


				//表示系処理
				check_disp_change();

				//時間処理
				time_picker()

				//クラブ表示処理
				club_select()


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
		var entry_datas = get_form_prams('edit_store', null, null, null);
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
				location.replace('./');

			}else if (!result.data.status && result.data.error_code == 0){
				// PHP返却エラー
				alert(result.data.error_msg);
				location.href = result.data.return_url;
			}else{
				console.log(result)
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


	/**
	 * クラブ用処理
	 */
	function club_select(){
		var cg_sub = $('#cuisine_genre option:selected').attr('sub');
		if(cg_sub == 5){
			$('.club_only').show();
		}else{
			$('.club_only').hide();
		}

		$('#cuisine_genre').off();
		$('#cuisine_genre').on('change', function(){
			var cg_sub = $('#cuisine_genre option:selected').attr('sub');
			if(cg_sub == 5){
				$('.club_only').show().find('select').addClass('validate required');
			}else{
				$('.club_only').hide().find('select').removeClass('validate required').val('');
			}
		});
	}
























});