<?php
   $dbhost = 'localhost:3036';
   $dbuser = 'root';
   $db = 'users';
   $dbpass = '';

// $link = mysqli_connect("localhost", "root", "", "users");
   

date("h:i:sa");
   $backup_file = $dbname . date("Y-m-d-H-i-s") . '.gz';
   $command = "mysqldump --opt -h $dbhost -u $dbuser -p $dbpass ". "test_db | gzip > $backup_file";
   
   system($command);



?>