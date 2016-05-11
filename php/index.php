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
            <li class="active"><a href="index.php">系统概况</a></li>
            <li><a href="process.php">进程</a></li>
            <li><a href="file.php">文件</a></li>
            <li><a href="website.php">网站</a></li>
            <li><a href="port.php">端口</a></li>
            <li><a href="firewall.php">防火墙</a></li>
            <li><a href="ethernet.php">网卡</a></li>
            <li><a href="syslogin.php">登录记录</a></li>
            <li><a href="command.php">命令历史</a></li>
          </ul>
          
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">系统概况</h1>
          <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title" data-toggle="collapse" data-target="#demo3"><strong>系统得分统计</strong></h3>
                </div>
                <div class="panel-body" id="demo3">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>快照次数</th>
                          <th>快照日期</th>
                          <th>得分</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>进程检测</td>
                          <?php show_mark('process'); ?>
                        </tr>
                        <tr>
                          <td>网站检测</td>
                          <?php show_mark('website'); ?>
                        </tr>
                        <tr>
                          <td>文件检测</td>
                          <?php show_mark('file'); ?>
                        </tr>
                        <tr>
                          <td>端口检测</td>
                          <?php show_mark('port'); ?>
                        </tr>
                        <tr>
                          <td>防火墙检测</td>
                          <?php show_mark('firewall'); ?>
                        </tr>
                        <tr>
                          <td>网卡检测</td>
                          <?php show_mark('ethernet'); ?>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


          <div class='row'>
            <div class="col-md-6">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title" data-toggle="collapse" data-target="#demo"><strong>快照历史</strong></h3>
                </div>
                <div class="panel-body" id="demo">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>快照次数</th>
                          <th>快照日期</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php show_ids_log();?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="panel panel-success">
                    <div class="panel-heading">
                      <h3 class="panel-title" data-toggle="collapse" data-target="#demo1"><strong>危害等级说明</strong></h3>
                    </div>
                    <div class="panel-body" id="demo1">
                      <div class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>等级</th>
                              <th>危害程度</th>
                              <th>颜色块</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="danger">
                              <td>0</td>
                              <td>危险</td>
                              <td>红色</td>
                            </tr>
                            <tr class="warning">
                              <td>1</td>
                              <td>警告</td>
                              <td>黄色</td>
                            </tr>
                            <tr class="info">
                              <td>2</td>
                              <td>注意</td>
                              <td>淡蓝色</td>
                            </tr>
                            <tr class="success">
                              <td>3</td>
                              <td>正常</td>
                              <td>青色</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
              </div>

            </div>
          </div>
          
 
              
          <!-- <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title" data-toggle="collapse" data-target="#demo"><strong>快照历史</strong></h3>
                </div>
                <div class="panel-body" id="demo">

                </div>
          </div> -->

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
    <script type="text/javascript">
      
      $("a").click(function(e){
        var info = $(e.target).attr('info');
        if (info)
          alert(info);
      });
    </script>

</body></html>