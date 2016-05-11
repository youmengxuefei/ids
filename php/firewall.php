<?php 
  include "include/function.php";
?>

<!DOCTYPE html>
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>基于系统快照的入侵检测系统</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head><style type="text/css" id="94812945000"></style>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">基于系统快照的入侵检测系统</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="index.php">系统概况</a></li>
            <li><a href="process.php">进程</a></li>
            <li><a href="file.php">文件</a></li>
            <li><a href="website.php">网站</a></li>
            <li><a href="port.php">端口</a></li>
            <li class="active"><a href="firewall.php">防火墙</a></li>
            <li><a href="ethernet.php">网卡</a></li>
            <li><a href="syslogin.php">登录记录</a></li>
            <li><a href="command.php">命令历史</a></li>
          </ul>
          
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">防火墙检测</h1>
          <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title" data-toggle="collapse" data-target="#demo"><strong>防火墙状态变动</strong></h3>
              </div>
              <div class="panel-body" id="demo">
                <?php show_new_firewall(); ?>
              </div>
        </div>

          <br><br><br>
          <button type="button" class="btn btn-info btn-lg" id="get_old_firewall">查询旧的防火墙列表</button>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script>
    var content1 = '<br><br><div class="panel panel-default">\
              <div class="panel-heading">\
                <h3 class="panel-title" data-toggle="collapse" data-target="#demo1"><strong>旧的防火墙状态</strong></h3>\
              </div>\
              <div class="panel-body" id="demo1">';
    var content2 = '</div></div>';
    $('#get_old_firewall').click(function(){
    $.get("ajax.php?old_firewall=1",function(data,status){
      $('#get_old_firewall').after(content1 + data + content2);
    });
  });
    </script>
    
</body></html>