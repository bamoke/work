jQuery(document).ready(function () {

    /*****
     *
     */
    ; (function () {
        var sY = 0;
        $(window).scroll(function () {
            var eY = this.scrollY;
            if (sY > eY && eY > 100) {
                $("#header").css('top', "0");
            } else if (sY < eY && eY > 100) {
                $("#header").css('top', "-100px");
            }
            sY = eY;
        })

        /** */
        $(".m-tab-nav").find("a").click(function () {
            var $contentWrap = $(".m-tab-content")
            var index = $(this).data("index")
            $(".m-tab-nav").find("a").removeClass("current")
            $(this).addClass("current")
            $contentWrap.find(".content-item").hide().eq(index).show();

        })
        /***
         * 
         */
        $("#index-album-wrap").slide(
            {
                effect: "leftLoop",
                mainCell: ".index-album-list",
                autoPlay: true,
                vis: 3,
                prevCell: '.arrow-left-btn',
                nextCell: '.arrow-right-btn'
            })

        /**
         * 
         */
        $("#js-menu-btn").click(function(){
            $(this).toggleClass("menu-on-show")
            $("#menu").fadeToggle("fast");
            $("#js-nav-masker").fadeToggle("fast");
        })

    })();


});


