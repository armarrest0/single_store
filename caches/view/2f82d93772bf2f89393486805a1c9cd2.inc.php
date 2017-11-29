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
<?php include template(menu_index,member); ?>
</div>
<div class="right padding-big-left padding-big-right">
<div class="margin-big-top border">
<div class="padding-big-left padding-big-right border-bottom bg-gray-white text-lh-40">
<span>欢迎您：<?php echo $member['username']?></span>
<?php if($_config['balance_pay'] == 1):?>
<div class="fr">
账户余额：<span class="text-mix">￥ <?php echo $member['money']?> </span>元
<a class="margin-big-left margin-large-right button bg-mix lh-normal" href="<?php echo url('member/money/pay');?>">充值</a>
<span class="text-gray">冻结余额：<?php echo $member['frozen_money']?>元</span>
</div>
<?php endif;?>
</div>
<div class="layout info-total clearfix">
<div class="fl w20">
<div class="item-double-txt">
<a href="<?php echo url('member/order/index');?>">
<em class="text-sub"><?php echo $member['counts']['going']; ?></em>
<p>进行中的订单</p>
</a>
</div>
</div>
<!--<div class="fl w20">
<div class="item-double-txt">
<em class="text-sub">0</em>
<p>优惠券</p>
</div>
</div>-->
<div class="fl w20">
<div class="item-double-txt">
<em class="text-sub"><?php echo $member['exp']?></em>
<p>经验值</p>
</div>
</div>
<div class="fl w20">
<div class="item-double-txt">
<a href="<?php echo url('member/message/index',array('status'=>0));?>">
<em class="text-sub"><?php echo $counts['message'];?></em>
<p>系统消息</p>
</a>
</div>
</div>
<div class="fl w20">
<div class="item-double-txt">
<a href="<?php echo url('member/consult/index');?>">
<em class="text-sub"><?php echo $counts['consult'];?></em>
<p>咨询回复</p>
</a>
</div>
</div>
<?php echo runhook('account_info_extra');?>
</div>
</div>

<div class="layout margin-big-top">
<div class="fl w50 padding-right">
<div class="border clearfix">
<div class="padding-big-left bg-gray-white text-lh-40">
<span>收藏的商品</span>
<a class="fr m-t-15 margin-right text-sub text-lh-little" href="<?php echo url('member/favorite/index');?>">更多</a>
</div>
<div class="slider member-slider">
<!--当商品超过三个才出现下面两个箭头-->
<a href="javascript:;" class="slider-control hidden border prev disabled">&lt;</a>
<a href="javascript:;" class="slider-control hidden border next">&gt;</a>
<div class="slider-items">
<ul class="lh">
<?php if(count($favorite['lists'])>0):?><?php if(is_array($favorite['lists'])) foreach($favorite['lists'] as $r){?><li>
<a href="<?php echo url('goods/index/detail',array('sku_id'=>$r['sku_id']));?>" target="_blank">
<img src="<?php echo thumb($r['_sku']['thumb'],500,500);?>" alt="<?php echo $r['_sku']['sku_name'];?>" width="105" height="105"></a>
<p class="text-gray">￥<?php echo $r['sku_price'];?></p>
</li>
<?php } ?>
<?php else:?>
<p class="text-tip">您还没有收藏任何商品</p>
<?php endif;?>
</ul>
</div>
</div>
</div>
</div>
<div class="fl w50 padding-left">
<div class="border">
<div class="padding-big-left bg-gray-white text-lh-40">
<span>为您推荐</span>
<a class="fr m-t-15 margin-right text-sub text-lh-little" id="rec_btn" href="javascript:;">换一批</a>
</div>
<div class="slider member-slider">
<!--当商品超过三个才出现下面两个箭头-->
<a href="javascript:;" class="slider-control hidden border prev disabled">&lt;</a>
<a href="javascript:;" class="slider-control hidden border next">&gt;</a>
<div class="slider-items" id="rec_slider">
<ul class="lh rec_box">

