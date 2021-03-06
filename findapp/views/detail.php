<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>失物招领平台 - 华东交通大学日新网</title>
<link rel="stylesheet" type="text/css" href="/static/css/common.css" />
<link rel="stylesheet" type="text/css" href="/static/css/beautiful-select.css" />
<script type="text/javascript" src="/static/js/jquery-1.8.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="/static/css/jqueryui.css" />
<script type="text/javascript" src="/static/js/jqueryui.js"></script>
<script type="text/javascript">
var host = '<?php echo base_url(); ?>';
var hash = '<?php echo $this->security->get_csrf_hash(); ?>';
var path = '<?php echo $this->data['qs']; ?>';
$(document).ready(function () {
    $('#getphone').on('click', function (event) {
        $("#getphone-dialog").dialog();
        event.preventDefault();
        return false;
    });
    $('#cyxx + a').on('mouseover', function (event) {
        $('#cyxx').css('marginTop', '-32px');
        $('#cyxx + a').css('marginTop', '-32px');
    });
    $('#cyxx + a').on('mouseout', function (event) {
        $('#cyxx').css('marginTop', '-22px');
        $('#cyxx + a').css('marginTop', '-22px');
    });
    $('#fbqs + a').on('mouseover', function (event) {
        $('#fbqs').css('marginTop', '-32px');
        $('#fbqs + a').css('marginTop', '-32px');
    });
    $('#fbqs + a').on('mouseout', function (event) {
        $('#fbqs').css('marginTop', '-22px');
        $('#fbqs + a').css('marginTop', '-22px');
    });
    $('#valid').on('click', function (event) {
        $validcode = $('#code').val();
        $.ajax({
            type: 'POST',
            url: host + 'a/detail/<?php echo $this->data['id']; ?>',
            data: { code: $validcode,
                    path: path,
                    csrf_name: hash
            },
            success: function (msg) {
                if (msg == 'error') {
                    alert('验证码输入错误！');
                } else {
                    $('#phonenumber').html(msg);
                    $('.ui-dialog-titlebar-close').click();
                }
            }
        });
        event.preventDefault();
        return false;
    });
    $('form').on('submit', function (event) {
        event.preventDefault();
        return false;
    });
});
</script>
</head>
<body>
<div id="header" style="background:39% 53% no-repeat url('/static/img/logo_new.png'); *margin-top:0px;">
    <div class="nav">
            <ul>
                <li><a target="_blank" href="http://swzl.ecjtu.net/">失物招领</a></li>
                <li><a target="_blank" href="http://www.ecjtu.net/">日新网</a></li>
                <li id="weibo"><a target="_blank" href="http://e.weibo.com/u/2961853293">微博平台</a></li>
            </ul>
        </div>
    <!--<ul>
        <li><a href="http://www.ecjtu.net">日新网</a></li>
        <li><a href="http://swzl.ecjtu.net">失物招领</a></li>
    </ul>-->
</div>
</div>
<div id="container">
    <div id="content">
        <div id="sidebar">
            <p id="message-title">亲爱的同学</p>
            <p id="message-content">欢迎来到失物招领，我们会竭尽所能给您提供帮助！</p>
            <div class="sidebar-btn">
                <img alt="" src="/static/img/cyxx.png" id="cyxx" />
                <a style="background:#fff;opacity:0;filter:alpha(opacity=0);" href="/" id="cyxx"></a>
                <img alt="" src="/static/img/masklayer.png" class="masklayer" />
            </div>
            <div class="sidebar-btn">
                <img alt="" src="/static/img/fbqs.png" id="fbqs" />
                <a style="background:#fff;opacity:0;filter:alpha(opacity=0);" href="/post"></a>
                <img alt="" src="/static/img/masklayer.png" class="masklayer" />
            </div>
        </div>
        <div class="detail-content">
            <div class="detail-tab" id="xxxq-tab"></div>
            <div class="detail-form">
                <table>
                    <tr>
                        <td class=".detail-title" style="color: #696969; font-size: 14px; line-height: 14px; text-align: right; width: 110px;">启事类型：</td>
                        <td><?php echo $this->data['qslx']; ?></td>
                    </tr>
                    <tr>
                        <td class=".detail-title" style="color: #696969; font-size: 14px; line-height: 14px; text-align: right; width: 110px;">物品名称：</td>
                        <td><?php echo $this->data['name']; ?></td>
                    </tr>
                    <tr>
                        <td class=".detail-title" style="color: #696969; font-size: 14px; line-height: 14px; text-align: right; width: 110px;">物品类型：</td>
                        <td><?php echo $this->data['cname']; ?></td>
                    </tr>&nbsp;
                    <tr>
                        <td class=".detail-title" style="color: #696969; font-size: 14px; line-height: 14px; text-align: right; width: 110px;">地　　点：</td>
                        <td><?php echo $this->data['place']; ?></td>
                    </tr>
                    <tr>
                        <td class=".detail-title" style="color: #696969; font-size: 14px; line-height: 14px; text-align: right; width: 110px;" >时　　间：</td>
                        <td><?php echo date('Y-m-d', $this->data['time']); ?></td>
                    </tr>
                    <tr>
                        <td class=".detail-title" style="color: #696969; font-size: 14px; line-height: 14px; text-align: right; width: 110px;">联&nbsp;系&nbsp;人：</td>
                        <td><?php echo $this->data['owner']; ?></td>
                    </tr>
                    <tr id="phonenumber">
                    </tr>
                    <tr>
                        <td class=".detail-title" style="color: #696969; font-size: 14px; line-height: 14px; text-align: right; width: 110px;">详细描述：</td>
                        <td id="xxms" style="font-size:12px; width:460px;"><?php echo $this->data['description']; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="#" id="getphone">联系TA</a></td>
                    </tr>
                </table>
            </div>
            <div class="clearb"></div>
        </div>
        <div id="getphone-dialog" style="display: none;">
            <p>请输入验证码：<?php echo $this->data['captcha']; ?></p>
            <?php echo form_open('detail/' . $this->data['id']); ?>
                <input type="text" name="captcha" id="code" />
                <input type="submit" id="valid" value="提交查询" />
            </form>
        </div>
    </div>
</div>
<div id="footer">
    <p><a href="http://www.ecjtu.net/about/">关于我们</a> | <a href="http://123.ecjtu.net/">网址导航</a> | <a href="http://hr.ecjtu.net/">人才招聘</a> | <a href="mailto:roger@ecjtu.jx.cn">不良信息举报</a></p>
    <p>华东交通大学团委、学工处 [ 版权所有 交大日新 ] 赣ICP备05003322号 日新工作室 维护</p>
    <p>信箱：214@ecjtu.net CopyRight 2001-2012 By [ecjtu.net] All Right Reserved</p>
<p><script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fff331ba2aed9cae70b1ccaa481038182' type='text/javascript'%3E%3C/script%3E"));
</script></p>
</div>
</body>
</html>
