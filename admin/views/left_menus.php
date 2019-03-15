<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <?php foreach ($selfMenus as $value) { ?>
            <li>
                <a href="javascript:;">
                    <i class="iconfont layui-icon <?=$value['icon']?>"></i>
                    <cite><?=$value['name']?></cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                <?php if (isset($value['child'])) { foreach ($value['child'] as $val) { ?>
                    <li>
                        <a _href="<?php echo $this->config->item('index_page').'?c='.$val['c'].'&m='.$val['m'];?>">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite><?=$val['name']?></cite>
                        </a>
                    </li >
                <?php }} ?>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!-- 左侧菜单结束 -->