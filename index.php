<?php
// UniWork – Public Home Page
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>UniWork | Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', Arial, sans-serif;
}
body{
    background: linear-gradient(to bottom, #7ca1c8ff, #c1d3e4ff);
    color:#0f172a;
}
a{text-decoration:none}

/* HEADER */
header{
    background:#ffffff;
    padding:15px 70px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,.3);
}
.logo{
    display:flex;
    align-items:center;
    gap:10px;
}
.logo img{
    height:38px;
}
header nav a{
    margin-left:22px;
    color:#1f2937;
    font-weight:500;
}
.btn{
    padding:10px 18px;
    border-radius:8px;
    font-weight:600;
}
.btn-primary{
    background:#2563eb;
    color:#fff;
}

/* HERO */
.hero{
    position:relative;
    min-height:520px;
    background:url("hero-bg.jpg") center/cover no-repeat;
    display:flex;
    align-items:center;
    padding:0 90px;
}
.hero::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(to bottom,#30669fff,#769abde5);
}
.hero-inner{
    position:relative;
    display:flex;
    align-items:center;
    justify-content:space-between;
    width:100%;
    gap:40px;
}
.hero-content{
    max-width:520px;
    color:#fff;
}
.hero-content h1{
    font-size:44px;
    margin-bottom:16px;
}
.hero-content p{
    font-size:18px;
    line-height:1.6;
    margin-bottom:28px;
    color:#e5e7eb;
}
.hero-buttons a{
    margin-right:14px;
}
.hero-image img{
    width:700px;
    max-width:100%;
    animation:float 4s ease-in-out infinite;
}
@keyframes float{
    0%{transform:translateY(0)}
    50%{transform:translateY(-12px)}
    100%{transform:translateY(0)}
}

/* SECTIONS */
section{
    padding:70px 90px;
}
section h2{
    text-align:center;
    font-size:32px;
    margin-bottom:40px;
}
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:28px;
}
.card{
    background:#fff;
    padding:32px;
    border-radius:16px;
    box-shadow:0 15px 30px rgba(0,0,0,.12);
    transition:.3s;
}
.card:hover{
    transform:translateY(-8px);
}
.card h4{
    margin-bottom:10px;
    color:#2563eb;
}
.card p{
    color:#475569;
}
.feature{
    background:linear-gradient(135deg,#e0f2fe,#f8fafc);
    border-left:5px solid #0e3790ff;
}

/* FOOTER */
footer{
    background:#fff;
    padding:40px;
    text-align:center;
    box-shadow:0 -2px 10px rgba(0,0,0,.08);
}
footer .links{
    display:flex;
    justify-content:center;
    gap:26px;
    margin-bottom:14px;
}
footer p{
    font-size:14px;
    color:#64748b;
}

/* RESPONSIVE */
@media(max-width:900px){
    header{padding:16px 24px}
    .hero{padding:60px 24px}
    .hero-inner{flex-direction:column;text-align:center}
    section{padding:60px 24px}
}
</style>
</head>

<body>

<!-- HEADER -->
<header>
    <div class="logo">
        <img src="assets/home_page/logo uni work.png" alt="UniWork Logo">
        <b>UniWork</b>
    </div>

    <nav>
        <a href="about.php">About</a>
        <a href="help.php">Help</a>

        <?php if(isset($_SESSION['user_id'])): ?>

            <?php if($_SESSION['role'] == 'Student'): ?>
                <a href="student_dashboard.php" class="btn btn-primary">Dashboard</a>
            <?php else: ?>
                <a href="employee_dashboard.php" class="btn btn-primary">Dashboard</a>
            <?php endif; ?>

            <a href="logout.php">Logout</a>

        <?php else: ?>

            <a href="login.php">Login</a>
            <a href="signup.php" class="btn btn-primary">Sign Up</a>

        <?php endif; ?>
    </nav>
</header>

<!-- HERO -->
<div class="hero">
    <div class="hero-inner">

        <div class="hero-content">
            <h1>Empowering Students,<br>Supporting Employers.</h1>
            <p>
                A smart platform that connects university students with
                flexible part-time jobs while helping employers find
                skilled and verified talent.
            </p>

            <div class="hero-buttons">
                <a href="signup.php" class="btn btn-primary">I'm a Student</a>
                <a href="signup.php" class="btn btn-primary" style="background:#0ea5e9">
                    I'm an Employer
                </a>
            </div>
        </div>

        <div class="hero-image">
            <img src="assets/home_page/homepage_image.jpg" alt="UniWork Illustration">
        </div>

    </div>
</div>

<!-- HOW IT WORKS -->
<section>
    <h2>How It Works</h2>
    <div class="grid">
        <div class="card">
            <h4>Create Profile</h4>
            <p>Showcase your skills, experience, and availability.</p>
        </div>
        <div class="card">
            <h4>Get Matched</h4>
            <p>Smart matching connects you with the right jobs.</p>
        </div>
        <div class="card">
            <h4>Get Paid</h4>
            <p>Secure payments through UniWork Student Wallet.</p>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section>
    <h2>Key Features</h2>
    <div class="grid">
        <div class="card feature">
            <h4>AI Job Matching</h4>
            <p>Opportunities based on skills and availability.</p>
        </div>
        <div class="card feature">
            <h4>Verified Users</h4>
            <p>Trusted students and employers on one platform.</p>
        </div>
        <div class="card feature">
            <h4>Wallet System</h4>
            <p>Secure in-app payments with full transparency.</p>
        </div>
    </div>
</section>

<!-- BENEFITS -->
<section>
    <h2>Benefits</h2>
    <div class="grid">
        <div class="card">
            <h4>For Students</h4>
            <p>Earn income, gain experience, and build your CV.</p>
        </div>
        <div class="card">
            <h4>For Employers</h4>
            <p>Hire skilled and motivated students easily.</p>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="links">
        <span>About</span>
        <span>Contact</span>
        <span>Help</span>
        <span>Privacy Policy</span>
    </div>
    <p>© UniWork 2025. All rights reserved.</p>
</footer>

</body>
</html>
