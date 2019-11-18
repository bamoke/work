jQuery(document).ready(function(){

    /*****
     *
     */
    ;(function(){
        var sY = 0;
        $(window).scroll(function(){
            var eY = this.scrollY;
            if(sY > eY && eY > 100) {
                $("#header").css('top',"0");
            }else if(sY < eY && eY >100 ) {
                $("#header").css('top',"-100px");
            }
            sY = eY;
        })

        /** */
        $(".m-tab-nav").find("a").click(function(){
            var $contentWrap = $(".m-tab-content")
            var index=$(this).data("index")
            $(".m-tab-nav").find("a").removeClass("current")
            $(this).addClass("current")
            $contentWrap.find(".content-item").hide().eq(index).show();
            
        })
    })();

		
});


 