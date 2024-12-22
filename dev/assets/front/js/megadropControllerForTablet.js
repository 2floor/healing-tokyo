/**
 * @fileoverview メガドロップがタブレットでも touch 操作できるようにする
 * @author Fumie Toyooka
 *
 */

 /**
  * メガドロップが開いているか閉じているかのフラグ用クロージャ
  * @param {boolean} opened - false: 閉じている、true: 開いている
  * @return {boolean} change - 状態を指定して変更させる
  * @return {boolean} value - 現在の状態を取得する
  */
 var stateMenu = function() {
     var opened = false;
     return {
         change: function(new_value) {
             opened = new_value;
         },
         value: function() {
             return opened;
         }
     };
 };

 /**
  * 表示されているメガドロップに紐付いた DOM かを判別する
  * @description 動的に付与された style 属性が存在するかどうかで判別させる
  * @param {Object} _this イベント発火させた DOM の受け皿
  * @return {boolean} true:
  */
 function isSelf (_this) {
     if (_this.attr('style') !== undefined) {
         return true;
     } else {
         return false;
     }
 }

 /**
  * メガドロップを表示させる関数
  * @description メガドロップを表示させ、フラグを true に変更させる
  * @param {Object} $trigger メガドロップを表示させるためのグロナビの DOM
  */
 function openMegadropMenu ($trigger, state) {
     state.change(true);
     $trigger.next('.try__menu-second-level').css({
         'opacity': 1,
         'visibility': 'visible'
     });
 }

 /**
  * メガドロップを閉じる関数
  * @description 開いているメガドロップを閉じ、フラグを false に変更させる
  * @param {Object} $trigger メガドロップを閉じるためのグロナビの DOM
  */
 function closeMegadropMenu ($trigger, state) {
     state.change(false);
     $trigger.removeAttr('style');
 }

$(document).on('ready', function(e){
    'use strict';
    /** @type {boolean} */
    var _ua = (function(u){
    /** タブレット（iPad か Android OSをつんだもの）の場合 */
        return {
            Tablet: u.indexOf("ipad") != -1
            || (u.indexOf("android") != -1 && u.indexOf("mobile") === -1)
        };
    })(window.navigator.userAgent.toLowerCase());

    if (_ua.Tablet) {
        /** @type {boolean} stateMenu インスタンス化 */
        var state = stateMenu();

        /** メガドロップが開くイベントが発火 */
        $('.try__init-bottom').on('touchend', function(e){
            if (!state.value()) { /** 初期状態 -> 任意のメガドロップトリガを押下した時 */
                e.preventDefault();
                openMegadropMenu($(e.target), state);
            } else {
                if (e.target.localName === 'p') {
                    if (isSelf($(e.target).next('.try__menu-second-level'))) { /** 自分自身 かつ p タグをタップしたとき */
                        closeMegadropMenu($('.try__menu-second-level'), state);
                    } else { /** 自分自身以外 かつ p タグをタップしたとき */
                          /** 開いているメガドロップを非表示にする */
                        closeMegadropMenu($('.try__menu-second-level'), state);
                        /** タップされた p タグ以下のメガドロップ表示 */
                        openMegadropMenu($(e.target), state);
                    }
                } else if (e.target.localName === 'a') {
                    if (!isSelf($(e.target).next('.try__menu-second-level'))) { /** 自分自身以外 かつ a タグとメガドロップ有りをタップ */
                        e.preventDefault();
                        /** 開いているメガドロップを非表示にする */
                        closeMegadropMenu($('.try__menu-second-level'), state);
                        /** タップされた p タグ以下のメガドロップ表示 */
                        openMegadropMenu($(e.target), state);
                    }
                }
            }
        });

        $(document).on('touchend', function(e){
            if (!isSelf($(e.target).next('.try__menu-second-level'))
                && (!$(e.target).closest('.try__menu-second-level').length
                    || !$(e.target).closest('.try__init-bottom').length)) { /** メガドロップを閉じる処理 */

              closeMegadropMenu($('.try__menu-second-level'), state);
            }
        });
    }
});