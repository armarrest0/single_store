<?php
hd_core::load_class('init', 'mobile');
class public_control extends baselogin_control{
    
      public function _initialize() {
		parent::_initialize();	
	}
    
        
        /**
        * [lists 商品列表]
        */
       public function ajax_goods_list()
       {
           $result = $this->load->service('goods/goods_sku')->lists();
           echo json_encode(array("status"=>1,"datas"=>$result));       
           
       }
       
       
        /**
        * [ 商品详情]
        */
       public function ajax_goods_detail()
       {
           $goods = $this->load->service('goods/goods_sku')->detail($_GET['sku_id'], FALSE);
           echo json_encode(array("status"=>1,"datas"=>$goods));       
           
       }
       
       
        /**
        * [ 商品分类]
        */
       public function ajax_category_list()
       {
           $list = $this->load->service('goods/goods_category')->lists();
           echo json_encode(array("status"=>1,"datas"=>$list));       
           
       }
       
       
}