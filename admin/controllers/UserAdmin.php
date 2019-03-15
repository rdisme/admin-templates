<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author rdisme
 * 管理员管理
 */
class UserAdmin extends MY_Controller
{

	private $curr_page; // 当前页码


	public function __construct()
	{
		parent::__construct();
		$this->curr_page = $this->input->get('curr_page');
		$this->curr_page = intval($this->curr_page);
	}


	// 管理员列表
	public function index()
	{
		$data = array();
		// 用户当前信息
		$data['userinfo'] = $this->userinfo;
		// 用户列表
		$data['list'] = $this->user->getRows();
		$this->load->view('useradmin/list',$data);
	}


	// 添加管理员
	public function addUser()
	{
		$data = array();
		// 获取现有的角色列表
		$data['roles'] = $this->role->get();
		$this->load->view('useradmin/add-user',$data);
	}


	// 编辑管理员
	public function editUser()
	{
		$uid = $this->input->get('uid');
		if (! $uid) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		if (! $userinfo = $this->user->getUserById($uid)) {
			die(json_encode(array('ret'=>401,'desc'=>'不合法的参数！')));
		}
		$data = array();
		// 获取现有的角色列表
		$data['roles'] = $this->role->get();
		// 获取管理员信息
		$data['cur_userinfo'] = $userinfo;
		$this->load->view('useradmin/edit-user',$data);
	}


	// 角色列表
	public function role()
	{
		$data = array();
		$data['list'] = $this->role->get();
		$this->load->view('useradmin/role',$data);
	}


	// 添加角色
	public function addRole()
	{
		$data = array();
		$data['rules'] = $this->rule->getNormalRules();
		$this->load->view('useradmin/role-add',$data);
	}


	// 更新角色权限
	public function upRole()
	{
		// 角色ID
		$roleid = $this->input->get('roleid');
		$data = array();
		// 获取角色信息
		$cur_role = $this->role->getRulesByRoleid($roleid);
		$cur_rules = array();
		if (isset($cur_role['ruleid'])) {
			$cur_rules = 'admin' == $cur_role['ruleid'] ? 'nb' : explode(',', $cur_role['ruleid']);
		}
		$data['cur_role'] = $cur_role;
		$data['cur_rules'] = $cur_rules;
		// 获取所有状态正常的权限列表
		$data['all_rules'] = $this->rule->getNormalRules();
		$this->load->view('useradmin/up-role-rules',$data);
	}


	// 查看角色权限
	public function viewRoleRules()
	{
		// 角色ID
		$roleid = $this->input->get('roleid');
		$data = array();
		// 获取角色信息
		$cur_role = $this->role->getRulesByRoleid($roleid);
		$cur_rules = array();
		if (isset($cur_role['ruleid'])) {
			$cur_rules = 'admin' == $cur_role['ruleid'] ? 'nb' : explode(',', $cur_role['ruleid']);
		}
		$data['cur_rules'] = $cur_rules;
		// 获取所有状态正常的权限列表
		$data['all_rules'] = $this->rule->getNormalRules();
		$this->load->view('useradmin/view-role-rules',$data);
	}


	// 权限分类列表
	public function cate()
	{
		$data = array();
		// 获取权限分类列表
		$data['list'] = $this->rule->getGroups();
		$this->load->view('useradmin/cate',$data);
	}


	// 更新权限分类
	public function upRuleCate()
	{
		$ruleid = $this->input->get('ruleid');
		$data = array();
		$data['ruleinfo'] = $this->rule->getRowById($ruleid);
		$this->load->view('useradmin/up-rule-cate',$data);
	}


	// 权限列表
	public function rule()
	{
		$data = array();
		$data['curr_page'] = $this->curr_page;
		$data['total_num'] = $this->rule->getRules($data,'total');
		$data['list'] = $this->rule->getRules($data); // 获取权限列表
		$data['groups'] = $this->rule->getNormalCates(); // 获取权限分类列表
		$this->load->view('useradmin/rule',$data);
	}


	// 更新权限
	public function upRule()
	{
		$ruleid = $this->input->get('ruleid');
		$data = array();
		// 获取权限分类列表
		$data['groups'] = $this->rule->getGroups();
		$data['ruleinfo'] = $this->rule->getRowById($ruleid);
		$this->load->view('useradmin/up-rule',$data);
	}


	// 管理员个人信息
	public function userinfo()
	{
		$data['userinfo'] = $this->userinfo;
		$data['roleinfo'] = $this->roleinfo;
		$this->load->view('useradmin/userinfo',$data);
	}


	// 更新个人密码
	public function upPwd()
	{
		$this->load->view('useradmin/up-pwd');
	}

// *********************************************** POST *******************************************************************************

	// 更新管理员状态
	// 禁用 启用
	public function editUserStatus()
	{
		$uid = $this->input->post('uid');
		$status = $this->input->post('status');

		if (! ($uid && $status)) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		if ($this->user->upUserStatus($uid,$status)) {
			die(json_encode(array('ret'=>200,'desc'=>'更新成功！')));
		}
		echo json_encode(array('ret'=>401,'desc'=>'更新失败！'));
	}


