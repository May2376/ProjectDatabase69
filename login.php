<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>ระบบจองห้องเรียน</title>
</head>
<body>

<h1 style="text-align:center; font-size:36px;">
    ระบบจองห้องเรียน
</h1>

<div style="text-align:center; margin-bottom:20px;">
    <a href="schedule.php">📅 ดูตารางห้องเรียน</a>
</div>

<?php
if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
    $result = $conn->query($sql);

    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role'];
        header("Location: dashboard.php");
    } else {
        echo "<p style='color:red; text-align:center;'>Login failed</p>";
    }
}
?>

<form method="post" style="text-align:center;">
    Username: <input type="text" name="username"><br><br>
    Password: <input type="password" name="password"><br><br>
    <button name="login">Login</button>
</form>


</body>
</html>
