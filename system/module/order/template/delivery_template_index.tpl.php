<?php include template('header','admin');?>
<style type="text/css">
	.high-table .tr .td {
    min-height: 41px;
    line-height: 40px;
}
</style>

		<div class="fixed-nav layout">
			<ul>
				<li class="first">运费模板管理<a id="addHome" title="添加到首页快捷菜单">[+]</a></li>
			</ul>
			<div class="hr-gray"></div>
		</div>
		<div class="content padding-big have-fixed-nav">
			<div class="table-work border margin-tb">
				<div class="border border-white tw-wrap">
					<a href="<?php echo url('order/delivery_template/update'); ?>"><i class="ico_add"></i>添加</a>
					<div class="spacer-gray"></div>
					<a data-message="是否确定删除所选？" href="<?php echo url('order/delivery_template/deletes',array('name'=>'ids'))?>" data-ajax='ids'><i class="ico_delete"></i>删除</a>
					<div class="spacer-gray"></div>
				</div>
			</div>
			<div class="table-wrap">
				<div class="table resize-table high-table check-table border clearfix">
					<div class="tr">
						<span class="th check-option" data-resize="false">
							<span><input id="check-all" type="checkbox" /></span>
						</span>
						<?php foreach ($lists['th'] AS $th) {?>
						<span class="th" data-width="<?php echo $th['length']?>">
							<span class="td-con"><?php echo $th['title']?></span>
						</span>
						<?php }?>
						<span class="th w1_5" data-width="10">
							<span class="td-con">操作</span>
						</span>
					</div>
					<?php foreach ($lists['lists'] AS $list) {?>
				<div class="tr">
					<span class="td check-option"><input type="checkbox" name="id" value="<?php echo $list['id']?>" /></span>
					<?php foreach ($list as $key => $value) {?>
					<?php if($lists['th'][$key]){?>
					<?php if ($lists['th'][$key]['style'] == 'double_click') {?>
					<span class="td">
						<div class="double-click">
							<a class="double-click-button margin-none padding-none" title="双击可编辑" href="javascript:;"></a>
							<input class="input double-click-edit text-ellipsis text-center" type="text" name="<?php echo $key?>" data-id="<?php echo $list['id']?>" value="<?php echo $value?>" />
						</div>
					</span>
					<?php }elseif ($lists['th'][$key]['style'] == 'hidden') {?>
						<input type="hidden" name="id" value="<?php echo $value?>" />
					<?php }elseif ($lists['th'][$key]['style'] == 'default') {?>
					<span class="td">
						<?php if($list['isdefault'] == 0){ ?>
							<span class="td-con"><?php echo $value;?></span>
						<?php }else{ ?>
							<span class="td-con"><?php echo $value;?>&nbsp;&nbsp;<img src="statics/images/icon_default.png" style="vertical-align: -3px;"></span>
						<?php } ?>
					</span>
					<?php }elseif ($lists['th'][$key]['style'] == 'ico_up_rack') {?>
					<span class="td">
						<a class="ico_up_rack <?php if($value != 1){?>cancel<?php }?>" href="javascript:;" data-id="<?php echo $list['id']?>" title="点击取消推荐"></a>
					</span>
					<?php }else{?>
					<span class="td">
						<span class="td-con"><?php echo $value;?></span>
					</span>
					<?php }?>
					<?php }?>
					<?php }?>
					<span class="td">
						<span class="td-con">
						<?php if($list['isdefault'] == 0){?>
							<a href="<?php echo url('order/delivery_template/set_default',array('id'=>$list['id'], 'isdefault', 1)); ?>">设为默认</a>&nbsp;&nbsp;&nbsp;
						<?php }?>
							<a href="<?php echo url('order/delivery_template/update',array('id'=>$list['id'])) ?>">编辑</a>&nbsp;&nbsp;&nbsp;
							<a data-confirm="是否确定删除？" href="<?php echo url('deletes',array('ids'=>$list['id'])) ?>">删除</a>
						</span>
					</span>
				</div>
				<?php }?>
				</div>
				<!-- 分页 -->
				<div class="paging padding-tb body-bg clearfix">
					<ul class="fr"><?php echo $lists['pages'];?></ul>
					<div class="clear"></div>
				</div>
			</div>
		</div>
<?php include template('footer','admin');?>
<script>
	$(".form-group .box").addClass("margin-none");
	$(window).load(function(){
		$(".table").resizableColumns();
		$('.table .tr:last-child').addClass("border-none");
		var ajax_url = '<?php echo url("order/delivery_template/status");?>';
		// 双击更改排序
		$(".table .ico_up_rack").bind('click',function(){
			var id = $(this).attr('data-id');
			var row = $(this);
			$.post(ajax_url,{id:id},function(data){
				if(data.status == 1){
					if(!row.hasClass("cancel")){
						row.addClass("cancel");
						row.attr("title","点击设为推荐");
					}else{
						row.removeClass("cancel");
						row.attr("title","点击取消推荐");
					}
				}else{
					message(data.message);
					return false;
				}
			},'json');
		});
	})
</script>