<?php
class init_control extends control
{
	public function _initialize() {
		defined('IN_PLUGIN') OR define('IN_PLUGIN', TRUE);
		parent::_initialize();
		$this->member = $this->load->service('mobile/mobile')->init();
		$this->load->librarys('View')->assign('member',$this->member);
		define('SKIN_PATH', __ROOT__.(str_replace(DOC_ROOT, '', TPL_PATH)).config('TPL_THEME').'/');

		
	}
}

class baselogin_control extends control
{
	public function _initialize() {
		defined('IN_PLUGIN') OR define('IN_PLUGIN', TRUE);
		parent::_initialize();				
		define('SKIN_PATH', __ROOT__.(str_replace(DOC_ROOT, '', TPL_PATH)).config('TPL_THEME').'/');

		
	}
}