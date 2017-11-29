<?php if(!defined('IN_APP')) exit('Access Denied');?>
<dt class="text-sub text-default">账户设置</dt>
<dd <?php if((CONTROL_NAME == 'account' && METHOD_NAME == 'safe')){?>class="current"<?php } ?>><a href="<?php echo url('member/account/safe');?>">安全中心</a></dd>
<dd <?php if((CONTROL_NAME == 'account' && METHOD_NAME == 'avatar')){?>class="current"<?php } ?>><a href="<?php echo url('member/account/avatar');?>">修改头像</a></dd>
<dd <?php if((CONTROL_NAME == 'address' && METHOD_NAME == 'index')){?>class="current"<?php } ?>><a href="<?php echo url('member/address/index');?>">收货地址</a></dd>
<dd <?php if((CONTROL_NAME == 'money' && METHOD_NAME == 'log')){?>class="current"<?php } ?>><a href="<?php echo url('member/money/log');?>">账户余额</a></dd>
<?php $data = runhook('menu_account_extra_menu');?><?php if(is_array($data)) foreach($data as $menu){?><dd <?php if((CONTROL_NAME == $menu[c] && MODULE_NAME == $menu[m] && $_GET['id'] == $menu[id])){?>class="current"<?php } ?>><a href="<?php echo url('plugin/index/index',array('id' => $menu['id']));?>"><?php echo $menu['name'];?></a></dd>
<?php } ?>