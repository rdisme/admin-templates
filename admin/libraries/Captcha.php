<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author rdisme
 * 验证码模块
 */
class Captcha
{

	private $ci;
	private $img_path;
	private $img_url;


	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->helper('captcha');
		$this->img_path = $this->ci->config->item('captcha_path');
		$this->img_url = $this->ci->config->item('captcha_img_path');
	}


	public function get($width=340, $height=50)
	{
		$vals = array(
			'expiration' => 30, // 默认30s过期
			'word_length' => 6,
			'img_width' => $width,
    		'img_height' => $height,
    		'pool' => '23456789abcdefghjklmnpqwxyzABCDEFGHJKLMNRSTUV',
		    'img_path'  => $this->img_path,
		    'img_url'   => $this->img_url
		);
		$cap = create_captcha($vals);

		return array(
				'word' => isset($cap['word'])? $cap['word']: '',
				'image' => isset($cap['image'])? $cap['image']: ''
		);
	}

}