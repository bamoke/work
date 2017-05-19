// JavaScript Document
require.config({
	baseUrl:"/work/yang/Public/js/",
	paths:{
		jquery:"jquery-1.10.1.min"
	}
})

require(["jquery"],function($) {
	var ajaxLoad={isComplete:true};
	var loginForm=window.document.forms[0];
	var $tipsBox=$(".errorTips")
	var $pInput=$("input[name='password']")
	var $uInput=$("input[name='username']")
	var $vInput=$("input[name='verify']");
	
	var curObj
	var tipsTxt;
	
	$uInput.blur(function(){checkUserName()})


	function checkUserName(){
			var uname=$uInput.val()
			if(uname==""){
				
				tipsTxt="请输入用户名！";
				showTips($uInput,tipsTxt);
				$uInput.focus()
				return false;
			}
			$uInput.removeClass("err")
			hideTips();
			return true;
		}
	
	function checkPw(){
		if($pInput.val() == "") {
			tipsTxt="请输入密码！"
			showTips($pInput,tipsTxt)
		}
		$pInput.removeClass("err")
		return true;
	}	
	
	function showTips(o,txt){
		o.addClass("err")
		$(".tipsTxtBox").text(txt)
		if(!$(".errorTips").hasClass("show")){
			$(".errorTips").slideDown("fast").addClass("show")
		}
	}

	function hideTips(){
		$(".errorTips").slideUp('fast').removeClass('show');
	}
	
	$(loginForm).submit(function(){
		var postUrl=this.action;
		if(!checkUserName()) return false;

		if($vInput.val()=="") {
			showTips($vInput,'请输入验证码')
			return false;
		}
		if(ajaxLoad.isComplete) {
			ajaxLoad.isComplete=false;
			$.ajax({
				url:postUrl,
				type:"post",
				data:$(loginForm).serialize(),
				dataType:"json",
				success:function(result){
					if(result.status) {
						window.location.href=result.jumpUrl
					}else {
						$(".errorTips").slideDown("fast").addClass("show")
						$(".tipsTxtBox").text(result.tips)
					}
				
				},
				complete:function(){ajaxLoad.isComplete=true}
			})
		}
		return false;
		
	})

//	刷新验证码
	$(".verifyImg").click(function(){
		var newSendUrl,sendUrl=this.src;
		if(sendUrl.indexOf("?") > 0){
			sendUrl=sendUrl.replace(/\?.*$/,"");
		}
		newSendUrl =sendUrl+"?r="+Math.floor((Math.random()*1000));
		this.src=newSendUrl;
	})

});