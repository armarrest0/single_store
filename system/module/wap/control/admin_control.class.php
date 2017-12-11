<?php
hd_core::load_class('init', 'admin');
class admin_control extends init_control {
	public function _initialize() {
		parent::_initialize();
		helper('attachment');
		$this->sku_service = $this->load->service('goods/goods_sku');
		$this->wap_template_service = $this->load->service('wap/wap_template');
		$this->category_service = $this->load->service('goods_category');
	}

	public function setting() {
		if(checksubmit('dosubmit')) {
			$load = hd_load::getInstance();
			$this->config = $load->librarys('hd_config');
			$data = array();
			$data['wap_enabled'] = (int) $_GET['wap_enabled'];
			$data['is_jump'] = (int) $_GET['is_jump'];
			$data['display_mode'] = (int) $_GET['display_mode'];
			$data['wap_domain'] = (string) $_GET['wap_domain'];
			$this->config->file('wap')->note('微店设置')->space(8)->to_require($data);
			showmessage(lang('_operation_success_'), url('setting'), 1);
		} else {
			$setting = array();
			$setting['wap_enabled'] = config('wap_enabled','wap');
			$setting['is_jump'] = config('is_jump','wap');
			$setting['wap_domain'] = config('wap_domain','wap');
			$setting['display_mode'] = config('display_mode','wap');
			$this->load->librarys('View')->assign('setting',$setting)->display('setting');
		}
	}

	public function diy() {
		$this->load->librarys('View')->display('diy');
	}

	public function diy_edit(){
		if(checksubmit('do_submit')){
			$path = DOC_ROOT.'template/wap/goods/index.html';
			if(!is_writable($path)){
				showmessage('模板文件没有写入权限，请检查！','',0);
			}
			$content_arr = array();
                        $item_data = array();
			foreach ($_GET['content'] AS $value) {
				$content_arr[] = '<!--'.$value.'-->';
				preg_match_all('/diy global\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$global_tml = json_decode(base64_decode($arr[1][0]),TRUE);                  
                                        $item_data = $this->load->table('mb_items')->where(array("item_type"=>'global'))->find();
                                        $item_data['item_data'] = serialize($global_tml);
                                        $item_data['item_type'] = 'global';
                                        $item_data['item_usable'] = 1;
                                        $item_data['item_sort'] = 1;
                             
                                        $this->load->table('mb_items')->update($item_data);
				}                                
                                
                                
                                preg_match_all('/diy ads\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$ads_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $item_data = $this->load->table('mb_items')->where(array("item_type"=>'ads'))->find();
                                        $item_data['item_data'] = serialize($ads_tml);
                                        $item_data['item_type'] = 'ads';
                                        $item_data['item_usable'] = 1;
                                        $item_data['item_sort'] = 2;
                                        $this->load->table('mb_items')->update($item_data);
				}
                                
                                preg_match_all('/diy search\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$search_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $item_data = $this->load->table('mb_items')->where(array("item_type"=>'search'))->find();
                                        $item_data['item_data'] = serialize($search_tml);
                                        $item_data['item_type'] = 'search';
                                        $item_data['item_usable'] = 1;
                                        $item_data['item_sort'] = 3;
                                        $this->load->table('mb_items')->update($item_data);
				}
                                
                                preg_match_all('/diy spacing\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$spacing_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $item_data = $this->load->table('mb_items')->where(array("item_type"=>'spacing'))->find();
                                        $item_data['item_data'] = serialize($spacing_tml);
                                        $item_data['item_type'] = 'spacing';
                                        $item_data['item_usable'] = 1;
                                        $item_data['item_sort'] = 4;
                                        $this->load->table('mb_items')->update($item_data);
				}
                                
                                preg_match_all('/diy goods\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$goods_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $item_data = $this->load->table('mb_items')->where(array("item_type"=>'goods'))->find();
                                        $item_data['item_data'] = serialize($goods_tml);
                                        $item_data['item_type'] = 'goods';
                                        $item_data['item_usable'] = 1;
                                        $item_data['item_sort'] = 5;
                                        $this->load->table('mb_items')->update($item_data);
				}
                                
                                preg_match_all('/diy cube\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$cube_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $item_data = $this->load->table('mb_items')->where(array("item_type"=>'cube'))->find();
                                        $item_data['item_data'] = serialize($cube_tml);
                                        $item_data['item_type'] = 'cube';
                                        $item_data['item_usable'] = 1;
                                        $item_data['item_sort'] = 6;
                                        $this->load->table('mb_items')->update($item_data);
				}
                                
                                preg_match_all('/diy nav\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$nav_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $item_data = $this->load->table('mb_items')->where(array("item_type"=>'nav'))->find();
                                        $item_data['item_data'] = serialize($nav_tml);
                                        $item_data['item_type'] = 'nav';
                                        $item_data['item_usable'] = 1;
                                        $item_data['item_sort'] = 7;
                                        $this->load->table('mb_items')->update($item_data);
				}
                                
                                preg_match_all('/diy notice\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$notice_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $item_data = $this->load->table('mb_items')->where(array("item_type"=>'notice'))->find();
                                        $item_data['item_data'] = serialize($notice_tml);
                                        $item_data['item_type'] = 'notice';
                                        $item_data['item_usable'] = 1;
                                        $item_data['item_sort'] = 8;
                                        $this->load->table('mb_items')->update($item_data);
				}                                
                              
			}
                        
			cache('wap_global',$global_tml);
			$content = '{template header goods}'."\r\n".'<body>'."\r\n".implode("\r\n",$content_arr)."\r\n".'</body>'."\r\n".'</html>';
			@file_put_contents($path, $content);
			showmessage('保存成功！',url('wap/admin/diy_edit'),1);
		}else{
			$cache = $this->load->service('goods/goods_category')->get();
			$category = $this->load->service('goods/goods_category')->get_category_tree($cache);
			$attachment_init = attachment_init(array('module'=>'wap','path' => 'common','mid' => $this->admin['id'],'allow_exts' => array('gif','jpg','jpeg','bmp','png')));
			foreach (array('网站首页','会员主页','购物车页','全部分类页','商品及分类') as $link) {
				switch ($link) {
					case '网站首页':
						$data['title'] = '网站首页';
						$data['name'] = 'index';
						$data['type'] = 'link';
						$data['link'] = __APP__;
						break;
					case '会员主页':
						$data['title'] = '会员主页';
						$data['name'] = 'member';
						$data['type'] = 'link';
						$data['link'] = url('member/index/index');
						break;
					case '购物车页':
						$data['title'] = '购物车页';
						$data['name'] = 'cart';
						$data['type'] = 'link';
						$data['link'] = url('order/cart/index');
						break;
					case '全部分类页':
						$data['title'] = '全部分类页';
						$data['name'] = 'classify';
						$data['type'] = 'link';
						$data['link'] = url('goods/index/category_lists');
						break;
					case '商品及分类':
						$data['title'] = '商品及分类';
						$data['name'] = 'goods';
						$data['type'] = 'popup';
						$data['link'] = url('wap/admin/goods_list');
						break;
					default:
						break;
				}
				$links[] = $data;
			}
			$tmpl = @file_get_contents(DOC_ROOT.'template/wap/goods/index.html');
			$this->load->librarys('View')->assign('category',$category)->assign('attachment_init',$attachment_init)->assign('links',$links)->assign('tmpl',$tmpl)->display('diy_edit');
		}
	}