</ul>
</div>
</div>
</div>
</div>
<div class="fl margin-big-top w50 padding-right">
<div class="border clearfix">
<div class="padding-big-left bg-gray-white text-lh-40">
<span>待评价商品</span>
<a class="fr m-t-15 margin-right text-sub text-lh-little" href="<?php echo url('comment/index/index');?>">更多</a>
</div>
<div class="slider member-slider">
<!--当商品超过三个才出现下面两个箭头-->
<a href="javascript:;" class="slider-control hidden border prev disabled">&lt;</a>
<a href="javascript:;" class="slider-control hidden border next">&gt;</a>
<div class="slider-items">
<ul class="lh">
<?php if(count($notcommentgoods)>0):?>
<?php foreach($notcommentgoods as $k=>$r):?>
<li>
<a href="<?php echo url('goods/index/detail',array('sku_id'=>$r['sku_id']));?>" target="_blank">
<img src="<?php echo thumb($r['sku_thumb'],500,500);?>" alt="<?php echo $r['sku_name'];?>" width="105" height="105"></a>
<p class="text-gray">￥<?php echo $r['sku_price'];?></p>
</li>
<?php endforeach;?>
<?php else:?>
<p class="text-tip">您暂时没有未评价的商品</p>
<?php endif;?>
</ul>
</div>
</div>
</div>
</div>
<div class="fl margin-big-top w50 padding-left">
<div class="border">
<div class="padding-big-left bg-gray-white text-lh-40">
<span>我的足迹</span>
<a class="fr m-t-15 margin-right text-sub text-lh-little" href="javascript:;" id="clear_history">清空</a>
</div>
<div class="slider member-slider">
<!--当商品超过三个才出现下面两个箭头-->
<a href="javascript:;" class="slider-control hidden border prev disabled">&lt;</a>
<a href="javascript:;" class="slider-control hidden border next">&gt;</a>
<div class="slider-items">
<ul class="lh" id="clear_history_box">
<?php
	$taglib_goods_goods = new taglib('goods','goods');
	$data = $taglib_goods_goods->history(array(), array('limit'=>'6','cache'=>'4a5dd9cf56dac3edd330d5cac354c28f,3600'));
?>
<?php if(!empty($data)>0):?><?php if(is_array($data)) foreach($data as $r){?><li>
<a href="<?php echo url('goods/index/detail',array('sku_id'=>$r['sku_id']));?>" target="_blank"><img src="<?php echo thumb($r['thumb'],500,500);?>" alt="<?php echo $r['sku_name'];?>" width="105" height="105"></a>
<p class="text-gray">￥<?php echo $r['prom_price']?></p>
</li>
<?php } ?>
<?php else:?>
<p class="text-tip">您还没浏览过任何商品</p>
<?php endif;?>

</ul>
</div>
</div>
</div>
</div>
<?php echo runhook('account_box_extra');?>
</div>

</div>
</div>
</div>

<?php include template(footer,common); ?>
<script>

$(function(){
get_rec_data();
function get_rec_data(){
var rec_html = ''
$.getJSON('<?php echo url('get_rec_data')?>',{'formhash':'<?php echo FORMHASH?>'},function(ret){

if(ret.result.length == 0){
$('.rec_box').html('<p class="text-tip">暂无为您推荐的商品</p>');
loadSlider();
return false;
}
var item;
for(var i in ret.result){
item = ret.result[i];
rec_html += '<li>';
rec_html += '<a href="'+item.goods_url+'" target="_blank">';
rec_html += '<img src="'+item.format_thumb+'" alt="'+item.sku_name+'" width="105" height="105"></a>';
rec_html += '<p class="text-gray">￥'+item.prom_price+'</p>';
rec_html += '</li>';
}
$('.rec_box').html(rec_html);
$('.rec_box').css("left","0");
loadSlider();
})

}
$('#rec_btn').on('click',function(){
get_rec_data();
})
$('#clear_history').on('click',function(){
$.getJSON('<?php echo url('clear_history')?>',{'formhash':'<?php echo FORMHASH?>'},function(ret){
if(ret.status == 1){
$('#clear_history_box').html('<p class="text-tip">您还没浏览过任何商品</p>');
}
})
})

function loadSlider(){
$(".slider").sliderRoll({
time: 300,
mouseover: true
});
$(".member-slider").each(function(){
if($(this).find("li").length>3){
$(this).find(".slider-control").removeClass("hidden");
$(this).find(".slider-control.next").removeClass("disabled");
}
});
}
})

</script>
