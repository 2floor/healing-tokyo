$(function (){
	var actionBef = $('[name=inputFormArea]').attr("action");


	$('[name=conf]').off('.formOn');
	$('[name=conf]').on({
		'click.formOn':  function(){
			console.log(actionBef);
			$('[name=inputFormArea]').attr("action", actionBef).removeAttr("target")
			validate(function(vali){
				if(vali){
					if(typeof additionalValidate == 'function') {
						additionalValidate(function(result){
					    	if(result){
					    		if(typeof depricateCheck == 'function'){
						    		depricateCheck($('[name=mail]'), function(flg){
										if(!flg) disabledForm();
									});
								}else{
									disabledForm();
								}
					    	}
					    });
					} else {
						if(typeof depricateCheck == 'function'){
							depricateCheck($('[name=mail]'), function(flg){
								if(!flg) disabledForm();
							});
						}else{
							disabledForm();
						}
					}
				}
			})
		},
	});


	$('[name=back]').off('.formOn');
	$('[name=back]').on({
		'click.formOn':  function(){
			disabledForm(2);
		},
	});


	$('[name=submitBtn]').off('.formOn');
	$('[name=submitBtn]').on({
		'click.formOn':  function(){
			disabledForm(2, function(){
				if($('input[type="file"]').length > 0){
					$('input[type="file"]').each(function(i, elem){
						var jq_id = $(elem).attr('jq_id');
						var col_name = $(elem).attr('col_name');
						var file_name = [];
						if($('#img_area' + jq_id).find('.file_name_area').length > 0){
							$('#img_area' + jq_id).find('.file_name_area').each(function(j, elem2){
								file_name.push($(elem2).attr("file_name"));
							});
							$(elem).after('<input type="hidden" name="'+col_name+'" value="'+file_name.join()+'">');
						}
					})
				}

				$('[name=inputFormArea]').html("");
				getForm(function(){
					$('[name=inputFormArea]').submit();
				})
			});
		},
	});


	$('[name=preview]').off('.formOn');
	$('[name=preview]').on({
		'click.formOn':  function(){
			var $prevBtn = $(this);
			if($('input[type="file"]').length > 0){
				$('input[type="file"]').each(function(i, elem){
					var jq_id = $(elem).attr('jq_id');
					var col_name = $(elem).attr('col_name');
					var file_name = [];
					if($('#img_area' + jq_id).find('.file_name_area').length > 0){
						$('#img_area' + jq_id).find('.file_name_area').each(function(j, elem2){
							file_name.push($(elem2).attr("file_name"));
						});
						$(elem).after('<input type="hidden" name="'+col_name+'" value="'+file_name.join()+'">');
					}
				})
			}

			$('[name=inputFormArea]').html("");
			getForm(function(){
				if($prevBtn.attr("prev_for") != undefined && $prevBtn.attr("prev_for") != null && $prevBtn.attr("prev_for") != ''){
					$('[name=inputFormArea]').attr("action", $prevBtn.attr("prev_for")).attr("target", "_blank").submit();
				}else{
					$('[name=inputFormArea]').attr("action", "plan_prev.php?sbid="+$('#sbid').val()).attr("target", "_blank").submit();
				}
			})
		},
	});


	function disabledForm(ty, callback1){
		if(ty == undefined) ty = 1;
		var disabledFlg = "disabled";
		if(ty == 1){
			$('#inputFormArea').find('input, textarea, select').each(function(i, elem){
				$(elem).attr('disabled', 'disabled');
				var type = $('[name='+$(elem).attr('name')+']').attr('type');
				if (type == 'radio' && $(elem).prop("checked") != true)  $(elem).parents('label').hide('name');
			});
			if($('.conf_top').length > 0){
				$('html, body').scrollTop($('.conf_top').offset().top);
			}else{
				$('html, body').scrollTop(0);
			}
			$('.conf_show').show();
			$('.conf_hide').hide();

			$(".required_form").removeClass("required_form").addClass("required_form_af");
		}else{
			$('#inputFormArea').find('input, textarea, select').each(function(i, elem){
				$(elem).removeAttr('disabled');
				var type = $('[name='+$(elem).attr('name')+']').attr('type');
				if (type == 'radio')  $(elem).parents('label').show('name');
			});
			if($('.conf_top').length > 0){
				$('html, body').scrollTop($('.conf_top').offset().top);
			}else{
				$('html, body').scrollTop(0);
			}
			$('.conf_show').hide();
			$('.conf_hide').show();

			$(".required_form_af").removeClass("required_form_af").addClass("required_form");
		}

		if(callback1 != undefined){
			callback1();
		}
	}

	function getForm(callback2){
		var input = '';
		$('#inputFormArea').find('input, textarea, select').each(function(i, elem){
			var type = $('[name='+$(elem).attr('name')+']').attr('type');
			if (type != 'radio' && type != 'checkbox') {
				if($(elem).hasClass('encode') ||  $(elem).hasClass('convert') ) {
					input += '<input type="hidden" name="'+$(elem).attr('name')+'" value="'+htmlspecialchars($(elem).val())+'">';
				}else{
					input += '<input type="hidden" name="'+$(elem).attr('name')+'" value="'+$(elem).val()+'">';
				}

			} else if(type == 'radio'){
				//ラジオボタン設定
				input += '<input type="hidden" name="'+$(elem).attr('name')+'" value="'+$('[name='+$(elem).attr('name')+']:checked').val()+'">';
			} else if (type == 'checkbox') {
				//チェックボックス設定(配列)
				input += '<input type="hidden" name="'+$(elem).attr('name')+'" value="'+$('[name='+$(elem).attr('name')+']:checked').map(function() { return $(this).val(); }).get()+'">';
			}

		});
		input += '<input type="hidden" name="preview" value="on">';
		$('[name=inputFormArea]').html(input);
		if(callback2 != undefined){
			callback2();
		}
	}

	function htmlspecialchars(str) {
		return 	(str + '')	.replace(/&/g, '&amp;')
								.replace(/"/g, '&quot;')
								.replace(/'/g, '&#039;')
								.replace(/</g, '&lt;')
								.replace(/>/g, '&gt;');
	}
});


