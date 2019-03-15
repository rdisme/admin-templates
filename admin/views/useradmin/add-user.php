<?php $this->load->view('header');?>
<body>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>登录名
            </label>
            <div class="layui-input-inline">
                <input type="text" id="username" name="username" required="" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>将会成为您唯一的登入名
            </div>
        </div>
        <div class="layui-form-item">
            <label for="phone" class="layui-form-label">
                <span class="x-red">*</span>手机
            </label>
            <div class="layui-input-inline">
                <input type="text" id="phone" name="phone" required="" lay-verify="phone" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>邮箱
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_email" name="email" required="" lay-verify="email" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="uip" class="layui-form-label">
                <span class="x-red">*</span>IP
            </label>
            <div class="layui-input-inline">
                <input type="text" id="uip" name="uip" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>最多2个IP并用英文逗号(',')隔开
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="x-red">*</span>角色</label>
            <div class="layui-input-block">
                <?php foreach ($roles as $role) { ?>
                <input type="radio" name="role" value="<?=$role['id']?>" title="<?=$role['name']?>">
                <?php } ?>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="L_pass" name="pass" required="" lay-verify="pass" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">6到16个字符</div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>确认密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="L_repass" name="repass" required="" lay-verify="repass" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label"></label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">增加</button>
        </div>
    </form>
</div>
</body>
<script>
layui.use(['form','layer'], function(){
    $ = layui.jquery;
    var form = layui.form,
        layer = layui.layer;

    //监听提交
    form.on('submit(add)', function(data){
        $.ajax({
            url : "<?php echo $this->config->item('index_page').'?c=userAdmin&m=addUserRole';?>",
            type: 'POST',
            data: {
                username:data.field.username,
                phone:data.field.phone,
                email:data.field.email,
                role:data.field.role,
                password:data.field.pass,
                uip:data.field.uip
            },
            dataType: 'json',
            success: function(ret) {
                var icon = 200 == ret.ret? 6: 5;
                var index = layer.alert(ret.desc, {icon: icon},function () {
                    if (200 == ret.ret) {
                        //关闭当前frame 获得frame索引
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    } else {
                        layer.close(layer.index);
                    }
                });
            },
            error: function(err) {
                layer.msg('网络异常！');
            }
        });
        return false;
    });

    //自定义验证规则
    form.verify({
        nikename: function(value){
            if(value.length < 5){
                return '昵称至少得5个字符啊';
            }
        },
        pass: [/(.+){6,12}$/, '密码必须6到12位'],
        repass: function(value){
            if($('#L_pass').val()!=$('#L_repass').val()){
                return '两次密码不一致';
            }
        }
    });
});
</script>    
</html>