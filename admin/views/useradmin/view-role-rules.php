<?php $this->load->view('header');?>
<body>
    <div class="x-body">
        <form action="" method="post" class="layui-form layui-form-pane">
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
        </form>
    </div>
</body>
</html>