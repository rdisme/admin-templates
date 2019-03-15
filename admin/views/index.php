<?php $this->load->view('header');?>
<body>
	<?php $this->load->view('body_top');?>
    <!-- 中部开始 -->
    <?php $this->load->view('left_menus');?>
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li>我的桌面</li>
          </ul>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src="<?php echo $this->config->item('index_page').'?c=welcome';?>" frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer layui-bg-cyan">
        <div class="copyright">Copyright ©2018 All Rights Reserved</div>
    </div>
    <!-- 底部结束 -->
</body>
</html>