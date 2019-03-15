<?php $this->load->view('header');?>
<body>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so layui-form-pane">
                <div class="layui-input-inline">
                    <select name="rule_type" lay-verify="required">
                        <option value="1">显示于菜单栏</option>
                        <option value="2">隐藏于菜单栏</option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="cateid" lay-verify="required">
                        <option value="">权限分类</option>
                        <?php foreach($groups as $val){ ?>
                        <option value="<?=$val['id']?>"><?=$val['name']?></option>
                        <?php } ?>
                    </select>
                </div>
                <input lay-verify="required" class="layui-input" placeholder="控制器名" name="controller" >
                <input lay-verify="required" class="layui-input" placeholder="方法名" name="function" >
                <input lay-verify="required" class="layui-input" placeholder="权限名" name="cate_name" >
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>增加</button>
            </form>
        </div>
        <xblock>
            <button class="layui-btn" onclick="window.location.href=''"><i class="layui-icon layui-icon-refresh-2"></i>刷新</button>
        </xblock>
        <table class="layui-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>权限规则</th>
                    <th>权限名称</th>
                    <th>所属分类</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $val) { ?>
                <tr>
                    <td><?=$val['id']?></td>
                    <td><?='c='.$val['c'].'&m='.$val['m']?></td>
                    <td><?=$val['name']?></td>
                    <td><?=isset($groups[$val['pid']])? $groups[$val['pid']]['name']: ''?></td>
                    <td><?=$val['addtime']?></td>
                    <td class="td-manage">
                        <a title="编辑"  onclick='x_admin_show("编辑","<?=$this->config->item('index_page').'?c=userAdmin&m=upRule&ruleid='.$val['id']?>",500)' href="javascript:;">
                            <i class="layui-icon">&#xe642;</i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div id="page"></div>
    </div>
</body>
<script>
layui.use(['form','laypage'], function(){
    var form = layui.form;
    var laypage = layui.laypage;

    laypage.render({
        elem: 'page',
        count: <?=$total_num?>,
        curr: <?=$curr_page?>,
        layout: ['prev', 'page', 'next', 'skip', 'count'],
        jump: function(obj, isfirst){
            if (! isfirst) {
                pageJump(obj.curr);
            }
        }
    });

    //监听提交
    form.on('submit(sreach)', function(data) {
        $.ajax({
            url:"<?=$this->config->item('index_page').'?c=userAdmin&m=addRule'?>",
            type:'POST',
            dataType:'json',
            data:{
                pid:data.field.cateid,
                controller:data.field.controller,
                function:data.field.function,
                name:data.field.cate_name,
                rule_type:data.field.rule_type
            },
            success:function(ret) {
                layer.msg(ret.desc,{time:2000},function(){
                    if (200 == ret.ret) {
                        window.location.href = '';
                    }
                });
            }
        });
        return false;
    });
});

function pageJump(curr_page)
{
    var jumpUrl = "/<?=$this->config->item('index_page')?>?c=userAdmin&m=rule";
    if (curr_page) { jumpUrl += '&curr_page=' + curr_page; }
    window.location.href = jumpUrl;
}
</script>
</html>