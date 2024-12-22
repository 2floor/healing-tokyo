$(function(){
	var ajax = {
			get : function(post_data) {
				var defer = $.Deferred();
				$.ajax({
					type : 'POST',
					url : '../cancel_ajax.php',// コントローラURLを取得
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

	$('.cancel_btn').off();
	$('.cancel_btn').on('click', function(){
		if (confirm('予約をキャンセルします。\r\n元に戻すことはできませんがよろしいですか？') == true) {
			var tar = $(this);
			var reservation_id = $(this).attr('rid');
			var store_basic_id = $(this).attr('sid');
			var member_id = $(this).attr('mid');

			var fd = new FormData();
			fd.append('action', 'cancel_offer');
			fd.append('reservation_id', reservation_id );
			fd.append('store_basic_id', store_basic_id );
			fd.append('member_id', member_id );

			ajax.get(fd).done(function(result) {

				if (result.data.status) {
					alert('申請が完了しました')
					tar.remove();
					$('.cansel_str_area' + reservation_id).append('<br><span style="color:red;">キャンセル申請中</span>')
				} else {
					alert(result.data.error_msg);
				}
			}).fail(function(result) {
				// 異常終了
				$('body').html(result.responseText);
			});
		}
	});


});