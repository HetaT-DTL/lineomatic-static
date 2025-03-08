/* Site Loader */


$(window).load(function () {
	$("#status").fadeOut();
	$("#preloader").delay(1000).fadeOut("slow");
})

/*Mobile Menu Copy*/
$('.mobile-menu .nav-menu').prepend(jQuery('.nav-menu').html());

/*Mobile Menu Copy*/

$("a.default-btn, a.default-btn-lg").append("<span class='dbtn-icon'></span>");


$(document).ready(function () {

	/* WOW  */
	new WOW().init();
	/* WOW  */

	/* Banner Slider */
	$('.home-slider').lightSlider({
		item: 1,
		addClass: "banner-slider",
		mode: 'fade',
		speed: 800,
		loop: true,
		pager: false,
		prevHtml: "<i class='fa fa-angle-left'></i>",
		nextHtml: "<i class='fa fa-angle-right'></i>",
	});
	/* Banner Slider */

	/* Testimonials */
	$('.testimonial-slider').lightSlider({
		item: 1,
		addClass: "default-slider",
		loop: true,
		pager: false,
		speed: 700,
		prevHtml: "<i class='fa fa-angle-left'></i>",
		nextHtml: "<i class='fa fa-angle-right'></i>",
	});

	/* Tab id */
	$(".machine-tab-content ul").idTabs();
	$(".wmap-tab ul").idTabs();
	/* Tab id */


	$(document).ready(function () {
		/* accordion*/
		var $container = $('.faq-content'),
			$trigger = $('.faq-question');
		$container.hide();
		$trigger.first().addClass('active').next().show();
		var fullWidth = $container.outerWidth(true);
		$trigger.on('click', function (e) {
			if ($(this).hasClass('active')) {
				$(this).removeClass('active').next().slideUp(500);
			} else {
				$(this).addClass('active').next().slideDown(500);
				jQuery("html, body").animate({ scrollTop: jQuery(this).offset().top - 50 }, 500);
			}

			e.preventDefault();
		});
		/* accordion */

		$('.mobile-menu ul.mega-menu-left').insertAfter('.mobile-menu .mega-menu');
		/* Mega Menu */
		$('.mobile-menu .mega-menu-left > li').each(function (e) {
			var cp_id = '.mobile-menu #' + $(this).children('a').attr('data-show');
			$(cp_id).insertAfter($(this).children('a'));
		});

		$('.mobile-menu .mega-menu-right').attr('class', 'sub-menu');
		$('.mobile-menu .mega-menu-left').attr('class', 'sub-menu');
		$('.mobile-menu .sub-menu').removeAttr('style');
		$('.mobile-menu .nav-menu > ul > li, .mobile-menu .nav-menu > ul > li > ul > li').each(function (e) {
			if ($(this).children('ul').hasClass('sub-menu')) {
				$('<span class="has-subnav"></span>').insertAfter($(this).children('a'));
				if (!$(this).hasClass('menu-children')) {
					$(this).addClass('menu-children');
				}
				$(this).removeAttr('id');
			}
		});
		$('.mobile-menu .mega-menu').remove();
	});

	jQuery('.categories-box').click(function (e) {
		jQuery(this).children('.categories-content').slideToggle();
		jQuery(this).toggleClass('faq-toggle');
	});
	jQuery('.categories-box .categories-content:not(".categories-content a")').click(function (e) {
		e.stopPropagation();
	});

	/* Menu */
	$(".mega-menu .left_mm .mega-menu-left li a").mouseover(function (e) {
		var ids = '#' + $(this).attr('data-show');
		if (ids) {
			$('.right_mm > ul').hide();
			$('#' + $(this).attr('data-show')).fadeIn('1000');
		}
	});

});


