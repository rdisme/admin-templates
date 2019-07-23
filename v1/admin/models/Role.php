<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author  rdisme
 * admin_role 角色表
 */
class Role extends CI_Model {


	const TABLE = 'admin_role';


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	// 根据角色ID获取角色信息
	// 限制角色状态：正常 status=1
	public function getRuleidsById($id)
	{
		$where = array('id'=>$id,'status'=>1);
		$this->db->where($where);
		return $this->db->get(self::TABLE)->row_array();
	}


	// 根据角色ID获取对应的角色信息
	public function getRulesByRoleid($roleid)
	{
		$where = array('id'=>$roleid);
		$this->db->where($where);
		return $this->db->get(self::TABLE)->row_array();
	}


	// 用于添加时的校验
	public function getByName($name)
	{
		$where = array(
				'name' => $name
		);
		$this->db->where($where);
		return $this->db->get(self::TABLE)->row_array();
	}


	public function get()
	{
		$where = array('status'=>1);
		$this->db->from(self::TABLE);
		$this->db->where($where);
		return $this->db->get()->result_array();
	}


	public function upRole($roleid,$name,$desc,$ruleid)
	{
		$data = array(
				'name' => $name,
				'description' => $desc,
				'ruleid' => $ruleid
		);
		$where = array('id'=>$roleid);
		$this->db->where($where);
		$this->db->update(self::TABLE,$data);
		return $this->db->affected_rows();
	}


	public function addRule($name,$desc,$ruleid)
	{
		$data = array(
				'name' => $name,
				'description' => $desc,
				'ruleid' => $ruleid,
				'addtime' => date('Y-m-d H:i:s')
		);
		$this->db->insert(self::TABLE,$data);
		return $this->db->insert_id();
	}

}