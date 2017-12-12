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
                        $global_list = array();
                        $ads_list = array();
                        $search_list = array();
                        $spacing_list = array();
                        $goods_list = array();
                        $cube_list = array();
                        $nav_list = array();
                        $notice_list = array();
			foreach ($_GET['content'] AS $k=>$value) {
				$content_arr[] = '<!--'.$value.'-->';
				preg_match_all('/diy global\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$global_tml = json_decode(base64_decode($arr[1][0]),TRUE);      
                                        $global_list[$k] = $global_tml;
                                        $row = $this->load->table('mb_items')->where(array("item_type"=>'global'))->find();
                                        if($row){
                                            $this->load->table('mb_items')->where(array("item_type"=>'global'))->delete();
                                        }
                                        
				}          
                                
                                preg_match_all('/diy ads\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$ads_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $ads_list[$k] = $ads_tml;
                                        $row = $this->load->table('mb_items')->where(array("item_type"=>'ads'))->find();
                                        if($row){
                                            $this->load->table('mb_items')->where(array("item_type"=>'ads'))->delete();
                                        }

				}
                                
                                preg_match_all('/diy search\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$search_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $search_list[$k] = $search_tml;
                                        $row = $this->load->table('mb_items')->where(array("item_type"=>'search'))->find();
                                        if($row){
                                            $this->load->table('mb_items')->where(array("item_type"=>'search'))->delete();
                                        }

				}
                                
                                preg_match_all('/diy spacing\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$spacing_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $spacing_list[$k] = $spacing_tml;
                                        $row = $this->load->table('mb_items')->where(array("item_type"=>'spacing'))->find();
                                        if($row){
                                            $this->load->table('mb_items')->where(array("item_type"=>'spacing'))->delete();
                                        }
				}
                                
                                preg_match_all('/diy goods\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$goods_tml = json_decode(base64_decode($arr[1][0]),TRUE);                                      
                                        $goods_list[$k] = $goods_tml;
                                        $row = $this->load->table('mb_items')->where(array("item_type"=>'goods'))->find();
                                        if($row){
                                            $this->load->table('mb_items')->where(array("item_type"=>'goods'))->delete();
                                        }
				}
                                
                                preg_match_all('/diy cube\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$cube_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $cube_list[$k] = $cube_tml;
                                        $row = $this->load->table('mb_items')->where(array("item_type"=>'cube'))->find();
                                        if($row){
                                            $this->load->table('mb_items')->where(array("item_type"=>'cube'))->delete();
                                        }
				}
                                
                                preg_match_all('/diy nav\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$nav_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $nav_list[$k] = $nav_tml;
                                        $row = $this->load->table('mb_items')->where(array("item_type"=>'nav'))->find();
                                        if($row){
                                            $this->load->table('mb_items')->where(array("item_type"=>'nav'))->delete();
                                        }

				}
                                
                                preg_match_all('/diy notice\s+(.+)}/',$value,$arr);
				if($arr[1]){
					$notice_tml = json_decode(base64_decode($arr[1][0]),TRUE);
                                        $notice_list[$k] = $notice_tml;
                                        $row = $this->load->table('mb_items')->where(array("item_type"=>'notice'))->find();
                                        if($row){
                                            $this->load->table('mb_items')->where(array("item_type"=>'notice'))->delete();
                                        }
				}  
			}
                        
                       ;
                        foreach($_GET['content'] as $k=>$v){
                           if($global_list[$k]){
                                $row = $this->load->table('mb_items')->where(array("item_type"=>'global'))->find();
                                if($row){
                                    continue;
                                }else{
                                    $item_data['item_data'] = serialize($global_list);
                                    $item_data['item_type'] = 'global';
                                    $item_data['item_usable'] = 1;
                                    $item_data['item_sort'] = $k+1;                             
                                    $this->load->table('mb_items')->update($item_data);
                                }
                                
                           }elseif($ads_list[$k]){
                                $row = $this->load->table('mb_items')->where(array("item_type"=>'ads'))->find();
                                if($row){
                                    continue;
                                }else{
                                    $item_data['item_data'] = serialize($ads_list);
                                    $item_data['item_type'] = 'ads';
                                    $item_data['item_usable'] = 1;
                                    $item_data['item_sort'] = $k+1;                             
                                    $this->load->table('mb_items')->update($item_data);
                                }
                                
                           }elseif($search_list[$k]){
                                $row = $this->load->table('mb_items')->where(array("item_type"=>'search'))->find();
                                if($row){
                                    continue;
                                }else{
                                    $item_data['item_data'] = serialize($search_list);
                                    $item_data['item_type'] = 'search';
                                    $item_data['item_usable'] = 1;
                                    $item_data['item_sort'] = $k+1;                             
                                    $this->load->table('mb_items')->update($item_data);
                                }
                                
                           }elseif($spacing_list[$k]){
                                $row = $this->load->table('mb_items')->where(array("item_type"=>'spacing'))->find();
                                if($row){
                                    continue;
                                }else{
                                    $item_data['item_data'] = serialize($spacing_list);
                                    $item_data['item_type'] = 'spacing';
                                    $item_data['item_usable'] = 1;
                                    $item_data['item_sort'] = $k+1;                             
                                    $this->load->table('mb_items')->update($item_data);
                                }
                                
                           }elseif($goods_list[$k]){
                                $row = $this->load->table('mb_items')->where(array("item_type"=>'goods'))->find();
                                if($row){
                                    continue;
                                }else{
                                    $item_data['item_data'] = serialize($goods_list);
                                    $item_data['item_type'] = 'goods';
                                    $item_data['item_usable'] = 1;
                                    $item_data['item_sort'] = $k+1;                             
                                    $this->load->table('mb_items')->update($item_data);
                                }
                                
                           }elseif($cube_list[$k]){
                                $row = $this->load->table('mb_items')->where(array("item_type"=>'cube'))->find();
                                if($row){
                                    continue;
                                }else{
                                    $item_data['item_data'] = serialize($cube_list);
                                    $item_data['item_type'] = 'cube';
                                    $item_data['item_usable'] = 1;
                                    $item_data['item_sort'] = $k+1;                             
                                    $this->load->table('mb_items')->update($item_data);
                                }
                                
                           }elseif($nav_list[$k]){
                                $row = $this->load->table('mb_items')->where(array("item_type"=>'nav'))->find();
                                if($row){
                                    continue;
                                }else{
                                    $item_data['item_data'] = serialize($nav_list);
                                    $item_data['item_type'] = 'nav';
                                    $item_data['item_usable'] = 1;
                                    $item_data['item_sort'] = $k+1;                             
                                    $this->load->table('mb_items')->update($item_data);
                                }
                                
                           }elseif($notice_list[$k]){
                                $row = $this->load->table('mb_items')->where(array("item_type"=>'notice'))->find();
                                if($row){
                                    continue;
                                }else{
                                    $item_data['item_data'] = serialize($notice_list);
                                    $item_data['item_type'] = 'notice';
                                    $item_data['item_usable'] = 1;
                                    $item_data['item_sort'] = $k+1;                             
                                    $this->load->table('mb_items')->update($item_data);
                                }                                
                           }else{
                               continue;
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