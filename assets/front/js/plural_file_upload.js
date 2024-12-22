/**
 * 管理画面用
 * 画像即時アップロード、サムネイル表示処理(複数フォーム対応)
 *
 * フロントにidがimg_path、img_length、img_typeに1から始まる連番を
 * 付与したパラメータをフロントに設定すること
 *
 * @author Second floor t.seidou
 */
var imgSize = "";
var file_type = "";
//拡張性制限
var PLURAL_IMG_TYPE_ARRAY = ["xls","xlsx","txt","doc","docx","pdf","jpg","JPG","jpeg","JPEG","gif","GIF","png","PNG","ppt","pptx"];

//ファイルアップロード制限(byte)
var PLURAL_FILE_MAX_SIZE = 20000000;

//フィルアップロード最大数
var PLURAL_FILE_MAX_CNT = 999999;

var target_no = 1;

function _(el){
	 return document.getElementById(el);
}

$(function() {

	//プログレスバーを全て非表示
	$('.progressArea').hide();

	//フォームボタン表示
	$('.img_btn').show();

	var imgName = "";
	$('input[type=file]').off();
	$('input[type=file]').bind('change', function() {
		//対象ファイル識別ID取得
		target_no = $(this).attr('jq_id');

		//対象ファイル最大枚数更新
		PLURAL_FILE_MAX_CNT = $('#img_length' + target_no).val();

		//対象ファイルアップ可能拡張子更新
		PLURAL_IMG_TYPE_ARRAY = $('#img_type' + target_no).val();

		if ( $('#img_type' + target_no).val().indexOf(',') != -1) {
			//カンマを含む場合のみ
			var resArray = $('#img_type' + target_no).val().split(",");
			PLURAL_IMG_TYPE_ARRAY = resArray;
		} else {
			PLURAL_IMG_TYPE_ARRAY = [$('#img_type' + target_no).val()];
		}


//		console.log(PLURAL_IMG_TYPE_ARRAY)

//		//プログレスバー表示
//		$('#progressArea' + target_no).show();

		imgSize = 0;
		var prog_file = "file" + target_no;
		var prog_progressBar = "progressBar" + target_no;
		var prog_outp = "outp" + target_no;

		var file = _(prog_file).files[0];
		 _(prog_progressBar).value = 0;
		 _(prog_outp).innerHTML = 0;

		//ファイル入力チェック
		if(chk_file_validate(file, PLURAL_IMG_TYPE_ARRAY, PLURAL_FILE_MAX_SIZE, $('#img_length' + target_no).val(), target_no)){
			var formdata = new FormData();

			formdata.append("file" + target_no, file);
			formdata.append("method", 'plural_img_upload');
			formdata.append("path", $('#img_path' + target_no).val());
			formdata.append("file_no", target_no);
			//追加(k.kawahata)
			formdata.append("base_dir", $('#base_dir').val());
			formdata.append("tmp_dir", $('#tmp_dir').val());
			formdata.append("edit_flg", $('#edit_flg').val());
			formdata.append("personal_dir", $('#personal_dir').val());

			var ajax = new XMLHttpRequest();
//			ajax.upload.addEventListener("progress", progressHandler, false);
			ajax.addEventListener("load", completeHandler, false);
			ajax.addEventListener("error", errorHandler, false);
			ajax.addEventListener("abort", abortHandler, false);
			ajax.open("POST", $('#common_ct_url').val());
			ajax.send(formdata);
		}
	});
});

function chk_file_validate(file, file_type_array, size, file_max_cnt, target_no){

	//拡張子取得
	var file_split_list = file.name.split(".");
	file_type = file_split_list.pop();

	//拡張子チェック
	if ($.inArray(file_type, file_type_array) == -1 && file_type != ""){
		alert("対応しているファイル拡張子は、"+file_type_array.join(', ')+"形式です。");
		return false;
	}

	//容量チェック
	if (file.size > size) {
		alert("アップロードできるファイル容量は1ファイル"+getFiseSize(size)+"までです。");
		return false;
	}

//	//登録画像枚数チェック
//	if($('.unit_prev_img' + target_no).length >= file_max_cnt){
//		alert("アップロードできるファイル数は"+file_max_cnt+"ファイルまでです。");
//		return false;
//	}

	return true;
}


function progressHandler(event){
	 imgSize = getFiseSize(event.total);
	 var percent = (event.loaded / event.total) * 100;
	 _("progressBar" + target_no).value = Math.round(percent);
	 _("status" + target_no).innerHTML = "uploaded "+getFiseSize(event.loaded)+" / "+getFiseSize(event.total);
	 _("outp" + target_no).innerHTML = Math.round(percent);

}



