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
<link type="text/css" rel="stylesheet" href="<?php echo __ROOT__;?>template/default/statics/css/haidao.css?v=<?php echo HD_VERSION;?>" />
<link type="text/css" rel="stylesheet" href="<?php echo __ROOT__;?>template/default/statics/css/public.css?v=<?php echo HD_VERSION;?>" />
<script type="text/javascript" src="<?php echo __ROOT__;?>template/default/statics/js/jquery-1.7.2.min.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo __ROOT__;?>template/default/statics/js/haidao.web.general.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo __ROOT__;?>template/default/statics/js/common.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo __ROOT__;?>statics/js/dialog/dialog-plus-min.js?v=<?php echo HD_VERSION;?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo __ROOT__;?>statics/js/dialog/ui-dialog.css?v=<?php echo HD_VERSION;?>" />
<script type="text/javascript" src="<?php echo __ROOT__;?>template/default/statics/js/cart.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript" src="<?php echo __ROOT__;?>statics/js/haidao.validate.js?v=<?php echo HD_VERSION;?>"></script>
<script type="text/javascript"> hd_cart.init(); </script>
<?php echo $site_rewrite_other;?>
<!--[if gte IE 8]>
<link type="text/css" rel="stylesheet" href="<?php echo __ROOT__;?>template/default/statics/css/compatible.css" />
<![endif]-->
</head>
<body>
<!-- 顶部工具条 -->
<div class="layout border-bottom bg-gray-white">
<div class="site-bar container">
<ul class="fl">
<li><a class="fun-homepage" href="javascript:;">设为首页</a></li>
<li class="spacer"></li>
<li><a class="fun-favorite" href="javascript:;">收藏本站</a></li>
<?php echo runhook('left_site_bar');?>
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
<li><a href="#">手机版</a></li> -->
<?php echo runhook('right_site_bar');?>
</ul>
</div>
</div>