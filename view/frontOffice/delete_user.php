<?php
session_start();
include '../../model/user.php';
include '../../controller/userC.php';

if (isset($_SESSION['user_email'])) {
    $user_id = $_SESSION['user_id'];
    $userC = new userC();
    $userC->deleteUser($user_id);

    unset($_SESSION['user_email']);
    unset($_SESSION['user_id']);


    header("Location: connexion.php");
    exit;
}
?>
