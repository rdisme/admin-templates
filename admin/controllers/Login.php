<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author rdisme
 * 微厅后台 登录页面
 */
class Login extends MY_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library('captcha');
	}


	// 登录页面
	public function index()
	{
		// 已登录
		if(200 === $this->getLoginStatus()) {
			header("location:{$this->indexUrl}");
		} else {
			// 生成验证码
			$cap = $this->captcha->get();
			// 缓存验证码
			$this->LoginLib->cacheCaptcha($cap['word']);
			$data = array();
			$data['image'] = $cap['image'];
			$this->load->view('login/login',$data);
		}
	}


	// post ajax 登录校验
	// 后期可改造登录密码错误次数限制
	public function valid()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$captchaWord = $this->input->post('captcha');
		// 校验参数
		if (! ($username && $password && $captchaWord)) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		// 校验密码输入次数
		if (false === $this->LoginLib->cachePassError($username,6)) {
			die(json_encode(array('ret'=>405,'desc'=>'密码错误次数过多！当前账号已被限制登录！')));
		}
		// 校验随机验证码
		if (! $this->captchaCheck($captchaWord)) {
			die(json_encode(array('ret'=>404,'desc'=>'验证码错误！')));
		}
		// 判断账号密码是否正确
		if (! $userinfo = $this->user->getRowByPsd($username,$password)) {
			// 密码错误更新输入次数
			$errorNum = $this->LoginLib->cachePassError($username);
			die(json_encode(array('ret'=>401,'desc'=>'账号或密码错误！已输错'.$errorNum.'次！')));
		}
		// 判断用户状态
		if (1 != $userinfo['status']) {
			die(json_encode(array('ret'=>402,'desc'=>'用户状态异常！')));
		}
		// 判断IP
		// if (! in_array($this->userIP, explode(',', $userinfo['ip']))) {
		// 	die(json_encode(array('ret'=>403,'desc'=>'用户权限不足！')));	
		// }
		// 设置缓存uid
		$this->LoginLib->cacheLoginStatus($userinfo['id']);
		echo json_encode(array('ret'=>200,'desc'=>'登录成功！'));
	}


	// 登出
	public function logout()
	{
		// 清除登录缓存
		$this->LoginLib->delLoginStatus();
		// 跳至登录首页
		header("location:{$this->loginUrl}");
	}


	public function demo()
	{
		$ip = '';
		$arr = explode(',', $ip);
		var_dump($arr);
	}


	// 校验随机验证码
	private function captchaCheck($userWord)
	{
		$captchaInfo = $this->LoginLib->cacheCaptcha();
		$cacheWord = $captchaInfo['word'];
		$userWord = strtolower($userWord);
		$cacheWord = strtolower($cacheWord);
		log_message('error',$userWord.'|'.$cacheWord);
		if ($userWord != $cacheWord) {
			return FALSE;
		}
		return TRUE;
	}

}