<!-- 顶部开始 -->
<div class="container layui-bg-cyan">
    <div class="logo"><a href="<?php echo $this->config->item('index_page');?>">西藏移动后台管理系统</a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;"><?php echo isset($userinfo['username']) ? $userinfo['username'] : 'don`t find your name';?></a>
            <dl class="layui-nav-child">
                <dd>
                    <a onclick='x_admin_show("个人信息","/<?=$this->config->item('index_page')?>?c=userAdmin&m=userinfo",500,500)'>个人信息</a>
                </dd>
                <dd>
                    <a onclick='x_admin_show("更新密码","/<?=$this->config->item('index_page')?>?c=userAdmin&m=upPwd",480,400)'>更新密码</a>
                </dd>
                <dd>
                    <a href="<?php echo $this->config->item('index_page').'?c=login&m=logout';?>">退出</a>
                </dd>
            </dl>
        </li>
    </ul>
</div>
<!-- 顶部结束 -->