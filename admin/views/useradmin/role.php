<?php $this->load->view('header');?>

<body>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so">
                <input lay-verify="required" type="text" name="username"  placeholder="角色名" autocomplete="off" class="layui-input">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <xblock>
            <button class="layui-btn" onclick='x_admin_show("添加角色","<?=$this->config->item('index_page').'?c=userAdmin&m=addRole'?>")'><i class="layui-icon"></i>添加</button>
            <button class="layui-btn" onclick="window.location.href=''"><i class="layui-icon layui-icon-refresh-2"></i>刷新</button>
            <!-- <span class="x-right" style="line-height:40px">共有数据：88 条</span> -->
        </xblock>
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>角色名</th>
                    <th>权限</th>
                    <th>描述</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($list as $val){ ?>
                <tr>
                    <td><?=$val['id']?></td>
                    <td><?=$val['name']?></td>
                    <td>
                        <a onclick='x_admin_show("查看权限","<?=$this->config->item('index_page').'?c=userAdmin&m=viewRoleRules&roleid='.$val['id']?>")' href="javascript:;"  title="查看权限">
                            <i class="layui-icon layui-icon-search" style="font-size: 21px; color: #1E9FFF;"></i></a>
                    </td>
                    <td><?=$val['description']?></td>
                    <td><?=$val['addtime']?></td>
                    <td class="td-manage">
                        <a title="编辑"  onclick='x_admin_show("编辑","<?=$this->config->item('index_page').'?c=userAdmin&m=upRole&roleid='.$val['id']?>")' href="javascript:;">
                            <i class="layui-icon">&#xe642;</i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>