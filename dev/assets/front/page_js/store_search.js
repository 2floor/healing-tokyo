
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
		//初期処理呼び出し
		page_init();
	}

	/**
	 * 初期処理
	 */
	function page_init(){

		//画面TOPへスクロール
		$('html,body').animate({ scrollTop: 0 }, 'fast');

		var param = getUrlVars();

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
			minDate: new Date(year, m, 1),
			maxDate: new Date(year, m + 2, 31)
		});
		$('.calender input').datepicker();

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
			if(query['t'] == 4){
				$("[name=plan_name]").val([1]);
			}
		}

		//エリアモーダル
		if (query['ar'] != '' && query['ar'] != null) {
			$('[name=area_chkbox]').val([query['ar']]);
		}

		//シーン
		if (query['s_n'] != '' && query['s_n'] != null) {
			$('[name=scene_id]').val([query['s_n']]);
		}

		//特徴
		if (query['c_n'] != '' && query['c_n'] != null) {
			$('[name=char_name]').val([query['c_n']]);
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


		//店舗検索処理
		store_search();

		//検索ボタン押下時
		$('#search_btn').on('click',function(){
			store_search_btn()
		})

		$('[name=search_sort]').change(function(){
			store_search_btn()
		});

		change_club()

	}

	/**
	 * 店舗検索処理
	 */
	function store_search(){

		no_scroll();
		$('#loading_area').removeClass('is-hide');

		var fd = get_form_prams('search', 'frm');
		ajax.get(fd).done(function(result) {
//			console.log(result);

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
//			console.log(aa)
		});
	}


	/**
	 * 店舗検索処理
	 */
	function store_search_btn(){
		$('#frm').attr('method' , 'get')
		.attr('action' , './index.php')
		.submit();
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

});



