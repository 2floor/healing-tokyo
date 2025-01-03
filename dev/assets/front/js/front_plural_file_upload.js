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
var PLURAL_FILE_MAX_SIZE = 1000000;

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

		var prog_file = "file" + target_no;
		var file = _(prog_file).files[0];


		$('#hid_img_name' + target_no).val(file.name)

//		//プログレスバー表示
//		$('#progressArea' + target_no).show();
//
//		imgSize = 0;
//		var prog_progressBar = "progressBar" + target_no;
//		var prog_outp = "outp" + target_no;
//
//		 _(prog_progressBar).value = 0;
//		 _(prog_outp).innerHTML = 0;

		//ファイル入力チェック
		if(chk_file_validate(file, PLURAL_IMG_TYPE_ARRAY, PLURAL_FILE_MAX_SIZE, $('#img_length' + target_no).val(), target_no)){
			var formdata = new FormData();

			formdata.append("file" + target_no, file);
			formdata.append("method", 'front_plural_img_upload');
			formdata.append("path", $('#img_path' + target_no).val());
			formdata.append("file_no", target_no);

			var ajax = new XMLHttpRequest();
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
//
//	//拡張子チェック
//	if ($.inArray(file_type, file_type_array) == -1 && file_type != ""){
//		alert("対応しているファイル拡張子は、"+file_type_array.join(', ')+"形式です。");
//		return false;
//	}


//	alert(file.size)
	//容量チェック
	if (file.size > size) {
		alert("アップロードできるファイル容量は1ファイル"+getFiseSize(size)+"までです。");

		//エラーの場合自身を書き換え
		var bak_html = $('#file_area_' + target_no).html();
		$('#file_area_' + target_no).html(bak_html);

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
//	 _("progressBar" + target_no).value = 100;
//	 _("outp" + target_no).innerHTML = 100;

	 console.log(event.target.response)

}

function errorHandler(event){
//	 _("status").innerHTML = "Upload Failed";
}

function abortHandler(event){
//	 _("status").innerHTML = "Upload Aborted";
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

	var date = new Date();
	var uniq_id = date.getHours() +""+ date.getMinutes() +""+ date.getSeconds() +""+ date.getMilliseconds();
	var img_path_array = img_full_path.split("/");
	var file_name = img_path_array[img_path_array.length-1]

	img_prev_html = '<div class="unit_prev_img unit_prev_img'+file_no+'" id="unit_prev_img_'+uniq_id+'" style="width:300px;">';
	img_prev_html += '<p><img src="'+img_full_path+'" class="prev_img" align="middle"></p>';
	img_prev_html += '<p class="font_bold">File Name<br><span class="font_normal file_name_area" file_no="'+file_no+'" file_name="'+file_name+'">'+file_name+'<br><br></span>';
	img_prev_html += '<br><span class="font_normal">&nbsp;</span></p>';

	img_prev_html += '<img src="../assets/admin/img/icon/del_off.png" class="del_img"></div><br>';

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
	});
}