<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author rdisme
 * 后台首页
 */
class Index extends MY_Controller
{

	// index控制器必须添加构造函数才能正常访问
	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$data = array();
		$data['userinfo'] = $this->userinfo;
		// 获取个人菜单栏
		$data['selfMenus'] = $this->rule->getRuleByid($this->roleinfo['ruleid']);
		$this->load->view('index',$data);
	}

}