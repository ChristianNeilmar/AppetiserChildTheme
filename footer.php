<?php

/**
 * The template for displaying the footer 
 */

$post_option = infinite_get_post_option(get_the_ID());
if (empty($post_option['enable-footer']) || $post_option['enable-footer'] == 'default') {
	$enable_footer = infinite_get_option('general', 'enable-footer', 'enable');
} else {
	$enable_footer = $post_option['enable-footer'];
}
if (empty($post_option['enable-copyright']) || $post_option['enable-copyright'] == 'default') {
	$enable_copyright = infinite_get_option('general', 'enable-copyright', 'enable');
} else {
	$enable_copyright = $post_option['enable-footer'];
}

$fixed_footer = infinite_get_option('general', 'fixed-footer', 'disable');
echo '</div>'; // infinite-page-wrapper

if ($enable_footer == 'enable' || $enable_copyright == 'enable') {

	if ($fixed_footer == 'enable') {
		echo '</div>'; // infinite-body-wrapper

		echo '<footer class="infinite-fixed-footer" id="infinite-fixed-footer" >';
	} else {
		echo '<footer>';
	}

	if ($enable_footer == 'enable') {

		echo '<div class="infinite-footer-wrapper" >';
		echo '<div class="infinite-footer-container infinite-container clearfix" >';

		$infinite_footer_layout = array(
			'footer-1' => array('infinite-column-60'),
			'footer-2' => array('infinite-column-15', 'infinite-column-15', 'infinite-column-15', 'infinite-column-15'),
			'footer-3' => array('infinite-column-15', 'infinite-column-15', 'infinite-column-30',),
			'footer-4' => array('infinite-column-20', 'infinite-column-20', 'infinite-column-20'),
			'footer-5' => array('infinite-column-20', 'infinite-column-40'),
			'footer-6' => array('infinite-column-40', 'infinite-column-20'),
		);

		$count = 0;
		$footer_style = infinite_get_option('general', 'footer-style');
		$footer_style = empty($footer_style) ? 'footer-2' : $footer_style;
		foreach ($infinite_footer_layout[$footer_style] as $layout) {
			$count++;
			echo '<div class="infinite-footer-column infinite-item-pdlr ' . esc_attr($layout) . '" >';
			if (is_active_sidebar('footer-' . $count)) {
				dynamic_sidebar('footer-' . $count);
			}
			echo '</div>';
		}

		echo '</div>'; // infinite-footer-container
		echo '</div>'; // infinite-footer-wrapper 

	} // enable footer

	if ($enable_copyright == 'enable') {
		$copyright_style = infinite_get_option('general', 'copyright-style', 'center');

		if ($copyright_style == 'center') {
			$copyright_text = infinite_get_option('general', 'copyright-text');

			if (!empty($copyright_text)) {
				echo '<div class="infinite-copyright-wrapper" >';
				echo '<div class="infinite-copyright-container infinite-container">';
				echo '<div class="infinite-copyright-text infinite-item-pdlr">';
				echo gdlr_core_escape_content(gdlr_core_text_filter($copyright_text));
				echo '</div>';
				echo '</div>';
				echo '</div>'; // infinite-copyright-wrapper
			}
		} else if ($copyright_style == 'left-right') {
			$copyright_left = infinite_get_option('general', 'copyright-left');
			$copyright_right = infinite_get_option('general', 'copyright-right');

			if (!empty($copyright_left) || !empty($copyright_right)) {
				echo '<div class="infinite-copyright-wrapper" >';
				echo '<div class="infinite-copyright-container infinite-container clearfix">';
				if (!empty($copyright_left)) {
					echo '<div class="infinite-copyright-left infinite-item-pdlr">';
					echo gdlr_core_escape_content(gdlr_core_text_filter($copyright_left));
					echo '</div>';
				}

				if (!empty($copyright_right)) {
					echo '<div class="infinite-copyright-right infinite-item-pdlr">';
					echo gdlr_core_escape_content(gdlr_core_text_filter($copyright_right));
					echo '</div>';
				}
				echo '</div>';
				echo '</div>'; // infinite-copyright-wrapper
			}
		}
	}

	echo '</footer>';

	if ($fixed_footer == 'disable') {
		echo '</div>'; // infinite-body-wrapper
	}
	echo '</div>'; // infinite-body-outer-wrapper

	// disable footer	
} else {
	echo '</div>'; // infinite-body-wrapper
	echo '</div>'; // infinite-body-outer-wrapper
}

