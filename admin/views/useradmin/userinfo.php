<?php $this->load->view('header');?>
<body>
<div class="x-body">
     <fieldset class="layui-elem-field">
        <!-- <legend>本地数据</legend> -->
        <div class="layui-field-box">
            <label class="layui-form-label">
                <span class="x-red">*</span>登录名
            </label>
            <div class="layui-form-mid layui-word-aux">
                <span class=""><?=$userinfo['username']?></span>
            </div>
            <hr>
            <label class="layui-form-label">
                <span class="x-red">*</span>角色
            </label>
            <div class="layui-form-mid layui-word-aux">
                <span class=""><?=$roleinfo['name']?></span>
            </div>
            <hr>
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>手机号
            </label>
            <div class="layui-form-mid layui-word-aux">
                <span class=""><?=$userinfo['phone']?></span>
            </div>
            <hr>
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>邮箱
            </label>
            <div class="layui-form-mid layui-word-aux">
                <span class=""><?=$userinfo['email']?></span>
            </div>
            <hr>
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>IP白名单
            </label>
            <div class="layui-form-mid layui-word-aux">
                <span class=""><?=$userinfo['ip']?></span>
            </div>
        </div>
    </fieldset>
    <div class="layui-form-mid layui-word-aux">
        <span class="x-red">若是信息有误，请及时联系管理员更新！</span>
    </div>
</div>
</body>
</html>