// Mobile Navigation
//$(".nav-menu ul > li.menu-children > a").after("<span class='has-subnav'></span>");
$(window).load(function (e) {
	$('body').addClass('js');
	var $menu = $('.mobile-menu .nav-menu'),
		$menulink = $('.menu-link'),
		$menuTrigger = $('.has-subnav');
	$bodyadd = $('body');

	$menulink.click(function (e) {
		e.preventDefault();
		$menulink.toggleClass('active');
		$menu.toggleClass('active');
		$bodyadd.toggleClass('nav-open');
	});

	$menuTrigger.bind('click', function (e) {
		e.preventDefault();
		var $this = $(this);
		$this.toggleClass('active').next('ul').toggleClass('active');
	});
});
// Mobile Navigation

/* Homepage Popup */
$('.content-popup').magnificPopup({
	type: 'inline',
	fixedContentPos: true,
	fixedBgPos: true,
	overflowY: 'auto',
	closeBtnInside: true,
	preloader: false,
	midClick: true,
	mainClass: 'content-popup mfp-fade'
});
/* Homepage Popup */

/* Back to Top */
$('.back-to-top').click(function () {
	$('html, body').animate({
		scrollTop: '0px'
	}, 1000);
});
/* Back to Top */

$('.img-popup').magnificPopup({ type: 'image', removalDelay: 300, mainClass: 'mfp-fade' });

// Popup contact page
$('.contry-popup').magnificPopup({ type: 'inline', removalDelay: 300, mainClass: 'contry-data mfp-fade' });
// Popup contact page

// Popup machines video
jQuery('.popup-machines-video').magnificPopup({
	type: 'inline',
	fixedContentPos: true,
	fixedBgPos: true,
	closeBtnInside: true,
	preloader: false,
	midClick: true,
	removalDelay: 300,
	mainClass: 'video-popup mfp-fade'
});

// Media and Gallery Page Image Popup
$('.gallery-popup-img').magnificPopup({
	type: 'image',
	closeOnContentClick: true,
	removalDelay: 300,
	mainClass: 'gallery-popup-content mfp-fade',
	image: {
		verticalFit: true
	}
});


$("#career").validate({
	rules: {
		entered_captcha: {
			required: true,
			equalTo: "#txtCaptcha"
		},
		email: {
			required: true,
			email: true,
		},
		image: {
			maxsize: 524288,
		},
		resume: {
			maxsize: 5242880,
		},
	},
	messages: {
		entered_captcha: {
			equalTo: "Enter valid Captcha"
		},
		image: {
			maxsize: 'Max file size limit exceeded',
		},
		resume: {
			maxsize: 'Max file size limit exceeded',
		},
	}
});



$("#contact-form").validate({
	rules: {
		name: {
			required: true,
		},
		company_name: {
			required: true,
		},
		email: {
			required: true,
			email: true
		},
		contact_number: {
			required: true,
		},
		state: {
			required: true,
		},
		country: {
			required: true,
		},
		subject: {
			required: true,
		},
		address: {
			required: true,
		}
	}
});



/* machines-btn-box */
$(document).ready(function () {

	function sticktothetop() {
		var window_top = $(window).scrollTop();
		if ($('.machines-btn-box-stick-here').length) {
			var top = $('.machines-btn-box-stick-here').offset().top;
			if (window_top > top) {
				$('.machines-btn-box').addClass('machines-stick');
				$('.machines-btn-box-stick-here').height($('.machines-btn-box').outerHeight());
			} else {
				$('.machines-btn-box').removeClass('machines-stick');
				$('.machines-btn-box-stick-here').height(0);
			}
		}
	}
	$(function () {
		$(window).scroll(sticktothetop);
		sticktothetop();
	});
	// if( typeof basic_choropleth === 'object' && basic_choropleth !== null)
	// {
	//     basic_choropleth.svg.selectAll('path').on('click', function(data) 
	//     { 
	//         console.log(data.id);

	//         //$("[data-code="+data.id+"]").trigger('click');

	//     });
	// }

	$('.end_prd').click(function () {
		//end_product_change();
		console.log("hii1")
		product_filter_change();
	});
	$('.ser_prd').click(function () {
		//machine_series_change();
		product_filter_change();
	});
	// var catID = getUrlParameter('catID');
	// if( catID != '' )
	// {
	//     console.log(catID );
	//     update_product_cat( catID );
	//     update_product_cat_visible( catID );
	// }
});

