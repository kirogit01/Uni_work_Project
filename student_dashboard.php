<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Student') {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Fetch user data */
$sql = "SELECT * FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

/* Handle profile update */
$success_msg = $error_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $id_no = $_POST['id_no'];
    $address = $_POST['address'];

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['profile_image']['name']);
        $file_path = 'uploads/' . $file_name;
        if (!move_uploaded_file($file_tmp, $file_path)) {
            $error_msg = "Failed to upload image.";
            $file_path = $user['profile_image'];
        }
    } else {
        $file_path = $user['profile_image'];
    }

    $update_sql = "UPDATE users SET username=?, email=?, id_no=?, address=?, profile_image=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssi", $username, $email, $id_no, $address, $file_path, $user_id);
    if ($stmt->execute()) {
        $success_msg = "Profile updated successfully!";
        $user['username'] = $username;
        $user['email'] = $email;
        $user['id_no'] = $id_no;
        $user['address'] = $address;
        $user['profile_image'] = $file_path;
    } else {
        $error_msg = "Failed to update profile.";
    }
}

/* Handle Apply / Reject for jobs */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_status'], $_POST['job_id'])) {
    $job_id = $_POST['job_id'];
    $status = $_POST['job_status'];

    $stmt = $conn->prepare("SELECT * FROM job_applications WHERE student_id=? AND job_id=?");
    $stmt->bind_param("ii", $user_id, $job_id);
    $stmt->execute();
    $existing = $stmt->get_result()->fetch_assoc();

    if ($existing) {
        $stmt = $conn->prepare("UPDATE job_applications SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $existing['id']);
    } else {
        $stmt = $conn->prepare("INSERT INTO job_applications (student_id, job_id, status) VALUES (?,?,?)");
        $stmt->bind_param("iis", $user_id, $job_id, $status);
    }
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>UniWork | Student Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,#dbeafe,#f8fafc);}
.topbar{background:#fff;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 6px 15px rgba(0,0,0,.15);}
.logo{display:flex;align-items:center;gap:10px;}
.logo img{width:36px;}
.topbar nav a{margin-left:25px;text-decoration:none;font-weight:600;color:#000;}
.topbar nav a:hover{color:#2563eb;}
.layout{display:flex;min-height:calc(100vh - 80px);}
.sidebar{width:260px;background:linear-gradient(180deg,#415fb1,#517ddb);color:#fff;padding:30px 20px;display:flex;flex-direction:column;align-items:center;}
.sidebar img{width:95px;height:95px;border-radius:50%;border:4px solid #fff;margin-bottom:15px;}
.sidebar h3{text-align:center;margin-bottom:30px;font-size:1.2em;word-break:break-word;}
.sidebar ul{list-style:none;padding:0;width:100%;}
.sidebar ul li{margin-bottom:10px;}
.sidebar ul li a{display:flex;align-items:center;gap:12px;color:#fff;padding:12px 15px;text-decoration:none;border-radius:10px;cursor:pointer;}
.sidebar ul li a:hover{background:rgba(255,255,255,.2);}
.main{flex:1;padding:30px;display:grid;grid-template-columns:1fr;gap:25px;}
.section{display:none;background:#fff;border-radius:18px;padding:25px;box-shadow:0 10px 25px rgba(0,0,0,.15);}
.section.active{display:block;}
.section h2{margin-top:0;color:#1e40af;display:flex;align-items:center;gap:10px;font-size:1.4em;border-bottom:1px solid #e5e7eb;padding-bottom:8px;margin-bottom:15px;}
.jobs-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px;}
.jobs-grid div{background:linear-gradient(135deg,#eff6ff,#dbeafe);padding:15px;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,0.08);}
.update-form label{display:block;margin:8px 0 4px;font-weight:600;}
.update-form input[type=text], .update-form input[type=email], .update-form input[type=file]{width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;margin-bottom:10px;}
.update-form button{padding:10px 20px;border:none;border-radius:20px;background:#3b7dbf;color:#fff;cursor:pointer;}
.success{color:green;margin-bottom:10px;}
.error{color:red;margin-bottom:10px;}
.notifications-list li{padding:8px;border-bottom:1px solid #e5e7eb;transition:background 0.3s;position:relative;}
.notifications-list li.new{background:#fde68a; animation:flash 1s ease-in-out 1;}
@keyframes flash{0%{background:#fde68a;}50%{background:#fff;}100%{background:#fde68a;}}
@media screen and (max-width:768px){.layout{flex-direction:column;}.sidebar{width:100%;flex-direction:row;overflow-x:auto;justify-content:center;padding:10px;}.sidebar ul{display:flex;gap:10px;flex-wrap:nowrap;}.sidebar ul li{margin:0;}.main{padding:15px;}.jobs-grid{grid-template-columns:1fr;}}
button{padding:6px 12px;border:none;border-radius:8px;background:#3b7dbf;color:#fff;cursor:pointer;margin-top:5px;margin-right:5px;}
button:hover{background:#2563eb;}
</style>
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <div class="logo"><img src="assets/home_page/logo uni work.png"><h1>UniWork</h1></div>
    <nav><a href="index.php">Home</a><a href="service_page.php">Services</a><a href="about.php">About</a></nav>
</div>

<div class="layout">

<!-- SIDEBAR -->
<div class="sidebar">
    <img src="<?= $user['profile_image'] ?? 'assets/student1.png'; ?>">
    <h3><?= strtoupper($user['username']); ?></h3>
    <ul>
        <li><a onclick="showSection('profile')"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
        <li><a onclick="showSection('jobs')"><i class="fa-solid fa-briefcase"></i> Jobs</a></li>
        <li><a onclick="showSection('wallet')"><i class="fa-solid fa-wallet"></i> Wallet</a></li>
        <li><a onclick="showSection('notifications')"><i class="fa-solid fa-bell"></i> Notifications</a></li>
        <li><a onclick="showSection('update_profile')"><i class="fa-solid fa-user-pen"></i> Update Profile</a></li>
        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
</div>

<div class="main">

<!-- PROFILE DASHBOARD -->
<div class="section active" id="profile">
    <h2>Profile</h2>
    <p><strong>Username:</strong> <?= $user['username']; ?></p>
    <p><strong>Email:</strong> <?= $user['email']; ?></p>
    <p><strong>Student ID:</strong> <?= $user['id_no']; ?></p>
    <p><strong>Address:</strong> <?= $user['address']; ?></p>
    <p><strong>Role:</strong> <?= $user['role']; ?></p>
</div>

<!-- JOBS -->
<div class="section" id="jobs">
    <h2>Jobs</h2>
    <div class="jobs-grid">
        <?php
        $today = date('Y-m-d');
        $jobs = $conn->query("SELECT * FROM jobs WHERE deadline >= '$today' ORDER BY created_at DESC");
        while($j=$jobs->fetch_assoc()):
            $app = $conn->query("SELECT status FROM job_applications WHERE job_id={$j['id']} AND student_id=$user_id")->fetch_assoc();
            $status = $app['status'] ?? '';
            
            // Skip rejected jobs
            if($status === 'Rejected') continue;
        ?>
        <div>
            <h3><?= $j['title'] ?> - <?= $j['company'] ?></h3>
            <p><strong>Description:</strong> <?= $j['description'] ?></p>
            <p><strong>Salary:</strong> <?= $j['salary'] ?></p>
            <p><strong>Deadline:</strong> <?= $j['deadline'] ?></p>

            <?php if(!$status): ?>
            <form method="POST" style="display:inline-block;">
                <input type="hidden" name="job_id" value="<?= $j['id'] ?>">
                <input type="hidden" name="job_status" value="Applied">
                <button type="submit">Apply</button>
            </form>
            <form method="POST" style="display:inline-block;">
                <input type="hidden" name="job_id" value="<?= $j['id'] ?>">
                <input type="hidden" name="job_status" value="Rejected">
                <button type="submit">Reject</button>
            </form>
            <?php else: ?>
            <p>Status: <b><?= $status ?></b></p>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- WALLET -->
<div class="section" id="wallet">
    <h2>Wallet</h2>
    <div class="wallet-cards">
        <div class="wallet-card"><h3>Balance</h3><p>LKR 5,000</p></div>
        <div class="wallet-card"><h3>Last Payment</h3><p>LKR 1,500</p></div>
    </div>
</div>

<!-- NOTIFICATIONS -->
<div class="section" id="notifications">
    <h2>Notifications</h2>
    <ul class="notifications-list">
        <?php
        $noti = $conn->query("SELECT * FROM notifications WHERE user_id=$user_id ORDER BY created_at DESC");
        while($n=$noti->fetch_assoc()):
            $cls = $n['is_read']==0 ? 'new' : '';
        ?>
        <li class="<?= $cls ?>"><?= $n['message'] ?> <span style="float:right;font-size:0.8em;color:#555"><?= $n['created_at'] ?></span></li>
        <?php endwhile; ?>
    </ul>
</div>

<!-- UPDATE PROFILE -->
<div class="section" id="update_profile">
    <h2>Update Profile</h2>
    <?php if($success_msg) echo "<div class='success'>$success_msg</div>"; ?>
    <?php if($error_msg) echo "<div class='error'>$error_msg</div>"; ?>
    <form class="update-form" method="POST" enctype="multipart/form-data">
        <label>Profile Image</label>
        <input type="file" name="profile_image" accept="image/*">

        <label>Full Name</label>
        <input type="text" name="username" value="<?= $user['username']; ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $user['email']; ?>" required>

        <label>Student ID</label>
        <input type="text" name="id_no" value="<?= $user['id_no']; ?>" required>

        <label>Address</label>
        <input type="text" name="address" value="<?= $user['address']; ?>" required>

        <button type="submit" name="update_profile">Save Changes</button>
    </form>
</div>

</div>
</div>

<script>
function showSection(sectionId){
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
}
</script>
</body>
</html>
