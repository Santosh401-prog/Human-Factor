<?php
// Fetch available therapists to schedule appointments ; this is for staff portal
$pdo = new PDO('mysql:host=localhost;dbname=care_system', 'root', '');
$stmt = $pdo->query("SELECT id, name FROM therapists");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
