var campaignPackage = {
    campaign: {
        init: function () {
            Kacana.homepage.applySlideImage();
            if ($.isFunction($.fn.nivoSlider)) {
                $('#homepage-main-slider').nivoSlider({
                    effect: 'fade',
                    slices: 15,
                    boxCols: 8,
                    boxRows: 4,
                    animSpeed: 300,
                    pauseTime: 5000,
                    startSlide: 0,
                    directionNav: true,
                    controlNav: true,
                    controlNavThumbs: false,
                    pauseOnHover: true,
                    manualAdvance: false,
                    prevText: 'Prev',
                    nextText: 'Next',
                    randomStart: false
                });
            }
        },
        detail: {

        },
        index: {

        }
    }
};

$.extend(true, Kacana, campaignPackage);