<?php $this->load->view('header');?>
<script src="/public/admin/js/echarts.min.js" charset="utf-8"></script>

<body>
    <div class="x-body">
        <blockquote class="layui-elem-quote">
            欢迎您：<?=$userinfo['username']?>，截止昨日累计已关注已绑定用户：<?=$binding_total_num?>
        </blockquote>

        <fieldset class="layui-elem-field">
            <legend>截止昨日信息统计</legend>
            <div class="layui-field-box">
                <table class="layui-table" lay-even>
                    <thead>
                        <tr>
                            <th>统计</th>
                            <th>关注</th>
                            <th>绑定</th>
                            <th>pv</th>
                            <th>uv</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>昨日</td>
                            <td><?=$attention_total_num_yesterday?></td>
                            <td><?=$binding_total_num_yesterday?></td>
                            <td><?=$yes_view_data['pv']?></td>
                            <td><?=$yes_view_data['uv']?></td>
                        </tr>
                        <tr>
                            <td>本月</td>
                            <td><?=$attention_total_num_curr_mon?></td>
                            <td><?=$binding_total_num_curr_mon?></td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="main" style="width: 100%;height:400px;"></div>
        </fieldset>

        <blockquote class="layui-elem-quote">
            指标说明：<br>
            关注量：指定时间段，关注事件的数量；（不区分新老用户）<br>
            绑定量：指定时间段，绑定事件的数量；（不区分新老用户）
        </blockquote>
    </div>

    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));
        var hoursData = <?=$yes_view_data['hours']?>;
        var hour;
        var xdata = [];
        var pvdata = [];
        var uvdata = [];

        for (var i = 0; i <= 23; i++) {
            hour = 10 > i ? '0' + i : i;
            xdata[i] = hour;
            uvdata[i] = undefined == hoursData[hour] ? 0 : hoursData[hour].uv;
            pvdata[i] = undefined == hoursData[hour] ? 0 : hoursData[hour].pv;
        }

        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '全天趋势图'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['pv','uv']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: xdata
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name:'pv',
                    type:'line',
                    stack: '总量',
                    data:pvdata
                },
                {
                    name:'uv',
                    type:'line',
                    stack: '总量',
                    data:uvdata
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
</body>
</html>