<?php
include "db.php";
// $file_whitelist = 'conf/process/whitelist.txt';
// $file_blacklist = 'conf/process/blacklist.txt';

function show_mark($table)
{
    $sql = "select max(ids_id),time from ids_log";
    $result = mysql_query($sql);
    $row = mysql_fetch_assoc($result);
    $ids_id = $row['max(ids_id)'];
    $time = $row['time'];
    $mark = get_mark($table);
    echo "<td>$ids_id</td>
          <td>$time</td>
          <td>$mark</td>";
}

function show_ids_log()
{
    $sql = "select * from ids_log";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_assoc($result))
    {
        $ids_id = $row['ids_id'];
        $time = $row['time'];
        echo "<tr>
              <td>$ids_id</td>
              <td>$time</td>
            </tr>";
    }
}

function get_mark($table)
{
    $ids_id = get_ids_id();
    $sql = "select * from $table where ids_id=$ids_id order by mark";
    $result = mysql_query($sql);
    $mark_sum = 100;
    while ($row = mysql_fetch_assoc($result))
    {
        $mark_tmp = $row['mark'];
        if($mark_tmp < 3)
            $mark_sum -= (3-$mark_tmp);
    }
    return $mark_sum;
}
// echo get_mark('process');

function no_new_website_info()
{
    $ids_id = get_ids_id();
    $sql = "select * from website where ids_id=$ids_id order by mark";
    $result = mysql_query($sql);
    $nums = mysql_num_rows($result);
    if(!$nums)
        echo "<p class=\"text-success\">无新增网站文件，您的网站很安全！</p>";
}
function no_new_otherpath_info()
{
    $ids_id = get_ids_id();
    $sql = "select * from file where ids_id=$ids_id order by mark";
    $result = mysql_query($sql);
    $nums = mysql_num_rows($result);
    if(!$nums)
        echo "<p class=\"text-success\">无新增系统关键文件，您的系统关键文件很安全！</p>";
}
function show_new_website_file()
{
    $ids_id = get_ids_id();
    $sql = "select * from website where ids_id=$ids_id order by mark";
    show_website_file($sql);
}
function show_new_otherpath_file()
{
    $ids_id = get_ids_id();
    $sql = "select * from file where ids_id=$ids_id order by mark";
    show_otherpath_file($sql);
}
function show_pagination($sql,$type)
{
    // type = old_website or new_website
    $result = mysql_query($sql);
    $nums = mysql_num_rows($result);
    if(!empty($_GET['page']))
        $page = intval($_GET['page']);
    else
        $page = 1;

    if($nums)
    {
        echo "<nav>
            <ul class='pagination'>
              <li>
                <a info='ajax.php?$type=1&page=$page&act=pre' aria-label='Previous'>
                  <span aria-hidden='true'>&laquo;</span>
                </a>
              </li>";
        $page_sum = ($nums-1) / 10 + 1;
        $page_count = 1;
        while($page_count < $page_sum)
        {
            echo "<li><a info='ajax.php?$type=1&page=$page_count'>$page_count</a></li>";
            $page_count += 1;
            if($page_count > 10)
                break;
        }
        echo  "<li>
                <a info='ajax.php?$type=1&page=$page&act=next' aria-label='Next'>
                  <span aria-hidden='true'>&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>";
    }
}
function show_otherpath_file($sql)
{
    if(!empty($_GET['page']))
    {
        $page = intval($_GET['page']);
        if(!empty($_GET['act']))
        {
            $act = $_GET['act'];
            if($act == 'pre')
                $page -= 1;
            if($act == 'next')
                $page += 1;
        }
        
        $limit = ($page - 1) * 10;
        $sql .= " limit $limit,10";  
    }
    else
        $sql .= " limit 0,10";
    $result = mysql_query($sql);
    $count = 1;
    while ($row = mysql_fetch_assoc($result))
    {
        $file = $row['file'];
        $father_path = $row['father_path'];
        $mtime = $row['mtime'];
        $size = $row['size'];
        $permission = $row['permission'];
        $mark = $row['mark'];
        if($mark == 3)
            echo '<tr class="success">';
        if($mark == 2)
            echo '<tr class="info">';
        if($mark == 1)
            echo '<tr class="warning">';
        if($mark == 0)
            echo '<tr class="danger">';
            echo "<td>$count</td>
            <td style='width: 200px; table-layout:fixed; word-break: break-all; word-wrap: break-word;'>$file</td>
            <td style='width: 240px; table-layout:fixed; word-break: break-all; word-wrap: break-word;'>$father_path</td>
            <td>$mtime</td>
            <td>$size</td>
            <td>$permission</td>
            <td>$mark</td></tr>";
        $count += 1;
    }
}

