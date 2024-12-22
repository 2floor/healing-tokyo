
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
	function get_form_prams(method, now_page_num, get_next_disp_page, page_disp_cnt) {

		var fd = new FormData();
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

		//SP用のメニュー処理
	    $(".spmenu_btn").on("click", function() {
	        $(this).next().slideToggle();
	        $(this).toggleClass("active");
	    });

		//画面TOPへスクロール
		$('html,body').animate({ scrollTop: 0 }, 'fast');

		//戻るボタン処理
		$('[name=return]').off();
		$('[name=return]').on('click',function(){
			location.href = './edit_cat_information.php';
		});

		//登録処理
		$('[name=entry]').off();
		$('[name=entry]').on('click',function(){
			// メソッド定義
			var form_datas = get_form_prams('entry', null, null, null);

			//登録処理呼び出し
			call_ajax_entry(form_datas)
		});
		// メソッド定義
		var form_datas = get_form_prams('data_refresh', null, null, null);

		//登録情報再取得
		call_ajax_data_refresh(form_datas)

		$.getScript("../assets/front/page_js/get_cat_data.js",function(){
		});

	}


	/**
	 * 初期処理AJAX
	 */
	function call_ajax_entry(post_data){
		ajax.get(post_data).done(function(result) {
			location.href = './';
		}).fail(function(result) {
			// 異常終了
			$('body').html(result.responseText);
		});
	}

	/**
	 * 登録情報再取得処理AJAX
	 */
	function call_ajax_data_refresh(post_data){
		ajax.get(post_data).done(function(result) {

			if (result != null) {
				var data = result.data.result;
				$('#mediation_flg_str').val(data.mediation_flg_str);
				$('#nego_status_str').val(data.nego_status_str);
				$('#etc2_str').val(data.etc2);
				$('#file1_str').val(data.file1);
				$('#file2_str').val(data.file2);
				$('#file3_str').val(data.file3);
				$('#file4_str').val(data.file4);
				$('#file5_str').val(data.file5);
				$('#movie_str').val(data.movie);
				$('#name_str').val(data.name);
				$('#gender_str').val(data.gender_str);
				$('#kind_str').val(data.kind);
				$('#pref_str').val(data.pref);
				$('#age_str').val(data.age);
				$('#rearing_years_str').val(data.rearing_years);
				$('#weight_str').val(data.weight);
				$('#height_str').val(data.height);
				$('#reason_str').val(data.reason);
				$('#characteristic_str').val(data.characteristic);
				$('#how_get_str').val(data.how_get);
				$('#castration_flg_str').val(data.castration_flg_str);
				$('#etc1_str').val(data.etc1_str);
				$('#micro_status_str').val(data.micro_status_str);
				$('#care_status_str').val(data.care_status);
				$('#health_str').val(data.health);
				$('#extradition_date_str').val(data.extradition_date);
				$('#other_str').val(data.other);
			}

		}).fail(function(result) {
			// 異常終了
			$('body').html(result.responseText);
		});
	}
});



