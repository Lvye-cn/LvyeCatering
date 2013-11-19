<?php
/**
 * Created by PhpStorm.
 * User: jinbangzhu
 * Date: 11/15/13
 * Time: 11:08 AM
 */
require_once('./mysqlConn.php');
getCon();

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if ($_GET['id']) {
    $sql = "delete from menu where id =" . $_GET['id'];
    if (!mysql_query($sql)) {
        die('Error: ' . mysql_error());
    }
    echo "<alert>删除成功</alert>";
}

if ($_GET['del']) {
    $sql = "delete from lvyeorder where id =" . $_GET['del'];
    if (!mysql_query($sql)) {
        die('Error: ' . mysql_error());
    }
    echo "<alert>删除成功</alert>";
}
if ($_POST['hours']) {
    if ($_POST['id']) {
        $sql = "UPDATE  deadtime SET  minute =  '" . $_POST['minute'] . "', hours='" . $_POST['hours'] . "'  WHERE  deadtime.id =" . $_POST['id'] . ";";
    } else {
        $sql = "INSERT INTO deadtime (id, name, hours, minute) VALUES (NULL, '', '" . $_POST['hours'] . "', '" . $_POST['minute'] . "');";
    }

//    echo $sql;
    if (!mysql_query($sql)) {
        die('Error: ' . mysql_error());
    }
    echo "<script>alert('更新成功')</script>";
}
?>
<!doctype html>
<!--[if lte IE 7 ]>
<html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html> <!--<![endif]-->

<head>
    <meta charset="UTF-8">
    <title>后台-绿野内部订餐系统</title>
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/index.css">
    <!--[if lt IE 9]>
    <script src="js/html5.js"></script>
    <![endif]-->
    <!--[if lte IE 6]>
    <script src="js/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>
        DD_belatedPNG.fix('.pngfix');
    </script>
    <![endif]-->
</head>
<body>
<!-- header begin -->
<header class="header">
    <div class="inner-header clearfix">

    </div>
</header>
<!-- header end -->

<!-- container begin -->
<div class="wrap clearfix">
    <div class="menu clearfix">
        <h5>菜单管理</h5>
        <ul class="menulist">
            <?php
            $result = mysql_query("SELECT * FROM menu");

            while ($row = mysql_fetch_array($result)) {
                echo " <li>
                    <img src=\"menus/" . $row['name'] . "\" alt=\"\" title=\"\" width='130' height='100'>
                    <a href='./background.php?id=" . $row['id'] . "' class=\"removebtn\"></a>
                </li>";
            }
            ?>
        </ul>

        <form action="./upload_file.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="" class="uploadbtn">
            <input type="submit" name="submit" value="开始上传" class="uploadbtn"/>
        </form>
    </div>
    <div class="menu_btbg"></div>
    <div class="bgtimewrap">
        <form action="./background.php" id="changeDeadTime" method="post" enctype="multipart/form-data">
            截止时间：
            <div class="timebg">
                <?php
                $result = mysql_query("SELECT * FROM deadtime");
                $row = mysql_fetch_array($result);
                ?>
                <input type="text" name="hours" id="" value="<?php echo $row['hours'] ?>" class="hours">
                <input type="text" name="minute" id="" value="<?php echo $row['minute'] ?>" class="mimute">
                <input type="hidden" name="id" id="" value="<?php echo $row['id'] ?>">
            </div>
            <input type="submit" value="更新" class="updatebtn"/>
        </form>
    </div>
    <div class="tablewrap">
        <table>

            <tr>
                <th></th>
                <th class="tdblue_big" width="105">吃什么</th>
                <th class="td_blue" width="58">单价</th>
                <th class="td_blue">份数</th>
                <th class="td_pink" width="106">总价</th>
                <th class="td_pink" width="58">操作</th>
            </tr>


            <?php

            $result = mysql_query("SELECT * FROM lvyeorder where DATE( TIME ) = curdate() order by eatwhat");


            while ($row = mysql_fetch_array($result)) {
                echo " <tr><td class=\"td_name\">" . $row['name'] . "</td>";
                echo " <td class=\"td_green\">" . $row['eatwhat'] . "</td>";
                echo " <td class=\"td_bluec\">" . $row['price'] . "</td>";
                echo " <td class=\"td_green\">" . $row['count'] . "</td>";
                echo " <td class=\"td_lightred\">" . $row['count'] * $row['price'] . "</td>";
                echo "<td class=\"td_bluec\"> <a href='background.php?del=" . $row['id'] . "'>删除</a></td></tr>";

                $total += $row['count'] * $row['price'];

            }
            echo "</table><div class=\"totalwrap\">总数：" . $total . "元</div>";
            ?>
    </div>


    <div class="table_bg"></div>
</div>
<!-- container end -->

<!-- footer begin -->
<footer class="footer">
    <div class="inner-footer clearfix">

    </div>
</footer>
<!-- footer end -->
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
</body>
</html>