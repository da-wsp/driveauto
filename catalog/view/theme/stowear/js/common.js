$(document).ready(function() {
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && responsive_design == 'yes' && $(window).width() < 768) {
		var i = 0;
		var produkty = [];
		
		$( ".box-product .carousel .item" ).each(function() {
			$( this ).find( ".product-grid .row > div" ).each(function() {
				if(i > 1) {
					produkty.push($(this).html());
				}
				
				i++;
			});
			for ( var s = i-3; s >= 0; s--, s-- ) {
				var html = "<div class='item'><div class='product-grid'><div class='row'>";
				if (produkty[s-1] != undefined) {
					html += "<div class='col-xs-6'>" + produkty[s-1] + "</div>";
				} else {
					html += "<div class='col-xs-6'>" + produkty[s+1] + "</div>";
				}
								
				if (produkty[s] != undefined) {
					html += "<div class='col-xs-6'>" + produkty[s] + "</div>";
				} else {
					html += "<div class='col-xs-6'>" + produkty[s+1] + "</div>";
				}
				html += "</div></div></div>";
				
				$( this ).after( html );
			}
			
			produkty = [];
			i = 0;
		});
	}
	
	/* Search */
	$('.button-search').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var search = $('header input[name=\'search\']').val();
		
		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}
		
		location = url;
	});
	
	$('header input[name=\'search\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var search = $('header input[name=\'search\']').val();
			
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			
			location = url;
		}
	});
	
	$(window).scroll(function(){
		if ($(this).scrollTop() > 300) {
	    	$('.scrollup').fadeIn();
	    } else {
			$('.scrollup').fadeOut();
		}
	}); 
	
	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});
	
	/* Search MegaMenu */
	$('.button-search2').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var search = $('.container-megamenu input[name=\'search2\']').val();
		
		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}
		
		location = url;
	});
	
	$('.container-megamenu input[name=\'search2\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var search = $('.container-megamenu input[name=\'search2\']').val();
			
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			
			location = url;
		}
	});
	
	/* Quatity buttons */
	
	$('#q_up').click(function(){
		var q_val_up=parseInt($("input#quantity_wanted").val());
		if(isNaN(q_val_up)) {
			q_val_up=0;
		}
		$("input#quantity_wanted").val(q_val_up+1).keyup(); 
		return false; 
	});
	
	$('#q_down').click(function(){
		var q_val_up=parseInt($("input#quantity_wanted").val());
		if(isNaN(q_val_up)) {
			q_val_up=0;
		}
		
		if(q_val_up>1) {
			$("input#quantity_wanted").val(q_val_up-1).keyup();
		} 
		return false; 
	});

	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	
	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});	
});

$(document).on('click', '.popup-modal-dismiss', function (e) {
	e.preventDefault();
	$.magnificPopup.close();
});

function getURLVar(key) {
    var value = [];
    
    var query = String(document.location).split('?');
    
    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');
            
            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }
        
        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
} 
	
// Cart add remove functions	
var cart = {
	'add': function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {			
				if (json['redirect']) {
					location = json['redirect'];
				}
				
				if (json['success']) {
					$("div.hover-product").hide();
					$("#notification .modal-footer").show();
					$("#notification").modal('show');
					$("#notification .modal-body p").html(json['success']);	
					
					$('#cart_block').load('index.php?route=module/cart #cart_block > *');
				}
			}
		});
	},
	'remove': function(key) {
		if(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
			location = 'index.php?route=checkout/cart&remove=' + key;
		} else {
			$.ajax({
				url: 'index.php?route=module/cart&remove=' + key,
				type: 'post',
				success: function(json) {
					$('#cart_block').load('index.php?route=module/cart #cart_block > *');
				}
			});	
		}		
	}
}

var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();
							
				if (json['success']) {
					$("div.hover-product").hide();
					$("#notification .modal-footer").hide();
					$("#notification").modal('show');
					$("#notification .modal-body p").html(json['success']);
					$('#wishlist-total').html(json['total']);
				}   
			}
		});
	},
	'remove': function() {
	
	}
}

var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();
							
				if (json['success']) {
					$("div.hover-product").hide();
					$("#notification .modal-footer").hide();
					$("#notification").modal('show');
					$("#notification .modal-body p").html(json['success']);
					$('#compare-total').html(json['total']);
				}   
			}
		});
	},
	'remove': function() {
	
	}
}

function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {						
			if (json['success']) {
				$("div.hover-product").hide();
				$("#notification .modal-footer").hide();
				$("#notification").modal('show');
				$("#notification .modal-body p").html(json['success']);
				$('#wishlist-total').html(json['total']);
				
			}	
		}
	});
}

function addToCompare(product_id) { 
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {						
			if (json['success']) {
				$("div.hover-product").hide();
				$("#notification .modal-footer").hide();
				$("#notification").modal('show');
				$("#notification .modal-body p").html(json['success']);
				$('#compare-total').html(json['total']);
			}	
		}
	});
}

function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$("div.hover-product").hide();
				$("#notification .modal-footer").show();
				$("#notification").modal('show');
				$("#notification .modal-body p").html(json['success']);
				$('#cart_block').load('index.php?route=module/cart #cart_block > *');
			}	
		}
	});
}