	public function nav(){
		if(checksubmit('do_submit')){
			$content = '<!--'.$_GET['content'][0].'-->';
			$id = $this->wap_template_service->getField('id',array('identifier'=>"menu"));
			$data = array();
			$data['id'] = $id;
			$data['content'] = $content;
			$data['identifier'] = "menu";
			$state = $this->wap_template_service->update($data);
 			$content = '{template header goods}'."\r\n".'<body>'."\r\n".implode("\r\n",$content)."\r\n".'</body>'."\r\n".'</html>';
			@file_put_contents($path, $content);
			showmessage('保存成功！',url('wap/admin/nav'),1);
		}else{
			$list = $this->wap_template_service->getField('content',array('identifier'=>"menu"));
			$attachment_init = attachment_init(array('module'=>'wap', 'path' => 'common','mid' => $this->admin['id'],'allow_exts' => array('gif','jpg','jpeg','bmp','png')));
			foreach (array('网站首页','会员主页','购物车页','全部分类页','商品及分类') as $link) {
				switch ($link) {
					case '网站首页':
						$data['title'] = '网站首页';
						$data['name'] = 'index';
						$data['type'] = 'link';
						$data['link'] = __APP__;
						break;
					case '会员主页':
						$data['title'] = '会员主页';
						$data['name'] = 'member';
						$data['type'] = 'link';
						$data['link'] = url('member/index/index');
						break;
					case '购物车页':
						$data['title'] = '购物车页';
						$data['name'] = 'cart';
						$data['type'] = 'link';
						$data['link'] = url('order/cart/index');
						break;
					case '全部分类页':
						$data['title'] = '全部分类页';
						$data['name'] = 'classify';
						$data['type'] = 'link';
						$data['link'] = url('goods/index/category_lists');
						break;
					case '商品及分类':
						$data['title'] = '商品及分类';
						$data['name'] = 'goods';
						$data['type'] = 'popup';
						$data['link'] = url('wap/admin/goods_list');
						break;
					default:
						break;
				}
				$links[] = $data;
			}
			$this->load->librarys('View')->assign('category',$category)->assign('attachment_init',$attachment_init)->assign('links',$links)->assign('list',$list)->display('nav');
		}
	}


	public function goods_list() {
		$_GET['limit'] = (isset($_GET['limit']) && is_numeric($_GET['limit'])) ? $_GET['limit'] : 5;
		$skus = $this->sku_service->get_lists($_GET);
		$pages = $this->admin_pages($skus['count'], $_GET['limit']);
		$this->load->librarys('View')->assign('skus',$skus)->assign('pages',$pages)->display('goods_list');
	}

	public function goods_category(){
		$result = $this->category_service->category_lists();
		$this->load->librarys('View')->assign('result',$result)->display('goods_category');
	}

	public function ajax_category(){
		$result = $this->category_service->ajax_category($_GET['id']);
		if(!$result){
			showmessage($this->category_service->error,'',0,'','json');
		}else{
			$this->load->librarys('View')->assign('result',$result);
			$result = $this->load->librarys('View')->get('result');
			showmessage(lang('_operation_success_'),'',1,$result,'json');
		}
	}
}