function completeHandler(event){
	 _("progressBar" + target_no).value = 100;
	 _("outp" + target_no).innerHTML = 100;

//	 console.log(event.target.response)

	 //画像プレビュー処理
	var img_datas = $.parseJSON(event.target.response);//Json形式にパース
	var date = new Date();
	var uniq_id = date.getHours() +""+ date.getMinutes() +""+ date.getSeconds() +""+ date.getMilliseconds();
	var img_prev_html = "";
	var file_path = img_datas.data['full_path'].replace('../', '');
	var file_no = img_datas.data['file_no'];

	if ($.inArray(file_type, PLURAL_IMG_TYPE_ARRAY) != -1){

		//uq_num追加(k.kawahata)
		img_prev_html = '<div class="storeEditImg2 unit_prev_img unit_prev_img'+file_no+'" id="unit_prev_img_'+uniq_id+'"  uq_num="'+file_path.split('/')[5]+uniq_id+'">';
		img_prev_html += '<div><img src="'+file_path+'" class="prev_img" align="middle" file_no="'+file_no+'" file_name="'+img_datas.data['file_name']+'"></div>';
//		img_prev_html += '<p class="font_bold">File Name<br><span class="font_normal file_name_area" file_no="'+file_no+'" file_name="'+img_datas.data['file_name']+'">'+img_datas.data['file_name']+'<br><br></span>';
//		img_prev_html += 'File Size<br><span class="font_normal">'+imgSize+'</span></p>';
//		img_prev_html += '<img src="../assets/admin/img/icon/del_off.png" class="del_img">';
		//↑最後の</div><br>削除(k.kawahata)

	} else if (file_type == "pdf") {
		img_prev_html = '<div class="unit_prev_img unit_prev_img'+file_no+'" id="unit_prev_img_'+uniq_id+'"><p><object class="prev_img" height="auto" data="' + file_path + '" align="middle"></object></p><p class="font_bold">File Name<br><span class="font_normal file_name_area">'+img_datas.data['file_name']+'<br><br></span>File Size<br><span class="font_normal">'+imgSize+'</span></p><img src="../assets/admin/img/icon/del_off.png" class="del_img form_area"></div><br>';
	}

	var dir_name = file_path.split('/')[4];
//	if(dir_name == 'store_detail_img'){
//		//画像コメント(store_detail_img)(k.kawahata)
//		img_prev_html += '<textarea id="'+ file_path.split('/')[5] + uniq_id +'" tar="'+ file_path.split('/')[5] + '" class="form-control input_form validate required store_detail_comment" style="width: 280px; height: 100px" rows="200" cols="280" placeholder="※この画像のコメント"></textarea><br />';
//	}else if(dir_name == 'reason_why'){
//		//画像コメント(k.kawahata)
//		img_prev_html += '<input type="text" id="'+ file_path.split('/')[5]+'_title' + uniq_id +'" value="" class="form-control input_form validate required reason_why_comment" tar="'+ file_path.split('/')[5] + '_title' + '" style="width: 280px;" autocomplete="off" placeholder="※この画像のタイトル"><br />';
//		img_prev_html += '<textarea id="'+ file_path.split('/')[5] + uniq_id +'_title" tar="'+ file_path.split('/')[5] + '_title' + '" class="form-control input_form validate required reason_why_comment" style="width: 280px; height: 100px" rows="200" cols="280" placeholder="現在の猫ちゃんの健康状態について記入してください。例）良好　エイズ、白血病検査共に陰性、内外駆虫済み等"></textarea><br />';
//		img_prev_html += '<textarea id="'+ file_path.split('/')[5] + uniq_id +'_detail" tar="'+ file_path.split('/')[5] + '_detail' + '" class="form-control input_form validate required reason_why_comment" style="width: 280px; height: 100px" rows="200" cols="280" placeholder="※この画像のコメント"></textarea><br />';

//	}
	img_prev_html +='</div>'
//		console.log(img_prev_html);

	if (location.href.indexOf('edit_reason.php') != -1 || location.href.indexOf('edit_seat.php') != -1 || location.href.indexOf('edit_appearance.php') != -1 || location.href.indexOf('edit_inview.php') != -1 || location.href.indexOf('edit_staff.php') != -1 || location.href.indexOf('edit_cuisine.php') != -1) {
		$('#img_area' + target_no).append(img_prev_html);
	}


	//tmp_dir追加(k.kawahata)
	$('#tmp_dir').val(img_datas.data['tmp_dir'])

	//削除アイコン変更処理
	$('.del_img').hover(function(){
		$(this).attr("src","../assets/admin/img/icon/del_on.png");
	},function(){
		$(this).attr("src","../assets/admin/img/icon/del_off.png");
	});

	//削除処理
	$('.del_img').on("click", function(){

		//コメント入力エリア消去(k.kawahata)
		var uq_num = $(this).closest("div").attr("uq_num");
		$("#"+ uq_num ).remove();

		$("#"+$(this).closest("div").attr("id")).remove();
	});
}

