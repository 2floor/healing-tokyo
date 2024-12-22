
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

//座席選択html
var select_seat_html ='';

////パラメータ取得
//var query = getUrlVars();
//var store_id = query['id'];


var etc1 = '';
var etc2 = '';

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

		var fd = new FormData();

		//チェックボックス複数名取得処理
		var checkbox_value = get_checkbox_value();

		get_file_name(fd);

		fd.append('method', method);
		fd.append('edit_del_id', $('#id').val());
		fd.append('title', $('[name=title]').val());
		fd.append('detail', $('[name=detail]').val());
		fd.append('only_women', $('[name=only_women]:checked').val());
		fd.append('charge', $('[name=charge]').val());
		fd.append('plan_contents', checkbox_value.plan_contents);
		fd.append('menu', $('[name=menu]').val());
		fd.append('drink', $('[name=drink]').val());
		fd.append('limit_time', $('[name=limit_time]').val());
		fd.append('benefits', $('[name=benefits]').val());
		fd.append('payment_way', $('[name=payment_way]').val());
		fd.append('notes', $('[name=notes]').val());
//		fd.append('seat_discrimination', $('[name=seat_discrimination]:checked').val());
		fd.append('available_num', $('[name=available_num]').val());
		fd.append('disp_people_num', $('[name=disp_people_num]').val());
		fd.append('day_night_flg', $('[name=day_night_flg]').val());
		fd.append('store_basic_id', $('[name=store_basic_id]').val());

		fd.append('etc1', etc1);
		fd.append('etc2', etc2);
		fd.append('noon_night_flg', $('[name=noon_night_flg]:checked').val());
		fd.append('special_flg', $('[name=special_flg]:checked').val());
		fd.append('etc4', $('[name=etc4]:checked').val());
		fd.append('etc5', checkbox_value.etc5);

		fd.append('tmp_dir', $('#tmp_dir').val());
		fd.append('img_path1', $('#img_path1').val());

		//対象フォーム設定
		var $form = $('#' + from_id);

		//フォームの値を&区切りの文字列で取得
		var query = $form.serialize();

		//フォームの値をObjectで取得
		var param = $form.serializeArray();

		//フォームの値を取得FormDataに設定
		$($form.serializeArray()).each(function(i, v) {
			var $type = $('[name='+v.name+']').attr('type');
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
		});

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
//				$('#conf_text').html('以下の項目はすべて<span class="registTit2">※必須項目</span>です。');
				$('#conf').show();
				$('#return, #submit').hide();
			}else if(name == 'submit'){
				disp_input();
				if($('#edit_flg').val() == 0){
					//plan_regist.phpより
					entry_exection();
					$('#conf').hide();
					$('#return, #submit').show();
				}else{
					//plan_edit.phpより
					edit_exection();
					$('#conf').hide();
					$('#return, #submit').show();
				}
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
		var form_datas = get_form_prams('init_store_plan', null);

		// 初期処理AJAX呼び出し処理
		call_ajax_detail_init(form_datas, true);

	}

	/**
	 * 時間入力処理
	 */
	function time_picker(){
		var target = '[name=start_time_hour], [name=start_time_min], [name=lo_time_hour], [name=lo_time_min], [name=start_time_dinner_hour], [name=start_time_dinner_min], [name=lo_time_dinner_hour], [name=lo_time_dinner_min]'

		$(target).off();
		$(target).on('change', function(){
			var tar = $(this).attr('tar');
			var hour = $('[name=' + tar.substr(0, (tar.length - 2)) + '_hour][tar="'+tar+'"]').val();
			var min = $('[name=' + tar.substr(0, (tar.length - 2)) + '_min][tar="'+tar+'"]').val();
			$('#' + tar).val(hour + ':' + min);
		});
	}

	/**
	 * 初期処理AJAX
	 */
	function call_ajax_detail_init(post_data, flg){
		ajax.get(post_data).done(function(result) {
			// 正常終了
			console.log(result.data);
			if (result.data.status) {

				$('#plan_type_html').html(result.data.plan_type_html);
				$('#select_seat_html').html(result.data.select_seat_html);
				select_seat_html = result.data.select_seat_html;

				//一覧表示処理呼び出し
				list_disp_exection(result.data);
				$('#personal_dir').val('store_id' + result.data.store_basic_id );
				$('.del').hide();

				//編集時
				if($('#edit_flg').val() == 1){
					$('#title').val(result.data.plan_data.title);
					$('#detail').val(result.data.plan_data.detail);
					$('span.img_name_0').text(result.data.plan_data.img);
					$('[name=only_women]').val([result.data.plan_data.only_women]);
					$('#charge').val(result.data.plan_data.charge);
					$('#plan_type_id').val(result.data.plan_data.plan_type_id);
					var plan_contents = result.data.plan_data.plan_contents.split(',');
					$('[name=plan_contents]').val(plan_contents);
					$('#menu').val(result.data.plan_data.menu);
					$('#drink').val(result.data.plan_data.drink);
					$('#limit_time').val(result.data.plan_data.limit_time);
					$('#benefits').val(result.data.plan_data.benefits);
					$('#payment_way').val(result.data.plan_data.payment_way);
					$('#notes').val(result.data.plan_data.notes);
					$('#disp_people_num').val(result.data.plan_data.disp_people_num);
//					$('[name=seat_discrimination]').val([result.data.plan_data.seat_discrimination]);
					$('#available_num').val(result.data.plan_data.available_num);
					$('#store_basic_id').val(result.data.plan_data.store_basic_id);
					$('#store_name').val(result.data.plan_data.store_basic_id);
					$('#day_night_flg').val(result.data.day_night_flg);
					etc1 = result.data.plan_data.etc1
					etc2 = result.data.plan_data.etc2

					$('[name=special_flg]').val([result.data.plan_data.etc3]);
					$('[name=etc4]').val([result.data.plan_data.etc4]);
					$('[name=etc5]').val(result.data.plan_data.etc5.split(','));

					if(result.data.day_night_flg == 0){
						$('#img_path1').val('plan_img/lunch/');
					}else if(result.data.day_night_flg == 1){
						$('#img_path1').val('plan_img/dinner/');
					}else if(result.data.day_night_flg == 2){
						$('#img_path1').val('plan_img/bar/');
					}else if(result.data.day_night_flg == 3){
						$('#img_path1').val('plan_img/club/');
					}

					$.each(result.data.seat_plan_relation_data, function(i){
						if(i > 0){
							add_form(parseInt(i) + 1);
						}
					});

					$.each(result.data.seat_plan_relation_data, function(i){

						var cnt = parseInt(i) + 1;
						var seat_data = result.data.seat_plan_relation_data[i];

						$('[name=seat_plan_relation_id_' + cnt +']').val(seat_data.seat_plan_relation_id);
						$('#available_num_' + cnt).val(seat_data.available_num);
						$('#store_seat_id_' + cnt).val(seat_data.store_seat_id);
						$('#start_time_' + cnt).val(seat_data.start_time);
						$('#lo_time_' + cnt).val(seat_data.end_time);
						$('[name=seat_discrimination_' + cnt + ']').val([seat_data.seat_discrimination]);
						$('#del_seat_plan_' + cnt).val(seat_data.seat_plan_relation_id);
						$('#del_seat_plan_' + cnt).attr('title', seat_data.seat_title);

						//時刻系処理
						var start_time = seat_data.start_time.split(':');
						var lo_time = seat_data.end_time.split(':');

						if( (lo_time[0] != '00' || lo_time[1] != '00')/* || (lo_time_dinner[0] != '00' || lo_time_dinner[1] != '00')*/ ){
							$('.business_time_text').show();
							$('.business_time_area').show();
							$('[name=lunch_flg]').prop('checked', true);
						}

						$('[name=start_time_hour][tar="start_time_' + cnt+'"]').val(start_time[0]);
						$('[name=start_time_min][tar="start_time_' + cnt+'"]').val(start_time[1]);
						$('#start_time_' + cnt).val(seat_data.start_time);
						$('[name=lo_time_hour][tar="lo_time_' + cnt+'"]').val(lo_time[0]);
						$('[name=lo_time_min][tar="lo_time_' + cnt+'"]').val(lo_time[1]);
						$('#lo_time_' + cnt).val(seat_data.end_time);

					});

				}

				//表示系処理
				check_disp_change();

				//時刻系処理
				time_picker();

				change_disp_scene(result.data.day_night_flg)
				$('#day_night_flg').off();
				$('#day_night_flg').on('change', function(){
					change_disp_scene();
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
	 * 会員情報新規登録処理
	 */
	function entry_exection(){
		//method定義
		var entry_datas = get_form_prams('create_store_plan', 'frm');
		//ajax呼び出し
		call_ajax_change_state(entry_datas);
	}


	/**
	 * 会員情報更新処理
	 */
	function edit_exection(){
		//method定義
		var entry_datas = get_form_prams('edit_store_plan', 'frm');
		//ajax呼び出し
		call_ajax_change_state(entry_datas);
	}

	/**
	 * 削除処理
	 */
	function del_exection(){
		$('.del').off();
		$('.del').on('click',function(){
			var id = $(this).val();
			ret = confirm("この座席との関連を削除します。よろしいですか？");
				if (ret == true){

					if(id != null && id != '' ){
						// 呼び出し前method定義
						var form_data = get_form_prams('delete_seat_plan_relation', null);
						form_data.append('id', id);
						$('.seat_input_area_' + $(this).attr('num')).remove();

						// ajax呼び出し
						call_ajax_change_state(form_data, true);
					}else{
						$('.seat_input_area_' + $(this).attr('num')).remove();
					}

					if($('.del').length == 1){
						$('.del').hide();
					}
				}
		});
	}

	/**
	 * 状態編集更新処理AJAX 更新、登録、削除、公開
	 */
	function call_ajax_change_state (post_data, flg){
		ajax.get(post_data).done(function(result) {
			// 正常終了
			if (result.data.status) {
				// 完了時表示メッセージ
				alert(result.data.msg);
				// ページ再読み込み
				if( flg == undefined || flg === false){
					location.replace('./');
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
	 * 各種表示系処理
	 */
	function check_disp_change(){

		$('#add_form').off();
		$('#add_form').on('click', function(){
			add_form($(this).val());
		});


	}

	/**
	 * シーン処理
	 */
	function change_disp_scene(disp){
		var day_night_flg = $('#day_night_flg').val();
		if(disp != undefined  && disp != null && disp != ''){
			day_night_flg = disp;
		}
		$('.scene_chkbox').each( function(i, elem){
			var etc1 = $(elem).attr('etc1');
			var etc1_arr = new Array();
			if(etc1.match(/,/g)){
				etc1_arr = etc1.split(',');
			}else{
				etc1_arr[0] = etc1;
			}

			if(etc1_arr.indexOf(day_night_flg) >= 0){
				$(elem).show();
			}else{
				$(elem).hide();
			}
		});


	}




	function add_form(num){
			var num_m = num -1;

			var form_html  = '<div class="seat_input_area_'+num+'">';
				form_html += '<div class="storeEditRow seat_input_num_'+num+'">';
				form_html += '	<input type="hidden" name="seat_plan_relation_id_'+num+'" class="seat_plan_relation_id_'+num+'" value="">';
				form_html += select_seat_html;
				form_html += '</div>';
				form_html += '<div class="storeEditRow">';
				form_html += '	<div class="storeEditCate">予約タイプ</div>';
				form_html += '	<div class="storeEditForm">';
				form_html += '		<span class="formRBox"><input type="radio" class="" name="seat_discrimination_'+num+'" value="0" checked="checked">卓（部屋）数で予約を取る</span>';
				form_html += '		<span class="formRBox"><input type="radio" class="" name="seat_discrimination_'+num+'" value="1">人数で予約を取る</span>';
				form_html += '	</div>';
				form_html += '</div>';
				form_html += '<div class="storeEditRow">';
				form_html += '	<div class="storeEditCate">予約可能人数（卓数）</div>';
				form_html += '	<div class="storeEditForm">';
				form_html += '	<input type="text" name="available_num_'+num+'" id="available_num_'+num+'" class="formTxt1 validate required number">';
				form_html += '	</div>';
				form_html += '</div>';
				form_html += '<div class="storeEditRow">';
				form_html += '	<div class="storeEditCate">利用可能時刻</div>';
				form_html += '	<div class="storeEditForm">';
				form_html += '	<input type="hidden" id="start_time_'+num+'" name="start_time_'+num+'" value="00:00" class="form-control input_form validate required" style="width: 400px;" autocomplete="off">';
				form_html += '		<select id="start_time_hour" name="start_time_hour" tar="start_time_'+num+'" class="" style="display: inline-block; width: 65px;">';
				form_html += '			<option value="00" selected>00</option>';
				form_html += '			<option value="01">01</option>';
				form_html += '			<option value="02">02</option>';
				form_html += '			<option value="03">03</option>';
				form_html += '			<option value="04">04</option>';
				form_html += '			<option value="05">05</option>';
				form_html += '			<option value="06">06</option>';
				form_html += '			<option value="07">07</option>';
				form_html += '			<option value="08">08</option>';
				form_html += '			<option value="09">09</option>';
				form_html += '			<option value="10">10</option>';
				form_html += '			<option value="11">11</option>';
				form_html += '			<option value="12">12</option>';
				form_html += '			<option value="13">13</option>';
				form_html += '			<option value="14">14</option>';
				form_html += '			<option value="15">15</option>';
				form_html += '			<option value="16">16</option>';
				form_html += '			<option value="17">17</option>';
				form_html += '			<option value="18">18</option>';
				form_html += '			<option value="19">19</option>';
				form_html += '			<option value="20">20</option>';
				form_html += '			<option value="21">21</option>';
				form_html += '			<option value="22">22</option>';
				form_html += '			<option value="23">23</option>';
				form_html += '		</select>時';
				form_html += '		<select id="start_time_min" name="start_time_min" tar="start_time_'+num+'" class="form-control input_form" style="display: inline-block; width: 65px;">';
				form_html += '			<option value="00">00</option>';
				form_html += '			<option value="15">15</option>';
				form_html += '			<option value="30">30</option>';
				form_html += '			<option value="45">45</option>';
				form_html += '		</select>分&nbsp;～&nbsp;';
				form_html += '		<input type="hidden" id="lo_time_'+num+'" name="lo_time_'+num+'" value="00:00" class="validate required" style="width: 400px;" autocomplete="off">';
				form_html += '		<select id="lo_time_hour" name="lo_time_hour" tar="lo_time_'+num+'" class="form-control input_form" style="display: inline-block; width: 65px;">';
				form_html += '			<option value="00" selected>00</option>';
				form_html += '			<option value="01">01</option>';
				form_html += '			<option value="02">02</option>';
				form_html += '			<option value="03">03</option>';
				form_html += '			<option value="04">04</option>';
				form_html += '			<option value="05">05</option>';
				form_html += '			<option value="06">06</option>';
				form_html += '			<option value="07">07</option>';
				form_html += '			<option value="08">08</option>';
				form_html += '			<option value="09">09</option>';
				form_html += '			<option value="10">10</option>';
				form_html += '			<option value="11">11</option>';
				form_html += '			<option value="12">12</option>';
				form_html += '			<option value="13">13</option>';
				form_html += '			<option value="14">14</option>';
				form_html += '			<option value="15">15</option>';
				form_html += '			<option value="16">16</option>';
				form_html += '			<option value="17">17</option>';
				form_html += '			<option value="18">18</option>';
				form_html += '			<option value="19">19</option>';
				form_html += '			<option value="20">20</option>';
				form_html += '			<option value="21">21</option>';
				form_html += '			<option value="22">22</option>';
				form_html += '			<option value="23">23</option>';
				form_html += '		</select>時';
				form_html += '		<select id="lo_time_min" name="lo_time_min" tar="lo_time_'+num+'" class="form-control input_form" style="display: inline-block; width: 65px;">';
				form_html += '			<option value="00">00</option>';
				form_html += '			<option value="15">15</option>';
				form_html += '			<option value="30">30</option>';
				form_html += '			<option value="45">45</option>';
				form_html += '		</select>分';
				form_html += '	</div>';
				form_html += '</div>';
				form_html += '<div class="editSeatBtn">';
				form_html += '	<button type="button" class="btnBase btnBg1 btnW1 del require_text" name="del_seat_plan_'+num+'" id="del_seat_plan_'+num+'" num="'+num+'" value="" title=""><span class="btnLh2"><i class="fa fa-pencil"></i> この座席を削除する</span></button>';
				form_html += '</div>';
				form_html += '</div>';


			$('#new_form_area').append(form_html);
			$('#add_form').val(parseInt(num )+ 1);
			$('.progressArea').hide();
			$('.seat_input_num_'+num+' #store_seat_id_1').attr({
				'id': 'store_seat_id_'+num,
				'name': 'store_seat_id_'+num
			});


			time_picker();

			//削除処理
			del_exection();

			$('.del').show();
			$.getScript('../assets/front/js/plural_file_upload.js');
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
					fd.append('img', this.files[0].name);
				}else{
					fd.append('img', $('span.img_name_' + cnt).text());
				}
			}
		});

	}


	/**
	 * チェックボックス複数名取得処理
	 */
	function get_checkbox_value(){
		var checkbox_array = {
				'plan_contents':'',
				'etc5':'',
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
		var return_array;
		return return_array = {
				'plan_contents': checkbox_array.plan_contents,
				'etc5': checkbox_array.etc5,
		}
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
		$("textarea").removeAttr("readonly");
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
		$(":text").attr("readonly", "readonly");
		$(":text").css(edit_form_css);
		$(":text").addClass('conf_color');

		// パスワード入力不可処理
		$(":password").attr("readonly", "readonly");
		$(":password").css(edit_form_css);
		$(":password").addClass('conf_color');

		// チェックボックス入力不可処理
		$("input:checkbox").attr({
			'disabled' : 'disabled'
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



