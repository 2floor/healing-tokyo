function UserInformation(api, $beforeUserInformation) {
	this.handleEvents(api, $beforeUserInformation);
}

UserInformation.prototype.handleEvents = function (api, $beforeUserInformation) {
	var _this = this;
	return $.ajax({
		url: api, 
		type: 'GET',
		dataType: 'html',
		async: true
	})
	// 成功したときの処理
	.done(function(data){
		var $uerInformationHTML = data;
		// ユーザへのメッセージを挿入する
		return _this.addUserInformation($uerInformationHTML, $beforeUserInformation);
	})
	.fail(function(xhr) {
		// 処理は失敗するが、エラーの出力はしない
	});
};

UserInformation.prototype.addUserInformation = function ($uerInformationHTML, $beforeUserInformation) {
    var isClass = $beforeUserInformation.attr('class');

    if (isClass === 'oz__articleBody') {
        $beforeUserInformation.before($uerInformationHTML);
    } else if (isClass === 'oz__submenu-wrap') {
        $beforeUserInformation.after($uerInformationHTML);
    } else {
        $beforeUserInformation.before($uerInformationHTML);
    }
};