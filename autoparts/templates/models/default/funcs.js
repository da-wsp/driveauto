var ShowNFilter=0;

$(document).ready(function () {
    if(ShowNFilter==1){
		var _contentRows = $('.modelsdiv');
		  _count = 0;
		  var symbol = [];
		  _contentRows.each(function (i) {
		var _cellText = $(this).children('.modelname').eq(0).text().substr(0,1);
		if($.inArray(_cellText,symbol)==-1) {
		  symbol.push(_cellText);
		}
		_count += 1;
		  });
		  var arr = symbol.sort();
		  for(var k=0;k<arr.length;k++) {
		$('.modelsfilter').append('<a href="javascript:void(0)">'+arr[k]+'</a>');
		  }
		var _alphabets = $('.modelsfilter > a');
		
		_alphabets.click(
			function () {
				var _letter = $(this), _text = $(this).text(), _count = 0;

				_alphabets.removeClass("active");
				_letter.addClass("active");
				
				_contentRows.hide();
				_contentRows.each(function (i) {
					if(_text==AllLng) {
						_count += 1;
						$(this).fadeIn(400);
					}else {
						var _cellText = $(this).children('.modelname').eq(0).text();
						if (RegExp('^' + _text).test(_cellText)) {
							_count += 1;
							$(this).fadeIn(400);
						}
					}
				});
		});
	}
});