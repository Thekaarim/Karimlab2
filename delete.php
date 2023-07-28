<?php
if (isset($_GET['line'])) {
    $lineToDelete = urldecode($_GET['line']);
    $data = file("customers.txt");
    $output = array();
    foreach ($data as $line) {
        if (trim($line) !== trim($lineToDelete)) {
            $output[] = $line;
        }
    }
    file_put_contents("customers.txt", implode("", $output));
}
header("Location: display_customers.php");
exit();
?>
