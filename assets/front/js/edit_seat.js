
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
	function get_form_prams (method, from_id) {

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
			} else if ($type == 'file') {
				//チェックボックス設定(配列)
				fd.append('img_' + $(this).attr('jq_id'), this.files[0].name)
			}
			console.log(v.name);
		});

		//ファイル名取得処理
		get_file_name(fd);

		//独自のパラメータやtype=fileがある場合はここでFormDataに追加
		//method設定
		fd.append('method', method);
		fd.append('edit_del_id', $('#id').val());
		fd.append('form_num', $('#add_form').val());

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
//				$('#conf_text').html('以下の項目はすべて<span class="registTit2">※必須項目</span>です。');
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
		var form_datas = get_form_prams('init_store_seat', null);

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
//				console.log(result.data);

				$('#input_area_created').html(result.data.input_area_created);

				//一覧表示処理呼び出し
				list_disp_exection(result.data);
				$('#personal_dir').val('store_id' + result.data.store_basic_id );

				if(result.data.store_seat_data != null && result.data.store_seat_data != ''){
					$.each(result.data.store_seat_data, function(i){
						if(i > 0){
							add_form(parseInt(i) + 1);
						}

						var cnt = parseInt(i) + 1;
						var seat_data = result.data.store_seat_data[i];

						$('[name=store_seat_id_' + cnt +']').val(seat_data.store_seat_id);
						$('#seat_type_' + cnt).val(seat_data.seat_type);
						$('#seat_title_' + cnt).val(seat_data.seat_title);
						$('#comment_' + cnt).val(seat_data.comment);
						$('#seat_num_' + cnt).val(seat_data.seat_num);
						$('#people_min_' + cnt).val(seat_data.people_min);
						$('#people_max_' + cnt).val(seat_data.people_max);
						$('[name=smoke_flg_' + cnt + ']').val([seat_data.smoke_flg]);
						$('#store_name_' + cnt).val(seat_data.store_basic_id);
						$('#del_seat_' + cnt).val(seat_data.store_seat_id);
						$('#del_seat_' + cnt).attr('title', seat_data.seat_title);
						$('span.img_name_' + i).text(seat_data.img)

						$('span.img_name_' + seat_data.store_seat_id).text(seat_data.img);
						$('#img_area' + cnt).append('<img class="storeEditImg2 " src="../upload_files/store/store_id'+result.data.store_basic_id+'/store_seat/'+seat_data.img+'">')
					});
				}

				//表示系処理
				check_disp_change();

				//削除処理
				del_exection();


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
		var entry_datas = get_form_prams('edit_store_seat', 'frm');
		//ajax呼び出し
		call_ajax_change_state(entry_datas);
	}

	/**
	 * 状態編集更新処理AJAX 更新、登録、削除、公開
	 */
	function call_ajax_change_state (post_data){
		ajax.get(post_data).done(function(result) {
//			console.log(result);
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
			}

		}).fail(function(result) {
			// 異常終了
			$('body').html(result.responseText);
		});
	}

	/**
	 * 削除処理
	 */
	function del_exection(){
		$('.del').off();
		$('.del').on('click',function(){
			var id = $(this).val();
			var title = $(this).attr('title');
			if( title == undefined){
				title = 'この座席';
			}
			ret = confirm(title + "を削除します。よろしいですか？");
				if (ret == true){

					if(id != null && id != '' ){
						// 呼び出し前method定義
						var form_data = get_form_prams('delete_seat', null);
						form_data.append('id', id);

						// ajax呼び出し
						call_ajax_change_state(form_data);
					}else{
						$('.seat_input_area_' + $(this).attr('num')).remove();
					}
				}
		});
	}



	/**
	 * 各種表示系処理
	 */
	function check_disp_change(){

		$('#add_form').off();
		$('#add_form').on('click', function(){
			add_form($(this).val());
		});


	}



	function add_form(num){
			var num_m = num -1;

			var form_html  = '<div class="storeEditItem seat_input_area_'+num+'" id="from_'+num+'">';
				form_html += '	<input type="hidden" name="store_seat_id_'+num+'" class="seat_id" value="">';
				form_html += '	<div class="storeEditRow">';
				form_html += '		<div class="storeEditCate">座席'+num+'名称</div>';
				form_html += '		<div class="storeEditForm">';
				form_html += '			<input type="text" id="seat_title_'+num+'" name="seat_title_'+num+'" class="formTxt1 validate required">';
				form_html += '		</div>';
				form_html += '	</div>';
				form_html += '	<div class="storeEditRow">';
				form_html += '		<div class="storeEditCate">座席'+num+'説明文</div>';
				form_html += '		<div class="storeEditForm">';
				form_html += '			<textarea id="comment_'+num+'" name="comment_'+num+'" rows="5" cols="" class="formTxt1 validate required"></textarea>';
				form_html += '		</div>';
				form_html += '	</div>';
				form_html += '	<div class="storeEditRow">';
				form_html += '		<div class="storeEditCate">座席タイプ</div>';
				form_html += '		<div class="storeEditForm">';
				form_html += '			<span class="registBox33">';
				form_html += '				<select name="seat_type_'+num+'" id="seat_type_'+num+'" class="formTxt1 validate required">';
				form_html += '					<option value="0" selected>窓際</option>';
				form_html += '					<option value="1">テラス席</option>';
				form_html += '					<option value="2">ソファ席</option>';
				form_html += '					<option value="3">個室</option>';
				form_html += '					<option value="4">半個室</option>';
				form_html += '					<option value="5">カウンター</option>';
				form_html += '				</select>';
				form_html += '			</span>';
				form_html += '		</div>';
				form_html += '	</div>';
				form_html += '	<div class="storeEditRow">';
				form_html += '		<div class="storeEditCate">座席数</div>';
				form_html += '		<div class="storeEditForm">';
				form_html += '			<span class="registBox33">';
				form_html += '				<input type="text" id="seat_num_'+num+'" name="seat_num_'+num+'" class="formTxt2 validate required number"><!--  --><span class="registItem">席</span>';
				form_html += '			</span>';
				form_html += '		</div>';
				form_html += '	</div>';
				form_html += '	<div class="storeEditRow">';
				form_html += '		<div class="storeEditCate">座席利用可能人数</div>';
				form_html += '		<div class="storeEditForm">';
				form_html += '			<span class="registBox33">';
				form_html += '				<input type="text" name="people_min_'+num+'" id="people_min_'+num+'" class="formTxt2 validate required number"><!--  --><span class="registItem">人～</span>';
				form_html += '			</span>';
				form_html += '			<span class="registBox33">';
				form_html += '				<input type="text" name="people_max_'+num+'" id="people_max_'+num+'" class="formTxt2 validate required number"><!--  --><span class="registItem">人</span>';
				form_html += '			</span>';
				form_html += '		</div>';
				form_html += '	</div>';
				form_html += '	<div class="storeEditRow">';
				form_html += '		<div class="storeEditCate">たばこ</div>';
				form_html += '			<div class="storeEditForm">';
				form_html += '				<span class="formRBox"><input type="radio" name="smoke_flg_'+num+'" value="0" checked>&nbsp;禁煙</span>';
				form_html += '				<span class="formRBox"><input type="radio" name="smoke_flg_'+num+'" value="1">&nbsp;喫煙</span>';
				form_html += '			</div>';
				form_html += '		</div>';
				form_html += '	<div class="storeEditRow">';
				form_html += '		<div class="storeEditCate">座席'+num+'画像</div>';
				form_html += '		<div class="storeEditForm">';
				form_html += '			<span>登録されている画像：　</span><span class="img_name_area img_name_'+num_m+'"></span>';
				form_html += '			<div id="fileArea'+num+'" class="form_btn img_btn">';
				form_html += '				<form id="upload_form'+num+'" enctype="multipart/form-data" method="post">';
				form_html += '					<input type="file" name="file'+num+'" id="file'+num+'" jq_id="'+num+'" cnt="'+num_m+'" class="form_file">';
				form_html += '					<br>';
				form_html += '					<div id="progressArea'+num+'" class="progressArea">';
				form_html += '						<progress id="progressBar'+num+'" value="0" max="100" style="width: 300px;"> </progress>';
				form_html += '						&nbsp;：';
				form_html += '						<output id="outp'+num+'">&nbsp;0</output>';
				form_html += '						%';
				form_html += '					</div>';
				form_html += '					<h4 id="status'+num+'"></h4>';
				form_html += '				</form>';
				form_html += '				<input type="hidden" name="img_'+num+'" id="img_'+num+'" value="">';
				form_html += '			</div>';
				form_html += '			<div id="img_area'+num+'"></div>';
				form_html += '		</div>';
				form_html += '	</div>';
				form_html += '	<div class="editSeatBtn">';
				form_html += '		<button type="button" class="btnBase btnBg1 btnW1 del require_text" name="del_seat_'+num+'" id="del_seat_'+num+'" value="" num="'+num+'"><span class="btnLh2"><i class="fa fa-pencil"></i> この座席を削除する</span></button>';
				form_html += '	</div>';
				form_html += '</div>';

			var conf_html  ='<input type="hidden" id="img_path'+num+'" value="store_seat/">';
				conf_html  +='<input type="hidden" id="img_length'+num+'" class="hid_img_length" value="1">';
				conf_html  +='<input type="hidden" id="img_type'+num+'"  class="hid_img_type" value="jpg,jpeg,JPG,JPEG,png,PNG,gif,GIF">';

			$('#new_form_area').append(form_html);
			$('#file_up_conf').append(conf_html);
			$('#add_form').val(parseInt(num )+ 1);
			$('.progressArea').hide();

			$.getScript('../assets/front/js/plural_file_upload.js');

			del_exection()
	}



	/**
	 * ファイル名取得処理
	 */
	function get_file_name(fd){

		//ファイル名取得
		$('input').each(function(){
			if($(this).attr('type') == 'file'){
				var cnt = $(this).attr('cnt');

				if(this.files[0] != undefined){
					fd.append('img_' + (parseInt(cnt) + 1), this.files[0].name);
				}else{
					fd.append('img_' + (parseInt(cnt) + 1), $('span.img_name_' + cnt).text());
				}
			}
		});

	}












	/**
	 * 一覧表示処理
	 */
	function list_disp_exection(data){
		// 一覧表示処理
		$('.list_disp_area').show();

		// 動的input area表示
		$('#input_area_created').html(data.input_area_created);

		// 入力非表示処理
		$('.input_disp_area').hide();

		// 初期HTMLリスト表示
		$('#list_html_area').html(data.html);

		// 初期HTMLリスト表示
		$('#admin_authority_tr').html(data.edit_menu_list_html);

	}

	/**
	 * 入力エリアundisable処理(入力画面用)
	 */
	function disp_input() {
		// テキスト入力可処理
		$(":text").removeAttr("readonly");
		$(":text").css(input_form_css);
		$(":text").removeClass('conf_color');

		// パスワード入力可処理
		$(":password").removeAttr("readonly");
		$(":password").css(input_form_css);
		$(":password").removeClass('conf_color');

		// チェックボックス入力可処理
		$("input:checkbox").attr({
			'readonly' : false
		});
		$("input:checkbox").css(input_form_css);
		$("input:checkbox").removeClass('conf_color');

		//セレクトボックス変更可
		$("select").removeAttr("readonly");
		$("select").css(input_form_css);
		$("select").removeClass('conf_color');
		$("select").removeClass('conf_select');

		//テキストエリア変更不可
		$("textarea").removeAttr("readonly");
		$("textarea").css(input_form_css);
		$("textarea").removeClass('conf_color');

		//ラジオボタン活性化
		$('input[type="radio"]').css(input_form_css);
		$('input[type="radio"]').removeAttr("readonly");
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
		$(":text").attr("readonly", "readonly");
		$(":text").css(edit_form_css);
		$(":text").addClass('conf_color');

		// パスワード入力不可処理
		$(":password").attr("readonly", "readonly");
		$(":password").css(edit_form_css);
		$(":password").addClass('conf_color');

		// チェックボックス入力不可処理
		$("input:checkbox").attr({
			'readonly' : true
		});
		$("input:checkbox").css(edit_form_css);
		$("input:checkbox").addClass('conf_color');

		//セレクトボックス変更不可
		$("select").attr("readonly", "readonly");
		$("select").css(edit_form_css);
		$("select").addClass('conf_color');
		$("select").addClass('conf_select');


		//テキストエリア変更不可
		$("textarea").attr("readonly", "readonly");
		$("textarea").css(edit_form_css);
		$("textarea").addClass('conf_color');

		//ラジオボタン非活性化
		$('input[type="radio"]').attr("readonly", "readonly");
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



