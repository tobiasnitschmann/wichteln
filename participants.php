<?php

header('Content-Type: application/json');

$db = new SQLite3('db/wichteln2');
$res = $db->query('SELECT * FROM participants');

if($_REQUEST['oldname']) {
    $db->query("UPDATE participants SET assigned = 0 WHERE name = '" + $_REQUEST['oldname'] + "'");
}

while ($row = $res->fetchArray()) {
    $array[$row['name']] = $row['assigned'];
    if($_REQUEST['oldname'] && $_REQUEST['oldname']==$row['name']) {
        $array[$row['name']] = 1;
    }
    $participants[] = $row['name'];
}

$filtered_array = array_filter($array, function($var) {  return !$var; });
if(count($filtered_array) > 0){
    $name = array_rand($filtered_array);
    $db->query("UPDATE participants SET assigned = 1 WHERE name = '{$name}'");
    $pos = array_search($name, array_keys($array));
} else {
    $pos = -1;
}

$result = array(
    'participants' => $participants,
    'pickedPos' => $pos,
    'pickedName' => $name
);
echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>
