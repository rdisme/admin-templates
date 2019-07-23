<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author rdisme
 * 登录服务
 */
class LoginLib
{

	private $ci;


	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('sessionLib','','sessionLib');
	}


	/**
	 * [delLoginStatus 删除登录缓存]
	 * @return [type] [description]
	 */
	public function delLoginStatus()
	{
		$this->ci->sessionLib->delLoginStatus();
	}


	/**
	 * [cachePassError 缓存、校验 错误次数]
	 * @param  string $username [账号]
	 * @param  string $limitNum [错误次数上限]
	 * @return limitNum 非空-校验-true/false 为空-缓存-errorNum错误次数
	 */
	public function cachePassError($username,$limitNum='')
	{
		// 获取已输入错误的次数
		$errorNum = $this->ci->sessionLib->getPassError($username);
		// 判断错误次数是否达上限
		if ($limitNum)
		{
			if ($limitNum <= $errorNum) {
				// 错误次数超过上限
				return false;
			}
			// 错误次数未超上限
			return true;
		}
		// 更新错误次数
		else
		{
			$this->ci->sessionLib->setPassError($username,++$errorNum);
			return $errorNum;
		}
	}


	/**
	 * [cacheCaptcha 缓存、获取验证码]
	 * @param  string $word [验证码内容]
	 * @return word非空缓存 word为空获取
	 */
	public function cacheCaptcha($word='')
	{
		if ($word) {
			return $this->ci->sessionLib->setCaptchaWord($word);
		}
		return $this->ci->sessionLib->getCaptchaWord();
	}


	/**
	 * [cacheLoginStatus 缓存登录状态 uid]
	 * @param  [type] $uid [用户ID]
	 * @return [type]      [description]
	 */
	public function cacheLoginStatus($uid='')
	{
		if( $uid ) {
			// 缓存方式：session
			return $this->ci->sessionLib->setLoginStatus($uid);
		}
		return $this->ci->sessionLib->getLoginStatus();
	}


}