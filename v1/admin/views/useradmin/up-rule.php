<?php $this->load->view('header');?>
<body>
    <div class="x-body">
        <form action="" method="post" class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>权限名
                </label>
                <div class="layui-input-inline">
                    <input value="<?=$ruleinfo['name']?>" lay-verify="required" type="text" id="name" name="name" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">  
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>分类名
                </label>              
                <div class="layui-input-inline">
                    <select name="cateid" lay-verify="required">
                        <option value="">权限分类</option>
                        <?php foreach($groups as $val){ ?>
                        <option <?php if ($ruleinfo['pid'] == $val['id']) {echo 'selected';} ?> value="<?=$val['id']?>"><?=$val['name']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">  
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>控制器名
                </label>
                <div class="layui-input-inline">
                    <input value="<?=$ruleinfo['c']?>" lay-verify="required" type="text" id="name" name="c" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">  
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>方法名
                </label>
                <div class="layui-input-inline">
                    <input value="<?=$ruleinfo['m']?>" lay-verify="required" type="text" id="name" name="m" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <input value="<?=$ruleinfo['id']?>" type="hidden" name="ruleid">
                <button class="layui-btn" lay-submit lay-filter="add">更新</button>
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
            url : "<?php echo $this->config->item('index_page').'?c=userAdmin&m=upRuleInfo';?>",
            type: 'POST',
            data: {
                name:data.field.name,
                cateid:data.field.cateid,
                c:data.field.c,
                m:data.field.m,
                ruleid:data.field.ruleid
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
});
</script>
</html>