<?php
if (file_exists("log.txt")) {
    $handle = fopen("log.txt", "w");
    fclose($handle);
    header("Location: index.php");
}
?>