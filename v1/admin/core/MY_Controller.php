<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author  rdisme
 * 常用方法的快捷方式
 * 请勿更改！！！
 */
class MY_Controller extends CI_Controller
{

	// 当前登录用户信息
	protected $userinfo;
	// 当前登录用户的角色信息
	protected $roleinfo;
	// 当前访问控制器名
	protected $c;
	// 当前访问方法名
	protected $m;
	// 当前访问方式
	protected $method;
	// 当前用户IP
	protected $userIP;
	// 登录日志
	protected $authorLog;
	// 登录地址
	protected $loginUrl;
	// 首页地址
	protected $indexUrl;


	public function __construct()
	{
		parent::__construct();
		// 角色表
		$this->load->model('user');
		// 用户表
		$this->load->model('role');
		// 权限表
		$this->load->model('rule');
		// 登录模块
		$this->load->library('LoginLib','','LoginLib');
		// 初始地址
		$this->loginUrl = '/' . $this->config->item('index_page') . '?c=login';
		$this->indexUrl = '/' . $this->config->item('index_page') . '?c=index';
		// 获取当前控制器、方法名
		$this->c = $this->input->get('c');
		$this->m = $this->input->get('m');
		$this->c = empty($this->c)? 'index': $this->c;
		$this->m = empty($this->m)? 'index': $this->m;
		$this->method = $this->input->method(true); // 获取method
		$this->userIP = $this->input->ip_address(); // 获取uip
		// 审核当前登录用户
		$this->authorCheck();
	}


	// 审核当前登录用户
	protected function authorCheck()
	{
		// 初始化日志
		$this->authorLog = 'logtype:admin';
		$this->authorLog .= '|ip:' . $this->userIP;
		$this->authorLog .= '|method:' . $this->method;
		$this->authorLog .= '|c:' . $this->c . '|m:' . $this->m;
		$status = 200;
		// 校验除了登录页面之外的所有链接
		if ('login' != $this->c) {
			$status = $this->ruleCheck();
		}
		// log status
		$this->authorLog .= '|status:'.$status;
		// log run
		log_message('error',$this->authorLog);
		// redirect by err status
		if (200 !== $status) {
			$this->redirectByStatus($status);
		}
	}


	// 判断是否登录
	// 主要用于除了登录页面之外的登录判断
	protected function redirectByStatus($status)
	{
		switch ($status) {
			case 401:
				$desc = '未登录或者缓存已过期！';
				break;
			case 402:
				$desc = '账号异常！';
				break;
			case 403:
				$desc = '角色信息异常！';
				break;
			case 406:
				$desc = '权限不足！';
				// 清除登录缓存
				$this->LoginLib->delLoginStatus();
				break;
			default:
				$desc = '权限不足！';
				break;
		}
		// echo by get method
		if ('GET' == $this->method) {
			// 需要跳转的情况
			if (in_array($status, array(401,402,403))) {
				$alert = 401 == $status? '': "alert('$desc');";
				die("<script>{$alert}window.location.href='{$this->loginUrl}'</script>");
			}
			die($desc);
		}
		// echo by post method
		die(json_encode(array('ret'=>99999,'desc'=>$desc)));
	}


	// 用户权限判断
	// 200 通过权限判断
	// 401 登录缓存过期
	// 402 缓存UID未能找到正常的用户（账号异常）
	// 403 角色信息异常
	// 404 本次链接未备案 不对普通管理员开放
	// 405 当前管理员权限不足访问
	protected function ruleCheck()
	{
		// 判断登录状态
		if (200 !== $status = $this->getLoginStatus()) {
			return $status;
		}
		// log uid
		$this->authorLog .= '|uid:' . $this->userinfo['id'];
		// log username
		$this->authorLog .= '|username:' . $this->userinfo['username'];
		// ip check
		// if (! in_array($this->userIP, explode(',', $this->userinfo['ip']))) {
			// return 406;
		// }
		// 根据用户ID获取角色信息
		if (! $this->roleinfo = $this->role->getRuleidsById($this->userinfo['roleid'])) {
			return 403;
		}
		// 超级管理员
		if ('admin' == $this->roleinfo['ruleid']) {
			return 200;
		}
		// 查看本次访问链接是否备案
		if (! $ruleinfo = $this->rule->getRowByCM($this->c, $this->m)) {
			return 404;
		}
		// 判断当前登录用户是否具有当前访问链接权限
		if (! in_array($ruleinfo['id'], explode(',', $this->roleinfo['ruleid']))) {
			return 405;
		}
		// 通过权限判断
		return 200;
	}


	// 获取登录状态
	protected function getLoginStatus()
	{
		$userCacheInfo = $this->LoginLib->cacheLoginStatus();
		$uid = $userCacheInfo['uid'];
		// 缓存失效
		if( ! $uid) {
			return 401;
		}
		// 该uid未匹配到数据
		if( ! $this->userinfo = $this->user->getRowById($uid)) {
			return 402;
		}
		return 200;
	}

}