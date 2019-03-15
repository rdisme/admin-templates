<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author rdisme
 * 微厅后台 session相关
 */
class SessionLib
{


	public function __construct()
	{
		$this->sessionStart();
	}


	/**
	 * [delLoginStatus 退出操作！清除登录缓存]
	 */
	public function delLoginStatus()
	{
		// 销毁内存中session变量 session_unset只是清空内存中session的值
		unset($_SESSION);
		// 销毁session文件 释放session ID 不会清理内存中的session值
		session_destroy();
		// 销毁本地的session cookie！
		setcookie(session_name(),'',time()-1,'/');
	}


	/**
	 * [getLoginStatus 获取登录缓存信息]
	 * @return [array]
	 */
	public function getLoginStatus()
	{
		return array(
				'uid' => isset($_SESSION['uid']) ? $_SESSION['uid'] : ''
		);
	}


	public function getCaptchaWord()
	{
		return array(
				'word' => isset($_SESSION['captcha_word']) ? $_SESSION['captcha_word'] : ''
		);
	}


	public function getPassError($username)
	{
		$key = 'pass_error_num' . $username;
		return isset($_SESSION[$key]) ? $_SESSION[$key] : 0;
	}


	public function setPassError($username,$nums)
	{
		$key = 'pass_error_num' . $username;
		$_SESSION[$key] = $nums;
	}


	public function setCaptchaWord($word)
	{
		$_SESSION['captcha_word'] = $word;
	}


	/**
	 * [setLoginStatus 缓存用户uid]
	 * @param [type] $uid [用户ID]
	 */
	public function setLoginStatus($uid)
	{
		$_SESSION['uid'] = $uid;
	}


	/**
	 * [sessionStart 开始session]
	 * @param  integer $timeout [默认过期时间 关闭浏览器即过期]
	 */
	private function sessionStart($timeout=0)
	{
		if( ! isset($_SESSION) ) {
			// 开启session
			session_start();
			// 设置session的过期时间
			$timeout = 0 < $timeout ? (time() + $timeout) : $timeout;
		    setcookie(session_name(), session_id(), $timeout, '/');
		}
	}

}

?>