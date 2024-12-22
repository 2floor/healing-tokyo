
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


		//月カレンダー変更時処理
		$('.calender').each(function() {
			var id = '#' + $(this).attr('id');
			$(id + ' input').bind('change', function() {
				//プルダウン更新処理呼び出し

				//2週間カレンダー全て非表示へ
				$('.two_w_cal').hide();

				//月カレンダーで指定された日付から2週間分を表示
				for (var i = 0; i < 14; i++) {
					var date = moment($(this).val());
					var plus_day = date.add(i, "day").format("YYYY-MM-DD");
					$('#'+plus_day).show();

					//CSS調整
					if (i == 0) {
						$('#'+plus_day).css({'border-left':'1px solid #0e1242'});
					} else {
						$('#'+plus_day).css({'border-left':'0px solid #0e1242'});
					}
				}
			});
		});

		// 予約不可日を配列で確保
		var holidays = $('[name=hid_holiday]').val().split(',');

		var date = moment();
		var now_date_array = date.format("YYYY-MM-DD").split('-');

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
			minDate: new Date(now_date_array[0], Number(now_date_array[1]) - 1, now_date_array[2]),
			maxDate: new Date(now_date_array[0], Number(now_date_array[1]) - 1, Number(now_date_array[2]) + 61),//本日より62日後まで指定可能
			beforeShowDay: function(date) {
				// 予約不可日の判定
				for (var i = 0; i < holidays.length; i++) {
					var htime = Date.parse(holidays[i]);    // 予約不可日を 'YYYY-MM-DD' から time へ変換
					var holiday = new Date();
					holiday.setTime(htime);                 // 上記 time を Date へ設定

					// 予約不可日
					if (holiday.getYear() == date.getYear() &&
						holiday.getMonth() == date.getMonth() &&
						holiday.getDate() == date.getDate()) {
						return [false, 'holiday'];
					}
				}
				// 平日
				return [true, ''];
			}
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
				dateFormat : 'yy-mm-dd',
				firstDay : 0,
				isRTL : false,
				showMonthAfterYear : true,
				yearSuffix : '年',

			};
		$.datepicker.setDefaults($.datepicker.regional['ja']);

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

});



