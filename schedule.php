<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ตารางห้องเรียน</title>
</head>
<body>

<h1 style="text-align:center;">📚 ระบบจองห้องเรียน</h1>
<h2 style="text-align:center;">ตารางการใช้ห้องเรียน</h2>

<!-- 🔙 ปุ่มกลับ Dashboard (จะเห็นแน่นอน) -->
<div style="text-align:center; margin:20px;">
    <a href="dashboard.php" style="text-decoration:none;">
        <button style="padding:10px 20px; font-size:16px; background:#4CAF50; color:white; border:none; border-radius:5px;">
            ⬅ กลับหน้าเมนูหลัก
        </button>
    </a>
</div>

<!-- ฟอร์มค้นหา -->
<form method="get" style="text-align:center; margin-bottom:20px;">
วันที่:
<input type="date" name="date" value="<?= $_GET['date'] ?? '' ?>">

ห้อง:
<select name="room_id">
<option value="">-- ทุกห้อง --</option>
<?php
$rooms = $conn->query("SELECT * FROM rooms");
while($r = $rooms->fetch_assoc()){
    $selected = (isset($_GET['room_id']) && $_GET['room_id']==$r['room_id']) ? "selected" : "";
    echo "<option value='{$r['room_id']}' $selected>{$r['room_name']}</option>";
}
?>
</select>

<button type="submit">ค้นหา</button>
</form>

<table border="1" cellpadding="8" style="margin:auto; border-collapse:collapse;">
<tr style="background:#f2f2f2;">
    <th>ห้อง</th>
    <th>วันที่</th>
    <th>เวลา</th>
    <th>ผู้จอง</th>
</tr>

<?php
$where = "WHERE b.status='approved'";

if(!empty($_GET['date'])){
    $date = $_GET['date'];
    $where .= " AND b.booking_date='$date'";
}

if(!empty($_GET['room_id'])){
    $room_id = $_GET['room_id'];
    $where .= " AND b.room_id='$room_id'";
}

$sql = "SELECT b.*, r.room_name, u.name
        FROM bookings b
        JOIN rooms r ON b.room_id=r.room_id
        JOIN users u ON b.user_id=u.user_id
        $where
        ORDER BY b.booking_date DESC, b.start_time ASC";

$res = $conn->query($sql);

if($res->num_rows > 0){
    while($row=$res->fetch_assoc()){
        echo "<tr>
                <td>{$row['room_name']}</td>
                <td>{$row['booking_date']}</td>
                <td>{$row['start_time']} - {$row['end_time']}</td>
                <td>{$row['name']}</td>
              </tr>";
    }
}else{
    echo "<tr><td colspan='4' style='text-align:center;'>ไม่พบข้อมูลการจอง</td></tr>";
}
?>
</table>

</body>
</html>
