<?php 
include("../database/register.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add User</title>
  <link rel="icon" href="../image/ncaa.png" type="image/x-icon">
  <link rel="stylesheet" href="../src/main.css">
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
      <li><a href="./dashboard.php">Dashboard</a></li>
      <!-- <li><a href="../database/logout.php">Logout</a></li> -->
    </ul>
    <div class="menu-toggle" id="menu-toggle">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="hero center margin-top:-100px">
    <div class="hero-content login-box" style="margin-top:-110px;">
      <h2>Add New User</h2>
      <div class="message"><?php echo $message; ?></div>
       <form method="POST" autocomplete="off">
        <select name="role">
          <option value="">Select Role</option>
          <option value="Admin">Admin</option>
          <option value="Staff">Staff</option>
        </select>
        <input type="text" name="name" placeholder="Full Name" autocomplete="off" value="<?php echo $name; ?>">
        <input type="text" name="username" placeholder="Username" value="<?php echo $user_name; ?>" autocomplete="off">
        <input type="password" name="password" placeholder="Password" autocomplete="off" value="<?php echo $password; ?>">
        <input type="password" name="c_password" placeholder="Confirm Password">
        <button type="submit" name="newn_user">Add User</button>
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
