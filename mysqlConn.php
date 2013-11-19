<?php
/**
 * Created by PhpStorm.
 * User: jinbangzhu
 * Date: 11/15/13
 * Time: 10:56 AM
 */
function getCon()
{
    if(!isset($mysql_con)){

        //echo "'".$ip.":".$port."','".$name."','".$pwd."'";
        //require('./ConDB_MySql/MySqlConner.php');
        $mysql_con=mysql_connect("192.168.12.230","root","root");
        if (!$mysql_con){
            die('Could not connect: ' . mysql_error());
        }else{
        }

        mysql_select_db("lvyeorder", $mysql_con);
    }
}