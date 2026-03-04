<?php 
include 'db.php';
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// อนุญาตเฉพาะอาจารย์และแอดมิน
if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['teacher','admin'])){
    die("เฉพาะอาจารย์เท่านั้นที่จองห้องได้");
}

if(isset($_POST['book'])){
    $room = $_POST['room_id'];
    $date = $_POST['date'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $uid = $_SESSION['user_id'];

    // ฟังก์ชันเช็คเวลาเป็นครึ่งชั่วโมง
    function toMinutes($time){
        list($h,$m) = explode(":", $time);
        return ($h * 60) + $m;
    }
    
    $startMin = toMinutes($start);
    $endMin   = toMinutes($end);
    
    if($startMin < 360 || $endMin > 1020){  // 360 = 06:00, 1020 = 17:00
        die("จองได้เฉพาะเวลา 06:00 - 17:00 เท่านั้น");
    }
    function isValidHalfHour($time){
        $parts = explode(":", $time);
        $minute = (int)$parts[1];
        return ($minute == 0 || $minute == 30);
    }

    // จำกัดช่วงเวลา
    if($start < "06:00" || $end > "17:00"){
        die("จองได้เฉพาะเวลา 06:00 - 17:00");
    }

    // เวลาเริ่มต้องน้อยกว่าสิ้นสุด
    if($start >= $end){
        die("เวลาเริ่มต้องน้อยกว่าเวลาสิ้นสุด");
    }

    // บังคับเลือกทีละ 30 นาที
    if(!isValidHalfHour($start) || !isValidHalfHour($end)){
        die("เลือกเวลาได้เฉพาะช่วง 30 นาที เช่น 09:00 หรือ 09:30");
    }

    // ตรวจสอบเวลาทับกัน
    $check = "SELECT * FROM bookings 
              WHERE room_id='$room' AND booking_date='$date'
              AND (start_time < '$end' AND end_time > '$start')";
    $result = $conn->query($check);

    if($result->num_rows > 0){
        echo "❌ เวลานี้ถูกจองแล้ว";
    } else {
        $sql = "INSERT INTO bookings 
                (room_id,user_id,booking_date,start_time,end_time,status)
                VALUES('$room','$uid','$date','$start','$end','pending')";
        $conn->query($sql);
        echo "✅ จองสำเร็จ";
    }
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

<div style="text-align:center; margin:20px;">
<h2>จองห้องเรียน</h2>

<form method="post">
วันที่: <input type="date" name="date" required><br><br>

เริ่ม: <input type="time" name="start_time" min="06:00" max="20:00" step="1800" required><br><br>
สิ้นสุด: <input type="time" name="end_time" min="06:00" max="20:00" step="1800" required><br><br>

ห้อง:
<select name="room_id" required>
<?php
$rooms = $conn->query("SELECT * FROM rooms");
while($r = $rooms->fetch_assoc()){
    echo "<option value='{$r['room_id']}'>
            {$r['room_name']} (ความจุ {$r['capacity']} คน)
          </option>";
}
?>
</select><br><br>

<button name="book">จอง</button>
</form>
