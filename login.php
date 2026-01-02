<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>UniWork - Role Based Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
/* ===== RESET ===== */
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
}

/* LEFT SIDE - IMAGE */
.left{
    flex:1;
    background: url('assets/loginbackground image.png') center/cover no-repeat;
    position: relative;
    display:flex;
    justify-content:center;
    align-items:center;
    color:white;
    font-size:48px;
    font-weight:bold;
    text-shadow: 1px 1px 5px rgba(0,0,0,0.5);
}

/* RIGHT SIDE - LOGIN CARD */
.right{
    flex:1;
    background:#bfe3ff;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px;
}

/* LOGIN CARD */
.login-card{
    width:380px;
    padding:40px 30px;
    background:#ffffff;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
    text-align:center;
}
.login-card h2{
    margin-bottom:25px;
    font-size:28px;
    text-decoration:underline;
}

/* ROLE SELECT */
.role-select{
    display:flex;
    justify-content:space-around;
    margin-bottom:25px;
}
.role-box{
    background:#f0f0f0;
    padding:10px 20px;
    border-radius:20px;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:8px;
    font-weight:500;
    transition:0.3s;
}
.role-box:hover{
    background:#d6e4f0;
}
.role-box input{
    margin:0;
}

/* INPUT GROUP */
.input-group{
    background:#fff;
    border-radius:30px;
    padding:10px 15px;
    display:flex;
    align-items:center;
    margin-bottom:20px;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
}
.input-group img{
    width:22px;
    margin-right:10px;
}
.input-group input{
    border:none;
    outline:none;
    width:100%;
    font-size:15px;
}

/* BUTTON */
button{
    background:#184f73;
    color:#fff;
    border:none;
    padding:12px 35px;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}
button:hover{
    background:#0f3a58;
}

/* SIGNUP TEXT */
.signup-text{
    margin-top:20px;
    color:#184f73;
}
.signup-text a{
    color:#184f73;
    text-decoration:none;
    font-weight:600;
}
.signup-text a:hover{
    text-decoration:underline;
}

/* ERROR MESSAGE */
.error{
    color:red;
    margin-bottom:15px;
}

/* ===== RESPONSIVE ===== */
@media(max-width:900px){
    .main{
        flex-direction:column;
        height:auto;
    }
    .left, .right{
        flex:unset;
        width:100%;
        height:300px;
    }
    .left{
        font-size:32px;
    }
    .login-card{
        margin-top:-50px;
        width:90%;
        padding:30px;
    }
}
</style>
</head>
<body>

<!-- TOP BAR -->
<div class="top-bar">
    <img src="assets/home_page/logo uni work.png" alt="UniWork Logo">
    <span>UniWork</span>
</div>
<div class="blue-strip"></div>

<!-- SPLIT MAIN -->
<div class="main">

    <!-- LEFT SIDE IMAGE -->
    <div class="left">
        Welcome!
    </div>

    <!-- RIGHT SIDE LOGIN CARD -->
    <div class="right">
        <div class="login-card">

            <h2>Login</h2>

            <!-- OPTIONAL ERROR MESSAGE -->
            <?php if(isset($_GET['error'])){ ?>
                <div class="error"><?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php } ?>

            <!-- LOGIN FORM -->
            <form method="POST" action="login_process.php">

                <div class="role-select">
                    <label class="role-box">
                        <input type="radio" name="role" value="Student" checked> Student
                    </label>
                    <label class="role-box">
                        <input type="radio" name="role" value="Employee"> Employee
                    </label>
                </div>

                <div class="input-group">
                    <img src="https://img.icons8.com/ios-filled/50/new-post.png" alt="Email Icon">
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <img src="https://img.icons8.com/ios-filled/50/lock-2.png" alt="Password Icon">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" name="login">Login</button>

            </form>

            <div class="signup-text">
                Don’t have an account? <a href="SignUp.php">Sign Up</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
