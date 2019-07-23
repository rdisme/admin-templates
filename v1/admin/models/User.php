<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author  rdisme
 * admin_user
 */
class User extends CI_Model {


	const TABLE = 'admin_user';
	const ROLE = 'admin_role';


	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


	// 根据用户ID 更新状态：启用、禁用
	public function upUserStatus($uid,$status)
	{
		$where = array('id'=>$uid);
		$data = array('status'=>$status);
		$this->db->where($where);
		$this->db->update(self::TABLE,$data);
		return $this->db->affected_rows();
	}


	// 更新个人密码
	public function upPass($id,$pass)
	{
		$this->db->set('password',md5($pass));
		$this->db->where('id',$id);
		$this->db->update(self::TABLE);
		return $this->db->affected_rows();
	}


	// 根据管理员ID更新管理员信息
	public function upUser($uid,$username,$phone,$email,$role,$password,$uip='')
	{
		$this->db->set('username',$username);
		$this->db->set('phone',$phone);
		$this->db->set('email',$email);
		$this->db->set('roleid',$role);
		if ($password) {
			$this->db->set('password',md5($password));
		}
		if ($uip) {
			$this->db->set('ip',$uip);
		}
		$this->db->where('id',$uid);
		$this->db->update(self::TABLE);
		return $this->db->affected_rows();
	}


	// 添加用户
	public function addUser($username,$phone,$email,$role,$password,$uip)
	{
		$data = array(
				'username' => $username,
				'phone' => $phone,
				'email' => $email,
				'roleid' => $role,
				'password' => md5($password),
				'addtime' => date('Y-m-d H:i:s'),
				'ip' => $uip
		);
		$this->db->insert(self::TABLE,$data);
		return $this->db->insert_id();
	}


	// 根据用户名获取记录
	public function getUserByName($username)
	{
		$where = array('username' => $username);
		$this->db->where($where);
		return $this->db->get(self::TABLE)->row_array();
	}


	// 获取管理员列表
	public function getRows()
	{
		$this->db->select(self::TABLE.'.*,'.self::ROLE.'.name');
		return $this->db->join(self::ROLE,self::TABLE.'.roleid='.self::ROLE.'.id')->get(self::TABLE)->result_array();
	}


	// 根据ID获取用户所有信息
	// 这里不限制用户状态
	public function getUserById($uid)
	{
		$where = array('id'=>$uid);
		$this->db->where($where);
		return $this->db->get(self::TABLE)->row_array();
	}


	// 根据uid获取用户记录
	// 限制用户状态 status=1
	public function getRowById($id)
	{
		$this->db->where('id',$id);
		$this->db->where('status',1);
		return $this->db->get(self::TABLE)->row_array();
	}


	// 登录校验用户名和密码
	// 不做用户状态限制
	public function getRowByPsd($user,$psd)
	{
		$this->db->where('username',$user);
		$this->db->where('password',md5($psd));
		return $this->db->get(self::TABLE)->row_array();
	}

}