function update_gallery_all() {
	$(".gallery-gwrap").fadeIn();
}

function update_gallery(year) {
	$(".gallery-gwrap").fadeOut();
	$("[data-year=" + year + "]").fadeIn();
}
function update_product_cat(cid) {
	//console.log(cid);
	$('.cat_link').removeClass('active');
	$('#cat_link_' + cid).addClass('active');

	$(".machine-product-box").fadeOut();
	$("[data-cat=" + cid + "]").fadeIn();
}
function update_product_cat_visible(cid) {
	$('#cat_link_' + cid).css('visibility', 'visible');
}
function end_product_change_1() {
	var favorite = [];
	$.each($(".end_prd:checked"), function () {
		favorite.push($(this).val());
	});
	console.log(favorite.join(","));
}
function machine_series_change_1() {
	var favorite = [];
	$.each($(".ser_prd:checked"), function () {
		favorite.push($(this).val());
	});
	console.log(favorite.join(","));
}
function product_filter_change() {
	var favorite = [];
	$.each($(".end_prd:checked"), function () {
		favorite.push($(this).val());
	});

	var favorite_sr = [];
	$.each($(".ser_prd:checked"), function () {
		favorite_sr.push($(this).val());
	});


	jQuery(".machine-product-box").each(function (index) {
		tmp_array = jQuery(this).attr("data-end-prd").split(",");
		tmp_array_sr = jQuery(this).attr("data-prd-ser").split(",");

		matched = true;
		for (i = 0; i < favorite.length; i++) {
			if (jQuery.inArray(favorite[i], tmp_array) == -1) {
				matched = false;
			}
		}
		for (i = 0; i < favorite_sr.length; i++) {
			if (jQuery.inArray(favorite_sr[i], tmp_array_sr) == -1) {
				matched = false;
			}
		}
		if (matched == true) {
			jQuery(this).show();
		} else {
			jQuery(this).hide();
		}
	});

	//console.log( favorite.join(",") );
}

function end_product_change() {
	var favorite = [];
	$.each($(".end_prd:checked"), function () {
		favorite.push($(this).val());
	});

	jQuery(".machine-product-box").each(function (index) {
		tmp_array = jQuery(this).attr("data-end-prd").split(",");
		matched = true;
		for (i = 0; i < favorite.length; i++) {
			if (jQuery.inArray(favorite[i], tmp_array) == -1) {
				matched = false;
			}
		}
		if (matched == true) {
			jQuery(this).show();
		} else {
			jQuery(this).hide();
		}
	});

	//console.log( favorite.join(",") );
}
function machine_series_change() {
	var favorite = [];
	$.each($(".ser_prd:checked"), function () {
		favorite.push($(this).val());
	});

	jQuery(".machine-product-box").each(function (index) {
		tmp_array = jQuery(this).attr("data-prd-ser").split(",");
		matched = true;
		for (i = 0; i < favorite.length; i++) {
			if (jQuery.inArray(favorite[i], tmp_array) == -1) {
				matched = false;
			}
		}
		if (matched == true) {
			jQuery(this).show();
		} else {
			jQuery(this).hide();
		}
		console.log(matched);
	});

	console.log(favorite.join(","));

}
var getUrlParameter = function getUrlParameter(sParam) {
	var sPageURL = window.location.search.substring(1),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
		}
	}
};

// Heta 2023 06 05
$(document).ready(function () {
	$(document).on('click', '.endProducts-btn', function () {
		var endprodId = $(this).attr('data-endprod-id');

		$('.endProducts-btn').removeClass('active');
		$(this).addClass('active');

		$.ajax({
			url: '/getEndProducts.php?id=' + endprodId,
			type: "GET",
			success: function (response) {
				$('.endProducts').html(response);
				// You will get response from your PHP page (what you echo or print)
			}
		});
	});
});

// Heta 2024 01 23 Popup
$(document).ready(function () {
	//console.log('i am in ready');
	//$(".poup_modal_show .popup_modal-content").fadeIn(1000);
});
$(".poup_modal_show .model-colse").click(function () {
	$(".poup_modal_show .popup_modal-content").css("display", "none");
});