<?php 
include("./database/config.php");
include("src/fonts/themify-icons/fonts/fonts.php");
// include("input.php");
session_start();

$message = "";
$username =  "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $username=strtolower($username);

    // Prepare SQL to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows == 1 && $password === $row['password'] ) {
        // $row = $result->fetch_assoc();

        // // Plain text password comparison
        // if ($password === $row['password']) {
            // Save session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect to dashboard
            header("Location:./user/dashboard.php");
        //     exit();
        // } else {
        //     $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Invalid Password</p>";
        // }
    } else {
        // $error = "User not found!";
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Invalid Username or Password!</p>";

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AVSEC EXAMS</title>
  <!-- Favicon -->
  <link rel="icon" href="image/ncaa.png" type="image/x-icon">
  <!-- CSS Links -->
  <link rel="stylesheet" href="src/in_log.css">
  <script type = "text/javascript" >
		function preventBack() { window.history.forward(); }
		setTimeout("preventBack()", 0);
		window.onunload = function () { null };
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-119386393-1');
	</script> 
</head>

<body>

  <!-- Navbar -->
  <nav>
    <div class="logo">NCAA AVSEC EXAMINATION</div>
    <ul id="menu">
      <!-- Both index.php and user_log.php are in the same folder (pages/) -->
      <li><a href="index.php">HOME</a></li>
      <!-- <li><a href="user_log.php">LOGIN</a></li> -->
    </ul>
    <div class="menu-toggle" id="menu-toggle">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </nav>

  <!-- Hero Section -->
  <!-- Hero / Login Section -->
  <div class="hero">
    <div class="hero-content login-box">
      <h2>ADMIN/STAFF LOGIN</h2>
     <div class="message"><?php echo $message; ?></div>
			<form method="post" action="" autocomplete="off" enctype="multipart/form-data">
          <input type="text" name="username" placeholder="Username"  autocomplete="off">
          <input type="password" name="password" placeholder="Password"  autocomplete="off">
          <button type="submit" name="signin" type="submit">Login</button>
      </form>
    </div>
  </div>  
  <script>
    const toggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');
    toggle.addEventListener('click', () => {
      menu.classList.toggle('active');
    });
  </script>
</body>
</html>
