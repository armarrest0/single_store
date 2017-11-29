<style type="text/css">
    .delivery-template .td select{ width: 100%; height: 26px; }
</style>
<div class="form-box">
    <?php echo form::input('radio', 'spu[delivery_type]', $goods['spu']['delivery_type'] ? $goods['spu']['delivery_type'] : 0, '运费类型：', '请选择运费模板启用状态',array('items' => array(0 => '运费模板', 1 => '统一运费'),'colspan' => 2)); ?>
    <div class="delivery-moudle <?php if($goods['spu']['delivery_type'] == 1):?>hidden<?php endif?>">
        <?php echo form::input('radio', 'spu[delivery_set_type]', $goods['spu']['delivery_set_type'] ? $goods['spu']['delivery_set_type'] : 0, '运费设置方式：', '请选择运费设置方式',array('items' => array(0 => '按规格商品统一设置', 1 => '按规格商品分别设置'),'colspan' => 2)); ?>
        <div class="delivery-moud-child <?php if($goods['spu']['delivery_set_type'] == 1):?>hidden<?php endif?>">
            <?php echo form::input('select', 'spu[delivery_template_id]', $goods['spu']['delivery_template_id'], '运费模板：', '请选择商品将关联的运费模板（必选）', array('items'=> $delivery_template)); ?>
            <?php echo form::input('text', 'spu[weight]', $goods['spu']['weight'] ? $goods['spu']['weight'] : '0.00', '设置商品重量：', '请填写每件商品重量，以（kg）为单位'); ?>
            <?php echo form::input('text', 'spu[volume]', $goods['spu']['volume'] ? $goods['spu']['volume'] : '0.00', '设置商品体积：', '请填写每件商品体积，以（m³）为单位'); ?>
        </div>

        <div class="delivery-moud-child <?php if($goods['spu']['delivery_set_type'] == 0):?>hidden<?php endif?>">
            <?php echo form::input('text', 'weight', '0.00', '规格商品重量：', '请填写规格商品重量，以（kg）为单位'); ?>
            <?php echo form::input('text', 'volume', '0.00', '规格商品体积：', '请填写规格商品体积，以（m³）为单位'); ?>
            <div id="js-deliveryTemp">
                <?php echo form::input('select', 'delivery_template_id', 0, '默认运费模板：', '请选择运费模板', array('items'=> $delivery_template)); ?>
            </div>
            <div class="fl layout clearfix">
                <div class="table-work border margin-top border-bottom-none">
                    <div class="border border-white tw-wrap border-bottom-none">
                        <a href="javascript:;" class="text-main">按规格商品分别设置</a>
                    </div>
                </div>
                <div class="layout">
                    <div class="table resize-table delivery-template border clearfix">
                        <div class="tr border-none resize-th">
                            <div class="th" data-width="30">
                                <div class="td-con">规格</div>
                            </div>
                            <div class="th" data-width="10">
                                <div class="td-con">重量（kg）</div>
                            </div>
                            <div class="th" data-width="10">
                                <div class="td-con">体积（m³）</div>
                            </div>
                            <div class="th" data-width="20">
                                <div class="td-con">规格运费模板</div>
                            </div>
                            <div class="th" data-width="30">
                                <div class="td-con"></div>
                            </div>
                        </div>
                </div>
            </div>
            <div data-id="delivery_template"></div>
        </div>
        <script id="delivery_template" type="text/html">
        <%for(var item in delivery_template){%>
        <%item = delivery_template[item]%>
        <div class="tr" data-id="<%=item['spec_md5']%>">
            <div class="td">
                <div class="td-con"><%=item['spec_str']%></div>
            </div>
            <div class="td" data-column='weight'>
                <div class="td-con"><input class="input js-weight" type="text" nullmsg="重量必须为数字" datatype="price" attr="weight[<%=item['spec_md5']%>]" value="<%=item['weight']?item['weight']:'0.00'%>" /></div>
            </div>
            <div class="td" data-column='volume'>
                <div class="td-con"><input class="input js-volume" type="text" nullmsg="体积必须为数字" datatype="price" attr="volume[<%=item['spec_md5']%>]" value="<%=item['volume']?item['volume']:'0.00'%>" /></div>
            </div>
            <div class="td" data-column="delivery_template_id">
                <select class="js-delivery-temps" attr="delivery_template_id[<%=item['spec_md5']%>]">
                <option style="display: none"></option>
                <%for(var temp in delivery_temps){%>
                    <%opt = delivery_temps[temp]%>
                    <option value="<%=temp%>" <%if(temp == item['delivery_template_id']){%>selected="selected" <%}%>><%=opt%></option>
                <%}%>
                </select>

            </div>
            <div class="td">
                <div class="td-con"></div>
            </div>
        </div>
        <%}%>
        </script>
    </div>

    </div>
    <!-- 统一运费 -->
    <div class="delivery-moudle <?php if($goods['spu']['delivery_type'] == 0):?>hidden<?php endif?>">
        <?php echo form::input('text', 'spu[delivery_price]', $goods['spu']['delivery_price'], '设置运费价格：', '请填写运费价格'); ?>
    </div>
</div>
<script type="text/javascript">
var delivery_temps = <?php echo $delivery_template ? json_encode($delivery_template) : '[]'?>;
init_delivery(sku,delivery_temps);

function init_delivery(sku,templates){
    var delivery_template = template('delivery_template', {'delivery_template': sku,'delivery_temps':templates});
    var tr=$(".delivery-template").find('.tr');
    if(tr.length>1){
        for(var i=1;i<tr.length;i++)
            tr.eq(i).remove();
    }
    $(".delivery-template").html($(".delivery-template").html()+delivery_template);
}

function append_delivery(sku,templates){
    var delivery_template = template('delivery_template', {'delivery_template': sku,'delivery_temps':templates});
    $(".delivery-template").append(delivery_template);
}
$('input[name="spu[delivery_set_type]"]').change(function(event) {
    var index = $("input[name='spu[delivery_set_type]']:checked").val();
    $(".delivery-moud-child").addClass('hidden')
    $(".delivery-moud-child").eq(index).removeClass('hidden');
    $(window).resize();
});

$('input[name="spu[delivery_type]"]').change(function(event) {
    var index = $("input[name='spu[delivery_type]']:checked").val();
    $(".delivery-moudle").addClass('hidden')
    $(".delivery-moudle").eq(index).removeClass('hidden');
    $(window).resize();
});

$("input[name=weight]").change(function(){
    $(".js-weight").val($(this).val());
})

$("input[name=volume]").change(function(){
    $(".js-volume").val($(this).val());
})

$("#js-deliveryTemp input[name='delivery_template_id']").live('change', '.listbox-items .listbox-item', function(){
    var html = '';
    $.each($("#js-deliveryTemp .listbox-items").find('.listbox-item'), function(){
        if($(this).hasClass('listbox-item-selected')){
            html += '<option value='+ $(this).data('val') +' selected="selected">'+ $(this).text(); +'</option>';
        }else{
            html += '<option>'+ $(this).text(); +'</option>';
        }
    });
    $(".js-delivery-temps").html(html);
})
</script>
