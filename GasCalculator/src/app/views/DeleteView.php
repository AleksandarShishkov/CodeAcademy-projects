<?php

session_start();

$id = $_SESSION['id'];

$data = file_get_contents('../database.json');
$refEvents = json_decode($data, true);

unset($refEvents['refuel_events'][$id]);

$refEvents = json_encode($refEvents, JSON_PRETTY_PRINT);
file_put_contents('../database.json', $refEvents);

echo '<h4><form method="POST"><input type="submit" name="back_to_form_btn" value="Върни се към таблицата"/></form></h4>';

if(isset($_POST['back_to_form_btn'])) {
    header('location: http://localhost/Codix-codeacademy/homework/Project-gasCalculator/GasCalculator/src/app/index.php');
}