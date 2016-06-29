<?php
$file = $_SERVER['DOCUMENT_ROOT'].'/tmp/editor_sql.txt';
$current = file_get_contents($file);
// Append a new person to the file
$sql .= "new statement\n";
// Write the contents back to the file

try {
	echo($current);
	file_put_contents($file, $sql);
} catch (Exception $e) {
	echo ($e);
}

//file_put_contents($file, $current);

?>