function show_website_file($sql)
{
    if(!empty($_GET['page']))
    {
        $page = intval($_GET['page']);
        if(!empty($_GET['act']))
        {
            $act = $_GET['act'];
            if($act == 'pre')
                $page -= 1;
            if($act == 'next')
                $page += 1;
        }
        
        $limit = ($page - 1) * 10;
        $sql .= " limit $limit,10";  
    }
    else
        $sql .= " limit 0,10";
    $result = mysql_query($sql);
    $count = 1;
    while ($row = mysql_fetch_assoc($result))
    {
        $file = $row['file'];
        $father_path = $row['father_path'];
        $file_mtime = $row['file_mtime'];
        $file_md5 = $row['file_md5'];
        $mark = $row['mark'];
        if($mark == 3)
            echo '<tr class="success">';
        if($mark == 2)
            echo '<tr class="info">';
        if($mark == 1)
            echo '<tr class="warning">';
        if($mark == 0)
            echo '<tr class="danger">';
            echo "<td>$count</td>
            <td style='width: 200px; table-layout:fixed; word-break: break-all; word-wrap: break-word;'>$file</td>
            <td style='width: 240px; table-layout:fixed; word-break: break-all; word-wrap: break-word;'>$father_path</td>
            <td>$file_mtime</td>
            <td>$file_md5</td>
            <td>$mark</td></tr>";
        $count += 1;
    }
}
function show_new_ethernet()
{
    $ids_id = get_ids_id();
    $sql = "select * from ethernet where ids_id=$ids_id order by mark";
    $result = mysql_query($sql);
    $row = mysql_fetch_assoc($result);
    $ethernet = $row['ethernet_detail'];
    if($ethernet)
        echo "<p class='text-danger'>$ethernet</p>";
    else
        echo "<p class='text-success'>无变动，您的防火墙很安全！</p>";
}

function show_new_firewall()
{
    $ids_id = get_ids_id();
    $sql = "select * from firewall where ids_id=$ids_id order by mark";
    $result = mysql_query($sql);
    $row = mysql_fetch_assoc($result);
    $firewall = $row['firewall_detail'];
    if($firewall)
        echo "<p class='text-danger'>$firewall</p>";
    else
        echo "<p class='text-success'>无变动，您的防火墙很安全！</p>";
}

function port_nothing_info()
{
    $ids_id = get_ids_id();
    $sql = "select * from port where ids_id=$ids_id order by mark";
    $result = mysql_query($sql);
    $nums = mysql_num_rows($result);
    if(!$nums)
        echo "<p class=\"text-success\">无新增监听端口，您的端口列表很安全！</p>";
}

function show_port($sql)
{
    $result = mysql_query($sql);
    $count = 1;
    while ($row = mysql_fetch_assoc($result))
    {
        $proto = $row['proto'];
        $listen = $row['listen'];
        $process = $row['process'];
        $mark = $row['mark'];
        if($mark == 3)
            echo '<tr class="success">';
        if($mark == 2)
            echo '<tr class="info">';
        if($mark == 1)
            echo '<tr class="warning">';
        if($mark == 0)
            echo '<tr class="danger">';
        echo "<td>$count</td>
            <td>$proto</td>
            <td>$listen</td>
            <td>$process</td>
            <td>$mark</td></tr>";
        $count += 1;
    }
}

