<?php if(!defined('IN_APP')) exit('Access Denied');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title><?php if(isset($SEO['title']) && !empty($SEO['title'])){?><?php echo $SEO['title'];?><?php } ?><?php echo $SEO['site_title'];?></title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta name="Keywords" content="<?php echo $SEO['keywords'];?>" />
<meta name="Description" content="<?php echo $SEO['description'];?>" />
<link type="text/css" rel="stylesheet" href="<?php echo SKIN_PATH;?>statics/css/haidao.css?v=<?php echo HD_VERSION;?>" />
<link type="text/css" rel="stylesheet" href="<?php echo SKIN_PATH;?>statics/css/public.css?v=<?php echo HD_VERSION;?>" />
<script type="text/javascript" src="<?php echo SKIN_PATH;?>statics/js/jquery-1.7.2.min.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo SKIN_PATH;?>statics/js/haidao.web.general.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo SKIN_PATH;?>statics/js/common.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo SKIN_PATH;?>statics/js/cart.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript"> hd_cart.init(); </script>
<script type="text/javascript" src="<?php echo SKIN_PATH;?>statics/js/member.order.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo __ROOT__;?>statics/js/haidao.validate.js?v=<?php echo HD_VERSION;?>"></script>
<!--[if gte IE 8]>
<link type="text/css" rel="stylesheet" href="template/default/statics/css/compatible.css" />
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo __ROOT__;?>statics/js/dialog/ui-dialog.css?v=<?php echo HD_VERSION;?>" />
<script type="text/javascript" src="<?php echo __ROOT__;?>statics/js/dialog/dialog-plus-min.js?v=<?php echo HD_VERSION;?>"></script>
</head>
<body>
<!-- 顶部工具条 -->
<div class="layout border-bottom bg-gray-white">
<div class="site-bar container">
<ul class="fl">
<li><a class="fun-homepage" href="javascript:;">设为首页</a></li>
<li class="spacer"></li>
<li><a class="fun-favorite" href="javascript:;">收藏本站</a></li>
</ul>
<ul class="fr">
<?php if ($member['id']): ?>
<li><a href="<?php echo url('member/index/index');?>"><?php echo $member['username'] ?></a></li>
<li class="spacer"></li>
<li><a href="<?php echo url('member/public/logout');?>">退出登录</a></li>
<li class="spacer"></li>
<?php else: ?>
<li><a href="<?php echo url('member/public/register');?>">注册</a></li>
<li class="spacer"></li>
<li><a href="<?php echo url('member/public/login');?>">登录</a></li>
<li class="spacer"></li>
<?php endif ?>
<li><a href="<?php echo url('member/order/index');?>">我的订单</a></li>
<!-- <li class="spacer"></li>
<li><a href="javascript:;">手机版</a></li> -->
</ul>
</div>
</div>
<!-- 头部 -->
<div class="layout bg-main member-head">
<div class="header container">
<div class="logo fl">
<span><a><img src="<?php echo SKIN_PATH;?>statics/images/member/logo.png" /></a></span>
</div>
<div class="fl m-l-15 margin-big-top back-shop">
<span class="text-white text-default">会员中心</span>
<a href="<?php echo __APP__;?>">返回商城首页</a>
</div>

<div class="fl menu text-default">
<ul>
<li><a href="<?php echo url('member/index/index');?>">首页</a></li>
<li><a href="<?php echo url('member/account/safe');?>">账户管理</a></li>
<li><a href="<?php echo url('member/message/index');?>">系统消息</a></li>
</ul>
</div>

<div class="user fr">
<!-- 购物车 -->
<div class="user-box" id="carts">
<div class="user-top bg-white border">
<i class="icon-cart fl"></i>我的购物车<em class="cart-num text-center bg-main margin-big-left fr" id="count">0</em>
</div>
<div class="user-content bg-white cart border">
<div class="user-con-top border-bottom none">
<a class="fl">最新加入的商品</a>
<a class="fr" href="javascript:;">清空购物车</a>
</div>
<div class="cart-goods border-bottom none" id="lists">load...</div>
<div class="cart-tips bg-white text-center"><p>购物车中还没有商品，赶紧选购吧！</p></div>
<div class="cart-info padding-lr">
<p class="margin-small-top hidden none">共
<em class="text-mix g_c">0</em> 种商品
<em class="text-mix m_c">0</em> 件，
商品金额总计:<em class="text-mix text-default p_c">￥0.00</em>
</p>
<a class="cart-btn margin-tb" href="<?php echo url('order/cart/index');?>">去购物车结算</a>
</div>
</div>
</div>
</div>
</div>
</div>
<?php echo runhook('member_common_header');?>
<!-- 购物车结束 -->