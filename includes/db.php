<?php

  $connection = mysqli_connect(
    $config['db']['server'],
    $config['db']['username'],
    $config['db']['password'],
    $config['db']['name']
  );

  if ($connection == False){
    echo "Подключение к базе данных не удалось!<br>";
    echo mysqli_connect_error();
    exit();
  }
?>
