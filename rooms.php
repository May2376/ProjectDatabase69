<?php include 'db.php'; ?>

<div style="text-align:center;">
<!-- 🔙 ปุ่มกลับ Dashboard (จะเห็นแน่นอน) -->
    <a href="dashboard.php" style="text-decoration:none;">
        <button style="padding:10px 20px; font-size:16px; background:#4CAF50; color:white; border:none; border-radius:5px;">
            ⬅ กลับหน้าเมนูหลัก
        </button>
    </a>
</div>

<div style="text-align:center;">
<h2>ห้องเรียน</h2>
<table border="1"cellpadding="8" style="margin:auto; border-collapse:collapse;">
<tr><th>ชื่อห้อง</th><th>อาคาร</th><th>ความจุ</th></tr>

<?php
$res = $conn->query("SELECT * FROM rooms");
while($r = $res->fetch_assoc()){

    echo "<tr>
            <td>{$r['room_name']}</td>
            <td>{$r['building']}</td>
            <td>{$r['capacity']}</td>
          </tr>";
}
?>
</table>
