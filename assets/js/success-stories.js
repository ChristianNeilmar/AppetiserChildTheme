jQuery(document).ready(function ($) {
    //wistia
    var wistia = document.querySelectorAll(".wistia");

    for (var i = 0; i < wistia.length; i++) {

        var source = "https://embed-ssl.wistia.com/deliveries/" + wistia[i].dataset.thumb + ".jpg";

        var image = new Image();
        image.src = source;
        image.addEventListener("load", function () {
            wistia[i].appendChild(image);
        }(i));

        wistia[i].addEventListener("click", function () {

            var iframe = document.createElement("iframe");

            iframe.setAttribute("frameborder", "0");
            iframe.setAttribute("allowfullscreen", "");
            iframe.setAttribute("mozallowfullscreen", "");
            iframe.setAttribute("webkitallowfullscreen", "");
            iframe.setAttribute("oallowfullscreen", "");
            iframe.setAttribute("msallowfullscreen", "");
            iframe.setAttribute("src", "//fast.wistia.net/embed/iframe/" + this.dataset.embed + "?videoFoam=true");

            this.innerHTML = "";
            this.appendChild(iframe);
        });
    };

    //Czar
    //console.log('webapp');
    $('.page-id-12412 .gdlr-core-page-builder-body img').addClass('web-appclassx').data('title', $(this).attr('title')).attr('title', '');
    //end	 czar

    //   Set timer for the slide
    var thumbs = $('.desktop-success-wrapper .success-thumb');
    var curcount = thumbs.length;
    var counter = 1;

    // console.log('slide count: ' + curcount);

    if ($(window).width() > 1080) {

        var intervalCount = 4000;
        var sliderInterval = setInterval(changeSlider, intervalCount);

        function changeSlider() {
            $('.success-thumb').removeClass('active');
            $('[data-tab=' + counter + ']').addClass('active');
            $('.success-content').removeClass('active');
            $('[data-content=' + counter + ']').addClass('active');

            counter++;

            if (counter > curcount) {
                counter = 1;
            }

        };

        function stopSlide() {
            clearInterval(sliderInterval);
        };

        function playSlide() {
            sliderInterval = setInterval(changeSlider, intervalCount);
        };

        //   Pause slider on hover
        $('.success-contents, .success-thumb').on('mouseenter', function () {
            stopSlide();
            //       console.log('in');
        });

        //  Play slider on mouseout
        $('.success-contents, .success-thumb').on('mouseleave', function () {
            playSlide();
            //       console.log('out');
        });

    };

    //   Slide click function
    $('[data-tab]').on('click', function (e) {
        $('.success-thumb').removeClass('active');
        $(this).addClass('active');
        $('.success-content').removeClass('active');
        $('.success-contents').find('[data-content=' + $(this).data('tab') + ']').addClass('active');
    });

    //   HERO ARROW SCROLL DOWN FUNCTION
    // The scroll-down function
    function scrollDown() {
        var vheight = $(window).height();
        $('html, body').animate({
            scrollTop: (Math.floor($(window).scrollTop() / vheight) + 1) * vheight - 87
        }, 1500);
    };

    // Click to Scroll DOWN Functions
    $('.hero-arrow').click(function (event) {
        scrollDown();
        event.preventDefault();
    });

    // CLICK AND DRAG SLIDER | for appetiser virtues ABOUT US page
    const sliderxxx = document.querySelector('.virtues .gdlr-core-pbf-wrapper-container');
    let isDown = false;
    let startX;
    let scrollLeft;

    if (sliderxxx) {
        sliderxxx.addEventListener('mousedown', (e) => {
            isDown = true;
            sliderxxx.classList.add('active');
            startX = e.pageX - sliderxxx.offsetLeft;
            scrollLeft = sliderxxx.scrollLeft;
        });

        sliderxxx.addEventListener('mouseleave', () => {
            isDown = false;
            sliderxxx.classList.remove('active');
        });

        sliderxxx.addEventListener('mouseup', () => {
            isDown = false;
            sliderxxx.classList.remove('active');
        });

        sliderxxx.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();

            const x = e.pageX - sliderxxx.offsetLeft;
            const walk = (x - startX) * 1.5;

            sliderxxx.scrollLeft = scrollLeft - walk;

        });
    }
});
