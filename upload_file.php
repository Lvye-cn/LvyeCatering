<?php
/**
 * Created by PhpStorm.
 * User: jinbangzhu
 * Date: 11/15/13
 * Time: 12:57 PM
 */

require_once('./mysqlConn.php');
getCon();

if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "image/pjpeg"))
    && ($_FILES["file"]["size"] < 20000000)
) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    } else {
        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
        echo "Type: " . $_FILES["file"]["type"] . "<br />";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

        move_uploaded_file($_FILES["file"]["tmp_name"],
            "menus/" . $_FILES["file"]["name"]);
        echo "Stored in: " . "menus/" . $_FILES["file"]["name"];

        $sql = "INSERT INTO menu (name) VALUES ('" . $_FILES["file"]["name"] ."'); ";
        if (!mysql_query($sql)) {
            die('Error: ' . mysql_error());
        }
        echo "<h1>upload success</h1>";
        echo "<a href='background.php'>Back</a>";
    }
} else {
    echo "Invalid file";
}