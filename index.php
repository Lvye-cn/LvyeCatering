<?php
require_once('./mysqlConn.php');
getCon();

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$name = $_POST['name'];
$eatwhat = $_POST['eat'];
$price = $_POST['price'];
$count = $_POST['count'];

if ($name) {
    if (isAlreadyOrder($name)) {
        echo "<script>alert('您今天已经下过单啦～')</script>";
    }else{
        insertOrder($name, $eatwhat, $price, $count);
    }

    setcookie('name', $name, time() + (10 * 365 * 24 * 60 * 60));
}

function insertOrder($name, $eatwhat, $price, $count)
{
    $sql = "INSERT INTO lvyeorder (name, eatwhat, price, count)
        VALUES ('" . $name . "', '" . $eatwhat . "', '" . $price . "', '".$count."'); ";
//    echo $sql;
    if (!mysql_query($sql)) {
        die('Error: ' . mysql_error());
    }

    echo "<script>alert('下单成功')</script>";
}

function isAlreadyOrder($name)
{
    $sql = "select count(*) from lvyeorder where name ='" . $name . "' and DATE( TIME ) = curdate()";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    return $row[0];
}
?>
<!doctype html>
<!--[if lte IE 7 ]> <html lang="en" class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->

<head>
    <meta charset="UTF-8">
    <title>首页-绿野内部订餐系统</title>
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/lightbox.css">
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
    <div class="container clearfix">
        <div class="two_column first">
            <!-- menu area begin -->
                <div class="menu_top clearfix">
                    <h5>菜单</h5>
                    <ul>
                        <?php
                        $result = mysql_query("SELECT * FROM menu");

                        while ($row = mysql_fetch_array($result)) {
                            echo "<li>
                                <a href=\"menus/".$row['name']."\" data-lightbox=\"menu\" target=\"_blank\"><img src=\"menus/".$row['name']."\" height=\"100\" width=\"100\" alt=\"\" title=\"\"></a>
                                </li>";
                        }?>
                    </ul>
                </div>
                <div class="menu_bt"></div>
            <!-- menu area end -->

            <!-- others eat begin -->
                <div class="others_top">
                    <h5>小伙伴们在吃的</h5>
                    <table>
                        <tr>
                            <th></th>
                            <th class="td_pink" width="106">吃什么</th>
                            <th class="td_blue" width="58">单价</th>
                            <th></th>
                        </tr>

                        <?php

                        $result = mysql_query("SELECT * FROM lvyeorder where DATE( TIME ) = curdate()");

                        while ($row = mysql_fetch_array($result)) {
                            echo " <tr><td class=\"td_name\"><div class=\"single_line\">";
                            echo $row['name'] ;
                            echo "</div></td>";

                            echo "<td class=\"td_fan\">";
                            echo $row['eatwhat'];
                            echo "</td>";

                            echo "<td class=\"td_price\">";
                            echo $row['price'];
                            echo "</td>";

                            echo "<td><a href=\"#\" class=\"eatsame\">我也吃这个</a></td>";
                            echo "</tr>";
                        }

                        ?>


                    </table>
                </div>
                <div class="others_bt"></div>
            <!-- others eat end -->

        </div>
        <div class="two_column second">
            <!-- end time area begin -->
                <div class="end_time">
                    截止时间
                    <?php
                    $result = mysql_query("SELECT * FROM deadtime");
                    $row = mysql_fetch_array($result);
                    ?>
                    <span class="timewrap"><?php echo $row['hours'].":".$row['minute'] ?></span>
                </div>
            <!-- end time area end -->

            <!-- order area begin -->
                <div class="orderwrap">
                    <h5>订餐</h5>
                    <form action="./" method="post">
                        <div class="labels">
                            <div>姓名</div>
                            <div>我要吃</div>
                            <div>单价</div>
                            <div>份数</div>
                            <div>总价</div>
                        </div>
                        <input type="text" name="name" value="<?php echo $_COOKIE['name'] ?>" class="name_field">
                        <input type="text" name="eat" class="cai_field">
                        <input type="text" name="price" id="" class="price_field">
                        <input type="text" name="count" maxlength="2" value="1" class="quantity_field">
                        <input type="text" class="total_field" readonly>
                        <input type="submit" class="order_btn" />
                        <div class="plus_btn"></div>
                        <div class="minus_btn"></div>
                    </form>
                </div>
            <!-- order area end -->
        </div>
    </div>
    <!-- container end -->

    <!-- footer begin -->
    <footer class="footer">
        <div class="inner-footer clearfix">

        </div>
    </footer>
    <!-- footer end -->
    <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script src="js/lightbox-2.6.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>