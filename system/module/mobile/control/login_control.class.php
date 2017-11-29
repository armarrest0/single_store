<?php
hd_core::load_class('init', 'mobile');
class login_control extends baselogin_control{
    public function _initialize() {
		parent::_initialize();
		$this->mb_token_table = $this->load->table('mb_user_token');
		$this->service = $this->load->service('mobile/mobile');
		$this->notify_service = $this->load->service('notify/notify');
		$this->notify_template_service = $this->load->service('notify/notify_template');
	}
        
        
        /**
        * 登录生成token
        */
       private function _get_token($member_id, $member_name, $client) {         
                   
           $this->mb_token_table->where(array("member_id"=>$member_id))->delete();
                
           //生成新的token
           $mb_user_token_info = array();
           $token = md5(strval(TIMESTAMP) . strval(rand(0,999999)));
           $mb_user_token_info['member_id'] = $member_id;
           $mb_user_token_info['member_name'] = $member_name;
           $mb_user_token_info['token'] = $token;
           $mb_user_token_info['login_time'] = TIMESTAMP;
           $mb_user_token_info['client_type'] = $client;
    
           $result = $this->mb_token_table->add($mb_user_token_info);


           if($result) {
               return $token;
           } else {
               return '';
           }

       }
	        
        /**
	*	登录ajax
	*/
        public function ajax_login() {
                
                $password = $_POST['password'];
		$memberinfo = $this->service->ajax_member_info(array("username"=>$_POST['username']));
            
                if(!$memberinfo || md5(md5($password).$memberinfo['encrypt']) != $memberinfo['password']) {
                    echo json_encode(array("status"=>0,"error"=>"账号密码错误"));
                } else {
                    $token = $this->_get_token($memberinfo['id'], $memberinfo['username'], 'app');
                    if($token) {
                        echo json_encode(array("status"=>1,"datas"=>$memberinfo, 'key' => $token));     
                    } else {
                        echo json_encode(array("status"=>0,"error"=>"账号密码错误"));
                    }
                }
            
	}
}