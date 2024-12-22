$('input[type="text"]').on("blur", function(){
	$(this).val(one2multi($(this).val()));
});
var one2multi = function (str) {
    var map = {
        '㈱': '(株)', '㈲': '(有)', '㈳': '(社)', '㈵': '(特)',
        '㈶': '(財)', '㈻': '(学)', '㈼': '(監)', '㍿': '株式会社'
    };
    var reg = new RegExp('(' + Object.keys(map).join('|') + ')', 'g');
    return str.replace(reg, function (match) {
        return map[match];
    });
}
