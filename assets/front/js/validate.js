/*
 * real-time validation
 */

/* ===============================================

@attrs
  required : attrs.required => 必須項目かどうか data-error : required でvalidation
  data-maxlength : attrs.maxlength => 文字数上限 data-error : maxlength でvalidation
  data-minlength : attrs.minlength => 文字数下限（ 今回は無いので全て0 ） data-error : minlength でvalidation

@setting
  ValidationView Class の incetance生成時に、
   $( textarea or input + .validation__textarea + max_{maxlength} )でDOMを取得
   => data-maxlength と .max_{maxlength} の値が一致することで、Validate constructor を使いまわすことができる。

================================================== */


/* Validate Model Class
================================================== */
// Observer constructor
function ValidateModel(attrs) {
	// 入力した文字の初期値
	this.val = '';
	// input 又は textarea から取得したdata値
	this.attrs = {
		required: attrs.required,
		maxlength: attrs.maxlength,
		minlength: attrs.minlength
	};

	this.listeners = {
		valid: [],
		invalid: []
	};
}

ValidateModel.prototype.validate = function() {
	var val;
	this.errors = [];

	for (var key in this.attrs) {
		val = this.attrs[key];
		if(!this[key](val)) this.errors.push(key);
	}

	this.trigger(!this.errors.length ? 'valid' : 'invalid');
};

ValidateModel.prototype.on = function(event, func) {
	if(!this.listeners[event]) {
		this.listeners[event] = [];
	}
	this.listeners[event].push(func);
};

ValidateModel.prototype.trigger = function(event) {
	$.each(this.listeners[event], function() {
		this();
	});
};

ValidateModel.prototype.set = function(val) {
	if (this.val === val) return;
	this.val = val;
	this.validate();
};

ValidateModel.prototype.required = function() {
	return this.val !== '';
};

ValidateModel.prototype.maxlength = function(num) {
	/* 大文字2bite換算の場合 */
	// var crlf = this.val.match(/(\r\n|\n|\r)/g);
	// var crlfLen = (crlf !== null) ? crlf.length : 0 ;
	// return num >= this.val.length + crlfLen;

	/* 大文字1bite換算の場合 */
	var rawVal = this.val;
	var countNum = 0;
	for (var i = 0; i < rawVal.length; i++) {
		var demiVal = rawVal.charCodeAt(i);

		if ((demiVal === 10) || (demiVal === 13)) {
			countNum += 1;
		} else if ((demiVal >= 0x0 && demiVal < 0x81) || (demiVal == 0xf8f0) || (demiVal >= 0xff61 && demiVal < 0xffa0) || (demiVal >= 0xf8f1 && demiVal < 0xf8f4)) {
			countNum += 0.5;
		} else {
			countNum += 1;
		}
	}

	return num >= countNum;
};

ValidateModel.prototype.minlength = function(num) {
	/* 大文字2bite換算の場合 */
	// var crlf = this.val.match(/(\r\n|\n|\r)/g);
	// var crlfLen = (crlf !== null) ? crlf.length : 0 ;
	// return num <= this.val.length + crlfLen;

	/* 大文字1bite換算の場合 */
	var rawVal = this.val;
	var countNum = 0;
	for (var i = 0; i < rawVal.length; i++) {
		var demiVal = rawVal.charCodeAt(i);

		if ((demiVal === 10) || (demiVal === 13)) {
			countNum += 1;
		} else if ((demiVal >= 0x0 && demiVal < 0x81) || (demiVal == 0xf8f0) || (demiVal >= 0xff61 && demiVal < 0xffa0) || (demiVal >= 0xf8f1 && demiVal < 0xf8f4)) {
			countNum += 0.5;
		} else {
			countNum += 1;
		}
	}

	return num <= countNum;
};


/* Validate View Class
================================================== */
function ValidateView(el) {
	this.initialize(el);
	this.handleEvents();

	// submitをした場合にもう一度バリデーションをかける
	this.submitValidation(el);
}


ValidateView.prototype.initialize = function(el) {
	this.$el = $(el);
	this.$list = this.$el.next().children();
	this.$listMinLength = this.$el.next().children('[data-error="minlength"]');
	this.$listMaxLength = this.$el.next().children('[data-error="maxlength"]');

	this.$counter = this.$el.next().next().children('.val-count');
	this.$initCounter = this.$el.next().next().children('.init-count');

	var obj = this.$el.data();
	if( this.$el.prop('required') ) {
		obj['required'] = '';
	} else {
		// 必須項目ではない場合の処理
		obj['required'] = 'noRequired';
	}

	var initContNum = 0;
	var initRawVal = this.$el.val();
	for (var i = 0; i < initRawVal.length; i++) {
		var demiVal = initRawVal.charCodeAt(i);

		if ((demiVal === 10) || (demiVal === 13)) {
			initContNum += 1;
		} else if ((demiVal >= 0x0 && demiVal < 0x81) || (demiVal == 0xf8f0) || (demiVal >= 0xff61 && demiVal < 0xffa0) || (demiVal >= 0xf8f1 && demiVal < 0xf8f4)) {
			initContNum += 0.5;
		} else {
			initContNum += 1;
		}
	}
	this.$counter.html(initContNum);

	this.$listMinLength.prepend(obj.minlength);
	this.$listMaxLength.prepend(obj.maxlength);


	this.$initCounter.html(obj.maxlength);

	this.model = new ValidateModel(obj);
};