function show_new_port()
{
    $ids_id = get_ids_id();
    $sql = "select * from port where ids_id=$ids_id order by mark";
    show_port($sql);
    
}


function show_file_list($file)
{
    $data = file($file);
    $count = 1;
    foreach ($data as $line)
    {
        $line = rtrim($line);
        echo "<tr><td>$count</td><td>$line</td></tr>";
        $count ++;
    }
}

function get_ids_id()
{
    $sql = 'select max(ids_id) from ids_log';
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    return $row[0];
}

function show_process_info()
{
    $ids_id = get_ids_id();
    $sql = "select * from process where ids_id=$ids_id order by mark";
    $result = mysql_query($sql);
    $nums = mysql_num_rows($result);
    if(!$nums)
        echo "<p class=\"text-success\">无新增进程，您的进程很安全！</p>";
}

function show_new_process()
{
    $ids_id = get_ids_id();
    $sql = "select * from process where ids_id=$ids_id order by mark";
    show_process($sql);
}

function show_process($sql)
{
    $result = mysql_query($sql);
    $count = 1;
    while ($row = mysql_fetch_assoc($result))
    {
        $user = $row['user'];
        $pid = $row['pid'];
        $cpu = $row['cpu'];
        $mem = $row['mem'];
        $process = $row['process'];
        $mark = $row['mark'];
        if($mark == 3)
            echo '<tr class="success">';
        if($mark == 2)
            echo '<tr class="info">';
        if($mark == 1)
            echo '<tr class="warning">';
        if($mark == 0)
            echo '<tr class="danger">';
        echo "<td>$count</td>
            <td style='width: 200px; table-layout:fixed; word-break: break-all; word-wrap: break-word;'>$process</td>
            <td>$user</td>
            <td>$pid</td>
            <td>$cpu</td>
            <td>$mem</td>
            <td>$mark</td></tr>";
        $count += 1;
    }
}

function delete_str_from_file($file,$str)
{
    $data = file($file);
    $newfile_array = array();
    foreach ($data as $line)
    {
        $line = rtrim($line);
        if ($str != $line)
            $newfile_array[] = $line;
    }
    $handle = fopen($file, "w");
    foreach ($newfile_array as $line) 
    {
        fwrite($handle, $line."\n");
    }
    fclose($handle);
}

function add_processlist()
{
    //添加进程名到白名单并把黑名单对应的列表删除
    if(!empty($_GET['addwhitelist']))
    {
        $data = file($GLOBALS['file_whitelist']);
        $whitelist = array();
        foreach ($data as $line)
        {
            $whitelist[] = rtrim($line);
        }
        $file_w = fopen($GLOBALS['file_whitelist'],"a");
        foreach ($_POST as $key => $value) 
        {
            if (!in_array($key, $whitelist))
            {
                fwrite($file_w,"$key"."\n");
            }
            delete_str_from_file($GLOBALS['file_blacklist'],$key); 
        }
        fclose($file_w);
        echo "<script>alert('添加成功！');</script>";
    }

    //添加进程名到黑名单并把白名单对应的列表删除
    if(!empty($_GET['addblacklist']))
    {
        $data = file($GLOBALS['file_blacklist']);
        $blacklist = array();
        foreach ($data as $line)
        {
            $blacklist[] = rtrim($line);
        }
        $file_w = fopen($GLOBALS['file_blacklist'],"a");
        foreach ($_POST as $key => $value) 
        {
            if (!in_array($key, $blacklist))
            {
                fwrite($file_w,"$key"."\n");
            }
            delete_str_from_file($GLOBALS['file_whitelist'],$key); 
        }
        fclose($file_w);
        echo "<script>alert('添加成功！');</script>";
    }

}



?>