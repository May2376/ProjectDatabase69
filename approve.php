<?php include 'db.php';

if($_SESSION['role'] != 'admin') die("Access denied");

$id = $_GET['id'];
$conn->query("UPDATE bookings SET status='approved' WHERE booking_id='$id'");
header("Location: booking_list.php");
?>
