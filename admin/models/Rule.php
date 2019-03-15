<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author  rdisme
 * admin_rule 权限表
 */
class Rule extends CI_Model {


	const TABLE = 'admin_rule';


	public function __construct() {
		parent::__construct();
		$this->load->database();
	}


	public function upRule($ruleid,$name,$cateid,$c,$m)
	{
		$data = array(
				'name' => $name,
				'pid' => $cateid,
				'c' => $c,
				'm' => $m
		);
		$where = array('id'=>$ruleid);
		$this->db->where($where);
		$this->db->update(self::TABLE,$data);
		return $this->db->affected_rows();
	}


	public function upRuleName($id,$name,$icon)
	{
		$data = array('name'=>$name,'icon'=>$icon);
		$where = array('id'=>$id);
		$this->db->where($where);
		$this->db->update(self::TABLE,$data);
		return $this->db->affected_rows();
	}


	public function getRowById($id)
	{
		$where = array('id'=>$id);
		$this->db->where($where);
		return $this->db->get(self::TABLE)->row_array();
	}


	public function getRowByCM($c,$m)
	{
		$where = array('c'=>$c,'m'=>$m);
		$this->db->where($where);
		return $this->db->get(self::TABLE)->row_array();
	}


	public function getRulesByids($ids)
	{
		$this->db->where_in('id',$ids);
		return $this->db->get(self::TABLE)->result_array();
	}


	public function addRule($c,$m,$pid,$name,$icon='',$rule_type=0)
	{
		$data = array(
				'c' => $c,
				'm' => $m,
				'pid' => $pid,
				'name' => $name,
				'type' => $rule_type,
				'addtime' => date('Y-m-d H:i:s')
		);
		if ($icon) {
			$data['icon'] = $icon;
		}
		$this->db->insert(self::TABLE,$data);
		return $this->db->insert_id();
	}


	// 获取所有菜单栏 不限制状态
	public function getGroups()
	{
		$this->db->where('pid',0);
		$this->db->from(self::TABLE);
		return $this->db->get()->result_array();
	}


	// 获取所有状态正常的权限列表
	public function getAll()
	{
		$this->db->from(self::TABLE);
		$this->db->where('status',1);
		return $this->db->get()->result_array();
	}


	// 获取菜单栏 主用于下拉列表
	public function getNormalCates()
	{
		$this->db->select('id,name');
		$this->db->where('status',1);
		$this->db->where('pid',0);
		$this->db->from(self::TABLE);
		$list = $this->db->get()->result_array();
		$data = array();
		foreach ($list as $key=>$val) {
			$data[$val['id']] = $list[$key];
		}
		return $data;
	}


	// 根据权限ID获取权限列表
	// 获取菜单栏专用！！！
	public function getRuleByid($ids)
	{
		if ('admin' == $ids) {
			// 超级管理员
			$data = $this->getAll();
		} else {
			// 其他管理员
			$ids = explode(',', $ids);
			$data = $this->getRulesByids($ids);
		}
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value['id']] =& $data[$key];
		}
		$trees = array();
		foreach ($data as $key => $value) {
			// 过滤隐藏链接
			if (1 == $value['type'])
			{
				continue;
			}
			if (0 == $value['pid'])
			{
				$trees[] =& $data[$key];
			}
			else
			{
				if (isset($array[$value['pid']])) {
					$parent =& $array[$value['pid']];
					$parent['child'][] =& $data[$key];
				}
			}
		}
		return $trees;
	}


	// 获取所有状态正常的权限列表包含权限分类
	public function getNormalRules()
	{
		$data = $this->getAll();
		$array = array();
		foreach ($data as $key => $value) {
			$array[$value['id']] =& $data[$key];
		}
		$trees = array();
		foreach ($data as $key => $value) {
			if (0 == $value['pid']) {
				$trees[] =& $data[$key];
			} else {
				if (isset($array[$value['pid']])) {
					$parent =& $array[$value['pid']];
					$parent['child'][] =& $data[$key];
				}
			}
		}
		return $trees;
	}


	// 获取所有状态正常的权限列表 并初始化数据格式
	public function getRules($where,$type='list',$offset=10)
	{
		$this->db->order_by('uptime','desc');
		$this->db->where('status',1);
		$this->db->where('pid !=',0);
		$this->db->from(self::TABLE);
		if ('list' == $type)
		{
			if (isset($where['curr_page'])) {
				$curr_page = $where['curr_page'];
				$start = 0 < $curr_page ? ($curr_page-1)*$offset : 0;
				$this->db->limit($offset,$start);
			}
			return $this->db->get()->result_array();
		}
		else
		{
			return $this->db->count_all_results();
		}
	}

}