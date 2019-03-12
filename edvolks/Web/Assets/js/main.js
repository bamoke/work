//Javascript
$(".navigation-btn").click(function(){
    var liNum = $(".m-nav").find("li").size();
    var delay = 120;
    if($("#js-head").hasClass('fixed')){
        $(".m-nav").find("li").each(function(index){
            this.style.marginRight="0";
            this.style.opacity='0';
            this.style.transitionDelay= (liNum - index-1)*delay + "ms";
        })
        setTimeout(function(){
            $(".m-nav").hide();
            $("#js-head").removeClass("fixed").find(".nav-masker").hide();
        },(liNum*delay+200))
    }else {
        
        $(".m-nav").show();
        $("#js-head").addClass("fixed").find(".nav-masker").show();
        $(".m-nav").find("li").each(function(index){
            this.style.marginRight="12px";
            this.style.opacity=1;
            this.style.transitionDelay= (index)*delay + "ms";
        })
    }

});