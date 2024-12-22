var ma = {
		get : function(post_data) {
			var defer = $.Deferred();
			$.ajax({
				type : 'POST',
				url : "../controller/admin/valiable_ct.php",// コントローラURLを取得
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

$(function (){
	$('.depricate_check').on('keyup, change, blur', function(){
		var $t = $(this);
		depricateCheck($t)
	});
});

function depricateCheck($elem, callback){
	var $t = $elem;
	var target = $t.attr('name');
	var table = $t.attr('tb');
	var owner = $t.attr('own');
	var val = $t.val();
	var fd = new FormData();
	fd.append("method", "depricate_check");
	fd.append("target", target);
	fd.append("table", table);
	fd.append("own", owner);
	fd.append("val", val);
	ma.get(fd).done(function(result) {
		if (result.data.status) {
			console.log(result.data.double_flg);
			if(result.data.double_flg){
				disp_error_msg($t, "このメールアドレスは登録済みです")
			}

			if(callback != undefined){
				callback();
			}
		} else if (!result.data.status && result.data.error_code == 0) {
			// PHP返却エラー
			alert(result.data.error_msg);
			location.href = result.data.return_url;
		}

	}).fail(function(result) {
		// 異常終了
		$('body').html(result.responseText);
	});
}