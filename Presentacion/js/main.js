var w;
var h;

checkSize = function () {
	w = $(window).width();
	h = $(window).height();
	if ($(".wrap-image").length > 0) {
		$(".wrap-image").each(function () {
			$(this).css({
				"width": w + "px",
				"height": h + "px"
			});
		});
	}
}


$(document).ready(function () {
	// load anchor from DOM
	var anchors = [];
	$('.section[data-anchor]').each(function () {
		anchors.push($(this).attr('data-anchor'));
	});
	$('#fullpage').fullpage({
		anchors: anchors,
		verticalCentered: true,
		resize: false,
		scrollOverflow: true,
		afterLoad: function (anchorLink, index) {
            $('.arrow-up').hide();
            
			// if active section has the menu hide toggle button & arrows.
			if ($('.section[data-anchor=' + anchorLink + '] #cierre').length > 0) {
				$(".btn-menu").hide();
				$('.arrow-down').hide();
				$('.arrow-up').hide();
			} else {
				$(".btn-menu").show();
				if ($(window).width() > 320) {
					$('.arrow-down').show();
					$('.arrow-up').show();
				}
			}
            
            if ($('.section[data-anchor=' + anchorLink + ']#intro').length > 0) {
                $('.arrow-up').hide();
            }
            if ($('.section[data-anchor=' + anchorLink + ']#cierre').length > 0) {
                $('.arrow-down').hide();
            }

			// if section has chart call function renderChart deffined at chars-def.js
			if ($('.section[data-anchor=' + anchorLink + '] .project-info').length > 0) {
				$.fn.fullpage.moveTo(index, 0);
			}

			// if section has chart call function renderChart deffined at chars-def.js
			if ($('.section[data-anchor=' + anchorLink + '] .wrap-chart').length > 0) {
				renderChart(anchorLink);
			}

			// hide prev / next arroe after change page
			$('.fp-controlArrow.fp-prev').hide();
			$('.fp-controlArrow.fp-next').show();

		},
		afterRender: function () {
			// Checking Section Sizes to inherit to the image wrapper
			checkSize();
			
			if ($('#loading').is(':visible'))
				$('#loading').hide();

		},
		afterResize: function () {
			checkSize();
		},
		afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex) {
			// show slide arrows when show a slide of a project, hide the arrows when show project info.
			if (slideIndex > 0) {
				$('.fp-controlArrow.fp-prev').show();
				$('.fp-controlArrow.fp-next').show();
			} else {
				$('.fp-controlArrow.fp-prev').hide();
				$('.fp-controlArrow.fp-next').show();
			}
		}

	});

	$('.arrow-up').click(function () {
		$.fn.fullpage.moveSectionUp();
	});


	$('.arrow-down').click(function () {
		$.fn.fullpage.moveSectionDown();
	});

	$('.learn-more').click(function() {
		$.fn.fullpage.moveSlideRight();
	});
    
    $('.arrow-up').hide();
    
    window.addEventListener('load', function() {
		new FastClick(document.body);
    })
	
});

// Detect enter keypress to launc site if the link is exist.
$(document).keypress(function (e) {
	if (e.which == 13) {
		if ($('.section.active .slide.active .launch-site').length > 0) {
			var href = $('.section.active .slide.active .launch-site').attr('href');
			window.open(href);
		}
	}
});