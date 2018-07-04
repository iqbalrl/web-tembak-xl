<?php
    $fil= fopen('count_file.txt', 'r');
   echo fread($fil, filesize('count_file.txt'));
   fclose($fil);
?>
