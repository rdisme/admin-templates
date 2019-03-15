<?php $this->load->view('header');?>
<body>
<div class="x-body">
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>老密码
            </label>
            <div class="layui-input-inline">
                <input type="password" name="oldpass" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <hr>
        <div class="layui-form-item">
            <label for="L_pass" class="layui-form-label">
                <span class="x-red">*</span>新密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="L_pass" name="pass" lay-verify="pass" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">6到16个字符</div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
                <span class="x-red">*</span>确认密码
            </label>
            <div class="layui-input-inline">
                <input type="password" id="L_repass" name="repass" lay-verify="repass" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label"></label>
            <button  class="layui-btn" lay-filter="add" lay-submit="">更新</button>
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
            url : "<?php echo $this->config->item('index_page').'?c=userAdmin&m=upPass';?>",
            type: 'POST',
            data: {
                oldpass:data.field.oldpass,
                pass:data.field.pass
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