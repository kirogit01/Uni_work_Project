<?php 
// UniWork - About Us
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>UniWork | About Us</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, Arial, sans-serif;
}

body{
    background:#5f97bf;   /* page blue */
}

/* ===== HEADER ===== */
header{
    background:#ffffff;
    padding:15px 70px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.15);
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:18px;
    font-weight:700;
}

.logo img{
    height:38px;
}

header nav a{
    margin-left:22px;
    color:#1f2937;
    font-weight:500;
    text-decoration:none;
}

/* MAIN PAGE CONTAINER (NO WHITE) */
.container{
    margin:25px;
    padding:35px;
    border-radius:30px;
}

/* DEFAULT WHITE CARD */
.box{
    background:#ffffff;
    border-radius:22px;
    padding:40px;
    margin-bottom:30px;
}

/* LIGHT BLUE CENTER CARD */
.box.light-card{
    background:#e1f0fa;
}

/* ABOUT */
.about{
    display:grid;
    grid-template-columns:1.3fr 1fr;
    gap:40px;
    align-items:center;
}

.about h1{ font-size:28px; }
.about h4{ font-size:14px; margin:6px 0 10px; }

.about p{
    font-size:13px;
    line-height:1.6;
    color:#475569;
}

.about img{ width:100%; }

/* MISSION */
.mission{
    margin-top:18px;
    background:#eef7ff;
    padding:15px 18px;
    border-left:5px solid #2563eb;
    border-radius:10px;
    font-size:13px;
}

/* ROLES */
.roles{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:40px;
    margin-top:35px;
}

.role{ text-align:center; }

.role-items{
    display:flex;
    justify-content:center;
    gap:30px;
}

.role-items img{
    height:55px;
    margin-bottom:6px;
}

/* FEATURES */
.features{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:30px;
    margin:25px 0;
}

.feature{
    text-align:center;
    font-size:12px;
}

.feature img{
    height:65px;
    margin-bottom:8px;
}

/* BENEFITS */
.benefits{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:50px;
}

.benefits ul{
    list-style:none;
    font-size:13px;
}

.benefits li{ margin-bottom:8px; }

/* TEAM + TECH */
.team-tech{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:40px;
}

.team{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-top:20px;
}

.member{
    text-align:center;
}

.member-image{
    width:120px;
    height:120px;
    border:2px solid #e5e7eb;
    border-radius:12px;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto;
}

.member-image img{
    width:80px;
}

.member-name{
    margin-top:8px;
    font-size:14px;
    font-weight:600;
}

/* TECHNOLOGY */
.tech{ text-align:center; }

.tech-icons{
    display:flex;
    justify-content:center;
    gap:18px;
}

.tech-icons img{
    height:150px;
}

/* FOOTER */
footer{
    background:#ffffff;
    padding:40px;
    text-align:center;
}

footer p{
    color:#64748b;
}

/* RESPONSIVE */
@media(max-width:900px){
    header{ padding:15px 20px; }
    .about,.roles,.benefits,.team-tech{ grid-template-columns:1fr; }
    .features{ grid-template-columns:1fr 1fr; }
    .team{ grid-template-columns:1fr 1fr; }
}
</style>
</head>

<body>

<header>
    <div class="logo">
        <img src="assets/home_page/logo uni work.png">
        <span>UniWork</span>
    </div>
    <nav>
        <a href="index.php">Home</a>
        <a href="services.php">Services</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Us</a>
    </nav>
</header>

<div class="container">

<!-- 1️⃣ WHITE CARD -->
<div class="box">
    <div class="about">
        <div>
            <h1>About UniWork</h1>
            <h4>Connecting Students with Real Opportunities</h4>
            <p>
                UniWork connects university students with qualified tutors through
a simple and trusted platform.Our goal is to make leaming easier
by providing quick access to academic support whenever needed.
experience, making the process seamless, efficient, and reliable.
Students and tutors sign in with their university email for a secure.
            </p>

            <div class="mission">
                <strong>Our Mission:</strong> Empowering the next generation through valuable work experiences.
            </div>
        </div>
        <img src="assets/about_page/img01.png">
    </div>

    <div class="roles">
        <div class="role">
            <h4>For Students</h4><br>
            <div class="role-items">
                <div><img src="assets/about_page/signup.png"><p>Sign Up</p></div>
                <div><img src="assets/about_page/profile.png"><p>Build Profile</p></div>
                <div><img src="assets/about_page/apply.png"><p>Apply for Jobs</p></div>
            </div>
        </div>

        <div class="role">
            <h4>For Employers</h4><br>
            <div class="role-items">
                <div><img src="assets/about_page/register.png"><p>Register</p></div>
                <div><img src="assets/about_page/post.png"><p>Post Jobs</p></div>
                <div><img src="assets/about_page/hire.png"><p>Hire Students</p></div>
            </div>
        </div>
    </div>
</div>

<!-- 2️⃣ LIGHT BLUE CARD -->
<div class="box light-card">
    <h4>Key Features</h4>

    <div class="features">
        <div class="feature"><img src="assets/about_page/dashboard.png"><p>Student Dashboard</p></div>
        <div class="feature"><img src="assets/about_page/profile01.png"><p>Profile Management</p></div>
        <div class="feature"><img src="assets/about_page/jobs.png"><p>Job Listings</p></div>
        <div class="feature"><img src="assets/about_page/secure.png"><p>Secure Login</p></div>
    </div>

    <div class="benefits">
        <div>
            <h4>Benefits for Students</h4><br>
            <ul>
                <li>✓ Gain experience</li>
                <li>✓ Build portfolio</li>
                <li>✓ Earn money</li>
                <li>✓ Verified opportunities</li>
            </ul>
        </div>

        <div>
            <h4>Benefits for Employers</h4><br>
            <ul>
                <li>✓ Easy hiring</li>
                <li>✓ Skilled students</li>
                <li>✓ Simple platform</li>
            </ul>
        </div>
    </div>
</div>

<!-- 3️⃣ WHITE CARD -->
<div class="box team-tech">
    <div>
        <h4>Team Members</h4>
        <div class="team">
        <?php
        $teamMembers = [
            "Member One","Member Two","Member Three",
            "Member Four","Member Five","Member Six",
            "Member Seven","Member Eight","Member Nine"
        ];
        foreach($teamMembers as $name):
        ?>
            <div class="member">
                <div class="member-image">
                    <img src="assets/team/icon.png">
                </div>
                <p class="member-name"><?php echo $name; ?></p>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

    <div class="tech">
        <h4>Technology Used</h4><br>
        <div class="tech-icons">
            <img src="assets/about_page/technology.webp">
        </div>
    </div>
</div>

</div>

<footer>
    <p>© UniWork 2025. All rights reserved.</p>
</footer>

</body>
</html>
