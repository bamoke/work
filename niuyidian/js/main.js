// Javascript
/***banner */
var swiper = new Swiper('#js-swiper-banner',{
	autoplay: 2500,
});
/**切换导航 */
$("#js-cate-btn").click(function(){
    $(this).toggleClass("cate-active")
    $("#js-cate-content").toggle()
})



/***tab 切换 */
function showTab(i) {
    const tabBtn = $("#js-switch-tab").find(".item")
    const tabContent = $(".js-tab-content")
    $.each(tabBtn,function(index,item){
        if(i==index) {
            $(item).addClass("active")
            $(tabContent[index]).show()
        }else {
            $(item).removeClass("active")
            $(tabContent[index]).hide()
        }
    })
}

function switchTab(tab,content,i) {
    const tabBtn = $(tab).find(".item")
    const tabContent = $(content).find(".js-tab-content")
    console.log(tabContent)
    $.each(tabBtn,function(index,item){
        if(i==index) {
            $(item).addClass("active")
            $(tabContent[index]).show()
        }else {
            $(item).removeClass("active")
            $(tabContent[index]).hide()
        }
    })
}
/**弹出登录框 */
$("#js-login-btn").click(function(){
    $("#js-login-box").toggle();
})
/**关闭登录弹出框 */
$("#js-close-login-btn").click(function(){
    $("#js-login-box").hide();
})

/**检测评论表单 */
function checkCommentForm(e){
    var value = window.document.getElementById("js-comment-content").value
    if (value.trim() === '') {
        return false
    }
}

/**检测password表单** */
function checkPasswordForm(e){
    const oldValue = window.document.getElementById("js-old-password").value
    const newValue = window.document.getElementById("js-new-password").value
    const newValue1 = window.document.getElementById("js-new-password-1").value
    if(oldValue.trim() == '') {
        alert("请输入原密码")
        return false;
    }
    if(newValue.trim() == '') {
        alert("请输入新密码")
        return false;
    }
    if(newValue1.trim() == '') {
        alert("请确认新密码")
        return false;
    }
    if(newValue1 != newValue) {
        alert("两次密码不一致")
        return false;
    }
}

/***上传头像 */
if(document.getElementById("js-avatar-input")){
    const fileInput = document.getElementById("js-avatar-input");
    const previewImg = document.getElementById("js-avatar-preview")
    const uploadBtn = document.getElementById("js-avatar-upload-btn")
    fileInput.onchange = function(){
        const fileName = this.value
        if(!/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(fileName))
        {
          alert("图片类型必须是.gif,jpeg,jpg,png中的一种")
          return false;
        }
        var file = this.files[0];
        var reader = new FileReader(file);
        reader.readAsDataURL(file);
        reader.onload=function(event){
            console.log(event)
            previewImg.src = event.target.result
            uploadBtn.style.display="block"
        }
    }

}