<?php $this->load->view('header');?>
<body class="login-bg">
    <div class="login">
        <div class="message">管理登录</div>
        <div id="darkbannerwrap"></div>
        <form method="post" class="layui-form" >
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <a id="captcha" href="javascript:void(0)"><?=$image?></a>
            <hr class="hr15">
            <input name="captcha" lay-verify="required" placeholder="验证码"  type="text" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>
</body>
<script>
$(function  () {
    layui.use('form', function(){
        var form = layui.form;
        //监听提交
        form.on('submit(login)', function(data){
            $.ajax({
                url : "<?php echo $this->config->item('index_page').'?c=login&m=valid';?>",
                type: 'POST',
                data: {
                    username: data.field.username,
                    password: data.field.password,
                    captcha: data.field.captcha
                },
                dataType: 'json',
                success: function(ret) {
                    layer.msg(JSON.stringify(ret.desc),{time:1000},function(){
                        if( 200 == ret.ret ) {
                            window.location.href = "<?php echo $this->config->item('index_page').'?c=index';?>";
                        }
                    });
                },
                error: function(err) {
                    layer.msg('网络异常！');
                }
            });
            return false;
        });
    });

    // 更换验证码
    $('#captcha').click(function(){
        $.ajax({
            url : "<?php echo $this->config->item('index_page').'?c=login&m=change_captcha';?>",
            type: 'POST',
            dataType: 'json',
            success: function(ret) {
                $('#captcha').html(ret.image);
            },
            error: function(err) {
                layer.msg('网络异常！');
            }
        });
    })
})
</script>
</html>