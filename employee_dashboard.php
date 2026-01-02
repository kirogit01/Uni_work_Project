<?php
session_start();
require 'db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Employee'){
    header("Location: login.php");
    exit();
}

$employee_id = $_SESSION['user_id'];

/* Fetch employee data */
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$profile_img = $user['profile_image'] ?? 'assets/employee profile.png';
$username    = $user['username'];
$email       = $user['email'];
$designation = $user['designation'] ?? '';
$phone       = $user['phone'] ?? '';
$company     = $user['company'] ?? '';
$industry    = $user['industry'] ?? '';
$address     = $user['address'] ?? '';
$website     = $user['website'] ?? '';

/* Handle profile update */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $designation = $_POST['designation'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];
    $industry = $_POST['industry'];
    $address = $_POST['address'];
    $website = $_POST['website'];

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename(time() . '_' . $_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
        $profile_img = $target_file;
    }

    $stmt = $conn->prepare("UPDATE users SET username=?, email=?, designation=?, phone=?, company=?, industry=?, address=?, website=?, profile_image=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $username,$email,$designation,$phone,$company,$industry,$address,$website,$profile_img,$employee_id);
    $stmt->execute();

    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
}

/* Handle Add Job */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_job'])){
    $title = $_POST['title'];
    $company_name = $_POST['company'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];
    $deadline = $_POST['deadline'];

    $stmt = $conn->prepare("INSERT INTO jobs (employee_id,title,company,description,salary,deadline,created_at) VALUES (?,?,?,?,?,?,NOW())");
    $stmt->bind_param("isssss",$employee_id,$title,$company_name,$description,$salary,$deadline);
    $stmt->execute();

    // Notifications for all students
    $students = $conn->query("SELECT id FROM users WHERE role='Student'");
    while($s=$students->fetch_assoc()){
        $msg = "New job posted: $title - $company_name";
        $role='Student';
        $stmt2 = $conn->prepare("INSERT INTO notifications (user_id,role,message,created_at,is_read) VALUES (?,?,?,NOW(),0)");
        $stmt2->bind_param("iss",$s['id'],$role,$msg);
        $stmt2->execute();
    }
}

/* Handle Payment to Students */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pay_student'])){
    $app_id = $_POST['application_id'];
    $amount = $_POST['amount'];

    // Mark application as paid
    $stmt = $conn->prepare("UPDATE job_applications SET paid=1, amount=? WHERE id=?");
    $stmt->bind_param("di", $amount, $app_id);
    $stmt->execute();

    // Add money to student's wallet
    $stmt2 = $conn->prepare("UPDATE users u JOIN job_applications ja ON u.id=ja.student_id SET u.wallet = u.wallet + ? WHERE ja.id=?");
    $stmt2->bind_param("di", $amount, $app_id);
    $stmt2->execute();

    // Send notification
    $stmt3 = $conn->prepare("INSERT INTO notifications (user_id, role, message, created_at, is_read) VALUES ((SELECT student_id FROM job_applications WHERE id=?),'Student', ?, NOW(),0)");
    $msg = "You have received LKR $amount for your job.";
    $stmt3->bind_param("is", $app_id, $msg);
    $stmt3->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UniWork - Employee Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f0f2f5;}
