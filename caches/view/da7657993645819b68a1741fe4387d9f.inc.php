<?php if(!defined('IN_APP')) exit('Access Denied');?>
<?php include template(header,member); ?>
<div class="margin-big-top layout">
<div class="container border border-gray-white member clearfix">
<div class="left padding-big">
<div class="user-head margin-big-left margin-big-top">
<img src="<?php echo $member['avatar'];?>" height="148" />
<span><a href="<?php echo url('member/account/avatar');?>">修改头像</a></span>
</div>
<div class="margin-top text-center text-default"><p><?php echo $member['_group']['name'] ?></p></div>
<dl class="margin-big-top member-memu clearfix">
<?php include template(menu_account,member); ?>
</dl>
</div>
<div class="right padding-big-left padding-big-right">
<div class="margin-big-top">
<label class="obtn obtn1" for="file-avatar" id="file-avatar">上传头像</label>
<span class="margin-big-left">如果您还没有设置自己的头像，系统会显示为默认头像，您需要自己上传一张新照片来作为自己的个人头像</span>
</div>

<div class="margin-big-top avatar clearfix">
<div class="fl avatar-box avatar-1 border">
<div id="avatar">
<img src="<?php echo __ROOT__;?>uploadfile/avatar/default.png" id="avatar_pic" />
</div>
</div>
<div class="avatar-other clearfix">
<div class="fl avatar-box avatar-2 border">
<img id="avatar-2" src="<?php echo __ROOT__;?>uploadfile/avatar/default.png" width="198" height="198" />
</div>
<div class="fl avatar-box avatar-3 border">
<img id="avatar-3" src="<?php echo __ROOT__;?>uploadfile/avatar/default.png" width="78" height="78" />
</div>
<div class="fl avatar-box avatar-4 border">
<img id="avatar-4" src="<?php echo __ROOT__;?>uploadfile/avatar/default.png" width="48" height="48" />
</div>
<div class="fl avatar-tips text-gray">
<p class="text-lh-30">· 请上传您的个人头像</p>
<p class="text-lh-30">· 请勿在形象标示上留有任何联系方式的信息</p>
<p class="text-lh-30">· 支持JPG格式，图片大小不超过2MB</p>
<p class="text-lh-30">· 请保证图片质量，分辨率压缩后至少为200*200</p>
<p class="text-lh-30">· 请不要在头像上面留电话，QQ，网址，邮箱等联系方式信息</p>
</div>
</div>
</div>
<form action="<?php echo url('avatar');?>" method="POST" name="avatar_form" onsubmit="return checkCoords();">
<input type="hidden" name="avatar" value="">
<input type="hidden" id="x" name="x" value="0">
<input type="hidden" id="y" name="y" value="0">
<input type="hidden" id="w" name="w" value="0">
<input type="hidden" id="h" name="h" value="0">
<input class="margin-big-top button bg-sub" type="submit" name="dosubmit" value="保存头像" />
</form>
</div>
</div>
</div>
<!--上传组件-->
<link type="text/css" rel="stylesheet" href="<?php echo __ROOT__;?>statics/js/jcrop/jquery.jcrop.css?v=<?php echo HD_VERSION;?>" />
<link type="text/css" rel="stylesheet" href="<?php echo __ROOT__;?>statics/js/upload/uploader.css?v=<?php echo HD_VERSION;?>" />
<script src="<?php echo __ROOT__;?>statics/js/jcrop/jquery.jcrop.min.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo __ROOT__;?>statics/js/upload/uploader.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo __ROOT__;?>statics/js/haidao.validate.js?v=<?php echo HD_VERSION;?>"></script>
<script>
var avatar = $("form[name=avatar_form]").Validform({
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
} else {
$.tips({
icon:'success',
content:ret.message,
callback:function() {
window.location.href = ret.referer;
}
});					
}
}
})
var uploader = WebUploader.create({
        auto:true,
        fileVal:'upfile',
        // swf文件路径
        swf: '<?php echo __ROOT__;?>statics/js/upload/uploader.swf',
        // 文件接收服务端。
        server: "<?php echo url('attachment/index/upload')?>",
        // 选择文件的按钮。可选
        formData:{
            file : 'upfile',
            upload_init : '<?php echo $attachment_init ?>'
        },
        // 压缩图片大小
        compress:{
        	width: 408,
        	height: 408,
        	allowMagnify: false
        },
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {
            id: '#file-avatar',
            multiple:false
        },
        accept:{
            title: '图片文件',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        chunked: false,
        chunkSize:1000000,
        resize: false
    });

    uploader.onFileQueued = function(file) {
    	$(this.options.pick.id).find('.webuploader-pick').html('上传中');
    }

    uploader.onUploadProgress = function(file, percentage) {
    	$(this.options.pick.id).find('.webuploader-pick').html('上传中(' + percentage * 100 + '%)');
    }

    uploader.onUploadSuccess = function(file, response) {
    	$(this.options.pick.id).find('.webuploader-pick').html('重新上传');
    	if(response.status == 1) {
    		if(response.result.width<200||response.result.height<200){
    			top.dialog({
title: '消息提示',
width: 300,
content: '<div class="padding-large text-center">请上传分辨率至少为200*200的图片！</div>',
okValue: '确定',
ok: function(){
},
})
.showModal();
    			return false;
    		}
$("input[name=avatar]").attr("value", response.result.url);
    		executeAvatarTailor(response.result.url,response.result.width,response.result.height);
    	} else {
    		top.dialog({
title: '消息提示',
width: 300,
content: '<div class="padding-large text-center">'+response.message+'</div>',
okValue: '确定',
ok: function(){
},
})
.showModal();
    	}
    }

var jcrop,boundx,boundy;
var initx,inity = 0;

/*
 * 使用ajax先把头像上传到后台，上传的图片大小为2M以内，宽度和长度均需要>200
 * 上传成功后将图片地址传递给executeAvatarTailor()方法
 * 提交表单时，裁剪的图片坐标会以隐藏表单上传上去，分别为x,y,w,h，通过后台裁剪图片
 * 后台裁剪时需要注意图片的比例，前台展示输出的图片最大宽度为400，超出宽度的图片会被压缩展示
 */

function executeAvatarTailor(S, W, H){
$("#avatar_pic").attr('src', S);
$(".avatar-other .avatar-box").children('img').attr('src', S);
boundx = W;
boundy = H;
setTimeout(function(){
$("#avatar_pic").Jcrop({
onSelect: showPreview,
aspectRatio: 1,
fixedSupport: true,
setSelect: [(W-200)/2,(H-200)/2,W/408*200,H/408*200],
minSize: [200,200],
allowSelect: false
},function(){
jcrop = this;
});
},100);
try{
jcrop.setImage(S);
}catch(e){}
$("#avatar").css({visibility:"visible",marginTop: -H/2+'px',marginLeft: -W/2+'px'});
}

//右边三个小图展示
function showPreview(o){
$('#x').val(o.x);
  	$('#y').val(o.y);
  	$('#w').val(o.w);
  	$('#h').val(o.h);

if(parseInt(o.w)>0){
var x1 = 198 / o.w;
var y1 = 198 / o.h;
var x2 = 78 / o.w;
var y2 = 78 / o.h;
var x3 = 48 / o.w;
var y3 = 48 / o.h;
}
imgCss($("#avatar-2"),x1,y1,o.x,o.y);
imgCss($("#avatar-3"),x2,y2,o.x,o.y);
imgCss($("#avatar-4"),x3,y3,o.x,o.y);
}

function imgCss(o,x,y,ox,oy){
o.css({
            width: Math.round(x * boundx) + 'px',
            height: Math.round(y * boundy) + 'px',
            marginLeft: '-' + Math.round(x * ox) + 'px',
            marginTop: '-' + Math.round(y * oy) + 'px'
        }).show();
}
</script>
<!--底部-->
<?php include template(footer,common); ?>