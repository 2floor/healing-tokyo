$(function (){

	datepickerBind();

	tour_num_disp();
	$('[name=tour_num]').off().on('change', function(){
		tour_num_disp();
	});

	addRembtnFunc();

});

function datepickerBind(){
	$('.tour_datepicker').datepicker({
		format : "YYYY-MM-DD"
	});
}


function tour_num_disp(){
	var tour_num = $('[name=tour_num]').val();
	for (var i = 1; i <= 3; i++) {
		if(tour_num >= i){
			$('.tour_num_' + i).show();
		}else{
			$('.tour_num_' + i).hide();
		}
	}
}

function addRembtnFunc(){
	$('.exBtn').off().on('click', function(){
		var html_btn_p = '		<button class="exBtn add">+</button>';
		var html_btn_m = '		<button class="exBtn rem">-</button>';

		var html_base  = '<div class="exceptionDateArea">';
			 html_base += '		<input type="text" name="exception_date-/####tour###/_/####num###/" id="exception_date-/####tour###/_/####num###/" class="formTxt1 validate required tour_datepicker" placeholder="日付" value="">';
			 html_base += '		<input type="number" name="ex_max_number_of_people-/####tour###/_/####num###/" id="ex_max_number_of_people-/####tour###/_/####num###/" class="formTxt1 validate required" placeholder="人数" value="">';
			 html_base += 		html_btn_p + html_btn_m;
			 html_base += '</div>';

		var $parent = $(this).parents('.exceptionDateWrap');
		var num = $parent.attr('num');
		var tour = $parent.attr('tour');
		if($(this).hasClass('add')){
			var new_num = Number(num) + 1
			html = html_base.replace(/\/####tour###\//g, tour).replace(/\/####num###\//g, new_num);
			$parent.append(html).attr('num', new_num);
			$(this).next('.rem').remove();
			$(this).remove();
			$('[name=exception_num-'+tour+']').val(new_num);

		}else if($(this).hasClass('rem')){
			$(this).parent('.exceptionDateArea').remove();
			num = (Number(num) - 1);
			$parent.attr('num', num);
			$parent.find('.exceptionDateArea').last().append(html_btn_p);
			if(num > 1){
				$parent.find('.exceptionDateArea').last().append(html_btn_m);
			}
			$('[name=exception_num-'+tour+']').val(num);
		}
		addRembtnFunc();
		datepickerBind();
	});
}