.topbar{background:#fff;padding:12px 25px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 4px 10px rgba(0,0,0,.1);}
.logo{display:flex;align-items:center;gap:10px;}
.logo img{width:35px;}
.topbar nav a{margin-left:20px;text-decoration:none;color:#000;font-weight:600;}
.topbar nav a:hover{color:#2563eb;}
.layout{display:flex;min-height:calc(100vh - 60px);}
.sidebar{width:230px;background:linear-gradient(180deg,#415fb1,#517ddb);color:#fff;padding:25px 15px;display:flex;flex-direction:column;align-items:center;}
.sidebar img{width:90px;height:90px;border-radius:50%;border:3px solid #fff;margin-bottom:15px;}
.sidebar h3{margin-bottom:25px;text-align:center;word-break:break-word;}
.sidebar ul{list-style:none;padding:0;width:100%;}
.sidebar ul li{margin-bottom:10px;}
.sidebar ul li a{display:flex;align-items:center;gap:10px;padding:10px 15px;color:#fff;text-decoration:none;border-radius:8px;cursor:pointer;}
.sidebar ul li a:hover{background:rgba(255,255,255,.2);}
.main{flex:1;padding:25px;}
.section{display:none;background:#fff;border-radius:12px;padding:20px;box-shadow:0 5px 15px rgba(0,0,0,.1);margin-bottom:20px;}
.section.active{display:block;}
.section h2{margin-top:0;border-bottom:1px solid #e5e7eb;padding-bottom:8px;margin-bottom:15px;display:flex;align-items:center;gap:10px;color:#1e40af;}
.personal-grid{display:grid;grid-template-columns:150px 1fr 1fr;gap:15px;align-items:center;}
.avatar{text-align:center;}
.avatar img{width:120px;height:120px;border-radius:50%;}
.form-group{margin-bottom:12px;}
label{font-size:13px;color:#555;}
input, textarea{width:100%;padding:8px;border-radius:6px;border:1px solid #ccc;}
textarea{resize:none;height:80px;}
.edit-btn{background:#3b7dbf;color:#fff;border:none;padding:6px 18px;border-radius:15px;cursor:pointer;}
.jobs-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.jobs-grid div{background:linear-gradient(135deg,#eff6ff,#dbeafe);padding:12px;border-radius:10px;box-shadow:0 3px 8px rgba(0,0,0,.08);}
.notifications-list li{padding:8px; border-bottom:1px solid #e5e7eb; position:relative; transition: background 0.3s;}
.notifications-list li.new{background:#fde68a; animation:flash 1s ease-in-out 1;}
.payment-form input{width:80px;margin-right:5px;}
.payment-form button{padding:4px 10px;border:none;border-radius:6px;background:#3b7dbf;color:#fff;cursor:pointer;}
.payment-form button:hover{background:#2563eb;}
@keyframes flash{0%{background:#fde68a;}50%{background:#fff;}100%{background:#fde68a;}}
</style>
</head>
<body>

<div class="topbar">
    <div class="logo"><img src="assets/uniwork logo.png"><span>UniWork</span></div>
</div>

<div class="layout">

<div class="sidebar">
    <img src="<?= $profile_img; ?>">
    <h3><?= strtoupper($username); ?></h3>
    <ul>
        <li><a onclick="showSection('dashboard')"><i class="fa-solid fa-gauge-high"></i> Dashboard</a></li>
        <li><a onclick="showSection('newjobs')"><i class="fa-solid fa-briefcase"></i> New Hired Jobs</a></li>
        <li><a onclick="showSection('pastjobs')"><i class="fa-solid fa-briefcase"></i> Past Jobs</a></li>
        <li><a onclick="showSection('addjob')"><i class="fa-solid fa-plus"></i> Add New Job</a></li>
        <li><a onclick="showSection('applications')"><i class="fa-solid fa-users"></i> Student Applications</a></li>
        <li><a onclick="showSection('payments')"><i class="fa-solid fa-money-bill-wave"></i> Payments</a></li>
        <li><a onclick="showSection('profile')"><i class="fa-solid fa-user"></i> Profile</a></li>
        <li><a onclick="showSection('notifications')"><i class="fa-solid fa-bell"></i> Notifications</a></li>
        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
</div>

<div class="main">

<!-- DASHBOARD -->
<div class="section active" id="dashboard">
    <h2>Employee Details</h2>
    <div class="personal-grid">
        <div class="avatar"><img src="<?= $profile_img; ?>"></div>
        <div class="form-group"><label>Full Name</label><input value="<?= $username; ?>" disabled></div>
        <div class="form-group"><label>Email</label><input value="<?= $email; ?>" disabled></div>
        <div class="form-group"><label>Designation</label><input value="<?= $designation; ?>" disabled></div>
        <div class="form-group"><label>Phone</label><input value="<?= $phone; ?>" disabled></div>
        <div class="form-group"><label>Company</label><input value="<?= $company; ?>" disabled></div>
        <div class="form-group"><label>Industry</label><input value="<?= $industry; ?>" disabled></div>
        <div class="form-group"><label>Address</label><input value="<?= $address; ?>" disabled></div>
        <div class="form-group"><label>Website</label><input value="<?= $website; ?>" disabled></div>
    </div>
</div>

<!-- PROFILE -->
<div class="section" id="profile">
    <h2>Edit Profile</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="personal-grid">
            <div class="avatar">
                <img src="<?= $profile_img; ?>">
                <input type="file" name="profile_image" accept="image/*">
            </div>
            <div class="form-group"><label>Full Name</label><input type="text" name="username" value="<?= $username; ?>"></div>
            <div class="form-group"><label>Designation</label><input type="text" name="designation" value="<?= $designation; ?>"></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" value="<?= $email; ?>"></div>
            <div class="form-group"><label>Phone</label><input type="text" name="phone" value="<?= $phone; ?>"></div>
            <div class="form-group"><label>Company</label><input type="text" name="company" value="<?= $company; ?>"></div>
            <div class="form-group"><label>Industry</label><input type="text" name="industry" value="<?= $industry; ?>"></div>
            <div class="form-group"><label>Address</label><input type="text" name="address" value="<?= $address; ?>"></div>
            <div class="form-group"><label>Website</label><input type="text" name="website" value="<?= $website; ?>"></div>
        </div>
        <button type="submit" name="update_profile" class="edit-btn">Save Changes</button>
    </form>
</div>

<!-- ADD JOB -->
<div class="section" id="addjob">
    <h2>Add New Job</h2>
    <form method="POST">
        <label>Job Title</label>
        <input type="text" name="title" required>
        <label>Company</label>
        <input type="text" name="company" required>
        <label>Description</label>
        <textarea name="description" required></textarea>
        <label>Salary</label>
        <input type="text" name="salary" required>
        <label>Deadline</label>
        <input type="date" name="deadline" required>
        <button type="submit" name="add_job">Add Job</button>
    </form>
</div>

<!-- NEW HIRED JOBS -->
<div class="section" id="newjobs">
    <h2>New Hired Jobs</h2>
    <?php
    $jobs = $conn->query("
        SELECT j.* 
        FROM jobs j
        LEFT JOIN job_applications ja ON j.id=ja.job_id AND ja.status='Accepted'
        WHERE j.employee_id=$employee_id
        GROUP BY j.id
        HAVING COUNT(ja.id)=0
        ORDER BY j.created_at DESC
    ");
    if($jobs->num_rows==0) echo "<p>No new jobs available.</p>";
    else while($j=$jobs->fetch_assoc()):
    ?>
    <div class="jobs-grid">
        <div>
            <b>Title:</b> <?= $j['title']; ?><br>
            <b>Company:</b> <?= $j['company']; ?><br>
            <b>Description:</b> <?= $j['description']; ?><br>
            <b>Salary:</b> <?= $j['salary']; ?><br>
            <b>Deadline:</b> <?= $j['deadline']; ?><br>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<!-- PAST JOBS -->
<div class="section" id="pastjobs">
    <h2>Past Jobs (Accepted Students)</h2>
    <?php
    $jobs = $conn->query("
        SELECT DISTINCT j.*
        FROM jobs j
        JOIN job_applications ja ON j.id=ja.job_id
        WHERE j.employee_id=$employee_id AND ja.status='Accepted'
        ORDER BY j.created_at DESC
    ");
    while($j=$jobs->fetch_assoc()):
        $apps = $conn->query("
            SELECT ja.*, u.username, u.email, u.id_no
            FROM job_applications ja
            JOIN users u ON ja.student_id=u.id
            WHERE ja.job_id={$j['id']} AND ja.status='Accepted'
        ");
        while($a=$apps->fetch_assoc()):
            $paid_status = $a['paid'] ? "Paid (LKR {$a['amount']})" : "Pending Payment";
    ?>
    <div style="border:1px solid #ccc;padding:8px;margin-bottom:6px;border-radius:8px;">
        <b>Job:</b> <?= $j['title']; ?> (<?= $j['company']; ?>)<br>
        <b>Student:</b> <?= $a['username']; ?> (<?= $a['id_no']; ?>)<br>
        <b>Email:</b> <?= $a['email']; ?><br>
        <b>Payment Status:</b> <?= $paid_status; ?><br>
        <?php if(!$a['paid']): ?>
        <form method="POST" class="payment-form">
            <input type="hidden" name="application_id" value="<?= $a['id']; ?>">
            <input type="number" name="amount" placeholder="Amount" required>
            <button type="submit" name="pay_student">Pay</button>
        </form>
        <?php endif; ?>
    </div>
    <?php endwhile; endwhile; ?>
</div>

<!-- STUDENT APPLICATIONS -->
<div class="section" id="applications">
    <h2>All Student Applications</h2>
    <?php
    $jobs = $conn->query("SELECT * FROM jobs WHERE employee_id=$employee_id ORDER BY created_at DESC");
    while($j=$jobs->fetch_assoc()):
        $apps = $conn->query("
            SELECT ja.*, u.username, u.email, u.id_no
            FROM job_applications ja
            JOIN users u ON ja.student_id=u.id
            WHERE ja.job_id={$j['id']}
        ");
        if($apps->num_rows>0){
            echo "<h3>{$j['title']} ({$j['company']})</h3>";
            while($a=$apps->fetch_assoc()):
    ?>
    <div style="border:1px solid #ccc;padding:6px;margin-bottom:5px;border-radius:6px;">
        <b>Student:</b> <?= $a['username']; ?> (<?= $a['id_no']; ?>)<br>
        <b>Email:</b> <?= $a['email']; ?><br>
        <b>Status:</b> <?= $a['status']; ?>
    </div>
    <?php endwhile; } endwhile; ?>
</div>

<!-- PAYMENTS -->
<!-- PAYMENTS -->
<!-- PAYMENTS -->
<div class="section" id="payments">
    <h2>Payments to Students</h2>
    <?php
    $stmt = $conn->prepare(
        "SELECT job_applications.id, job_applications.amount, users.username, users.id_no, jobs.title, jobs.company
        FROM job_applications
        INNER JOIN users ON job_applications.student_id = users.id
        INNER JOIN jobs ON job_applications.job_id = jobs.id
        WHERE job_applications.paid = 0 AND jobs.employee_id = ?
        ORDER BY job_applications.id DESC"
    );

    if($stmt){
        $stmt->bind_param("i", $employee_id);
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result && $result->num_rows > 0){
                while($row = $result->fetch_assoc()):
    ?>
    <div style="border:1px solid #ccc;padding:8px;margin-bottom:6px;border-radius:8px;">
        <b>Student:</b> <?= htmlspecialchars($row['username']); ?> (<?= htmlspecialchars($row['id_no']); ?>)<br>
        <b>Job:</b> <?= htmlspecialchars($row['title']); ?> (<?= htmlspecialchars($row['company']); ?>)<br>
        <form method="POST" class="payment-form">
            <input type="hidden" name="application_id" value="<?= $row['id']; ?>">
            <input type="number" name="amount" placeholder="Amount" required>
            <button type="submit" name="pay_student">Pay</button>
        </form>
    </div>
    <?php
                endwhile;
            } else {
                echo "<p>No pending payments.</p>";
            }
        } else {
            echo "<p>Execution failed: ".$stmt->error."</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Preparation failed: ".$conn->error."</p>";
    }
    ?>
</div>



<!-- NOTIFICATIONS -->
<div class="section" id="notifications">
    <h2>Notifications</h2>
    <ul class="notifications-list">
        <?php
        $noti = $conn->query("SELECT * FROM notifications WHERE user_id=$employee_id ORDER BY created_at DESC");
        while($n=$noti->fetch_assoc()):
            $cls = $n['is_read']==0 ? 'new' : '';
        ?>
        <li class="<?= $cls ?>"><?= $n['message']; ?> <span style="float:right;font-size:0.8em;color:#555"><?= $n['created_at']; ?></span></li>
        <?php endwhile; ?>
    </ul>
</div>

<script>
function showSection(id){
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(id).classList.add('active');
}
</script>

</div>
</div>
</body>
</html>
