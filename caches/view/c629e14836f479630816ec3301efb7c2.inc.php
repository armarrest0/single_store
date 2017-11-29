<?php if(!defined('IN_APP')) exit('Access Denied');?>
<dl class="margin-big-top member-memu clearfix">
<dt class="text-sub text-default">交易中心</dt>
<dd <?php if((CONTROL_NAME=='order' && METHOD_NAME=='index' && (!isset($_GET[type]) || !in_array($_GET[type],array(1,3)) ))){?>class="current"<?php } ?>><a href="<?php echo url('member/order/index');?>">我的订单</a></dd>
<dd <?php if((CONTROL_NAME=='order' && METHOD_NAME=='index' && $_GET[type]==1)){?>class="current"<?php } ?>><a href="<?php echo url('member/order/index', array('type' => 1));?>">待付款订单</a><span class="fr <?php if($member['counts'][pay] > 0){?>in2<?php } else { ?>in1<?php } ?>"><?php echo $member['counts']['pay']; ?></span></dd>
<dd <?php if((CONTROL_NAME=='order' && METHOD_NAME=='index' && $_GET[type]==3)){?>class="current"<?php } ?>><a href="<?php echo url('member/order/index', array('type' => 3));?>">待发货订单</a><span class="fr <?php if($member['counts'][delivery] > 0){?>in2<?php } else { ?>in1<?php } ?>"><?php echo $member['counts']['delivery']; ?></span></dd>
<dd <?php if((MODULE_NAME=='comment')){?>class="current"<?php } ?>><a href="?m=comment">待评价交易</a><span class="fr  <?php if($member['counts'][load_comment] > 0){?>in2<?php } else { ?>in1<?php } ?>"><?php echo $member['counts']['load_comment']; ?></span></dd>
<?php $data = runhook('member_order_lists_left');?>
</dl>
<dl class="margin-big-top member-memu">
<dt class="text-sub text-default">信息中心</dt>
<dd <?php if((CONTROL_NAME=='favorite')){?>class="current"<?php } ?>><a href="<?php echo url('member/favorite/index');?>">我的收藏</a></dd>
<dd <?php if((CONTROL_NAME=='consult')){?>class="current"<?php } ?>><a href="<?php echo url('member/consult/index');?>">我的咨询</a></dd>
<dd <?php if((CONTROL_NAME=='service')){?>class="current"<?php } ?>><a href="<?php echo url('member/service/index');?>">售后服务</a></dd>
<?php $data = runhook('member_extra_lists');?><?php if(is_array($data)) foreach($data as $menu){?><dd <?php if((CONTROL_NAME=="$menu[control_name]")){?>class="current"<?php } ?>>
<a href="<?php echo $menu['url'];?>"><?php echo $menu['name'];?></a>
</dd>
<?php } ?>
</dl>
