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
	$('.depricate_check').off('.depricateCheck').on('change.depricateCheck', function(){
		var $t = $(this);
		depricateCheck($t)
	});
});

var depricateCheck = function ($elem, callback){
	var $t = $elem;

	$t.siblings(".error").remove();

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
				if($('[name=eng_flg]').val() == 'on'){
					$t.after("<span class='error'><label style='color:red;'>This Email already registered.</label></span>");
				}else{
					$t.after("<span class='error'><label style='color:red;'>このメールアドレスは登録済みです</label></span>");
				}
				$('html, body').scrollTop($('.error').offset().top);
			}

			if(callback != undefined){
				callback(result.data.double_flg);
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