<?php
require_once "cookieauth.php";
require_once 'config.php';
// this is going to put the bugs report in the database so that the developers can see the problem
if (isset($_POST['bug'])) {
    $conn = dbConnect();
    $reporter = $_POST['reporter'];
    $report = $_POST['report'];
    $description = $_POST['description'];
    $whattheuserdid = $_POST['whatTheUserDid'];

    $stmt = $conn->prepare("INSERT INTO bugs SET reporter=?, meaning_of_report=?, bug_report=?, what_happend_report=?");
    $stmt->execute([$reporter, $report, $description, $whattheuserdid]);

    header('Location: ../index.php');
    exit;
}
?>