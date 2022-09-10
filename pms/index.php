<?php 
	include './config/connection.php';

$message = '';

	if(isset($_POST['login'])) {
    $userName = $_POST['user_name'];
    $password = $_POST['password'];

    $encryptedPassword = md5($password);

    $query = "select `id`, `display_name`, `user_name`, 
`profile_picture` from `users` 
where `user_name` = '$userName' and 
`password` = '$encryptedPassword';";

try {
  $stmtLogin = $con->prepare($query);
  $stmtLogin->execute();

  $count = $stmtLogin->rowCount();
  if($count == 1) {
    $row = $stmtLogin->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['display_name'] = $row['display_name'];
    $_SESSION['user_name'] = $row['user_name'];
    $_SESSION['profile_picture'] = $row['profile_picture'];

    header("location:dashboard.php");
    exit;

  } else {
    $message = 'Incorrect username or password.';
  }
}  catch(PDOException $ex) {
      echo $ex->getTraceAsString();
      echo $ex->getMessage();
      exit;
    }
  

		
	}
?>
<!DOCTYPE html>
<!-- === Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        /* ===== Google Font Import - Poformsins ===== */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body{
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url("img/petBackgroundLogin.jpg");
            background-size: cover;
        }

        .box{
            position: absolute;
            right: 50px;
            max-width: 430px;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.35);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 0 20px;
        }

        .box .forms{
            display: flex;
            align-items: center;
            height: 440px;
            width: 200%;
            transition: height 0.2s ease;
        }


        .box .form{
            width: 50%;
            padding: 30px;
            background-color: rgba(0, 0, 0, 0.35);
            color: white;
            transition: margin-left 0.18s ease;
        }

        .box .signup{
            opacity: 0;
            transition: opacity 0.09s ease;
        }
        
        .box .form .title{
            position: relative;
            left: 33%;
            transform: translateX(-50%);
            font-size: 27px;
            font-weight: 600;
        }

        .form .title::before{
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 30px;
            background-color: rgb(7, 161, 7);
            border-radius: 25px;
        }

        .form .input-field{
            position: relative;
            height: 50px;
            width: 100%;
            margin-top: 30px;
            color: white;
        }

        .input-field input{
            position: absolute;
            background-color: rgba(0, 0, 0, 0.35);
            color: white;
            height: 100%;
            width: 100%;
            padding: 0 35px;
            border: none;
            outline: none;
            font-size: 16px;
            border-bottom: 2px solid #ccc;
            border-top: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .input-field i{
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 23px;
            transition: all 0.2s ease;
        }

        .input-field i.icon{
            left: 5px;
        }
        .input-field i.showHidePw{
            right: 0;
            cursor: pointer;
            padding: 10px;
        }

        .form .checkbox-text{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
        }

        .checkbox-text .checkbox-content{
            display: flex;
            align-items: center;
        }

        .checkbox-content input{
            margin: 0 8px -2px 4px;
            accent-color: #4070f4;
        }

        .form .text{
            color: white;
            font-size: 14px;
        }

        .form a.text{
            color: white;
            text-decoration: none;
        }
        .form a:hover{
            text-decoration: underline;
        }

        .form .button{
            margin-top: 35px;
        }

        .form .button input{
            border: none;
            color: white;
            font-size: 17px;
            font-weight: 500;
            letter-spacing: 1px;
            border-radius: 6px;
            background-color: rgb(7, 161, 7);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .button input:hover{
            background-color: rgb(8, 192, 8);
        }

        .form .login-signup{
            margin-top: 30px;
            text-align: center;
        }
    </style>
    <!--<title>Login & Registration Form</title>-->
</head>
<body>
            <!-- Header -->
    <section id="header">
        <div class="header nav">
        <div class="nav-bar">
            <div class="brand">
            <a href="#hero">
                <img src="img/logo.png" alt="VCO logo">
            </a>
            </div>
            <div class="nav-list">
            <div class="hamburger">
                <div class="bar"></div>
            </div>
            <ul>
                <li><a href="../home/home.html" data-after="Home">Home</a></li>
                <li><a href="../home/home.html" data-after="About">About Us</a></li>
                <li><a href="../home/home.html" data-after="Contact">Contact</a></li>
                <li><a href="../claim-and-adopt/claim-and-adopt.html" data-after="Adopt and Claim">Adopt And Claim</a></li>
                <li><a href="index.php" data-after="Login">Login</a></li>
            </ul>
            </div>
        </div>
        </div>
    </section>
    <!-- End Header -->
    <div class="box">
        <div class="forms">
            <div class="form login">
                <span class="title">Login</span>
                <form method="post">
                    <div class="input-field">
                        <input type="text" placeholder="Enter your Username" name="user_name" autocomplete="off" required>
                        <i class="uil uil-user icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Enter your password" name="password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <!--
                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="logCheck">
                            <label for="logCheck" class="text">Remember me</label>
                        </div>
                    </div>
                    -->
                    <div class="input-field button">
                        <input type="submit" value="Login" name="login">
                    </div>
                    <div class="row">
          <div class="col-md-12">
            <p class="text-danger" style="color:white;">
              <?php 
              if($message != '') {
                echo $message;
              }
              ?>
            </p>
          </div>
        </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const box = document.querySelector(".box"),
      pwShowHide = document.querySelectorAll(".showHidePw"),
      pwFields = document.querySelectorAll(".password"),
      signUp = document.querySelector(".signup-link"),
      login = document.querySelector(".login-link");

    //   js code to show/hide password and change icon
    pwShowHide.forEach(eyeIcon =>{
        eyeIcon.addEventListener("click", ()=>{
            pwFields.forEach(pwField =>{
                if(pwField.type ==="password"){
                    pwField.type = "text";

                    pwShowHide.forEach(icon =>{
                        icon.classList.replace("uil-eye-slash", "uil-eye");
                    })
                }else{
                    pwField.type = "password";

                    pwShowHide.forEach(icon =>{
                        icon.classList.replace("uil-eye", "uil-eye-slash");
                    })
                }
            }) 
        })
    })
    </script>
</body>
</html>