ValidateView.prototype.handleEvents = function() {
	var _this = this;

	this.$el.on('keyup', function(e) {
		_this.onKeyup(e);
		_this.onCountup(e);
	});

	this.model.on('valid', function() {
		_this.onValid();
	});
	this.model.on('invalid', function() {
		_this.onInvalid();
	});
};

ValidateView.prototype.submitValidation = function(el) {
	var _this = this;
	// _.each(el, function(element) {
	var $target = $(el);

	var rawVal = $target.val();
	var targetVal = rawVal;

	this.model.set(targetVal);
	// });

	this.model.on('valid', function() {
		_this.onValid();
	});
	this.model.on('invalid', function() {
		_this.onInvalid();
	});
};

ValidateView.prototype.onKeyup = function(e) {
	var $target = $(e.currentTarget);

	var rawVal = $target.val();
	var targetVal = rawVal;

	this.model.set(targetVal);
};

ValidateView.prototype.onCountup = function(e) {
	// var $targetLength = $(e.currentTarget).val().length;
	var $target = $(e.currentTarget);
	var rawVal = $target.val();

	/* 大文字2bite換算の場合 */
	// var crlf = rawVal.match(/(\r\n|\n|\r)/g);
	// var crlfLen = (crlf !== null) ? crlf.length : 0 ;
	// var targetLen = rawVal.length + crlfLen;
	// this.$counter.html(targetLen);

	/* 大文字1bite換算の場合 */
	var countNum = 0;
	for (var i = 0; i < rawVal.length; i++) {
		// 入力された文字の unicode コードポイントを10進数で返す
		var demiVal = rawVal.charCodeAt(i);

		if ((demiVal === 10) || (demiVal === 13)) {
			// 改行は全角として認識させる
			countNum += 1;
		} else if ((demiVal >= 0x0 && demiVal < 0x81) || (demiVal == 0xf8f0) || (demiVal >= 0xff61 && demiVal < 0xffa0) || (demiVal >= 0xf8f1 && demiVal < 0xf8f4)) {
			// Shift_JIS, Unicodeの半角をすべて全角の半分の大きさで考える
			// Shift_JIS: 0x0 ～ 0x80, 0xa0 , 0xa1 ～ 0xdf , 0xfd ～ 0xff
			// Unicode : 0x0 ～ 0x80, 0xf8f0, 0xff61 ～ 0xff9f, 0xf8f1 ～ 0xf8f3
			countNum += 0.5;
		} else {
			// その他全角すべて
			// ※サロゲート文字列は全角の倍数としてカウントされる
			countNum += 1;
		}
	}

	this.$counter.html(countNum);

};

ValidateView.prototype.onValid = function() {
	this.$el.removeClass('error');
	this.$counter.removeClass('error');
	this.$list.hide();
};

ValidateView.prototype.onInvalid = function() {
	var _this = this;
	this.$el.addClass('error');
	this.$counter.addClass('error');
	this.$list.hide();

	$.each(this.model.errors, function(index, val) {
		_this.$list.filter('[data-error=\'' + val + '\']').show();
		// 必須項目ではない場合の処理
		if(_this.$el.data('required') === 'noRequired') {
			_this.$list.filter('[data-error="required"]').hide();
		}
	});
};



/* instance
================================================== */
// data値とバリデーションを施す値を一致させていれば、コンストラクタ関数は使い回しでインスタンス化可能
// テキストエリア500文字
$(function() {
	$('textarea.validation__textarea.max_500').each(function() {
	  new ValidateView(this);
	});
	// テキストエリア250文字
	$('textarea.validation__textarea.max_250').each(function() {
	  new ValidateView(this);
	});
	// テキストエリア200文字
	$('textarea.validation__textarea.max_200').each(function() {
	  new ValidateView(this);
	});
	// テキストエリア150文字
	$('textarea.validation__textarea.max_150').each(function() {
	  new ValidateView(this);
	});
	// テキストエリア100文字
	$('textarea.validation__textarea.max_100').each(function() {
	  new ValidateView(this);
	});
	// テキストエリア50文字
	$('textarea.validation__textarea.max_50').each(function() {
	  new ValidateView(this);
	});


	// インプット10文字
	$('input.validation__input.max_10').each(function() {
	  new ValidateView(this);
	});
	// インプット20文字
	$('input.validation__input.max_20').each(function() {
	  new ValidateView(this);
	});
	// インプット50文字
	$('input.validation__input.max_50').each(function() {
	  new ValidateView(this);
	});
	// インプット50文字
	$('input.validation__input.max_100').each(function() {
	  new ValidateView(this);
	});
	// インプット200文字
	$('input.validation__input.max_200').each(function() {
	  new ValidateView(this);
	});
});


/* 保存ボタンを押した時に発火するイベント */
$('#validationTrigger').on('click', function() {
	_.each($('input.validation__input, .validation__textarea'), function(element) {
		var inputValidation = new ValidateView($(element));
		return inputValidation.model.validate();
	});
});