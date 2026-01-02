<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UniWork Help Center</title>
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
  .topbar nav a:hover { color:#369be4;}

  /* Layout */
  .layout { flex:1; display:flex; }

  /* Sidebar */
  .sidebar {
    width:260px;
    background:linear-gradient(180deg,#415fb1,#517ddb);
    color:#fff;
    padding:30px 20px;
    text-align:center;
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
    cursor:pointer;
    transition:0.3s;
  }
  .sidebar ul li a:hover { background:rgba(255,255,255,0.2); }

  .help-img {
    width: 100px;
    height: 100px;
    display: block;
    margin: 0 auto 15px;
    border-radius: 50%;
    box-shadow: 0 4px 10px rgba(0,0,0,0.25);
  }

  /* Main content */
  .main {
    flex:1;
    padding:30px;
    display:flex;
    flex-direction:column;
    gap:25px;
  }

  /* Sections */
  .section {
    background:rgba(255,255,255,0.9);
    border-radius:18px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
    display:none; /* hidden by default */
  }
  .section.active { display:block; }
  .section h2 {
    margin-top:0;
    color:#1e40af;
    display:flex;
    align-items:center;
    gap:10px;
    border-bottom:1px solid #e5e7eb;
    padding-bottom:8px;
    margin-bottom:15px;
  }

  /* FAQ */
  .faq-item { border-bottom:1px solid #e5e7eb; }
  .faq-question { cursor:pointer; padding:10px; font-weight:600; }
  .faq-answer { display:none; padding:10px; color:#374151; }

  /* Contact form */
  .form input, .form textarea {
    width:100%;
    padding:10px;
    margin:8px 0;
    border-radius:8px;
    border:1px solid #ccc;
  }
  .form button {
    padding:10px 15px;
    border:none;
    border-radius:8px;
    background:#2563eb;
    color:#fff;
    font-weight:600;
    cursor:pointer;
  }

</style>
</head>
<body>

<div class="topbar">
  <div class="logo"><img src="assets/uniwork_icon.png" alt="UniWork"><h1>UniWork</h1></div>
  <nav><a href="#">Home</a><a href="#">Dashboard</a></nav>
</div>

<div class="layout">
  <div class="sidebar">
    <!-- Help Icon -->
    <img src="assets/helping_image.png" alt="Help Icon" class="help-img">
    <h3>Help Center</h3>
    <ul>
      <li><a onclick="showSection('faqs')"><i class="fa-solid fa-circle-question"></i> FAQs</a></li>
      <li><a onclick="showSection('gettingStarted')"><i class="fa-solid fa-book"></i> Getting Started</a></li>
      <li><a onclick="showSection('contactSupport')"><i class="fa-solid fa-envelope"></i> Contact Support</a></li>
    </ul>
  </div>

  <div class="main">
    <!-- FAQs Section -->
    <div class="section active" id="faqs">
      <h2><i class="fa-solid fa-circle-question"></i> FAQs</h2>
      <div class="faq-item">
        <div class="faq-question">How do I reset my password?</div>
        <div class="faq-answer">Click “Forgot password” on login, enter your email, and follow the reset link.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question">Which currency does the wallet use?</div>
        <div class="faq-answer">All balances and transactions are displayed in LKR.</div>
      </div>
    </div>

    <!-- Getting Started Section -->
    <div class="section" id="gettingStarted">
      <h2><i class="fa-solid fa-book"></i> Getting Started</h2>
      <ul>
        <li>Create your account with university email</li>
        <li>Complete your profile (contact, skills, photo)</li>
        <li>Explore dashboard (calendar, jobs, wallet)</li>
      </ul>
    </div>

    <!-- Contact Support Section -->
    <div class="section" id="contactSupport">
      <h2><i class="fa-solid fa-envelope"></i> Contact Support</h2>
      <form class="form">
        <input type="email" placeholder="Your email">
        <textarea placeholder="Describe your issue"></textarea>
        <button type="submit">Send</button>
      </form>
    </div>
  </div>
</div>

<script>
  // Show only one section at a time
  function showSection(sectionId){
    document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
  }

  // FAQ toggle
  document.querySelectorAll('.faq-question').forEach(q => {
    q.addEventListener('click', () => {
      const answer = q.nextElementSibling;
      answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
    });
  });
</script>

</body>
</html>
