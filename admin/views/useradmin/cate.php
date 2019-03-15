<?php $this->load->view('header');?>
  <body>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so layui-form-pane">
                <input class="layui-input" lay-verify="required" placeholder="分类名" name="cate_name">
                <input class="layui-input" lay-verify="required" placeholder="icon" name="cate_icon">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>增加</button>
            </form>
        </div>
        <xblock>
            <button class="layui-btn" onclick='x_admin_show("添加角色","<?=$this->config->item('index_page').'?c=icon&m=index'?>")'>
                <i class="layui-icon layui-icon-search"></i>查看更多icon
            </button>
            <button class="layui-btn" onclick="window.location.href=''"><i class="layui-icon layui-icon-refresh-2"></i>刷新</button>
            <!-- <span class="x-right" style="line-height:40px">共有数据：88 条</span> -->
        </xblock>
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>分类名</th>
                    <th>icon图标</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list as $val){ ?>
                <tr>
                    <td><?=$val['id']?></td>
                    <td><?=$val['name']?></td>
                    <td><i class="layui-icon <?=$val['icon']?>"></i></td>
                    <td><?=$val['addtime']?></td>
                    <td class="td-manage">
                        <a title="编辑"  onclick='x_admin_show("编辑","<?=$this->config->item('index_page').'?c=userAdmin&m=upRuleCate&ruleid='.$val['id']?>",600)' href="javascript:;">
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
    form.on('submit(sreach)', function(data) {
        $.ajax({
            url:"<?=$this->config->item('index_page').'?c=userAdmin&m=addCate'?>",
            type:'POST',
            dataType:'json',
            data:{
                name:data.field.cate_name,
                icon:data.field.cate_icon
            },
            success:function(ret) {
                layer.msg(ret.desc,{time:1000},function(){                
                    if (200 == ret.ret) {
                        window.location.href = '';
                    }
                });
            }
        });
        return false;
    });
});
</script>
</html>