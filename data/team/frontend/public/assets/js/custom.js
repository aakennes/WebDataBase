(function ($) {
	"use strict";
  
	// 初始化 Owl Carousel
	$('.owl-men-item, .owl-women-item, .owl-kid-item').each(function () {
	  if ($(this).length) {
		$(this).owlCarousel({
		  items: 5,
		  loop: true,
		  dots: true,
		  nav: true,
		  margin: 30,
		  responsive: {
			0: { items: 1 },
			600: { items: 2 },
			1000: { items: 3 },
		  },
		});
	  }
	});
  
	// 滚动事件监听，动态添加类名
	$(window).scroll(function () {
	  var scroll = $(window).scrollTop();
	  var box = $('#top').length ? $('#top').height() : 0;
	  var header = $('header').length ? $('header').height() : 0;
  
	  if (scroll >= box - header) {
		$("header").addClass("background-header");
	  } else {
		$("header").removeClass("background-header");
	  }
	});
  
	// 平滑滚动到目标位置
	$('.scroll-to-section a[href*=\\#]:not([href=\\#])').on('click', function (e) {
	  var target = $(this.hash);
  
	  // 检查目标是否存在
	  if (target.length) {
		e.preventDefault();
		var width = $(window).width();
		if (width < 991) {
		  $('.menu-trigger').removeClass('active');
		  $('.header-area .nav').slideUp(200);
		}
		$('html,body').animate(
		  {
			scrollTop: target.offset().top - 80,
		  },
		  700
		);
	  }
	});
  
	//增加try-catch，防止错误导致程序中断
	function onScroll(event) {
		var scrollPos = $(document).scrollTop();
		$('.nav a').each(function () {
			var currLink = $(this);
			var href = currLink.attr("href");
	
			// 跳过无效的 href
			if (!href || href === "#" || href.startsWith("javascript:")) {
				return;
			}
	
			try {
				var refElement = $(href); // 尝试选择目标元素
				if (refElement.length && refElement.position()) {
					if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
						$('.nav ul li a').removeClass("active");
						currLink.addClass("active");
					} else {
						currLink.removeClass("active");
					}
				}
			} catch (error) {
				console.warn("Invalid href detected:", href, error);
			}
		});
	}
	
  
	// 页面加载动画
	$(window).on('load', function () {
	  if ($('.cover').length) {
		$('.cover').parallax({
		  imageSrc: $('.cover').data('image'),
		  zIndex: '1',
		});
	  }
  
	  $("#preloader").animate(
		{
		  opacity: '0',
		},
		600,
		function () {
		  setTimeout(function () {
			$("#preloader").css("visibility", "hidden").fadeOut();
		  }, 300);
		}
	  );
	});
  
	// 调整窗口大小时修复导航
	$(window).on('resize', function () {
	  mobileNav();
	});
  
	function mobileNav() {
	  var width = $(window).width();
	  $('.submenu').on('click', function () {
		if (width < 767) {
		  $('.submenu ul').removeClass('active');
		  $(this).find('ul').toggleClass('active');
		}
	  });
	}
  
	// 初始化滚动事件监听器
	$(document).ready(function () {
	  $(document).on("scroll", onScroll);
	});
  })(window.jQuery);
  