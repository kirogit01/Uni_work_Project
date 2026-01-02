<?php 
// UniWork – Payment Gateway Page (Frontend Only)
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>UniWork | Payment</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', Arial, sans-serif;
}

body{
    background:#dbeaf3;
    color:#0f172a;
}

/* HEADER */
header{
    background:#ffffff;
    padding:16px 60px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
}

.logo img{
    height:38px;
}

.logo span{
    font-size:20px;
    font-weight:700;
}

header nav a{
    margin-left:22px;
    text-decoration:none;
    color:#1f2937;
    font-weight:500;
    font-size:15px;
}

/* PAGE */
.container{
    padding:40px 60px;
}

h2{
    font-size:26px;
    font-weight:700;
    margin-bottom:25px;
}

/* GRID */
.payment-grid{
    display:grid;
    grid-template-columns:1fr 1fr 1fr;
    gap:30px;
}

/* CARD */
.card{
    background:#ffffff;
    padding:28px;
    border-radius:16px;
    box-shadow:0 15px 30px rgba(0,0,0,.12);
}

.card h3{
    font-size:18px;
    font-weight:600;
    margin-bottom:18px;
}

/* SUMMARY */
.summary p{
    margin-bottom:12px;
    color:#475569;
    font-size:15px;
}

.summary strong{
    color:#0f172a;
    font-weight:600;
}

.total{
    margin-top:18px;
    padding-top:15px;
    border-top:1px solid #e5e7eb;
    font-size:18px;
    font-weight:600;
}

/* METHODS */
.methods label{
    display:flex;
    align-items:center;
    gap:16px;
    margin-bottom:18px;
    cursor:pointer;
    font-size:15px;
    font-weight:500;
}

.methods img{
    width: 60px;      /* SAME width for all */
    height: 30px;     /* SAME height for all */
    object-fit: contain;
}

/* FORM */
.form-group{
    margin-bottom:16px;
}

.form-group label{
    display:block;
    font-size:14px;
    font-weight:500;
    margin-bottom:6px;
}

.form-group input{
    width:100%;
    padding:11px;
    border-radius:8px;
    border:1px solid #cbd5e1;
}

.inline{
    display:flex;
    gap:14px;
}

.pay-btn{
    margin-top:25px;
    width:100%;
    padding:15px;
    background:#1e3a8a;
    color:#ffffff;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
}

.secure{
    text-align:center;
    margin-top:14px;
    font-size:13px;
    color:#475569;
}

/* SUCCESS POPUP */
.success-box{
    position:fixed;
    bottom:30px;
    right:30px;
    background:#ffffff;
    padding:22px;
    border-radius:16px;
    box-shadow:0 20px 40px rgba(0,0,0,.25);
    width:280px;
    display:none;
    z-index:999;
}

.success-box.active{
    display:block;
}

.success-box .icon{
    font-size:36px;
    color:#16a34a;
    text-align:center;
    margin-bottom:10px;
}

.success-box h3{
    text-align:center;
    font-size:18px;
    font-weight:700;
    margin-bottom:8px;
}

.success-box p{
    text-align:center;
    font-size:14px;
    color:#475569;
}

.success-box button{
    margin-top:14px;
    width:100%;
    padding:10px;
    border:none;
    background:#1e3a8a;
    color:#fff;
    border-radius:8px;
    font-size:14px;
    cursor:pointer;
}

/* RESPONSIVE */
@media(max-width:900px){
    .payment-grid{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<header>
    <div class="logo">
        <img src="assets/logo uni work.png" alt="UniWork Logo">
        <span>UniWork</span>
    </div>

    <nav>
        <a href="index.php">Home</a>
        <a href="#">Dashboard</a>
        <a href="#">Wallet</a>
        <a href="#">Support</a>
        <a href="#">Logout</a>
    </nav>
</header>

<div class="container">
<h2>Payment Summary</h2>

<div class="payment-grid">

<!-- SUMMARY -->
<div class="card summary">
<p><strong>Job Title</strong><br>Event Decoration Helper</p>
<p><strong>Employer</strong><br>John</p>
<p><strong>Date of Work</strong><br>11 Dec 2025</p>
<p><strong>Amount</strong><br>LKR 3500.00</p>
<p><strong>Service Fee</strong><br>LKR 105.00</p>

<div class="total">
Total Payable<br>
LRK 3605.00
</div>
</div>

<!-- METHODS (ONLY ONE SELECTABLE) -->
<div class="card methods">
<h3>Choose Payment Method</h3>

<label>
    <input type="radio" name="payment_method" checked>
    <img src="mastercard.png">
    MasterCard
</label>

<label>
    <input type="radio" name="payment_method">
    <img src="visa.png">
    Visa
</label>

<label>
    <input type="radio" name="payment_method">
    <img src="paypal.png">
    PayPal
</label>

<label>
    <input type="radio" name="payment_method">
    <img src="google_pay.png">
    Google Pay
</label>

</div>

<!-- FORM -->
<div class="card">
<h3>Enter Payment Details</h3>

<div class="form-group">
<label>Card Holder Name</label>
<input type="text" placeholder="John Doe">
</div>

<div class="form-group">
<label>Card Number</label>
<input type="text" placeholder="1234 5678 9012 3456">
</div>

<div class="inline">
<div class="form-group">
<label>Expiry Date</label>
<input type="text" placeholder="MM / YY">
</div>

<div class="form-group">
<label>CVV</label>
<input type="password" placeholder="123">
</div>
</div>

<button class="pay-btn" onclick="showSuccess()">Pay Now – LKR 3605.00</button>
<div class="secure">🔒 Secure Payment · Encrypted Transaction</div>

</div>
</div>
</div>

<!-- SUCCESS CARD -->
<div class="success-box" id="successBox">
    <div class="icon">✔</div>
    <h3>Payment Successful</h3>
    <p>Your payment was processed successfully.</p>
    <button onclick="location.href='dashboard.php'">Go to Dashboard</button>
</div>

<script>
function showSuccess(){
    document.getElementById("successBox").classList.add("active");
}
</script>

</body>
</html>