$header_style = infinite_get_option('general', 'header-style', 'plain');

if ($header_style == 'side' || $header_style == 'side-toggle') {
	echo '</div>'; // infinite-header-side-nav-content
}

$back_to_top = infinite_get_option('general', 'enable-back-to-top', 'disable');
if ($back_to_top == 'enable') {
	echo '<a href="#infinite-top-anchor" class="infinite-footer-back-to-top-button" id="infinite-footer-back-to-top-button"><i class="fa fa-angle-up" ></i></a>';
}
?>



<?php wp_footer();

//  country code 
//$ip =  $_SERVER['REMOTE_ADDR'];
//$ip_info = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));  
//$url = "http://www.geoplugin.net/json.gp?ip=".$ip;
//if($ip_info && $ip_info->geoplugin_countryName != null){
//		$country_fetch = $ip_info->geoplugin_countryName;

//}	
//


//$referrer = $_SERVER['referrer'] ? 'organic' : 'direct';

$referrer = '';



?>









<script>
	(function($) {
		$(document).ready(function() {
			$(" .page-id-24624 .infinite-logo-inner img , .darkmode.dark-header .infinite-logo-inner img").attr("src", "https://appetiser.com.au/wp-content/uploads/2024/07/Appetiser-Logo_Light1_5x.webp");
			$(".infinite-logo-inner a , .infinite-logo-inner>a").attr("href", "https://appetiser.com.au/just-build-it/");

			var refferr = "<?php echo $referrer; ?>";
			//console.log('referrr >> ' + document.referrer);	
			window.addEventListener('message', event => {

				if (event.data.type === 'hsFormCallback' && event.data.eventName === 'onFormReady') {
					$.getJSON("https://ip.guide/",
						function(data) {
							var city = data.city;
							var loc = data.loc;
							var ip = data.ip;

							$('input[name="detected_country"]').val(data.network.autonomous_system.country);
							$('input[name="city"]').val(data.location.city);
							$('input[name="referer"]').val(document.referrer);
							console.log('ipguide');
						});

				}

			});

			function refresh_country() {
				// $('input[name="detected_country"]').val(country);   
			}
			setInterval(refresh_country, 2000);




		});











	})(jQuery);
</script>



<!-- home 2023 -->
<?php if (is_page(21772)) {
?>

<?php
} ?>

