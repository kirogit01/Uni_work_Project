<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UniWork Services</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  body {
    margin: 0;
    font-family: "Segoe UI", Calibri, Arial, sans-serif;
    background: linear-gradient(135deg, #dbeafe, #f8fafc);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  /* Topbar */
  .topbar {
    background:#fff;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 6px 15px rgba(0,0,0,0.15);
    position:sticky;
    top:0;
    z-index:50;
  }
  .logo { display:flex; align-items:center; gap:10px;}
  .logo img { width:36px; height:36px;}
  .logo h1 { margin:0; font-size:1.6em; color:#000;}
  .topbar nav a {
    margin-left:25px;
    font-weight:600;
    text-decoration:none;
    color:#000;
    transition:0.3s;
  }
  .topbar nav a:hover { color:#2563eb; }

  /* Layout */
  .layout { flex:1; display:flex; }

  /* Sidebar */
  .sidebar {
    width:260px;
    background:linear-gradient(180deg,#415fb1,#517ddb);
    color:#fff;
    padding:30px 20px;
    text-align:center;
    box-shadow:4px 0 15px rgba(0,0,0,0.2);
  }
  .sidebar h3 { margin:20px 0; }
  .sidebar ul { list-style:none; padding:0; text-align:left; }
  .sidebar ul li a {
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 15px;
    border-radius:10px;
    color:#fff;
    text-decoration:none;
    transition:0.3s;
  }
  .sidebar ul li a:hover {
    background:rgba(255,255,255,0.2);
    transform:translateX(6px);
  }

  /* Main */
  .main {
    flex:1;
    padding:40px;
  }

  /* Hero */
  .hero {
    text-align:center;
    margin-bottom:40px;
  }
  .hero h2 {
    font-size:2em;
    color:#1e40af;
    margin-bottom:10px;
  }
  .hero p {
    color:#374151;
    font-size:1.1em;
  }

  /* Service Cards */
  .services-grid {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
  }
  .service-card {
    background:linear-gradient(135deg,#ffffff,#f0f4ff);
    border-radius:18px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
    text-align:center;
    transition:0.3s;
    position:relative;
    overflow:hidden;
  }
  .service-card:hover {
    transform:translateY(-8px);
    box-shadow:0 12px 30px rgba(0,0,0,0.2);
  }
  .service-card i {
    font-size:2.5em;
    color:#2563eb;
    margin-bottom:12px;
    transition:0.3s;
  }
  .service-card:hover i { color:#1e40af; transform:scale(1.1); }
  .service-card h3 {
    margin:0 0 10px;
    color:#1e40af;
    font-size:1.3em;
  }
  .service-card p {
    color:#374151;
    font-size:0.95em;
  }

  /* Decorative gradient overlay */
  .service-card::before {
    content:"";
    position:absolute;
    top:-50%;
    left:-50%;
    width:200%;
    height:200%;
    background:radial-gradient(circle at center, rgba(124,92,255,0.15), transparent 70%);
    transform:rotate(25deg);
    opacity:0;
    transition:opacity 0.4s;
  }
  .service-card:hover::before { opacity:1; }
</style>
</head>
<body>

<div class="topbar">
  <div class="logo"><img src="assets/uniwork_icon.png" alt="UniWork"><h1>UniWork</h1></div>
  <nav>
    <a href="#">Home</a>
    <a href="student_dashboard.php">Dashboard</a>
    <a href="service_page.php">Services</a>
    <a href="help.php">Help</a>
    <a href="#">Wallet</a>
  </nav>
</div>

<div class="layout">
  <div class="sidebar">
    <h3>Services</h3>
    <ul>
      <li><a href="#"><i class="fa-solid fa-briefcase"></i> Jobs</a></li>
      <li><a href="#"><i class="fa-solid fa-calendar-days"></i> Calendar</a></li>
      <li><a href="#"><i class="fa-solid fa-wallet"></i> Wallet</a></li>
      <li><a href="#"><i class="fa-solid fa-user"></i> Profile</a></li>
      <li><a href="#"><i class="fa-solid fa-headset"></i> Support</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="hero">
      <h2>Our Services</h2>
      <p>Discover everything UniWork offers to support your student journey.</p>
    </div>

    <div class="services-grid">
      <div class="service-card">
        <i class="fa-solid fa-briefcase"></i>
        <h3>Job Opportunities</h3>
        <p>Browse and apply for part-time and full-time jobs posted by trusted companies.</p>
      </div>

      <div class="service-card">
        <i class="fa-solid fa-calendar-days"></i>
        <h3>Smart Calendar</h3>
        <p>Organize classes, deadlines, and interviews with event dots and reminders.</p>
      </div>

      <div class="service-card">
        <i class="fa-solid fa-wallet"></i>
        <h3>Wallet</h3>
        <p>Track your earnings and transactions in LKR with secure payment history.</p>
      </div>

      <div class="service-card">
        <i class="fa-solid fa-user"></i>
        <h3>Profile Management</h3>
        <p>Complete your profile to 100% and unlock personalized job recommendations.</p>
      </div>

      <div class="service-card">
        <i class="fa-solid fa-headset"></i>
        <h3>Support</h3>
        <p>Get help anytime with FAQs, guides, and direct contact to UniWork support.</p>
      </div>
    </div>
  </div>
</div>

</body>
</html>
