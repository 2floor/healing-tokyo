
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


$(function() {
	//コントローラー呼び出し
	right_page_init();

	/**
	 * 初期処理
	 */
	function right_page_init(){

		//画面TOPへスクロール
		$('html,body').animate({ scrollTop: 0 }, 'fast');

		//プルダウン初期処理
		moment.locale('ja');

		//今日の日付を取得
		var now_date = moment().format('YYYY/MM/DD');
		var now_day = moment().format('D');
		$('[name=r_day]').val(now_day);

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
			buttonImage: $('[name=hid_path]').val() + "assets/admin/js/common/colorpicker/images/calendar-icon.png",
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

		//検索ボタン押下時
		$('#right2_s_btn').on('click',function(){

			var year = $('[name=r_year]').val();
			var day = $('[name=r_day]').val();
			var noscene = $('[name=noscene]:checked').val();
			var t = $('[name=t]:checked').val();

			var min_cnt = $('[name=s_min_cnt]').val();
			var max_cnt = $('[name=s_max_cnt]').val();

			var area = $('[name=area_chkbox]:checked').map(function() {
			  return $(this).val();
			}).get();

			var area_str = '';
//			for (var i = 0; i < area.length; i++) {
				area_str += area;
//			}

			var link = '';

			if (t != '' && t != null) {
				link += '&t='+t;
			}

			if (year != '' && year != null) {
				link += '&y='+year;
			}

			if (day != '' && day != null) {
				link += '&day='+day;
			}

			if (noscene != '' && noscene != null) {
				link += '&no='+noscene;
			}

			if (min_cnt != '' && min_cnt != null) {
				link += '&min='+min_cnt;
			}

			if (max_cnt != '' && max_cnt != null) {
				link += '&max='+max_cnt;
			}

			if (area_str != '' && area_str != null) {
				link += '&ar='+area_str;
			}

			location.href = $('[name=hid_path]').val() + 'search/?' + link
		})
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



