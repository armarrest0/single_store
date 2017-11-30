<?php
hd_core::load_class('init', 'mobile');
class public_control extends init_control
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
	*	用户地址信息ajax
	*/
//        public function ajax_member_address() {     
//                $sqlmap = array();
//                $sqlmap['mid'] = $_POST['mid'];                
//                $lists = $this->load->service('mobile/member_address')->lists($sqlmap, 5,$_POST['page']);           
//                if($lists){
//                    echo json_encode(array("status"=>1,"datas"=>$lists));
//                }else{
//                    echo json_encode(array("status"=>0,"error"=>"暂无数据"));
//                }
//	}
        
        
        
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
            
            $order_id = $_POST['order_id'];
            $order_delivery = $this->load->service('order/delivery')->order_delivery_find(array('id' => $order_id));

            //更新物流跟踪
            if($order_id > 0){
                $this->load->service('order/order_track')->update_api100($order_delivery['sub_sn'],$order_id);
            }
            $info = array();
            $info['delivery'] = $this->load->service('order/delivery')->find(array('id' => $order_delivery['delivery_id']));
            $info['tracks'] = $this->load->service('order/order_track')->get_tracks_by_sn($order_delivery['sub_sn']);
            
           echo json_encode(array("status"=>1,"datas"=>$info));        
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
                            $this->error = lang('no_promission_upload','attachment/language');
                            return FALSE;
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
       
}