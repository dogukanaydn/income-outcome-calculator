<?php
session_start();

require_once 'config.php';

if (!empty($connection)){
    if (isset($_POST['name']) && isset($_POST['how-much'])) {
        $stat = $_POST['stat'];
        $name = $_POST['name'];
        $money = $_POST['how-much'];
        $control = "SELECT * FROM list WHERE name = '$name'";
        $controlResult = $connection->query($control);
        if ($controlResult->num_rows == 0) {
            $stmt = $connection->prepare("INSERT INTO list VALUES ( NULL,?, ?, ?)");
            $stmt->bind_param('ssd',  $stat, $name, $money );
            $stmt->execute();
            $stmt->close();
            $_SESSION['message'] = "Record added successfully";
            header('Location: index.php');
        } else {
            $_SESSION['message'] = "There is a record with this name. Enter different name.";
            header('Location: index.php');
        }
    }

    if (isset($_POST['delete'])) {
        $deleteName = $_POST['selected-name'];
        $stmt = $connection->prepare("DELETE FROM list WHERE name = '$deleteName'");
        $stmt->execute();
        $stmt->close();
        $_SESSION['message'] = "Record deleted successfully";
        header('Location: index.php');
    }



}