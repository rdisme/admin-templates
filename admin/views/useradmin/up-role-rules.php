<?php $this->load->view('header');?>
<body>
    <div class="x-body">
        <form action="" method="post" class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>角色名
                </label>
                <div class="layui-input-inline">
                    <input value="<?=$cur_role['name']?>" lay-verify="required" type="text" id="name" name="nickname" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">拥有权限</label>
                <table  class="layui-table layui-input-block">
                    <tbody>
                    <?php foreach ($all_rules as $rule) { ?>
                        <tr>
                            <td>
                                <input <?php echo 'nb' == $cur_rules ? 'checked' : (in_array($rule['id'], $cur_rules) ? 'checked' : '');?> lay-filter='cate' type="checkbox" value="ruleid" name="<?=$rule['id']?>" title="<?=$rule['name']?>">
                            </td>
                            <td>
                                <div class="layui-input-block">
                                <?php if (isset($rule['child'])) { foreach ($rule['child'] as $val) { ?>
                                <input <?php echo 'nb' == $cur_rules ? 'checked' : (in_array($val['id'], $cur_rules) ? 'checked' : '');?> lay-filter='rule' type="checkbox" value="ruleid" name="<?=$val['id']?>" title="<?=$val['name']?>">
                                <?php }} ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="desc" class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <textarea lay-verify="required" placeholder="请输入内容" id="desc" name="desc" class="layui-textarea"><?=$cur_role['description']?></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <input value="<?=$cur_role['id']?>" type="hidden" name="roleid">
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
    
    // 监听分类点击事件
    form.on('checkbox(cate)',function(data){
        var ftd = $(this).parent().next();
        var finput = ftd.find('input');
        var fdiv = ftd.find('.layui-form-checkbox');
        var ischecked = data.elem.checked;
        // 渲染input
        finput.prop('checked',ischecked);
        // 渲染div
        if (ischecked) {
            fdiv.addClass('layui-form-checked');
        } else {
            fdiv.removeClass('layui-form-checked');
        }
    });

    // 监听权限点击事件
    form.on('checkbox(rule)',function(data){
        var ftd = $(this).parent().parent().prev();
        var finput = ftd.find('input');
        var fdiv = ftd.find('div');
        if (true === data.elem.checked) {
            finput.prop('checked',true);
            fdiv.addClass('layui-form-checked');
        } else {
            var borther = $(this).siblings('input');
            var borther_length = borther.length;
            for (var i = 0; i < borther_length; i++) {
                if (borther[i].checked) {
                    return false;
                }
            }
            finput.prop('checked',false);
            fdiv.removeClass('layui-form-checked');
        }
    });

    //监听提交
    form.on('submit(add)', function(data){
        var nickname = data.field.nickname;
        var desc = data.field.desc;
        var ruleid = [];
        var roleid = data.field.roleid;

        for (var key in data.field) {
            if ('ruleid' == data.field[key]) {
                ruleid.push(key);
            }
        }

        $.ajax({
            url : "<?php echo $this->config->item('index_page').'?c=userAdmin&m=upRoleRule';?>",
            type: 'POST',
            data: {nickname:nickname,desc:desc,ruleid:ruleid.join(','),roleid:roleid},
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