<?php 
include 'db.php'; 

// ต้องล็อกอินก่อนดูรายการจอง
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>

<!-- 🔙 ปุ่มกลับ Dashboard (จะเห็นแน่นอน) -->
<div style="text-align:center; margin:20px;">
    <a href="dashboard.php" style="text-decoration:none;">
        <button style="padding:10px 20px; font-size:16px; background:#4CAF50; color:white; border:none; border-radius:5px;">
            ⬅ กลับหน้าเมนูหลัก
        </button>
    </a>
</div>
<div style="text-align:center;">
<h2>รายการจองห้องเรียน</h2>

<table border="1" cellpadding="8" style="margin:auto; border-collapse:collapse;">
<tr>
    <th>ห้อง</th>
    <th>วันที่</th>
    <th>เวลา</th>
    <th>ผู้จอง</th>
    <th>สถานะ</th>
</tr>


<?php
$sql = "SELECT b.*, r.room_name, u.name 
        FROM bookings b
        JOIN rooms r ON b.room_id=r.room_id
        JOIN users u ON b.user_id=u.user_id
        ORDER BY b.booking_date DESC";

$res = $conn->query($sql);

while($row=$res->fetch_assoc()){
    echo "<tr>
            <td>{$row['room_name']}</td>
            <td>{$row['booking_date']}</td>
            <td>{$row['start_time']} - {$row['end_time']}</td>
            <td>{$row['name']}</td>
            <td>";

    // ถ้าเป็น admin และยังไม่อนุมัติ ให้แสดงปุ่ม
    if($row['status'] == 'pending' && $_SESSION['role'] == 'admin'){
        echo "<a href='approve.php?id={$row['booking_id']}'>อนุมัติ</a>";
    } else {
        echo $row['status'];
    }

    echo "</td></tr>";
}
?>


