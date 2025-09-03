<?php 
include("../database/register.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Exam</title>
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
      <li><a href="../user/dashboard.php">Dashboard</a></li>
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
      <h2>Add New Exam</h2>
      <div class="message"><?php echo $message; ?></div>
      <form method="POST" autocomplete="off">
        <input type="text" name="name" placeholder="Exam Name" autocomplete="off" value="<?php echo $name; ?>">
        <input type="text" name="e_code" placeholder="Exam Code" autocomplete="off" value="<?php echo $e_code; ?>">
        <input type="number" name="no_question" min="60" max="150" placeholder="Number of Question" autocomplete="off" value="<?php echo $no_question ?? 0; ?>">
        <div style="display:flex; justify-content:center; margin-bottom:3px;">
          <label style="font-weight:bold;">Exam Duration</label>
        </div>
        <div style="display:flex; gap:10px; margin-bottom:15px;">
          <div>
              <label for="hours">Hours:</label>
              <input type="number" id="hours" name="hours" min="0" max="4" value="<?php echo $hours ?? 0; ?>" style="width:80px;">
          </div>
          <div>
              <label for="minutes">Minutes:</label>
              <input type="number" id="minutes" name="minutes" min="0" max="59" value="<?php echo $minutes ?? 0; ?>" style="width:80px;">
              <!-- <input type="number" id="minutes" name="minutes" min="0" max="60" value="<?php echo $minutes ?? 0; ?>" style="width:80px;"> -->
          </div>
        </div>
        <button type="submit" name="add_exam">Add Exam</button>
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
