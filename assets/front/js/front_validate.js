//入力フォーム必須チェック
function validate(flg){

	if (flg == null) {
		flg = false;
	}

		//エラーの初期化
		$(".error").remove();
		$(":text,textarea").css("background","#fff");
		$(":password").css("background","#fff");
		$("select").css("background","#fff");

		$(":text,textarea").filter(".validate").each(function(){

			//必須項目のチェック
			$(this).filter(".required").each(function(){
				if($(this).val()==""){
					$(this).after("<span class='error'><label>必須項目です</label></span>")
					$(this).css("background","#FFCCCC");
				}

			})

			//数値のチェック
			$(this).filter(".number").each(function(){
				var num_array =[];
				if($(this).val().match(/\-/g)){
					num_array = $(this).val().split('-');
				}else{
					num_array[0] = $(this).val();
				}
				var number_validate_flg =false;
				$.each(num_array, function(k, v){
					if(isNaN(v)){
						number_validate_flg = true;
					}
				});
				if(number_validate_flg){
					$(this).after("<span class='error'><label>数値とハイフンのみ入力可能です</label></span>");
					$(this).css("background","#FFCCCC");
				}
			})

			//メールアドレスのチェック
			$(this).filter(".mail").each(function(){
				if($(this).val() && !$(this).val().match(/.+@.+\..+/g)){
					$(this).after("<span class='error'><label>メールアドレスの形式が異なります</label></span>");
					$(this).css("background","#FFCCCC");
				}
			})

			//メールアドレス確認のチェック
			$(this).filter(".mail_check").each(function(){
				if($(this).val() && $(this).val()!=$("input[name="+$(this).attr("name").replace(/^(.+)_check$/, "$1")+"]").val()){
					$(this).after("<span class='error'><label>入力内容が確認と異なります</label></span>");
					$(this).css("background","#FFCCCC");
				}
			})
		})

		//パスワードのチェック
		$(":password").filter(".validate").each(function(){

			if ($(this).attr('id') != "after_password") {
				//パスワードの必須チェック
				$(this).filter(".required").each(function(){
					if($(this).val()==""){
						$(this).after("<span class='error'><label>必須項目です</label></span>");
						$(this).css("background","#FFCCCC");
					}
				})

				//パスワードの桁数チェック
				$(this).filter(".password").each(function(){
					if($(this).val().length < 8 || $(this).val().length > 20 || (!$(this).val().match(/[^a-zA-Z]/) || !$(this).val().match(/[^0-9]/))){
						$(this).after("<span class='error'><label>半角英字と半角数字を含む8～20文字を設定して下さい。</label></span>");
						$(this).css("background","#FFCCCC");
					}
				})


				//パスワード確認のチェック
				$(this).filter(".password_conf").each(function(){
					if($(this).val() && $(this).val()!=$('.password').val()){
						$(this).after("<span class='error'><label>パスワードと内容が異なります</label></span>");
						$(this).css("background","#FFCCCC");
					}
				})
			}
		})

		//セレクトボックスのチェック
		$("select").filter(".validate").each(function(){
			$(this).filter(".required").each(function(){
				if($('select[name="' + $(this).attr("name") + '"]').val() == ''){

					if($(this).hasClass("alert_after")){
	 					$("#" + $(this).parent().attr('id')).after("<span class='error'><label>選択してください</label></span>");
					} else {
						$(this).after("<span class='error'><label>選択してください</label></span>");
					}
					$(this).css("background","#FFCCCC");
				}
			})
		})

		//ラジオボタンのチェック
		$(":radio").filter(".validate").each(function(){
			$(this).filter(".required").each(function(){
				if($(":radio[name="+$(this).attr("name")+"]:checked").size() == 0){
					$(this).before("<span class='error'><label>選択してください</label></span><br>");
					return false;
				}
			})
		})

		//プライバシーポリシー系チェックボックス
		$(":checkbox").filter(".validate").each(function(){
			$(this).filter(".required").each(function(){
				if($(":checkbox[name="+$(this).attr("name")+"]:checked").size() == 0){
					$(this).before("<span class='error'><label>同意して下さい</label></span><br>");
					return false;
				}
			})
		})


		//チェックボックスのチェック
		var checkbox_array = [];
		$(".checkboxRequired").each(function(){
			checkbox_array.push($(this).attr('name'));

//			if($(":checkbox:checked",this).size()==0){
//				$(this).after("<span class='error'><label>選択してください</label></span>");
//				return false;
//			}
		})


		//エラーの際の処理
		if($("span.error").size() > 0){
//			$("p.error").parent().addClass("error");
			$("span.error").css("color","red");
//			alert(document.body.scrollTop);
			$('html,body').animate({ scrollTop: $("span.error:first").offset().top-250 });

			return false;
		}
		return true;
}