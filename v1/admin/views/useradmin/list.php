<?php $this->load->view('header');?>
<body>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so">
                <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <xblock>
            <button class="layui-btn" onclick='x_admin_show("添加角色","<?=$this->config->item('index_page').'?c=userAdmin&m=addUser'?>")'>
                <i class="layui-icon"></i>添加
            </button>
            <button class="layui-btn" onclick="window.location.href=''"><i class="layui-icon layui-icon-refresh-2"></i>刷新</button>
            <!-- <span class="x-right" style="line-height:40px">共有数据：88 条</span> -->
        </xblock>
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>登录名</th>
                    <th>手机</th>
                    <th>邮箱</th>
                    <th>IP</th>
                    <th>角色</th>
                    <th>加入时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($list as $val){ ?>
                <tr>
                    <td><?=$val['id']?></td>
                    <td><?=$val['username']?></td>
                    <td><?=$val['phone']?></td>
                    <td><?=$val['email']?></td>
                    <td><?=$val['ip']?></td>
                    <td><?=$val['name']?></td>
                    <td><?=$val['addtime']?></td>
                    <td class="td-status">
                        <?php if (1 == $val['status']) { ?>
                        <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
                        <?php } else { ?>
                        <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已禁用</span>
                        <?php } ?>
                    </td>
                    <td class="td-manage">
                        <?php
                        if ('1' != $val['roleid']) { 
                            if (1 == $val['status']) { 
                        ?>
                        <a onclick="member_stop(this,<?=$val['id']?>)" href="javascript:;"  title="禁用">
                            <i class="layui-icon layui-icon-zzunlock-alt"></i>
                        <?php } else { ?>
                        <a onclick="member_stop(this,<?=$val['id']?>)" href="javascript:;"  title="启用">
                            <i class="layui-icon layui-icon-zzunlock"></i>
                        <?php } ?>
                        </a>
                        <?php } ?>
                        <a title="编辑"  onclick='x_admin_show("编辑","<?=$this->config->item('index_page').'?c=userAdmin&m=editUser&uid='.$val['id']?>")' href="javascript:;">
                            <i class="layui-icon">&#xe642;</i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
<script>

layui.use('form', function(){
    var form = layui.form;
    //监听提交
    form.on('submit(sreach)', function(data){
        layer.msg(JSON.stringify(data.field));
        return false;
    });
});

/*用户-停用*/
function member_stop(obj,id){
    // 标题
    var title = $(obj).attr('title');
    status = '启用' == title ? 1 : 2;
    // 重复确认
    layer.confirm('确认要'+title+'吗？',function(index){
        $.ajax({
            url : "<?php echo $this->config->item('index_page').'?c=userAdmin&m=editUserStatus';?>",
            type: 'POST',
            data: {uid:id,status:status},
            dataType: 'json',
            success: function(ret) {
                if (200 == ret.ret) { // 更新成功
                    if (2 == status) { // 启用
                        $(obj).attr('title','启用');
                        $(obj).find('i').removeClass('layui-icon-zzunlock-alt');
                        $(obj).find('i').addClass('layui-icon-zzunlock');
                        $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已禁用');
                        layer.msg('已禁用!',{icon: 5,time:1000});
                    } else { // 禁用
                        $(obj).attr('title','禁用');
                        $(obj).find('i').removeClass('layui-icon-zzunlock');
                        $(obj).find('i').addClass('layui-icon-zzunlock-alt');
                        $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                        layer.msg('已启用!',{icon: 6,time:1000});
                    }
                } else { // 更新失败
                    layer.msg(ret.desc,{icon: 5,time:1000});
                }
            },
            error: function(err) {
                layer.msg('网络异常！');
            }
        });
    });
}
</script>
</html>