<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>UniWork - Sign Up</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
    margin:0;
    padding:0;
}
body, html{
    height:100%;
}

/* ===== TOP BAR ===== */
.top-bar{
    background:#fff;
    padding:15px 30px;
    display:flex;
    align-items:center;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}
.top-bar img{
    width:38px;
    margin-right:10px;
}
.top-bar span{
    font-size:26px;
    font-weight:600;
    color:#000;
}
.blue-strip{
    height:40px;
    background:#5fa2cf;
}

/* ===== SPLIT SCREEN ===== */
.main{
    display:flex;
    height:calc(100vh - 95px);
    min-height:600px; /* ensures height on small screens */
}

/* LEFT SIDE - IMAGE */
.left{
    flex:1;
    background: url("assets/signupbackground.png") center/cover no-repeat;
}

/* RIGHT SIDE - SIGNUP CARD */
.right{
    flex:1;
    background:#bfe3ff;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px 20px;
}

/* SIGNUP CARD */
.signup-card{
    width:100%;
    max-width:400px; /* prevents card from stretching too much */
    padding:40px 30px;
    background:#ffffff;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
    text-align:center;
}

/* CARD TITLE */
.signup-card h2{
    margin-bottom:30px;
    font-size:28px;
    text-decoration:underline;
}

/* INPUT GROUP */
.input-group{
    background:#fff;
    border-radius:30px;
    padding:12px 15px;
    display:flex;
    align-items:center;
    margin-bottom:20px;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
}
.input-group img{
    width:22px;
    margin-right:12px;
}
.input-group input,
.input-group select{
    border:none;
    outline:none;
    width:100%;
    font-size:15px;
    background:transparent;
}

/* BUTTON */
button{
    background:#184f73;
    color:#fff;
    border:none;
    padding:12px 30px;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}
button:hover{
    background:#0f3a58;
}

/* LOGIN TEXT */
.login-text{
    margin-top:20px;
    color:#184f73;
}
.login-text a{
    color:#184f73;
    text-decoration:none;
    font-weight:600;
}
.login-text a:hover{
    text-decoration:underline;
}

/* RESPONSIVE */
@media(max-width:900px){
    .main{
        flex-direction:column;
        height:auto;
    }
    .left{
        height:250px;
        width:100%;
    }
    .right{
        width:100%;
        padding:30px 15px;
    }
    .signup-card{
        margin-top:-60px;
        width:95%;
        padding:30px;
    }
}
</style>
</head>

<body>

<!-- TOP BAR -->
<div class="top-bar">
    <img src="assets/uniwork logo.png" alt="UniWork Logo">
    <span>UniWork</span>
</div>
<div class="blue-strip"></div>

<!-- MAIN SPLIT -->
<div class="main">

    <!-- LEFT SIDE -->
    <div class="left"></div>

    <!-- RIGHT SIDE -->
    <div class="right">
        <div class="signup-card">

            <h2>Create Account</h2>

            <!-- SIGNUP FORM -->
            <form method="POST" action="signup_process.php">

                <div class="input-group">
                    <img src="https://img.icons8.com/ios-filled/50/user.png" alt="Username">
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <div class="input-group">
                    <img src="https://img.icons8.com/ios-filled/50/new-post.png" alt="Email">
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <img src="https://img.icons8.com/ios-filled/50/lock-2.png" alt="Password">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="input-group">
                    <img src="https://img.icons8.com/ios-filled/50/user-shield.png" alt="Role">
                    <select name="role" required>
                        <option value="">Select Role</option>
                        <option value="Student">Student</option>
                        <option value="Employee">Employee</option>
                    </select>
                </div>

                <div class="input-group">
                    <img src="https://img.icons8.com/ios-filled/50/id-verified.png" alt="ID No">
                    <input type="text" name="idno" placeholder="ID No">
                </div>



                <button type="submit">Sign Up</button>
            </form>

            <div class="login-text">
                Already have an account? <a href="Login.php">Login</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
