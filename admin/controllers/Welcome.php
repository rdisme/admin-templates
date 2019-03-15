<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author rdisme
 * 欢迎页
 */
class Welcome extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		echo 'welcome to admin';
	}


}