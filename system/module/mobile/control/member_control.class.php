<?php
hd_core::load_class('init', 'mobile');
class member_control extends init_control
{
	public function _initialize() {
		parent::_initialize();
		$this->mb_token_table = $this->load->table('mb_user_token');
		$this->service = $this->load->service('mobile/mobile');
		$this->notify_service = $this->load->service('notify/notify');
		$this->notify_template_service = $this->load->service('notify/notify_template');
	}      
        
        /**
	*	用户信息ajax
	*/
        public function ajax_member_info() { 
                echo json_encode($this->member);
	}
        

        
         /**
	*	用户地址详情ajax
	*/
        public function ajax_member_address_detail() {                   
                $lists = $this->load->service('mobile/mobile_address')->mid($this->member['id'])->fetch_by_id($_POST['address_id']);                   
                if($lists){
                    echo json_encode(array("status"=>1,"datas"=>$lists));
                }else{
                    echo json_encode(array("status"=>0,"error"=>"暂无数据"));
                }
	}
        
        
        /**
	*	地址列表ajax
	*/
       public function ajax_district(){
		$id = (int) $_GET['area_id'];
		$result = $this->load->service('admin/district')->get_children($id);
		$this->load->librarys('View')->assign('result',$result);
		$result = $this->load->librarys('View')->get('result');
                if($result){
                    echo json_encode(array("status"=>1,"datas"=>$result));
                }else{
                    echo json_encode(array("status"=>0,"error"=>"暂无数据"));
                }
	}
        
        
        /**
	*	用户地址信息增加ajax
	*/
        public function ajax_member_address_add() {      
                $data = array();
                $data['mid'] = $this->member['id'];
                $data['name'] = $_POST['true_name'];
                $data['mobile'] = $_POST['mobile'];
                $data['zipcode'] = $_POST['zipcode'];
                $data['district_id'] = $_POST['district_id'];
                $data['address'] = $_POST['address'];
                $result = $this->load->service('mobile/mobile_address')->add($data);
                
                echo json_encode($result);
	}
        
        
          
        /**
	*	用户地址信息修改ajax
	*/
        public function ajax_member_address_edit() {      
                $data = array();
                $data['id'] = $_POST['address_id'];
                $data['mid'] = $this->member['id'];
                $data['name'] = $_POST['true_name'];
                $data['mobile'] = $_POST['mobile'];
                $data['zipcode'] = $_POST['zipcode'];
                $data['district_id'] = $_POST['district_id'];
                $data['address'] = $_POST['address'];
                $data['isdefault'] = $_POST['isdefault'];
                $result = $this->load->service('mobile/mobile_address')->edit($data);                
                echo json_encode($result);
	}
        
        
         /**
	*	用户地址信息列表ajax
	*/
        public function ajax_member_address_list() {      
        
            $sqlmap = array();
            $sqlmap['mid'] = $this->member['id'];
            if($_POST['isdefault']){
                $sqlmap['isdefault'] = $_POST['isdefault'];
            }

            $result = $this->load->service('mobile/mobile_address')->lists($sqlmap);            
            echo json_encode(array("status"=>1,"datas"=>$result));
           
        }        
        
        
         /**
	*	用户余额收入明细ajax
	*/
        public function ajax_member_log() {  
            
            $sqlmap['mid'] = $this->member['id'];
            $sqlmap['type'] = 'money';
            $result = $this->load->service('mobile/mobile_log')->lists($sqlmap, 15, $_POST['page'], "id DESC");            
            echo json_encode(array("status"=>1,"datas"=>$result['lists']));        
           
        }        
        
        
         /**
	*	用户充值记录ajax
	*/
        public function ajax_member_deposit() {  
            
            $sqlmap['mid'] = $this->member['id'];
            $sqlmap['order_status'] = 1;
            $result = $this->load->service('mobile/mobile_deposit')->fetch($sqlmap, 15, $_POST['page'], "id DESC");
            
            echo json_encode(array("status"=>1,"datas"=>$result));        
           
        }       
        
        
         /**
	*	订单物流查询ajax
	*/
        public function ajax_order_delivery() {              
            
                $o_d_id = (int) $_POST['delivery_id'];
		$result = $this->load->service('order/delivery')->get_delivery_log($o_d_id);
		
                echo json_encode(array("status"=>1,"datas"=>$result));        
        }     
        
       
        