	// 更新后台管理用户
	public function editUserRole()
	{
		$username = $this->input->post('username');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$role = $this->input->post('role');
		$password = $this->input->post('password');
		$uid = $this->input->post('uid');
		$uip = $this->input->post('uip');

		if (! ($username && $phone && $email && $role && $uid)) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		if ($this->user->upUser($uid,$username,$phone,$email,$role,$password,$uip)) {
			die(json_encode(array('ret'=>200,'desc'=>'更新成功！')));
		}
		echo json_encode(array('ret'=>401,'desc'=>'更新失败！'));
	}


	// 添加后台管理用户
	public function addUserRole()
	{
		$username = $this->input->post('username');
		$phone = $this->input->post('phone');
		$email = $this->input->post('email');
		$role = $this->input->post('role');
		$password = $this->input->post('password');
		$uip = $this->input->post('uip');

		if (! ($username && $phone && $email && $role && $password && $uip)) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		if ($this->user->getUserByName($username)) {
			die(json_encode(array('ret'=>402,'desc'=>'当前用户名称已存在！')));
		}
		if ($this->user->addUser($username,$phone,$email,$role,$password,$uip)) {
			die(json_encode(array('ret'=>200,'desc'=>'添加成功！')));
		}
		echo json_encode(array('ret'=>401,'desc'=>'添加失败！'));
	}


	// 更新权限
	public function upRuleInfo()
	{
		$ruleid = $this->input->post('ruleid');
		$name = $this->input->post('name');
		$cateid = $this->input->post('cateid');
		$c = $this->input->post('c');
		$m = $this->input->post('m');

		if (! ($ruleid && $name && $cateid && $c && $m)) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		if (! $this->rule->upRule($ruleid,$name,$cateid,$c,$m)) {
			die(json_encode(array('ret'=>401,'desc'=>'更新失败！')));
		}
		echo json_encode(array('ret'=>200,'desc'=>'更新成功！'));
	}


	// 更新权限分类
	public function upRuleName()
	{
		$ruleid = $this->input->post('ruleid');
		$name = $this->input->post('name');
		$icon = $this->input->post('icon');

		if (! ($ruleid && $name && $icon)) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		if (! $this->rule->upRuleName($ruleid,$name,$icon)) {
			die(json_encode(array('ret'=>401,'desc'=>'更新失败！')));
		}
		echo json_encode(array('ret'=>200,'desc'=>'更新成功！'));
	}


	// 更新角色权限
	public function upRoleRule()
	{
		$roleid = $this->input->post('roleid');
		$name = $this->input->post('nickname');
		$desc = $this->input->post('desc');
		$ruleid = $this->input->post('ruleid');
		if (! $name || ! $desc || ! $roleid) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		if (! $this->role->upRole($roleid,$name,$desc,$ruleid)) {
			die(json_encode(array('ret'=>401,'desc'=>'更新失败！')));
		}
		echo json_encode(array('ret'=>200,'desc'=>'更新成功！'));
	}


	// 添加角色权限
	public function addRoleRule()
	{
		$name = $this->input->post('nickname');
		$desc = $this->input->post('desc');
		$ruleid = $this->input->post('ruleid');

		if (! $name || ! $desc) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		if ($this->role->getByName($name)) {
			die(json_encode(array('ret'=>402,'desc'=>'当前角色名称已存在！')));
		}
		if (! $this->role->addRule($name,$desc,$ruleid)) {
			die(json_encode(array('ret'=>401,'desc'=>'添加失败！')));
		}
		echo json_encode(array('ret'=>200,'desc'=>'添加成功！'));
	}


	// 添加权限
	public function addRule()
	{
		$c = $this->input->post('controller');
		$m = $this->input->post('function');
		$pid = $this->input->post('pid');
		$name = $this->input->post('name');
		$rule_type = $this->input->post('rule_type');
		if (!$c || !$m || !$pid || !$name || !$rule_type) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		$rule_type = 2 == $rule_type? 1: 0;
		if (! $this->rule->addRule($c,$m,$pid,$name,'',$rule_type)) {
			die(json_encode(array('ret'=>401,'desc'=>'添加失败！')));
		}
		echo json_encode(array('ret'=>200,'desc'=>'添加成功！'));
	}


	// 添加权限分类
	public function addCate()
	{
		$name = $this->input->post('name');
		$icon = $this->input->post('icon');
		if (! $name || ! $icon) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		if (! $this->rule->addRule('','',0,$name,$icon)) {
			die(json_encode(array('ret'=>401,'desc'=>'添加失败！')));
		}
		echo json_encode(array('ret'=>200,'desc'=>'添加成功！'));
	}


	// ajax post update password
	public function upPass()
	{
		$pass = $this->input->post('pass');
		$oldpass = $this->input->post('oldpass');

		if (! ($pass && $oldpass)) {
			die(json_encode(array('ret'=>400,'desc'=>'参数错误！')));
		}
		if (md5($oldpass) != $this->userinfo['password']) {
			die(json_encode(array('ret'=>401,'desc'=>'旧密码有误！')));
		}
		if ($this->user->upPass($this->userinfo['id'],$pass)) {
			die(json_encode(array('ret'=>200,'desc'=>'更新成功！')));
		}
		echo json_encode(array('ret'=>403,'desc'=>'更新失败！'));
	}

}