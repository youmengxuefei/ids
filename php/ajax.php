<?php
include "include/function.php";
if(!empty($_GET['old_process']))
{
    $ids_id = get_ids_id();
    $sql = "select * from process where ids_id<$ids_id order by mark";
    show_process($sql);
}
if(!empty($_GET['old_port']))
{
    $ids_id = get_ids_id();
    $sql = "select * from port where ids_id<$ids_id order by mark";
    show_port($sql);
}
if(!empty($_GET['old_firewall']))
{
    show_old_firewall();
}
if(!empty($_GET['old_ethernet']))
{
    show_old_ethernet();
}

if(!empty($_GET['new_website']))
{
    $ids_id = get_ids_id();
    $sql = "select * from website where ids_id=$ids_id order by mark";
    show_website_file($sql);
}

if(!empty($_GET['old_website']))
{
    $ids_id = get_ids_id();
    $sql = "select * from website where ids_id<$ids_id order by mark";
    show_website_file($sql);
}
if(!empty($_GET['old_website_pagination']))
{
    $ids_id = get_ids_id();
    $sql = "select * from website where ids_id<$ids_id order by mark";
    show_pagination($sql,'old_website');
}
if(!empty($_GET['new_otherpath']))
{
    $ids_id = get_ids_id();
    $sql = "select * from file where ids_id=$ids_id order by mark";
    show_otherpath_file($sql);
}

if(!empty($_GET['old_otherpath']))
{
    $ids_id = get_ids_id();
    $sql = "select * from file where ids_id<$ids_id order by mark";
    show_otherpath_file($sql);
}
if(!empty($_GET['old_otherpath_pagination']))
{
    $ids_id = get_ids_id();
    $sql = "select * from file where ids_id<$ids_id order by mark";
    show_pagination($sql,'old_otherpath');
}
function show_old_ethernet()
{
    $ids_id = get_ids_id();
    $sql = "select * from ethernet where ids_id<$ids_id order by mark";
    $result = mysql_query($sql);
    $row = mysql_fetch_assoc($result);
    $ethernet = $row['ethernet_detail'];
    $mark = $row['mark'];
    $count = 1;
    if($ethernet)
        while($ethernet)
        {
            echo "<p>$count : <br>";
            if($mark == 3)
                echo '<pre class="text-success">';
            if($mark == 2)
                echo '<pre class="text-info">';
            if($mark == 1)
                echo '<pre class="text-warning">';
            if($mark == 0)
                echo '<pre class="text-danger">';
            echo "$ethernet</pre></p>";
            $row = mysql_fetch_assoc($result);
            $ethernet = $row['ethernet_detail'];
            $mark = $row['mark'];
            $count += 1;
        }
        
    else
        echo "<p class='text-success'>请到控制中心执行检测！</p>";
}
function show_old_firewall()
{
    $ids_id = get_ids_id();
    $sql = "select * from firewall where ids_id<$ids_id order by mark";
    $result = mysql_query($sql);
    $row = mysql_fetch_assoc($result);
    $firewall = $row['firewall_detail'];
    $mark = $row['mark'];
    $count = 1;
    if($firewall)
        while($firewall)
        {
            echo "<p>$count : <br>";
            if($mark == 3)
                echo '<pre class="text-success">';
            if($mark == 2)
                echo '<pre class="text-info">';
            if($mark == 1)
                echo '<pre class="text-warning">';
            if($mark == 0)
                echo '<pre class="text-danger">';
            echo "$firewall</pre></p>";
            $row = mysql_fetch_assoc($result);
            $firewall = $row['firewall_detail'];
            $mark = $row['mark'];
            $count += 1;
        }
        
    else
        echo "<p class='text-success'>请到控制中心执行检测！</p>";
}

?>