        /**
        * 用户登出
        */
       public function ajax_logout()
       {
           $this->load->service('mobile/mobile')->logout($this->member);
       }
       
       
       
       
        /**
     * 传回调写入
     * @param array $files 文件信息
     * @return mixed
     */
	public function write($file = array(), $iswrite = true) {
		if(empty($file)) {
			$this->error = lang('_param_error_');
			return FALSE;
		}
		if(!isset($file['aid'])) {
			$data = array(
				'module'   => $this->_config['module'] ? $this->_config['module'] : MODULE_NAME,
				'catid'    => 0,
				'mid'      => (int) $this->_config['mid'],
				'name'     => $file['name'],
				'filename' => $file['savename'],
				'filepath' => $file['savepath'],
				'filesize' => $file['size'],
				'fileext'  => $file['ext'],
				'isimage'  => (int) $file['isimage'],
				'filetype' => $file['type'],
				'md5'      => $file['md5'],
				'sha1'     => $file['sha1'],
				'width'    => (int) $file['width'],
				'height'   => (int) $file['height'],
				'url'      => $file['url'],
			);
            if(!defined('IN_ADMIN')) {
                $data['issystem'] = 1;
                $data['mid'] = ADMIN_ID;
            }
            if($iswrite === true) $this->load->table('attachment/attachment')->update($data);
			return $data;
		}
		return $file;
	}
       
       
        /**
     * 头像更改
     */
	public function ajax_avatar() {
		
            if(checksubmit('dosubmit')) {
			
                    $config = array('module'=>'member', 'path' => 'member', 'mid' => $this->member['id'],'allow_exts'=>array('bmp','jpg','jpeg','gif','png'));                    
                    
                    if($config['mid'] < 1) {
                             echo json_encode(array("status"=>0,"message"=>"上传失败"));      
                    }
                    $attach_type = $this->load->service('admin/setting')->get('attach_type');
                    $driver = $attach_type ? $attach_type : 'local';
                    $upload = new upload($config, $driver);
                    $result = $upload->upload("avatar");
                    if($result === FALSE) {
                            echo json_encode(array("status"=>0,"message"=>"上传失败"));      
                    }
                    $this->file = $this->write($result, $iswrite);
                    $avatar = $this->file['url'];                    
                    if(is_file($avatar) && file_exists($avatar)) {
                        
		        $ext = strtolower(pathinfo($avatar, PATHINFO_EXTENSION));
		        $name = basename($avatar, '.'.$ext);
		        $dir = dirname($avatar);
		        if(in_array($ext, array('gif','jpg','jpeg','bmp','png'))) {
		            $name = $name.'_crop_200_200.'.$ext;
		            $file = $dir.'/'.$name;
                            $image = new image($avatar);	                
                            $image->save($file);
                                if(file_exists($file)) {
                                    $avatar = getavatar($this->member['id'], false);
                                    dir::create(dirname($avatar));
                                    @rename($file, $avatar);
                                    echo json_encode(array("status"=>1,"message"=>"上传成功"));      
                                } else {
                                    echo json_encode(array("status"=>0,"message"=>"上传失败"));  
                                }
		        } else {
		        	echo json_encode(array("status"=>0,"message"=>"上传失败"));  
		        }
                    } else {
                            echo json_encode(array("status"=>0,"message"=>"上传失败"));  
                    }
                    
		}
    }
    
    
       /**
        * 用户订单列表
        */
       public function ajax_order_list()
       {
           // 查询条件
            $sqlmap = array();
            $sqlmap['buyer_id'] = $this->member['id'];
            if (isset($_GET['sn'])) $sqlmap['sn'] = array('LIKE','%'.$_GET['sn'].'%');
            if (!isset($_GET['type'])) $sqlmap['status'] = array('IN','1,2');
            $limit  = (isset($_GET['limit'])) ? $_GET['limit'] : 5;
            $orders = $this->load->service('order/order')->fetch($sqlmap, $limit, $_GET['page'], 'id DESC');                   
            echo json_encode(array("status"=>1,"datas"=>$orders));   
       }
        
       
       /**
        * 用户订单详情
        */
       public function ajax_order_info()
       {
            $o_d_id = remove_xss($_POST['delivery_id']);
            $detail = $this->load->service('order/order_sub')->sub_detail($_POST['sub_sn'] ,$o_d_id);
            if($detail){
                //更新跟踪物流
                if($detail['delivery_status'] > 0 && $o_d_id > 0){
                    $this->load->service('order/order_track')->update_api100($detail['sub_sn'],$o_d_id);
                    $detail = $this->load->service('order/order_sub')->sub_detail($_POST['sub_sn'] ,$o_d_id);
                }
                $detail['_member'] = $this->load->table('member/member')->find($detail['buyer_id']);
                $detail['_main'] = $this->load->service('order/order')->member_table_detail($detail['order_sn']);
                // 是否显示子订单号信息
                $detail['_showsubs'] = (count($detail['_main']['_subs']) > 1) ? TRUE : FALSE;

                echo json_encode(array("status"=>1,"datas"=>$detail));   
            }else{
                 echo json_encode(array("status"=>0,"message"=>"输入参数有误"));  
            }
            
          
       }
       
       
       /**
        * 用户订单取消
        */
       public function ajax_order_cancel()
       {                    
            $sub_sn = remove_xss($_POST['sub_sn']);
            $order = $this->load->service('order/order_sub')->find(array('sub_sn' => $sub_sn), 'buyer_id,order_sn');
            if ($order['buyer_id'] != $this->member['id']) echo json_encode(array("status"=>0,"message"=>"操作失败"));  
            $result = $this->load->service('order/order_sub')->set_order($sub_sn ,$action = 'order',$status = 2 ,array('msg'=>'用户取消订单','isrefund' => 1));

            model('order/order_trade')->where(array('order_sn'=>$order['order_sn']))->setField('status',-1);
            
            if($result){
                echo json_encode(array("status"=>1,"message"=>"操作成功"));   
            }else{
                echo json_encode(array("status"=>0,"message"=>"操作失败"));   
            }

       }
       
       
       /**
        * 用户订单确认收货
        */
       public function ajax_order_finish()
       {                    
            $sub_sn = remove_xss($_POST['sub_sn']);
            $order = $this->load->service('order/order_sub')->find(array('sub_sn' => $sub_sn), 'buyer_id');
            if ($order['buyer_id'] != $this->member['id']) echo json_encode(array("status"=>0,"message"=>"操作失败"));  
            $data = array();
            $data['msg'] = '确认订单商品收货';
            $data['o_delivery_id'] = remove_xss($_POST['delivery_id']);
            $result = $this->load->service('order/order_sub')->set_order($sub_sn ,'finish',1 ,$data);
            
            if($result){
                echo json_encode(array("status"=>1,"message"=>"操作成功"));   
            }else{
                echo json_encode(array("status"=>0,"message"=>"操作失败"));   
            }
          
       }
       
       
         /**
	*	添加到购物车
	*/
        public function ajax_cart_add() { 
                $goods_id = $_POST['goods_id'];
                $quantity = $_POST['quantity'];
                $params = array();
                $params[$goods_id] = $quantity;	
		
		$result = $this->load->service('order/cart')->cart_add($params , (int) $this->member['id'] ,$_GET['buynow']);
		if($result){
                    echo json_encode(array("status"=>1,"message"=>"添加成功"));   
                }else{
                    echo json_encode(array("status"=>0,"message"=>"添加失败"));   
                }
	}
        
        
          /**
	*	购物车商品数量修改
	*/
        public function ajax_cart_set_nums() { 
                $goods_id = $_POST['goods_id'];
                $quantity = $_POST['quantity'];        
		
		$result = $this->load->service('order/cart')->set_nums($goods_id , $quantity , (int) $this->member['id']);
		if($result){
                    echo json_encode(array("status"=>1,"message"=>"修改成功"));   
                }else{
                    echo json_encode(array("status"=>0,"message"=>"修改失败"));   
                }
	}
        
        
          /**
	*	购物车商品列表
	*/
        public function ajax_cart_lists() { 
         
		$result = $this->load->service('order/cart')->get_cart_lists((int) $this->member['id'] ,'',TRUE);		
                
                echo json_encode(array("status"=>1,"datas"=>$result));   
		
	}
       
       
           /**
	*	立即购买
	*/
        public function ajax_now_buy() {        
		$district_id = $this->member['_address'][0]['district_id'];
		$skuids = $_POST['sku_id'].",".$_POST['sku_num'];
		if (isset($_POST['district_id']) && is_numeric($_POST['district_id'])) {
			$district_id = (int) $_POST['district_id'];
		}
		
		$result =  $this->load->service('order/order')->create($this->member['id'], $skuids , $district_id, 1, $deliverys, $order_prom, $sku_prom, $remarks, $invoices, true);
		if (!$result) {
			echo json_encode(array("status"=>0,"message"=>"生成订单失败"));   
                        exit;
		}
		runhook('after_create_order',$result);
		echo json_encode(array("status"=>1,"message"=>"生成订单成功")); 
		
	}
        
        
           /**
	*	购物车结算
	*/
        public function ajax_cart_buy() {        
		$district_id = $this->member['_address'][0]['district_id'];                
                
                $skuids = $_POST['sku_ids'];
		if (isset($_POST['district_id']) && is_numeric($_POST['district_id'])) {
			$district_id = (int) $_POST['district_id'];
		}
		
		$result =  $this->load->service('order/order')->create($this->member['id'], $skuids , $district_id, 1, $deliverys, $order_prom, $sku_prom, $remarks, $invoices, true);
		if (!$result) {
			echo json_encode(array("status"=>0,"message"=>"生成订单失败"));   
                        exit;
		}
		runhook('after_create_order',$result);
		echo json_encode(array("status"=>1,"message"=>"生成订单成功")); 
		
	}
       
        
          /**
	*	支付列表
	*/
        public function ajax_payment_list() {        
            
            // 后台设置-余额支付 1:开启，0：关闭
            $setting = $this->load->service('admin/setting')->get();
            $balance_pay = $setting['balance_pay'];
            $member_info = $this->member;
            $pays = $setting['pays'];
            
            $payments = $this->load->service('pay/payment')->getpayments('wap', $pays);
            
            echo json_encode(array("status"=>1,"datas"=>$payments)); 
        }
        
        
        /**
	*	文件上传
	*/
         public function file_upload() {            
			
                    $config = array('module'=>'member', 'path' => 'member', 'mid' => $this->member['id'],'allow_exts'=>array('bmp','jpg','jpeg','gif','png'));                    
                    
                    if($config['mid'] < 1) {
                             echo json_encode(array("status"=>0,"message"=>"上传失败"));      
                    }
                    $attach_type = $this->load->service('admin/setting')->get('attach_type');
                    $driver = $attach_type ? $attach_type : 'local';
                    $upload = new upload($config, $driver);
                    $result = $upload->upload("imgs");
                    if($result === FALSE) {
                            echo json_encode(array("status"=>0,"message"=>"上传失败"));      
                    }
                    $this->file = $this->write($result, $iswrite);
                    
                    return $this->file;
         }
        
        
          /**
	*	用户退款退货
	*/
        public function ajax_return_refund() {        
                
                if(checksubmit('dosubmit')) {
                    $upload_file = $this->file_upload();
   
                    if($upload_file){
                        $files = array();
                        array_push($files, $upload_file['url']);
                        $operator = get_operator();
                        $result = $this->load->service('order/order_server')->create_return($_POST['order_id'] ,$_POST['amount'] ,$_POST['cause'] ,$_POST['desc'],$files,$operator['id'],$operator['operator_type']);

                        if($result){
                            echo json_encode(array("status"=>1,"message"=>"生成退款单成功")); 
                        }else{
                            echo json_encode(array("status"=>0,"message"=>"生成退款单失败")); 
                        }
                    }else{
                        echo json_encode(array("status"=>0,"message"=>"上传文件失败")); 
                    }
                }
        }
        
        
         /**
	*	退货单信息填写
	*/
        public function ajax_return_save() {        
                $operator = get_operator();	// 获取操作者信息
		$return_id = $this->load->service('order/order')->order_return_field('id', array('o_sku_id'=>$_POST['order_id']));
		$result = $this->load->service('order/order_server')->return_goods($return_id,$_POST['delivery_name'],$_POST['delivery_sn'], $operator['id'], $operator['operator_type']);
		$refund = $this->load->service('order/order')->order_refund_find(array('o_sku_id'=>$_POST['order_id']));
		// 创建退款日志
		$log['refund_id']     = $refund['id'];
		$log['order_sn']      = $refund['order_sn'];
		$log['sub_sn']        = $refund['sub_sn'];
		$log['o_sku_id']      = $refund['o_sku_id'];
		$log['operator_id']   = $operator['id'];
		$log['operator_name'] = $operator['username'];
		$log['operator_type'] = $operator['operator_type'];
		$log['action']           = '用户发货完毕';
		$log['msg'] = $_POST['mark'];
		$this->load->service('order/order')->order_refund_log_update($log);
                
                if($refund){
                     echo json_encode(array("status"=>1,"message"=>"提交成功")); 
                }else{
                     echo json_encode(array("status"=>0,"message"=>"提交失败")); 
                }
                
        }
        
        
          /**
	*	消息列表
	*/
        public function ajax_message_list() {        
            
                $sqlmap = array();
		$sqlmap['mid'] = $this->member['id'];
		if(isset($_POST['status'])){
			$sqlmap['status'] = (int)$_POST['status'];
		}
		$_POST['limit'] = $_POST['limit'] ? $_POST['limit'] : 15;
		$result = $this->load->service('member/member_message')->lists($sqlmap, $_POST['limit'], $_POST['page'], 'dateline desc');
		
                echo json_encode(array("status"=>1,"datas"=>$result['lists'])); 
        }
        
        
        
