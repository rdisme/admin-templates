<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author rdisme
 * icon
 */
class Icon extends MY_Controller
{

	public function index()
	{
		$this->load->view('icon/index');
	}

}