//入力フォーム必須チェック
function validate(callback) {

    flg = false

    //エラーの初期化
    var ini_color = "#fff";
    $(".error").remove();
    $(".error-form").removeClass('error-form');
//		$(":text,textarea").css("background",ini_color);
//		$('[type="tel"]').css("background",ini_color);
//		$('[type="email"]').css("background",ini_color);
//		$(":password").css("background",ini_color);
//		$("select").css("background",ini_color);

    $(":text,textarea").filter(".validate").each(function () {

        //必須項目のチェック
        $(this).filter(".required").each(function () {
            if ($(this).val() == "") {
                $(this).after("<span class='error'><label>Required form</label></span>")
                $(this).addClass("error-form");
            }
        })

        //数値のチェック
        $(this).filter(".number").each(function () {
            if (isNaN($(this).val())) {
                $(this).after("<span class='error'><label>Only numerical values ​​can be entered</label></span>");
                $(this).addClass("error-form");
            }
        })
        $(this).filter(".tel").each(function () {
            if ($(this).val() && !$(this).val().match(/^(0[5-9]0[0-9]{8}|0[1-9][1-9][0-9]{7})$/)) {
                $(this).after("<span class='error'><label>Only 10 to 11 digits can be entered</label></span>");
                $(this).addClass("error-form");
            }
        })

        //パスワードの桁数チェック
        $(this).filter(".password").each(function () {
            if ($(this).val() != null && $(this).val() != '' && ($(this).val().length < 8 || $(this).val().length > 20 || (!$(this).val().match(/[^a-zA-Z]/) || !$(this).val().match(/[^0-9]/)))) {
                $(this).after("<span class='error'><label>8 to 20 characters mixing alphabets and numbers.</label></span>");
                $(this).addClass("error-form");
            }
        })

        //メールアドレスのチェック
        $(this).filter(".mail").each(function () {
            if ($(this).val() && !$(this).val().match(/.+@.+\..+/g)) {
                $(this).after("<span class='error'><label>Email address format is different</label></span>");
                $(this).addClass("error-form");
            }
        })

        //メールアドレス確認のチェック
        $(this).filter(".mail_check").each(function () {
            if ($(this).val() && $(this).val() != $("input[name=" + $(this).attr("name").replace(/^(.+)_check$/, "$1") + "]").val()) {
                $(this).after("<span class='error'><label>Email address and contents are different</label></span>");
                $(this).addClass("error-form");
            }
        })

        $(this).filter(".half_width").each(function () {
            if ($(this).val() != null && !checkHasError($(this)) && $(this).val() != '' && !$(this).val().match(/^[\x20-\x7E]+$/)) {
                $(this).after("<span class='error'><label>Only half-width characters are allowed</label></span>");
                $(this).addClass("error-form");
            }
        });

        //必須項目のチェック
        $(this).filter(".couple").each(function () {
            var couple = $(this).attr('couple');
            var couple_flg = true;
            var couple_exist = false;
            var couple_non_exist = false;
            var couple_require = false;
            var cnt = 0
            $('[couple="' + couple + '"]').each(function (i, elem) {
                cnt++;
                if ($(elem).val() == null || $(elem).val() == '') {
                    couple_non_exist = true;
                } else {
                    couple_exist = true;
                }
                if ($(elem).hasClass('couple_require') && $(elem).val() == null || $(elem).val() == '') {
                    couple_require = true;
                }
            })

            console.log(couple_exist, couple_non_exist, couple_require);
            if (couple_exist === true && couple_non_exist === true) {
                //どちらかが抜けてる
                $('.couple_error_' + couple).html("<span class='error'><label>" + cnt + "つのフォームは必須項目です</label></span>");
                $(this).addClass("error-form");
            } else if (couple_non_exist === true && couple_require == true) {
                //必須抜け
                $('.couple_error_' + couple).html("<span class='error'><label>" + cnt + "つのフォームはa必須項目です</label></span>");
                $(this).addClass("error-form");
            }

        });
    })

    //数字チェック
    $('[type="tel"]').filter(".validate").each(function () {

        //必須項目のチェック
        $(this).filter(".required").each(function () {
            if ($(this).val() == "") {
                $(this).after("<span class='error'><label>Required form</label></span>")
                $(this).addClass("error-form");
            }

        })

        //数値のチェック
        $(this).filter(".number").each(function () {
            if (isNaN($(this).val())) {
                $(this).after("<span class='error'><label>Only numerical values ​​can be entered</label></span>");
                $(this).addClass("error-form");
            }
        })

        //必須項目のチェック
        $(this).filter(".couple").each(function () {
            var couple = $(this).attr('couple');
            var couple_flg = true;
            var couple_exist = false;
            var couple_non_exist = false;
            var couple_require = false;
            var cnt = 0
            $('[couple="' + couple + '"]').each(function (i, elem) {
                cnt++;
                if ($(elem).val() == null || $(elem).val() == '') {
                    couple_non_exist = true;
                } else {
                    couple_exist = true;
                }
                if ($(elem).hasClass('couple_require')) {
                    couple_require = true;
                }
            })

            if (couple_exist === true && couple_non_exist === true) {
                //どちらかが抜けてる
                $('.couple_error_' + couple).html("<span class='error'><label>" + cnt + "つのフォームは必須項目です</label></span>");
                $(this).addClass("error-form");
            } else if (couple_non_exist === true && couple_require == true) {
                //必須抜け
                $('.couple_error_' + couple).html("<span class='error'><label>" + cnt + "つのフォームは必須項目です</label></span>");
                $(this).addClass("error-form");
            }

        });
    });


    //英数字入力
    $('[type="email"]').filter(".validate").each(function () {

        //英字チェック
        $(this).filter(".required").each(function () {
            if ($(this).val() == "") {
                $(this).after("<span class='error'><label>Required form</label></span>")
                $(this).addClass("error-form");
            }
        })

        if ($(this).val() && !$(this).hasClass('mail') && $(this).val().match(/[^0-1a-zA-Z]/)) {
            $(this).after("<span class='error'><label>Only single-byte alphanumeric characters can be entered</label></span>");
            $(this).addClass("error-form");
        }

        //メールアドレスのチェック
        $(this).filter(".mail").each(function () {
            if ($(this).val() && !$(this).val().match(/.+@.+\..+/g)) {
                $(this).after("<span class='error'><label>Email address format is different</label></span>");
                $(this).addClass("error-form");
            }
        })

        //メールアドレス確認のチェック
        $(this).filter(".mail_check").each(function () {
            if ($(this).val() && $(this).val() != $("input[name=" + $(this).attr("name").replace(/^(.+)_check$/, "$1") + "]").val()) {
                $(this).after("<span class='error'><label>Email address and contents are different</label></span>");
                $(this).addClass("error-form");
            }
        })

    });

    //パスワードのチェック
    $(":password").filter(".validate").each(function () {

        //パスワードの必須チェック
        $(this).filter(".required").each(function () {
            if ($(this).val() == "") {
                $(this).after("<span class='error'><label>Required form</label></span>");
                $(this).addClass("error-form");
            }
        })

        //パスワードの桁数チェック
        $(this).filter(".password").each(function () {
            if ($(this).val() != null && $(this).val() != '' && !checkHasError($(this)) && ($(this).val().length < 8 || $(this).val().length > 20 || (!$(this).val().match(/[^a-zA-Z]/) || !$(this).val().match(/[^0-9]/)))) {
                $(this).after("<span class='error'><label>8 to 20 characters mixing alphabets and numbers.</label></span>");
                $(this).addClass("error-form");
            }
        });


        //パスワード確認のチェック
        $(this).filter(".password_conf").each(function () {
            if ($(this).val() != $('.password').val() && !checkHasError($(this))) {
                $(this).after("<span class='error'><label>Password and contents are different</label></span>");
                $(this).addClass("error-form");
            }
        });

        $(this).filter(".half_width").each(function () {
            if ($(this).val() != null && !checkHasError($(this)) && $(this).val() != '' && !$(this).val().match(/^[\x20-\x7E]+$/)) {
                $(this).after("<span class='error'><label>Only half-width characters are allowed</label></span>");
                $(this).addClass("error-form");
            }
        });
    });

    //セレクトボックスのチェック
    $("select").filter(".validate").each(function () {
        $(this).filter(".required").each(function () {
            if ($('select[name="' + $(this).attr("name") + '"]').val() == '' || $('select[name="' + $(this).attr("name") + '"]').val() == null) {

                if ($(this).hasClass("alert_before")) {
                    $("#" + $(this).parent().attr('id')).after("<span class='error'><label>Please select</label></span>");
                } else {
                    $(this).after("<span class='error'><label>Please select</label></span>");
                }
                $(this).addClass("error-form");
            }
        })
    })

    //ラジオボタンのチェック
    $(":radio").filter(".validate").each(function () {
        $(this).filter(".required").each(function () {
            if ($(":radio[name=" + $(this).attr("name") + "]:checked").size() == 0) {
                $(this).after("<span class='error'><label>Please select</label></span>");
                return false;
            }
        })
    })

    //チェックボックスのチェック
    var checkbox_array = [];
    $(".checkboxRequired").each(function () {
        checkbox_array.push($(this).attr('name'));
    })

    // 重複を検出したものを重複しないでリスト
    var checkbox_array = checkbox_array.filter(function (x, i, self) {
        return self.indexOf(x) === i && i !== self.lastIndexOf(x);
    });

    for (var i = 0; i < checkbox_array.length; i++) {
        if ($('[name=' + checkbox_array[i] + ']:checked').length == 0) {
            $('#' + checkbox_array[i] + '_error').html("<span class='error'><label>最低1つ選択してください</label><br></span>");
        }
    }

    //利用規約に同意する
    $(":checkbox").filter(".privacy_policy").each(function () {
        if (!$(this).prop('checked')) {
            $(this).after("<span class='error'><label>I have not agreed to the terms</label><br></span>");
        }
    })


    //ファイルの必須チェック
    $("input:file").filter(".validate").each(function () {
        $(this).filter(".required").each(function () {
            var data = $(this).parents('.form-group').find('.file_name_area').attr('file_name');
            if (data == null || data == '' || data == undefined) {
                $(this).parents('.form-group').find('.file_error').after("<span class='error'><br><label>Please choose the file</label></span>")
            }
        })
    })


    //チェックボックス＆セレクトボックスの複合必須チェック
    if (flg) {
        var select_chk_flg = true;
        var checkbox_chk_flg = true;
        var add_selector = "";

        var checkbox_checked = $('.chk_checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (checkbox_checked == "") {
            checkbox_chk_flg = false;
        }

        $("select").filter(".validate").each(function () {
            $(this).filter(".chk_select").each(function () {
                if ($('select[name="' + $(this).attr("name") + '"]').prop("selectedIndex") == 0) {
                    select_chk_flg = false;
                    add_selector = $(this);
                }
            })
        });

        if (!select_chk_flg && !checkbox_chk_flg) {
            add_selector.after("<span class='error'><label>検索条件(特徴)、検索条件(職種)のいずれかを1つ選択して下さい</label></span>");
            add_selector.css("background", "#FFCCCC");
        }
    }

    //エラーの際の処理
    if ($("span.error").length > 0) {
        $("span.error").css("color", "red");
        $('html,body').animate({scrollTop: $("span.error:first").offset().top - 250});

    } else {
        flg = true;
    }
    if (callback != undefined) {
        callback(flg);
    } else {
        return flg;
    }
}

function checkHasError(ele) {
    return ele.hasClass('error-form') && ele.parent().find('.error').length
}