         /**
	*	订单评价
	*/
        public function ajax_order_evaluate() {       
            
		if(checksubmit('dosubmit')) {
                        $pic = $this->comoment_pic($_POST['tid']);
                        if(!$pic){
                            echo json_encode(array("status"=>0,"message"=>"图片上传失败")); 
                        }
                        $pic_arr = array();
                        array_push($pic_arr, $pic);
                        $data = array();
                        $data['id'] = 0;			
			$data['mid'] = $this->member['id'];
			$data['username'] = $this->member['username'];
                        $data['content'] = $_POST['content'];
                        $data['mood'] = $_POST['mood'];
			
                        $data['imags'] = $pic_arr;
                        $data['tid'] = $_POST['tid'];
                        $data['page'] = 1;
                        $result = $this->load->service('comment/comment')->add($data);  
                        
                        if($result){
                            echo json_encode(array("status"=>1,"message"=>"评价成功")); 
                        }else{
                            echo json_encode(array("status"=>0,"message"=>"评价失败")); 
                        }
		} 
        }
        
        
        
     /**
     * 晒图内容
     */
	public function comoment_pic($tid) {
		
            if(checksubmit('dosubmit')) {
			
                    $config = array('module'=>'member', 'path' => 'member', 'mid' => $this->member['id'],'allow_exts'=>array('bmp','jpg','jpeg','gif','png'));                    
                    
                    if($config['mid'] < 1) {
                             echo json_encode(array("status"=>0,"message"=>"上传失败"));      
                    }
                    $attach_type = $this->load->service('admin/setting')->get('attach_type');
                    $driver = $attach_type ? $attach_type : 'local';
                    $upload = new upload($config, $driver);
                    $result = $upload->upload("comment_pic");
                    if($result === FALSE) {
                            echo json_encode(array("status"=>0,"message"=>"上传失败"));      
                    }
                    $this->file = $this->write($result, $iswrite);
                    $avatar = $this->file['url'];                    
                    if(is_file($avatar) && file_exists($avatar)) {
                        
		        $ext = strtolower(pathinfo($avatar, PATHINFO_EXTENSION));
		        $name = basename($avatar, '.'.$ext);
		        $dir = dirname($avatar);
		        if(in_array($ext, array('gif','jpg','jpeg','bmp','png'))) {
		            $name = $name.'_crop_200_200.'.$ext;
		            $file = $dir.'/'.$name;
                            $image = new image($avatar);	                
                            $image->save($file);
                                if(file_exists($file)) {
                                    $avatar = './uploadfile/common/'.$tid.'/'.$tid.".".$ext;
                                    dir::create(dirname($avatar));
                                    @rename($file, $avatar);
                                    return $avatar;   
                                } else {
                                    return false;
                                }
		        } else {
		        	return false;
		        }
                    } else {
                            return false;
                    }
                    
		}
    }
        
}