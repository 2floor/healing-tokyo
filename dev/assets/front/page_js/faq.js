$(function(){

	//指定件数表示
	var show_num = 5;
	$('.q_parent').hide();
	for (var i = 0; i < show_num; i++) {
		$('.q_parent').eq(i).show();
	}

	personal_disp();

	$('[name=search_start]').off();
	$('[name=search_start]').on('click', function(){
		all_off();
		var keyword = $('[name=keyword]').val();
		if(keyword){
			var flg = false;
			$('.q_parent').hide().each(function(i, elem){
				var text1 = $(elem).find('.search_text_a').text();
				if(text1.match(keyword)){
					$(elem).show();
					flg=true;
				}

				var text2 = $(elem).find('.search_text_q').text();
				if(text2.match(keyword)){
					$(elem).show();
					flg=true;
				}

			});
			if(!flg){
				alert('検索したキーワードでは見つかりませんでした');
				$('.q_parent').show();
			}else{
				$('html, body').animate({scrollTop: $('.ttl_top').offset().top + 300});
			}
		}else{
			alert('項目が空です');
		}
	});

	$('[name=cat_btn]').off();
	$('[name=cat_btn]').on('click', function(){
		all_off();
		var cat = $(this).val();
		if(cat == 0){
			$('.q_parent').show();
		}else{
			$('.q_parent').hide().each(function(i, elem){
				if($(elem).attr('cat') == cat){
					$(elem).show();
				}
			});
		}
		$('html, body').animate({scrollTop: $('.ttl_top').offset().top + 300});
		personal_disp();
	});

	$('.disp_all').off();
	$('.disp_all').on('click', function(){
		all_off();
		$('html, body').animate({scrollTop: $('.ttl_top').offset().top + 300});
		$('.q_parent').show();
		personal_disp();
	});
//
//	$('.etc1_check').off();
//	$('.etc1_check').on('click', function(){
//		var etc1 = $(this).attr('etc1');
//		var etc1_array = [etc1];
//		if(etc1.match(/,/g)){
//			etc1_array = etc1.split(',');
//		}
//		$('.q_parent').hide();
//		$.each(etc1_array, function(k, v){
//			$('.q_parent[faq_id="'+v+'"]').show();
//		});
//		personal_disp();
//		$('html, body').animate({scrollTop: $('.ttl_top').offset().top + 300});
//	});

	function personal_disp(){
		$('.faq_in').off();
		$('.faq_in').on('click', function(){
			var tar_id = $(this).attr('tar_id');
			all_off();
			$('.q_parent').hide();
			var jq_num = $('.q_parent[faq_id="'+tar_id+'"]').attr('jq_num');
			$("#ac-"+jq_num).prop('checked', true)
			$('.q_parent[faq_id="'+tar_id+'"]').find('.ac-medium').addClass('acopen_jq');

			var jq_num = $('.q_parent[faq_id="'+tar_id+'"]').show();
			$('html, body').animate({scrollTop: $('.ttl_top').offset().top + 300});
		});

	}

	function all_off(){
		$('.acopen_jq').removeClass('acopen_jq');
		 $("[id^=ac-]").prop('checked', false);
	}

});