function errorHandler(event){
	 _("status").innerHTML = "Upload Failed";
}

function abortHandler(event){
	 _("status").innerHTML = "Upload Aborted";
}

/**
 * ファイルサイズの単位
 * @param {int} file_size
 * @return {string}
 */
function getFiseSize(file_size)
{
  var str;

  // 単位
  var unit = ['byte', 'KB', 'MB', 'GB', 'TB'];

  for (var i = 0; i < unit.length; i++) {
    if (file_size < 1024 || i == unit.length - 1) {
      if (i == 0) {
        // カンマ付与
        var integer = file_size.toString().replace(/([0-9]{1,3})(?=(?:[0-9]{3})+$)/g, '$1,');
        str = integer +  unit[ i ];
      } else {
        // 小数点第2位は切り捨て
        file_size = Math.floor(file_size * 100) / 100;
        // 整数と小数に分割
        var num = file_size.toString().split('.');
        // カンマ付与
        var integer = num[0].replace(/([0-9]{1,3})(?=(?:[0-9]{3})+$)/g, '$1,');
        if (num[1]) {
          file_size = integer + '.' + num[1];
        }
        str = file_size +  unit[ i ];
      }
      break;
    }
    file_size = file_size / 1024;
  }

  return str;
}


/**
 * 編集初期処理用画像設定処理
 * 1つの項目に複数画像設定されている場合はループ処理にて呼び出すこと
 *
 * @param img_full_path ファイル名を含めた相対パス
 * @param file_no ファイルアップボタンの上から数えた1から始まる連番
 */
function set_img_area(img_full_path, file_no){
	console.log(img_full_path)

	var date = new Date();
	var uniq_id = date.getHours() +""+ date.getMinutes() +""+ date.getSeconds() +""+ date.getMilliseconds();
	var img_path_array = img_full_path.split("/");
	var file_name = img_path_array[img_path_array.length-1]

	var img_prev_html = '<div class="unit_prev_img unit_prev_img'+file_no+'" id="unit_prev_img_'+uniq_id+'" style="width:300px;  display: inline-block; margin-right: 20px;" uq_num="'+img_full_path.split('/')[5]+uniq_id+'">';
	img_prev_html += '<p><img src="'+img_full_path+'" class="prev_img" align="middle"></p>';
	img_prev_html += '<p class="font_bold">File Name<br><span class="font_normal file_name_area" file_no="'+file_no+'" file_name="'+file_name+'">'+file_name+'<br><br></span>';
	img_prev_html += '<br><span class="font_normal">&nbsp;</span></p>';

	img_prev_html += '<img src="../assets/admin/img/icon/del_off.png" class="del_img">';

	var dir_name = img_full_path.split('/')[4];
	if(dir_name == 'store_detail_img'){
		//画像コメント(store_detail_img)(k.kawahata)
		img_prev_html += '<textarea id="'+ img_full_path.split('/')[5] + uniq_id +'" tar="'+ img_full_path.split('/')[5] + '" class="form-control input_form validate required store_detail_comment '+ img_full_path.split('/')[5] +'_com" style="width: 280px; height: 100px" rows="200" cols="280" placeholder="現在の猫ちゃんの健康状態について記入してください。例）良好　エイズ、白血病検査共に陰性、内外駆虫済み等"></textarea><br />';
	}else if(dir_name == 'reason_why'){
		//画像コメント(k.kawahata)
		img_prev_html += '<input type="text" id="'+ img_full_path.split('/')[5]+'_title' + uniq_id +'" value="" class="form-control input_form validate required reason_why_comment r_img_title" tar="'+ img_full_path.split('/')[5] + '_title' + '" style="width: 280px;" autocomplete="off" placeholder="※この画像のタイトル"><br />';
		img_prev_html += '<textarea id="'+ img_full_path.split('/')[5] + uniq_id +'_detail" tar="'+ img_full_path.split('/')[5] + '_detail' + '" class="form-control input_form validate required reason_why_comment  r_img_detail" style="width: 280px; height: 100px" rows="200" cols="280" placeholder="現在の猫ちゃんの健康状態について記入してください。例）良好　エイズ、白血病検査共に陰性、内外駆虫済み等"></textarea><br />';

	}
	img_prev_html +='</div>'

	$('#img_area' + file_no).append(img_prev_html);

	//削除アイコン変更処理
	$('.del_img').hover(function(){
		$(this).attr("src","../assets/admin/img/icon/del_on.png");
	},function(){
		$(this).attr("src","../assets/admin/img/icon/del_off.png");
	});

	//削除処理
	$('.del_img').on("click", function(){
		$("#"+$(this).closest("div").attr("id")).remove();

		//コメント入力エリア消去(k.kawahata)
		var uq_num = $(this).closest("div").attr("uq_num");
		$("#"+ uq_num ).remove();

	});
}