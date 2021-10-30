<?php

header('Content-Type: application/json');

$db = new SQLite3('db/wichteln2');

if($_REQUEST['name']) {
    $name = $_REQUEST['name'];
    $result = $db->exec("UPDATE participants SET assigned = 0 WHERE name = '{$name}'");
    echo json_encode($result);
} else {
    echo json_encode(array('result' => 'name not set'), JSON_UNESCAPED_UNICODE);
}
?>
