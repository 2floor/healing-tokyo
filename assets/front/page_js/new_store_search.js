
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
//const MAX_ENTRY_CNT = 19;

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
				url : $('#sct_url').val(),// コントローラURLを取得
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
//			console.log(v.name);
		});


		//独自のパラメータやtype=fileがある場合はここでFormDataに追加
		//method設定
		fd.append('method', method);

		//検索タイプ(ALL、ランチ、ディナー、バー、クラブ)
		fd.append('search_type', $('#search_type').val());

		// フォーム入力値返却
		return fd;
	}
	/**
	 * 処理コントローラー
	 */
	function page_ctrl(){
		//bodysize取得
		get_body_size(true);
	}

	/**
	 * 初期処理
	 */
	function page_init(){

		//画面TOPへスクロール
		$('html,body').animate({ scrollTop: 0 }, 'fast');

		var param = getUrlVars();
		console.log(param);

		if (param['ar'] != null && param['ar'] != '') {
			ary = param['ar'].split(',');
			$("[name=area_chkbox]").val(ary);

			var select_area_chkbox = $('[name=area_chkbox]:checked').map(function() {
				return $(this).attr('jq_str');
			}).get();

			var select_area_html = '';
			for (var i = 0; i < select_area_chkbox.length; i++) {
				select_area_html += '<span class="formRBox" id="select_area_disp">' + select_area_chkbox[i] + '</span>';
			}

			if (select_area_html == '') {
				select_area_html = '<span class="formRBox">指定なし</span>';
			}

			$('#select_area_str').html(select_area_html);
		}

		//プルダウン初期処理
		moment.locale('ja');

		//今日の日付を取得
		var now_date = moment().format('YYYY/MM/DD');

		//プルダウン更新処理呼び出し
		set_y_select(now_date)

		//hidden項目に今日の日付を設定
		$('#dateCal').val(now_date)

		//エリアチェックボックス変更処理
		$('[name=select_area]').on('click', function(){
			var select_area_chkbox = $('[name=area_chkbox]:checked').map(function() {
				return $(this).attr('jq_str');
			}).get();

			var select_area_html = '';
			for (var i = 0; i < select_area_chkbox.length; i++) {
				select_area_html += '<span class="formRBox" id="select_area_disp">' + select_area_chkbox[i] + '</span>';
			}

			if (select_area_html == '') {
				select_area_html = '<span class="formRBox">指定なし</span>';
			}

			$('#select_area_str').html(select_area_html);
			parent.$.fn.colorbox.close();
		});

		$('[name=reset]').on('click', function(){
			$('#select_area_str').html('<span class="formRBox">指定なし</span>');
		});



		//カレンダー変更時処理
		$('.calender').each(function() {
			var id = '#' + $(this).attr('id');
			$(id + ' input').bind('change', function() {
				//プルダウン更新処理呼び出し
				set_y_select($(this).val())
			});
		});

		//カレンダーの表示
		var date = new Date();
		var year = date.getFullYear();
		var m = date.getMonth();
		var d = date.getDate();
		$.datepicker.setDefaults({
			numberOfMonths : 2,
//	 		showCurrentAtPos : 1,
			stepMonths : 1,
			showButtonPanel : true,
			gotoCurrent : true,
			showOn: "button",
			buttonImage: "../assets/admin/js/common/colorpicker/images/calendar-icon.png",
			buttonImageOnly: true,
			minDate: new Date(year, m, d),
			maxDate: new Date(year, m + 2, 31),
			onSelect: function(dateText) {
				var d = dateText.split('/');
				$('#date_select_jq').val(d[0] + d[1] + d[2]);
				$('#dateCal').val(dateText);
			}
		});
//		$('.calender input').datepicker();

		$.datepicker.regional['ja'] = {
				closeText : '閉じる',
				prevText : '前の月',
				nextText : '次の月',
				currentText : '今日',
				monthNames : [ '1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月',
						'9月', '10月', '11月', '12月' ],
				monthNamesShort : [ '1月', '2月', '3月', '4月', '5月', '6月', '7月',
						'8月', '9月', '10月', '11月', '12月' ],
				dayNames : [ '日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日' ],
				dayNamesShort : [ '日', '月', '火', '水', '木', '金', '土' ],
				dayNamesMin : [ '日', '月', '火', '水', '木', '金', '土' ],
				weekHeader : '週',
				dateFormat : 'yy/mm/dd',
				firstDay : 0,
				isRTL : false,
				showMonthAfterYear : true,
				yearSuffix : '年',

			};
		$.datepicker.setDefaults($.datepicker.regional['ja']);

		$('.calendar').datepicker();


		var query = getUrlVars();

		//来店日日付指定
		if (query['no'] != '' && query['no'] != null && query['no'] != '1') {
			$("#d3").attr("checked", true);
		}

		//利用最小人数
		if (query['min'] != '' && query['min'] != null) {
			$('[name=min_cnt]').val(query['min'])
		}

		//利用最大人数
		if (query['max'] != '' && query['max'] != null) {
			$('[name=max_cnt]').val(query['max'])
		}

		//時間帯
		$(".club_only").hide();
		if (query['t'] != '' && query['t'] != null) {
			$('[name=time_zone]').val([query['t']])
			if(query['t'] == 3){
				$(".club_only").show();
			}else{
				$(".club_only").hide();
			}
		}

		//エリアモーダル
		if (query['ar'] != '' && query['ar'] != null) {
			$('[name=area_chkbox]').val([query['ar']]);
		}

		//プランタイプ
		if (query['p_n'] != '' && query['p_n'] != null) {
			$('[name=plan_name]').val([query['p_n']]);
		}

		//プランタイプ(プラチナ、ゴールド)
		if (query['p_t'] != '' && query['p_t'] != null) {
			$('[name=p_type]').val([query['p_t']]);
		}

		//シーン
		if (query['s_n'] != '' && query['s_n'] != null) {
			$('[name=scene_id]').val([query['s_n']]);
		}

		//クラブ在籍人数
		if (query['e6'] != '' && query['e6'] != null) {
			$('[name=etc6]').val([query['e6']]);
		}

		//クラブ平均年齢
		if (query['e7'] != '' && query['e7'] != null) {
			$('[name=etc7]').val([query['e7']]);
		}

		if (query['g_id'] != null && query['g_id'] != '') {
			var ary = query['g_id'].split(',');
			$("[name=cuisine_genre]").val(ary);
		}

		if(query['search_sort'] != null && query['search_sort'] != ''){
			$('[name=search_sort]').val(query['search_sort']);
		}

		if(query.outside == 1){
			no_scroll();
			$('#loading_area').removeClass('is-hide');

			var fd = new FormData();
			fd.append('method', 'search');
			var json_str = $('#get_json').val();
			var json = JSON.parse(json_str);
			$.each(json, function(key, val){
				if(!$.isArray(val)){
					fd.append(key, val);
				}else{
					fd.append(key, val.join());
				}
			});

			ajax.get(fd).done(function(result) {
				//店舗HTML設定
				$('#search_result').html(result.data.html);

				//検索条件HTML設定
				$('#search_disp_str').html(result.data.search_disp_str);

				//検索件数HTML設定
				$('#hit_no').html(result.data.search_cnt);

				return_scroll();
				$('#loading_area').addClass('is-hide');

				$(".paging").pagination({
					items: result.data.pager_page_cnt,//ページ数
					displayedPages: 1,
					viewNum: 20,
					cssStyle: 'light-theme',
					prevText: '<<前へ',
					nextText: '次へ>>',
					onPageClick: function(pageNumber){show(pageNumber)}
				});
				show(1);


			}).fail(function(result) {
				return_scroll();
				$('#loading_area').addClass('is-hide');
				$('body').html(result.responseText);
				// 異常終了
			});
		}else{
			//店舗検索処理
			if($('#outside').val() == 0){
				store_search();
			}
		}


		//検索ボタン押下時
		$('#search_btn').on('click',function(){
//			if($('#outside').val() == 0){
//				store_search();
//			}else{
				$('#frm').attr('method', 'get');
				$('#frm').attr('action', $('#index_path').val());
				$('#frm').append('<input type="hidden" name="outside" value="1"/>');
				$('#frm').append('<input type="hidden" name="search_sort" value="' + $('[name=search_sort]').val() + '"/>');
				$('#frm input[type=checkbox]').each(function(i, elem){
					$(elem).attr('name', $(elem).attr('name') + '[]');
				});
				$('#frm').submit();
//			}
		})

		$('[name=search_sort]').change(function(){
			$('#frm').attr('method', 'get');
			$('#frm').attr('action', $('#index_path').val());
			$('#frm').append('<input type="hidden" name="outside" value="1"/>');
			$('#frm').append('<input type="hidden" name="search_sort" value="' + $('[name=search_sort]').val() + '"/>');
			$('#frm input[type=checkbox]').each(function(i, elem){
				if($(elem).attr('name') != undefined){
					$(elem).attr('name', $(elem).attr('name') + '[]');
				}
			});
			$('#frm').submit();
		});

		change_club()

		//モーダル処理
		open_modal();

	}

	/**
	 * 店舗検索処理
	 */
	function store_search(){

		no_scroll();
		$('#loading_area').removeClass('is-hide');

		var fd = get_form_prams('search', 'frm');
		ajax.get(fd).done(function(result) {

			//店舗HTML設定
			$('#search_result').html(result.data.html);

			//検索条件HTML設定
			$('#search_disp_str').html(result.data.search_disp_str);

			//検索件数HTML設定
			$('#hit_no').html(result.data.search_cnt);

			return_scroll();
			$('#loading_area').addClass('is-hide');

			$(".paging").pagination({
				items: result.data.pager_page_cnt,//ページ数
				displayedPages: 1,
				viewNum: 20,
				cssStyle: 'light-theme',
				prevText: '<<前へ',
				nextText: '次へ>>',
				onPageClick: function(pageNumber){show(pageNumber)}
			});
			show(1);

			//お気に入り追加
			add_fav();

		}).fail(function(result) {
			return_scroll();
			$('#loading_area').addClass('is-hide');
			$('body').html(result.responseText);
			// 異常終了
		});
	}


	//プルダウン更新処理
	function set_y_select(date) {
		var dates = date.split('/');
		var set_y = dates[0] + dates[1];

		//プルダウン年設定
		$('#year').val(set_y)
		var month = dates[1] - 1;

		//選択値変更
		$('#date_select_jq').val(dates[0] + dates[1] + dates[2]);

		//和名変換用配列設定
		moment.lang('ja', {
			weekdays: ["日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日"],
			weekdaysShort: ["日","月","火","水","木","金","土"],
		});

		var m = moment([dates[0], month, dates[2]]);
		var end_day = m.daysInMonth();
		var day_html = '';

		//セレクトボックスHTML生成
		for(var i = 1; i < end_day + 1; i++){
			if (i == Number(dates[2])) {
				//選択日のセレクトを選択
				day_html += '<option value="'+i+'" selected>'+moment([dates[0], month, i]).format("DD日(ddd)")+'</option>';
			} else {
				day_html += '<option value="'+i+'">'+moment([dates[0], month, i]).format("DD日(ddd)")+'</option>';
			}
		}
		//セレクトボックスへ反映
		$('#day').html(day_html);



		var query = getUrlVars();

		//日付指定(年月設定)
		if (query['y'] != '' && query['y'] != null) {
			$('#year').val(query['y'])
			$('#date_select_jq').val(query['y']+query['day']);
			$("#date_select_jq").attr("checked", true);
		}

		if (query['year'] != '' && query['year'] != null) {
			$('#year').val(query['year'])
			$('#date_select_jq').val(query['year']+query['day']);
			$("#date_select_jq").attr("checked", true);
		}

		//日付指定(日設定)
		if (query['day'] != '' && query['day'] != null) {
			$('#day').val(query['day'])
			$('#date_select_jq').val(query['y']+query['day']);
			$("#date_select_jq").attr("checked", true);
		}

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

	//スクロール禁止用関数
	function no_scroll(){
		//PC用
		var scroll_event = 'onwheel' in document ? 'wheel' : 'onmousewheel' in document ? 'mousewheel' : 'DOMMouseScroll';
		$(document).on(scroll_event,function(e){e.preventDefault();});
		//SP用
		$(document).on('touchmove.noScroll', function(e) {e.preventDefault();});
	}

	//スクロール復活用関数
	function return_scroll(){
		//PC用
		var scroll_event = 'onwheel' in document ? 'wheel' : 'onmousewheel' in document ? 'mousewheel' : 'DOMMouseScroll';
		$(document).off(scroll_event);
		//SP用
		$(document).off('.noScroll');
	}

	function show(pageNumber){
		var page="#page-"+pageNumber;
		$('.selection').hide()
		$(page).show()

		if (pageNumber == 1) {
			$('.st_cnt').html('1');
			if ($('.hit_no').text() < 20) {
				$('.end_cnt').html($('#hit_no').text());
			} else {
				$('.end_cnt').html('20');
			}
		} else {
			$('.st_cnt').html(pageNumber * 20 - 20 + 1);

			var disp_plan_cnt = $(page).find('.searchResultBox').length;
			$('.end_cnt').html(pageNumber * 20 - 20 + disp_plan_cnt + 1);

		}

	}

	function change_club(){
		$('[name=time_zone]').off();
		$('[name=time_zone]').on('change', function(){
			var v = $('[name=time_zone]:checked').val()
			if(v == 3){
				$('.club_only').show();
			}else{
				$('.club_only').hide();
			}
		});
	}

	function open_modal(){

		$('.search_tbl_col').off();
		$('.search_tbl_col').on('click', function(){

			//クリックした要素
			var selected_elem = $(this);

			//どのモーダルを表示させるか
			var search_type = $(selected_elem).attr('se-ty');

			//モーダルサイズ設定
			if(get_body_size()){
				//PCサイズ
				var offset = $(selected_elem).offset();
				var width = 400;
				if(search_type == 'SArea' || search_type == 'SGenre' || search_type == 'SEtc'){
					offset = $('.search_tbl_col').eq(0).offset();
					width = 0;
					$('.search_tbl_col').each(function(i, elem){
						width += $(elem).outerWidth(true);
					});
					width += 20;
				}else if(search_type == 'SDate'){
					width += 60;
				}
				$('.search_min_modal').css({
					top: offset.top + 35,
					left: offset.left - 10,
					width: width + 'px',
				});
			}else{
				//スマホサイズ
				var top = $(window).scrollTop();
				var height = window.parent.screen.height;
				if(search_type == 'SNum' || search_type == 'SDate'){
					top += 150;
					height = 'auto';
				}

				$('.search_min_modal').css({
					top: top + 'px',
					left: 0,
					width: '100%',
					height: height,
				});

				//カレンダーの表示
				$('.calendar').datepicker('destroy');
				var date = new Date();
				var year = date.getFullYear();
				var m = date.getMonth();
				var d = date.getDate();
				$.datepicker.setDefaults({
					numberOfMonths : 1,
//			 		showCurrentAtPos : 1,
					stepMonths : 1,
					showButtonPanel : true,
					gotoCurrent : true,
					showOn: "button",
					buttonImage: "../assets/admin/js/common/colorpicker/images/calendar-icon.png",
					buttonImageOnly: true,
					minDate: new Date(year, m, d),
					maxDate: new Date(year, m + 2, 31),
					onSelect: function(dateText) {
						var d = dateText.split('/');
						$('#date_select_jq').val(d[0] + d[1] + d[2]);
						$('#dateCal').val(dateText);
					}
				});

				$.datepicker.regional['ja'] = {
						closeText : '閉じる',
						prevText : '前の月',
						nextText : '次の月',
						currentText : '今日',
						monthNames : [ '1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月',
								'9月', '10月', '11月', '12月' ],
						monthNamesShort : [ '1月', '2月', '3月', '4月', '5月', '6月', '7月',
								'8月', '9月', '10月', '11月', '12月' ],
						dayNames : [ '日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日' ],
						dayNamesShort : [ '日', '月', '火', '水', '木', '金', '土' ],
						dayNamesMin : [ '日', '月', '火', '水', '木', '金', '土' ],
						weekHeader : '週',
						dateFormat : 'yy/mm/dd',
						firstDay : 0,
						isRTL : false,
						showMonthAfterYear : true,
						yearSuffix : '年',

					};
				$.datepicker.setDefaults($.datepicker.regional['ja']);

				$('.calendar').datepicker();
			}

			//表示
			$('.search_min_modal').show();
			$('.search_min_modal_layer').show();
			$('.' + search_type).show();

			//現在の検索条件取得
			var before_input = {};
			$('.' + search_type).find('input, select').each(function(i, elem){
				var v = {
						'name' :$(elem).attr('name'),
						'value' :$(elem).val(),
					};
				if(!$('[name='+v.name+']').hasClass('exception')){
					$type = $('[name='+v.name+']').attr('type');
					if ($type != 'radio' && $type != 'checkbox') {
						//text,textarea,select設定
						before_input[v.name] = v.value;
					} else if($type == 'radio'){
						//ラジオボタン設定
						before_input[v.name] = $('[name='+v.name+']:checked').val();
					} else if ($type == 'checkbox') {
						//チェックボックス設定(配列)
						var area = $('[name='+v.name+']:checked').map(function() {
							return $(this).val();
						}).get();
						before_input[v.name] = area;
					}
				}
			});

			//レイヤー、閉じるボタンクリック
			$('.search_min_modal_layer, .close_modal').off();
			$('.search_min_modal_layer, .close_modal').on('click', function(){
				$('.search_min_modal').hide();
				$('.search_min_modal_layer').hide()
				$('.search_min_modal_in').hide();

				$('.' + search_type).find('input, select, textarea').each(function(i, elem){
					var type = $(this).attr('type');
					if(type != 'checkbox' && type != 'radio' && type != 'file'){
						//テキスト
						$(elem).val('');
					}else if(type == 'checkbox'){
						//チェックボックス
						$(elem).prop('checked', false);
					}else if(type == 'radio'){
						//ラジオボタン
						$(elem).attr('checked', false);
					}
				});

				//複数回処理させない
				var check_flg = new Array();
				$('.' + search_type).find('input, select, textarea').each(function(i, elem){
					if(!$(this).hasClass('exception')){
						var type = $(this).attr('type');
						var name = $(this).attr('name');
						//複数回処理させない
						if(check_flg[name] !== true){
							if(type != 'checkbox' && type != 'radio' && type != 'file'){
								//テキスト
								$(elem).val(before_input[name]);
							}else if(type == 'checkbox'){
								if(before_input[name]){
									//チェックボックス
									var check_array = new Array();
									if(before_input[name][1]){
										//複数
										check_array = before_input[name]
									}else{
										//単数
										check_array[0] = before_input[name][0];
									}
									$('[name=' + name + ']').val(check_array);
									console.log();
								}
							}else if(type == 'radio'){
								//ラジオボタン
								$('[name=' + name + ']').val([before_input[name]]);
							}
							check_flg[name] = true;
						}
					}
				});
			});

			//リセットクリック
			$('.reset_modal').off();
			$('.reset_modal').on('click', function(){
				if(search_type == 'SDate' ){
					var date = new Date();
					var year = date.getFullYear();
					var m = date.getMonth() + 1;
					var d = date.getDate();
					$('#date_select_jq').val("");
					$(selected_elem).find('.search_res').text('日付');
					$('.search_min_modal').hide();
					$('.search_min_modal_layer').hide()
					$('.search_min_modal_in').hide();
				}else{
					$('.' + search_type).find('input, select, textarea').each(function(i, elem){
						var type = $(this).attr('type');
						if(type != 'checkbox' && type != 'radio' && type != 'file'){
							//テキスト
							$(elem).val('');
						}else if(type == 'checkbox'){
							//チェックボックス
							$(elem).prop('checked', false);
						}else if(type == 'radio'){
							//ラジオボタン
							$(elem).attr('checked', false);
						}
					});
				}
			});

			//設定クリック
			$('.set_modal').off();
			$('.set_modal').on('click', function(){
				$('.search_min_modal').hide();
				$('.search_min_modal_layer').hide()
				$('.search_min_modal_in').hide();

				var f = false;
				var after_input ={};
				$('.' + search_type).find('input, select').each(function(i, elem){
					var v = {
							'name' :$(elem).attr('name'),
							'value' :$(elem).val(),
						};
					$type = $('[name='+v.name+']').attr('type');
					if ($type != 'radio' && $type != 'checkbox') {
						//text,textarea,select設定
						after_input[v.name] = v.value;
						if(v.value){
							f = true;
						}
					} else if($type == 'radio'){
						//ラジオボタン設定
						after_input[v.name] = $('[name='+v.name+']:checked').val();
						if($('[name='+v.name+']:checked').val()){
							f = true;
						}
					} else if ($type == 'checkbox') {
						//チェックボックス設定(配列)
						var area = $('[name='+v.name+']:checked').map(function() {
							return $(this).val();
						}).get();
						after_input[v.name] = area;
						if(area.length != 0){
							f = true;
						}
					}
				});
				if(f){
					if(search_type == 'SDate' ){
						$(selected_elem).find('.search_res').text(after_input['dateCal']);
					}else {
						$(selected_elem).find('.search_res').text('指定有り');
					}
				}else{
					var ini_text = '';
					if(search_type == 'SDate' ){
						ini_text = '日付';
					}else if(search_type == 'STime' ){
						ini_text = '時間帯';
					}else if(search_type == 'SNum'){
						ini_text = '指定なし';
					}else if(search_type == 'SArea' ){
						ini_text = 'エリア';
					}else if( search_type == 'SGenre' ){
						ini_text = 'ジャンル';
					}else if( search_type == 'SEtc'){
						ini_text = '予算・他';
					}
					$(selected_elem).find('.search_res').text(ini_text);
				}
			});
		});
	}


	/**
	 * bodysize取得
	 */
	function get_body_size(flg){
		var res = '';
		var wid = $(document).width();
		if(wid <= 767){
			//スマホサイズ
			res = false;
		}else{
			//PCサイズ
			res = true;
		}

		if(flg === true) {
			if(res === false){
				var html = {};
				$('.spVi').each(function(i, elem){
					html[$(elem).attr('se-ty')] = $(elem).prop('outerHTML');
				});
				html['search_btn'] = $('.search_btn').prop('outerHTML');
				html['cf'] = '<span class="clearFix"></span>';
				$('.search_tbl').html('')
					.append(html['SDate'])
					.append(html['SArea'])
					.append(html['SNum'])
					.append(html['SGenre'])
					.append(html['cf'])
					.append(html['search_btn'])
					.append(html['cf']);
			}
			//初期処理呼び出し
			page_init();
		}else{
			return res;
		}
	}



	function add_fav(){
		$('.add_fav').off();
		$('.add_fav').on('click', function(){
			var tar  = $(this)
			var hid_s_id = tar.attr('hid_s_id');
			var fd = new FormData();
			fd.append('method', 'add_fav');
			fd.append('hid_s_id', hid_s_id);

			ajax.get(fd).done(function(result) {
				if(!result.data.status){
					alert(result.data.msg);
				}else{
					tar.removeClass('add_fav').removeClass('fa-heart-o').addClass('fa-heart')
				}
			}).fail(function(result) {
				return_scroll();
				$('#loading_area').addClass('is-hide');
				$('body').html(result.responseText);
				// 異常終了
			});
		});
	}
});



