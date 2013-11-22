<?php
/**
 * Created by PhpStorm.
 * User: jinbangzhu
 * Date: 11/15/13
 * Time: 1:58 PM
 */
require_once('./mysqlConn.php');
getCon();
// Report simple running errors
error_reporting(E_ERROR | E_PARSE);
?>
<input type="button" onclick="window.print()" value="打印" />
<table style="width: 100%" border="1px solid gray">
    <tr>
        <td>ID</td>
        <td>姓名</td>
        <td>吃什么</td>
        <td>份数</td>
        <td>价钱</td>
    </tr>
    <?php

    $result = mysql_query("SELECT * FROM lvyeorder where DATE( TIME ) = curdate() order by eatwhat");

    $total;
    $num = 1;
    while ($row = mysql_fetch_array($result)) {
        echo "<tr data-eatwhat='" . $row['eatwhat'] . "' data-price='" . $row['price'] . "' >";
        echo "<td>$num</td>";
        echo "<td>" . $row['name'] . "</td>"
            . "<td>" . $row['eatwhat'] . "</td>"
            . "<td>" . $row['count'] . "</td>"
            . "<td>" . $row['price'] . "</td>";
        echo "</tr>";
        $num++;
        $total += $row['price'];
    }
    echo "<tr><td collspan='4'>总计：".$total."元</td></tr>";
    mysql_close($mysql_con);
    ?>
</table>