<?php if (is_page(18221)) {
?>



	<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/ScrollTrigger.min.js"></script>

	<script src="https://scrollmagic.io/assets/js/lib/greensock/TweenMax.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/jquery.ScrollMagic.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js"></script>


	<script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/debug.addIndicators.min.js"></script>

	<script>
		(function($) {



			$('.rad-vod-anim').append('<div class="vimoverlay"></div><style>.vp-unmute{display:none !important;}</style>');

			$('#bannervid').prop('playsinline', true);


			$("iframe").contents().find(".vp-controls-wrapper").addClass("taphide");
			$("iframe").contents().find(".vp-controls-wrapper").attr("style", "width:100%;height:100%;display:none!important;")
			if ($(window).width() < 767) {
				// do whatever
				//console.log('MOBILEEEEEEEEEEEE');
				$('iframe').prop('allowfullscreen', true);
				$("iframe").contents().find(".vp-controls-wrapper").remove();
				$("iframe").each(function() {
					$(this).attr("src", $(this).attr("src").replace("muted=0?background=1", "muted=1"));
				});
			}

			// init controller
			var vcontroller = new ScrollMagic.Controller();
			var bannervid = document.getElementById('bannervid');
			var slides = document.querySelectorAll(".vpin");
			var vpin = new ScrollMagic.Controller();
			var breakpoint = $(document).width();
			// build scene
			var vpd, voff, vth;
			vth = 0;
			if (breakpoint <= 3440) {
				vpd = "145%";
				voff = -200;
				vth = .1;
			}
			if (breakpoint <= 2560) {
				vth = 0;
				vpd = "145%";
				voff = slides.clientHeight - window.innerHeight;
				vth = .2;
			}
			if (breakpoint <= 1920) {
				vpd = "170%";

				voff = slides.clientHeight - window.innerHeight;
			}
			if (breakpoint <= 1366) {
				vpd = "138%";
			}
			if (breakpoint <= 1024) {
				vpd = "185%";
				vth = .3;
				voff = slides.clientHeight - window.innerHeight;
			}

			if (breakpoint <= 1024) {
				vpd = "140	%";
				vth = .3;
				voff = slides.clientHeight - window.innerHeight;
			}

			if (breakpoint <= 600) {
				vpd = "130%";
				vth = .3;
				voff = slides.clientHeight - window.innerHeight;
			}


			var scene = new ScrollMagic.Scene({
					triggerElement: "body",
					duration: 100,
					offset: 100
				})
				.addTo(vcontroller)
				//.addIndicators() // add indicators (requires plugin)

				.on("enter", function() {
					//console.log('trigger play');
					bannervid.play();
				})
				.on("leave", function() {
					//console.log('trigger pause');
					//	bannervid.pause();
				});
			//video pin
			// 
			const init = () => {
				slides.forEach((slide, i) => {
					new ScrollMagic.Scene({
							triggerElement: slide,
							triggerHook: vth,
							duration: vpd,
							offset: voff
						})
						.setPin(slide, {
							pushFollowers: false
						})
						//.addIndicators()
						.on('start', function(event) {
							$(slide).addClass('vid-opacity');
						})
						.addTo(vpin);
					//.setClassToggle(slide, "vid-opacity")
					var offsetneto = slide.clientHeight - window.innerHeight;

					//console.log($(window).width()+" >> "+breakpoint + " " + offsetneto + " >> "+voff);
				});
				//console.log('normal desktop');


			};

			$(window).bind('scroll', function() {
				if ($(this).scrollTop() < 10) { // show after 200 px of user scrolling
					//bannervid.play();
					$('.vpin').removeClass('vid-opacity');
				}
			});


			//console.log(vpd);
			init();
			//

			//LTR
			// init controller
			var ltr = new ScrollMagic.Controller();

			if ($(window).width() < 767) {
				// do whatever
				// build scenes
				var revealElements = document.getElementsByClassName("ltr");
				for (var i = 0; i < revealElements.length; i++) { // create a scene for each element

					new ScrollMagic.Scene({
							triggerElement: revealElements[i], // y value not modified, so we can use element as trigger as well
							offset: 100, // start a little later
							triggerHook: 0.9,
						})
						.setClassToggle(revealElements[i], "visible") // add class toggle
						//	.addIndicators({name: "ltr " + (i+1) }) // add indicators (requires plugin)
						.addTo(ltr);
				}

			} else {
				// build scenes
				var revealElements = document.getElementsByClassName("ltr");
				for (var i = 0; i < revealElements.length; i++) { // create a scene for each element

					new ScrollMagic.Scene({
							triggerElement: revealElements[i], // y value not modified, so we can use element as trigger as well
							offset: 100, // start a little later
							triggerHook: 0.7,
						})
						.setClassToggle(revealElements[i], "visible") // add class toggle
						//.addIndicators({name: "ltr " + (i+1) }) // add indicators (requires plugin)
						.addTo(ltr);
				}
			}

			//



			//RTL
			// init controller
			var rtl = new ScrollMagic.Controller();


			if ($(window).width() < 767) {
				// build scenes
				var revealElements = document.getElementsByClassName("rtl");
				for (var i = 0; i < revealElements.length; i++) { // create a scene for each element
					new ScrollMagic.Scene({
							triggerElement: revealElements[i], // y value not modified, so we can use element as trigger as well
							offset: 100, // start a little later
							triggerHook: 0.9,
						})
						.setClassToggle(revealElements[i], "visible2") // add class toggle
						//		.addIndicators({name: "rtl " + (i+1) }) // add indicators (requires plugin)
						.addTo(rtl);
				}
			} else {
				// build scenes
				var revealElements = document.getElementsByClassName("rtl");
				for (var i = 0; i < revealElements.length; i++) { // create a scene for each element
					new ScrollMagic.Scene({
							triggerElement: revealElements[i], // y value not modified, so we can use element as trigger as well
							offset: 100, // start a little later
							triggerHook: 0.7,
						})
						.setClassToggle(revealElements[i], "visible2") // add class toggle
						//.addIndicators({name: "rtl " + (i+1) }) // add indicators (requires plugin)
						.addTo(rtl);
				}
			}

			//




			//fade in out animation
			//console.log('trigger animation fade in out');
			var sections = gsap.utils.toArray(".miles-section .title-container");
			sections.forEach((elem, i) => {
				var trigger = elem.querySelector(".title-fade");
				var headlines = elem.querySelectorAll("*");
				const tl = gsap.timeline({

					scrollTrigger: {
						trigger: trigger,
						start: "+=100 100%",
						end: "+=100 0%",
						scrub: true,
						//   markers: true,
						triggerHook: .5,
						toggleActions: "play reverse play reverse",
					}

				});


				tl
					.to(headlines, {
						opacity: 1,
						duration: 1,
						stagger: 0.1
					})
					.to(headlines, {
						opacity: .7,
						duration: 1,
						stagger: 0.1
					}, 1);


			});



			//testimonial fade
			var controllerxxx = new ScrollMagic.Controller();
			var revealElements = document.getElementsByClassName("testimonial-fade");
			for (var i = 0; i < revealElements.length; i++) { // create a scene for each element
				new ScrollMagic.Scene({
						triggerElement: revealElements[i], // y value not modified, so we can use element as trigger as well
						offset: 0, // start a little later
						triggerHook: 0.8,
					})
					.setClassToggle(revealElements[i], "visible") // add class toggle
					//	.addIndicators({name: "testimonial-fade " + (i+1) }) // add indicators (requires plugin)
					.addTo(controllerxxx);
			}



			//$(".infinite-logo-inner img ").attr("src","/wp-content/uploads/2023/12/Appetiser-Logo_Light.webp"); //logo
			//https://appetiser.com.au/wp-content/uploads/2024/06/Appetiser-Logo_Light1_5x.webp

			$(".infinite-logo-inner img ").attr("src", "https://appetiser.com.au/wp-content/uploads/2024/06/Appetiser-Logo_Light1_5x.webp"); //logo

			$(".infinite-logo-inner a").attr("href", "https://appetiser.com.au/just-build-it/");



			$(document).ready(function() {
				// Get media - with autoplay disabled (audio or video)
				var media = $('.vello-vid video').not("[autoplay='autoplay']");
				var tolerancePixel = 20;

				function checkMedia() {
					// Get current browser top and bottom
					var scrollTop = $(window).scrollTop() + tolerancePixel;
					var scrollBottom = $(window).scrollTop() + $(window).height() - tolerancePixel;

					media.each(function(index, el) {
						var yTopMedia = $(this).offset().top;
						var yBottomMedia = $(this).height() + yTopMedia;

						if (scrollTop < yBottomMedia && scrollBottom > yTopMedia) { //view explaination in `In brief` section above
							$(this).get(0).play();
						} else {
							$(this).get(0).pause();
						}
					});

					//}
				}
				$(document).on('scroll', checkMedia);
				//
			});
		})(jQuery);
	</script>
<?php
} ?>
<!-- end home 2023 -->


