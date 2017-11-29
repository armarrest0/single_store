<?php if(!defined('IN_APP')) exit('Access Denied');?>
<?php include template(toper,common); ?>
<script type="text/javascript" src="template/default/statics/js/jquery.cookie.js?v=<?php echo HD_VERSION;?>"></script>
<!-- 头部 -->
<div class="header container">
<div class="logo fl">
<span><a href="/"><img src="<?php echo SKIN_PATH;?>statics/images/logo.png" /></a></span>
</div>
<div class="fr">
<span class="text-default login-tips">已注册的会员请 <a class="text-sub" href="<?php echo url('login',array('url_forward'=>$_GET['url_forward']));?>">登录</a></span>
</div>
</div>
<?php
$setting = model('admin/setting','service')->get();
?>
<!-- 登录 -->
<div class="layout border-top">
<div class="container">
<div class="padding-left border-left border-middle border-sub cart-address">注册新会员</div>
</div>
<div class="container padding-big border border-gray-white clearfix">
<div class="double-line reg-list text-default clearfix">
<form action="<?php echo url('register');?>" name="register" method="post">
<div class="list margin-big-top">
<input type="hidden" name="url_forward" value="<?php echo $_GET['url_forward'];?>">
<span class="label">用户名：</span>
<div class="content">
<input class="input radius fl" type="text" name="username" placeholder="请输入您的用户名！" datatype="s2-15" nullmsg="请填写用户名，由3-15个字符组成" errormsg="请填写用户名，由3-15个字符组成" ajaxurl="<?php echo url('ajax_register_check');?>" />
</div>
</div>
<div class="list margin-big-top">
<span class="label">登录密码：</span>
<div class="content">
<input class="input radius fl" type="password" name="password" placeholder="请输入登陆密码" datatype="*" ajaxurl="<?php echo url('ajax_register_check');?>" nullmsg="请输入登陆密码" />
</div>
</div>
<div class="list margin-big-top">
<span class="label">确认密码：</span>
<div class="content">
<input class="input radius fl" type="password" name="pwdconfirm" placeholder="请输入确认密码" datatype="*" nullmsg="请输入确认密码" recheck="password" />
</div>
</div>
                    <?php if(in_array('email',$setting['reg_user_fields'])) { ?>
<div class="list margin-big-top">
<span class="label">邮箱：</span>
<div class="content">
<input class="input radius fl" type="text" name="email" placeholder="请输入您的邮箱地址！" datatype="email" nullmsg="请输入您的电子邮箱" ajaxurl="<?php echo url('ajax_register_check');?>" />
</div>
</div>
                    <?php } ?>
                            <?php if(in_array('phone',$setting['reg_user_fields'])) { ?>
<div class="list margin-big-top">
<span class="label">手机：</span>
<div class="content">
<input class="input radius fl" type="text" name="mobile" placeholder="请输入您的手机号码！" datatype="mobile" ajaxurl="<?php echo url('ajax_register_check');?>" nullmsg="请输入手机号码" />
</div>
</div>
            <?php if($sms_reg){ ?>
<div class="list margin-big-top">
<span class="label">验证码：</span>
<div class="content verify-code">
<input class="input radius" name="vcode" type="text" disabled="disabled" datatype="n" ajaxurl="<?php echo url('ajax_register_vcode_check');?>" nullmsg="请输入验证码"/>
<input class="button bg-sub" type="button" id="sendsms" value="发送验证码" />
</div>
</div>
                                <?php } ?>
                            <?php } ?>
<div class="list">
<span class="label"></span>
<div class="content text-small">
<input class="va-m" type="checkbox" checked/> 同意 <a class="text-main reg-xy" href="javascript:;">《网站服务协议》</a>
</div>
</div>

<?php echo runhook('before_register_btn');?>

<div class="list">
<span class="label"></span>
<div class="content reg-btn">
<input id="popup-submit" class="button bg-sub text-default" type="submit" name="dosubmit" value="注册" />
</div>
</div>
</form>
</div>
</div>
</div>
<div id="xy" class="popup-item">
<textarea class="fl layout textarea padding text-gray border-none" readonly="readonly" style="height:300px;">
<?php echo $setting['reg_agreement']?>
</textarea>
</div>
<!--底部-->
<?php include template(footer,common); ?>
<script type="text/javascript">
var register = $("form[name=register]").Validform({
showAllError:true,
ajaxPost:true,
callback:function(ret) {
if(ret.status == 0) {
$.tips({
icon:'error',
content:ret.message,
callback:function() {
return false;
}
});
}else{
$.tips({
icon:'success',
content:ret.message,
callback:function() {
window.location.href=ret.referer;
}
});
}
}
})

/*仿刷新：检测是否存在cookie*/
if($.cookie("reg_captcha")){
reget($.cookie("reg_captcha"));
}
$("input[name=mobile]").live('blur',function(){
var ajaxurl = $("input[name=vcode]").attr('ajaxurl');
$("input[name=vcode]").attr('ajaxurl',ajaxurl+'&mobile='+$(this).val());
})
$("#sendsms").live("click",function(){
var mobile = $('input[name="mobile"]').val();
var checkurl = "<?php echo url('member/public/ajax_register_check');?>";
$.post(checkurl,{name:'mobile',param:mobile},function(ret){
if(ret.status == 1){
var ajaxurl="<?php echo url('member/public/register_validate');?>";
$.post(ajaxurl,{'mobile':mobile},function(data){
},'json');
$("[name=vcode]").removeAttr("readonly disabled");
reget(60);
}else{
$.tips({
icon:'error',
content:'手机号有误',
callback:function() {}
});
}
},'json');
})
//重新获取验证码
function reget(count){
var mobj = $('input[name="mobile"]');
var btn = $("#sendsms");
var count = count;
var resend = setInterval(function(){
count--;
if (count > 0){
btn.val(count+"秒后重新获取");

mobj.attr('readonly',true);
$.cookie("reg_captcha", count, {path: '/', expires: (1/86400)*count});
}else {
clearInterval(resend);
mobj.removeAttr('disabled readonly');
btn.val("重获验证码").removeAttr('disabled').css({'cursor':'','background':'#046bb3'});
}
}, 1000);

btn.attr('disabled',true).css({'cursor':'not-allowed','background':'#989898'});
}
$(function(){
$(".reg-xy").click(function(){
top.dialog({
title: '用户协议',
content: $("#xy"),
width: 600,
cancelValue: '关闭',
cancel: function(){
}
}).showModal();
})
});
$(".va-m").click(function(){
if($(".va-m").prop("checked")){
$(".reg-btn .button").val("注册").css("background","#1380cb");
$(".reg-btn .button").attr("disabled",false);
}else{
$(".reg-btn .button").val("请同意网站服务协议").css("background","rgb(152, 152, 152)");
$(".reg-btn .button").attr("disabled",true);
}
});
</script>