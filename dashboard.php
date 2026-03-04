<?php include 'db.php'; 
if(!isset($_SESSION['user_id'])) header("Location: login.php");
?>

<div style="text-align:center; margin:20px;">
    <!-- 🔙 ปุ่มกลับ Dashboard (จะเห็นแน่นอน) -->
    <a href="dashboard.php" style="text-decoration:none;">
        <button style="padding:10px 20px; font-size:16px; background:#4CAF50; color:white; border:none; border-radius:5px;">
            ⬅ กลับหน้าเมนูหลัก
        </button>
    </a>
</div>
<div style="text-align:center; margin:20px; ">
<h2>Welcome <?php echo $_SESSION['name']; ?></h2>
<a href="rooms.php">ดูห้องเรียน</a><br>
<a href="booking_add.php">จองห้อง</a><br>
<a href="booking_list.php">รายการจอง</a><br>
<a href="logout.php">Logout</a>