<?php
if ((is_single() && get_post_type() != 'portfolio' && get_post_type() != 'location') || is_page([15362, 8071, 21891])) {
?>
	<script>
		jQuery(document).ready(function($) {
			$('.menu-item-2371>a').attr('href', '/contact-us/');
		});
	</script>
<?php
}
?>


<?php
if (is_single(16346)) {
	/* US */
?>
	<!-- <script async
		  type="text/javascript"
		  src="<?php echo esc_url(get_stylesheet_directory_uri() . '/asset/jquery.mask.min.js'); ?>">
		</script>	 -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<?php
} else {
	/* Anywhere but US */
}
?>

<script>
	//Function to get the Google Client ID
	function getClientId2() {
		try {
			var trackers = ga.getAll();
			var i, len;
			for (i = 0, len = trackers.length; i < len; i += 1) {
				if (trackers[i].get('trackingId') === "UA-88663511-2") {
					////console.log("CID:> "+trackers[i].get('clientId'));
					return trackers[i].get('clientId');
				}
			}
		} catch (e) {}
		return '';
	}

	function getClientId() {
		try {
			var e,
				t,
				n = ga.getAll();
			for (e = 0, t = n.length; e < t; e += 1)
				if ("UA-88663511-2" === n[e].get("trackingId")) return console.log("m"), n[e].get("clientId");

		} catch (e) {}
		try {
			if (((clientId = ga.getAll()[0].get("clientId")), clientId)) return console.log("s"), clientId;
		} catch (e) {}
		try {
			if (((clientId = getCookieValue()), clientId)) return console.log("c"), clientId;
		} catch (e) {}
		return "";
	}

	function getCookieValue() {
		var e = document.cookie.match("(^|;)\\s*_ga\\s*=\\s*([^;]+)"),
			t = e ? e.pop() : "",
			n = "";
		if (t) {
			var o = t.split(".");
			o[2] & o[3] && (n = o[2] + "." + o[3]);
		}
		return n;
	}


	function getParameterByName(name, href) {
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regexS = "[\\?&]" + name + "=([^&#]*)";
		var regex = new RegExp(regexS);
		var results = regex.exec(href);
		if (results == null) {
			return "";
		} else {
			return decodeURIComponent(results[1].replace(/\+/g, " "));
		}



	}

	//---------------------------
	function IDGenerator() {
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!
		var yyyy = today.getFullYear();

		var hrs = today.getHours();
		var mins = today.getMinutes();
		var secs = today.getSeconds();

		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		if (hrs < 10) {
			hrs = '0' + hrs;
		}
		if (mins < 10) {
			mins = '0' + mins;
		}
		if (secs < 10) {
			secs = '0' + secs;
		}

		return dd.toString() + mm.toString() + yyyy.toString() + hrs.toString() + mins.toString() + secs.toString();

	}
	var idg = IDGenerator();
	////console.log("IDG> "+idg);

	//function for assigning new session id to contact form
	function assign_sessionid(form_wrapper) {
		var form_sel = form_wrapper + ' form ';
		var session_field = form_wrapper + ' form  input[name="utm_session_id"]';
		var utm_session_id = IDGenerator();
		jQuery(session_field).val('sessionID_' + utm_session_id);
		jQuery(form_sel).trigger('submit');
	}


	function gtm_populate_init() {
		var url = window.location.href;
		jQuery('input#utm_source').val(getParameterByName("utm_source", url));

		//console.log(getParameterByName("utm_source", url));

		jQuery('input#utm_medium').val(getParameterByName("utm_medium", url));
		jQuery('input#utm_content').val(getParameterByName("utm_content", url));
		jQuery('input#utm_campaign').val(getParameterByName("utm_campaign", url));
		jQuery('input#utm_term').val(getParameterByName("utm_term", url));

		jQuery('input[name="utm_session_id"]').each(function() {
			var utm_session_id = IDGenerator();
			jQuery(this).val('sessionID_' + utm_session_id);
		});

	}


	//---------------------------	 
	jQuery(document).ready(function() {

		setTimeout(gtm_populate_init, 2000);
		jQuery('#wpcf7-f3151-p2039-o1  form').attr('id', 'case-study');
		jQuery('#wpcf7-f1319-p2039-o2  form').attr('id', 'contact-us');
	}); //end jQuery(document).ready(function()


	//animate scroll down  hero
	jQuery(document).ready(function() {
		//animate scroll down  hero
		jQuery("#hero-down-arrow-wrapper  .gdlr-core-icon-item-icon").click(function(e) {
			e.preventDefault();
			var aid = '#post-grid-wrapper';
			jQuery('html,body').animate({
				scrollTop: jQuery(aid).offset().top
			}, 'slow');
		});
	}); //end jQuery(document).ready(function()  

	<?php
	if (is_page(11492)) {
	?>

		//for Test PAGE only
	<?php
	} else {
	?>



		/*
		function setformfield(e) {
			window.jQuery ? jQuery.noConflict()('input[name="google_client_id"]').val(e).change() : (document.querySelector("input[name='google_client_id']").value = e);
		}
		window.onload = function () {
			//console.log('working');
			setformfield(getClientId());	
			var clientId = getClientId();
			////console.log('CID>>>'+ clientId);
			try {
				ga(function (e) {
					var t = e.get("clientId");
					//console.log("a"), setformfield(t);
					
				});
			} catch (e) {}
		};
		*/
	<?php
	}




	?>






	jQuery(document).ready(function() {







		var linkinvalue = jQuery('.single-portfolio a.gdlr-core-social-network-icon:last-child').attr('href');
		if (linkinvalue = "https://www.linkedin.com/company/appetiser-pty-ltd") {
			jQuery('.single-portfolio a.gdlr-core-social-network-icon:last-child').attr('href', "https://www.linkedin.com/company/appetiserapps/");
			//	//console.log("LI VAL "+linkinvalue);
		}


		function refresh_cid() {
			var clientId = getClientId();
			var clientId2 = getClientId2();
			////console.log(clientId+"   CID test");
			var count = 0;
			jQuery('input[name="google_client_id"]').each(function() {
				////console.log('GCID');
				count = count + 1;
				jQuery(this).val(clientId);
				if (jQuery(this).val() != "") {
					////console.log('has value');
				} else {
					////console.log('no value changing');
					jQuery(this).val(clientId);

				}
			});

		}

		setInterval(refresh_cid, 2000);

		<?php
		if (is_single(16346)) {
			/* US */
		?>
			setTimeout(
				function() {
					//console.log('US');	
					jQuery('.postid-16346 #app-contact-form .hs-phone input').mask('(000) 0000-0000').intlTelInput({
						autoHideDialCode: true,
						autoPlaceholder: "ON",
						// dropdownContainer: document.body,
						formatOnDisplay: true,
						hiddenInput: "full_number",
						// initialCountry: "auto",
						// nationalMode: true,
						// placeholderNumberType: "MOBILE",
						// preferredCountries: ['US'],
						separateDialCode: true
					}).css("width", "100%");
					--
				},
				5000
			);

		<?php

		} else {
			/* Anywhere but US */
		}
		?>

	});;
</script>
<script src="https://cdn.jsdelivr.net/gh/gkogan/sup-save-url-parameters/sup.min.js"></script>

</body>

</html>