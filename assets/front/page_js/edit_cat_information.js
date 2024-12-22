
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
		fd.append('mediation_flg', $('[name=mediation_flg]:checked').val());
		fd.append('nego_status', $('[name=nego_status]:checked').val());
		fd.append('etc2', $('[name=etc2]').val());

		fd.append('file1', $('#hid_img_name1').val());
		fd.append('file2', $('#hid_img_name2').val());
		fd.append('file3', $('#hid_img_name3').val());
		fd.append('file4', $('#hid_img_name4').val());
		fd.append('file5', $('#hid_img_name5').val());
		fd.append('movie', $('[name=movie]').val());
		fd.append('name', $('[name=name]').val());
		fd.append('gender', $('[name=gender]:checked').val());
		fd.append('kind', $('[name=kind]').val());
		fd.append('pref', $('[name=pref]').val());
		fd.append('age', $('[name=age]').val());
		fd.append('rearing_years', $('[name=rearing_years]').val());
		fd.append('weight', $('[name=weight]').val());
		fd.append('height', $('[name=height]').val());
		fd.append('reason', $('[name=reason]').val());
		fd.append('characteristic', $('[name=characteristic]').val());
		fd.append('how_get', $('[name=how_get]').val());
		fd.append('castration_flg', $('[name=castration_flg]:checked').val());
		fd.append('etc1', $('[name=etc1]:checked').val());
		fd.append('micro_status', $('[name=micro_status]:checked').val());
		fd.append('care_status', $('[name=care_status]').val());
		fd.append('health', $('[name=health]').val());
		fd.append('extradition_date', $('[name=extradition_date]').val());
		fd.append('other', $('[name=other]').val());
		fd.append('change_img', $('[name=change_img]:checked').val());

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


		$('[name=conf]').off();
		$('[name=conf]').on('click',function(){

			if ($('.formErrorContent').length == 0) {

				if ($('#hid_img_name1').val() == '') {
					alert('プロフィール画像の1枚目は必須です。');
				} else {
					// メソッド定義
					var form_datas = get_form_prams('conf', null, null, null);
					// 初期処理AJAX呼び出し処理
					call_ajax_conf(form_datas);
				}
			}
		});

		$.getScript("../assets/front/page_js/get_cat_data.js",function(){

			if(($("[name=change_img]").length) != 0){
				$("#set_img_area").hide();

			$("[name=change_img]").change(function(){
				if($(this).val() == 0){
					$("#set_img_area").hide();
				} else {
					myRet = confirm("画像を変更するを選択した場合、\r\n登録されている画像が全て未登録になります。\r\nよろしいですか？");
					if ( myRet == true ){
						$("#set_img_area").show();
					}else{
						$('[name=change_img]').val(['0']);
					}
				}
			});
			}
		});

//		//初期情報取得処理AJAX呼び出し
//		var form_datas = get_form_prams('init', null, null, null);
//		call_ajax_init(form_datas);
	}

	/**
	 * 確認処理AJAX
	 */
	function call_ajax_init(post_data){
		ajax.get(post_data).done(function(result) {

			//登録済み会員情報設定
			var user_data = result.data.result;
			$('[name=nickname]').val(user_data.nickname);
			$('[name=name2]').val(user_data.name2);
			$('[name=name1]').val(user_data.name1);
			$('[name=age]').val(user_data.etc1);
			$('[name=zip]').val(user_data.zip1 + user_data.zip2);
			$('[name=pref]').val(user_data.pref);
			$('[name=addr]').val(user_data.addr);
			$('[name=other_addr]').val(user_data.other_addr);
			$('[name=tel]').val(user_data.tel);

			if (user_data.name2 == '' || user_data.name2 == null) {
				//未登録時対応

			} else {
				//登録済み対応
				$('#def_nickname').html(user_data.nickname);
				$('#def_name2').html(user_data.name2);
				$('#def_name1').html(user_data.name1);
				$('#def_age').html(user_data.etc1);
				$('#def_zip').html(user_data.zip1 + user_data.zip2);
				$('#def_pref').html(user_data.pref);
				$('#def_addr').html(user_data.addr);
				$('#def_other_addr').html(user_data.other_addr);
				$('#def_tel').html(user_data.tel);

				if (user_data.gender == 0) {
					$('#def_gender').html('男性');
				} else {
					$('#def_gender').html('女性');
				}
				$('[name=gender]').val([user_data.gender]);

				$('.new_cha').hide();
			}

			//パスワード変更処理
			$('[name=ch_pass]').off();
			$('[name=ch_pass]').change(function(){
				var pass_area = '';
				if ($('[name=ch_pass]:checked').val() == '0') {
					pass_area += '<div class="editMemberInfoFormRow">';
					pass_area += '<div class="editMemberInfoFormRow">';
					pass_area += '<div class="editMemberInfoFormItem">新しいパスワード：</div>';
					pass_area += '<div class="editMemberInfoFormTxt01">';
					pass_area += '<input type="password" name="pass" class="form100-40 validate required password" placeholder="パスワードを入力">';
					pass_area += '</div>';
					pass_area += '</div>';
					pass_area += '<div class="editMemberInfoFormRow">';
					pass_area += '<div class="editMemberInfoFormItem">新パスワード確認用：</div>';
					pass_area += '<div class="editMemberInfoFormTxt01">';
					pass_area += '<input type="password" name="pass_conf" class="form100-40 validate required password_conf" placeholder="パスワードを入力">';
					pass_area += '</div>';
					pass_area += '</div>';
				}
				$('#change_pass_area').html(pass_area);
			});


		}).fail(function(result) {
			// 異常終了
//			$('body').html(result.responseText);
		});
	}


	/**
	 * 初期処理AJAX
	 */
	function call_ajax_conf(post_data){
		ajax.get(post_data).done(function(result) {
			location.href = 'edit_cat_information_conf.php';
		}).fail(function(result) {
			// 異常終了
//			$('body').html(result.responseText);
		});
	}
});



