<?php

$user = (!empty($_POST['user'])) ? trim($_POST['user']) : '';
$host = (!empty($_POST['host'])) ? trim($_POST['host']) : '';
$password = (!empty($_POST['password'])) ? trim($_POST['password']) : '';
$query = (!empty($_POST['query'])) ? trim($_POST['query']) : '';
$dbname = (!empty($_POST['dbname'])) ? trim($_POST['dbname']) : '';
$encode = (!empty($_POST['encode'])) ? trim($_POST['encode']) : 'utf8';
if ($encode === 'win1251') {
    $query = iconv('UTF-8', 'windows-1251', $query);
}
$result = [];
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $dbResult = $db->query($query);
    if (!empty($dbResult)) {
        foreach ($dbResult as $row) {
            $result[] = $row;
        }
    }
} catch (PDOException $e) {
    $result[] = $e;
} catch (Exception $e) {
    $result[] = $e;
}
/*
try {
    $user = 'root';
    $pass = '';
    $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
    var_dump($dbh);
    foreach($dbh->query('SHOW DATABASES;') as $row) {
        print_r($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}*/
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="windows-1251">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyAdmin</title>
</head>
<body>
<form action="" method="post">
    <p><label for="">Host</label>
        <input type="text" name="host" value="<?= (!empty($_POST['host'])) ? $_POST['host'] : '' ?>"></p>
    <p>
        <label for="">dbname</label>
        <input type="text" name="dbname" value="<?=(!empty($_POST['dbname'])) ? $_POST['dbname'] : ''?>">
    </p>
    <p><label for="">User</label>
        <input type="text" name="user" value="<?= (!empty($_POST['user'])) ? $_POST['user'] : '' ?>"></p>
    <p><label for="">Password</label>
        <input type="text" name="password" value="<?= (!empty($_POST['password'])) ? $_POST['password'] : '' ?>"></p>
    <p><label for="">encode db</label>
        <select name="encode" id="">
            <option value="utf8">UTF-8</option>
            <option value="win1251">windows-1251</option>
        </select>
    </p>

    <p><label for="">query</label>
        <textarea id="" cols="30" rows="10" name="query"><?=
            (!empty($_POST['query'])) ? $_POST['query'] : ''
            ?></textarea></p>
    <input type="submit" value="send">
    <?php
    echo '<br>';
    echo count($result);
    echo '<br>';
    echo '<pre>';
    foreach ($result as $line) {
        print_r($line);
        echo '<br>';
    }
    echo '</pre>';
    ?>
</form>
</body>
</html>
