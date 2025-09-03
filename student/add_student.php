<?php 
include("../database/register.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Student</title>
  <link rel="icon" href="../image/ncaa.png" type="image/x-icon">
  <link rel="stylesheet" href="../src/main.css">
  <link rel="stylesheet" href="../src/form.css">
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
  <div class="hero center">
    <div class="hero-content login-box">
      <h2>Add New Student</h2>
      <form method="POST" enctype="multipart/form-data" autocomplete="off" style="display:flex;flex-direction:column;height:100%;">
         <div id="img">
          <img src="../vendors/images/profile/defaultimage.JPG" autocomplete="off" onclick="triggerClick()" id="profileDisplay">
          <input type="file" id="profile_Image" onchange="displayImage(this)" name="file" style="display: none;">
        </div>
        <div class="message"><?php echo $message; ?></div>
        <div class="form-body">
          <input type="text" name="nimc_no" placeholder="NIMC Number" autocomplete="off" value="<?php echo $nimc_no; ?>">
          <input type="text" name="name" placeholder="Full Name" autocomplete="off" value="<?php echo $name; ?>">
          <input type="number" name="phone_no" placeholder="Phone Number" autocomplete="off" value="<?php echo $phone_no; ?>">
          <input type="date" name="dob" value="<?php echo $dob; ?>">

          <select name="gender">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>

        </div>

        <div class="form-footer">
          <button type="submit" name="add_student">Add Student</button>
        </div>
      </form>
    </div>
  </div>
  <script>
    const toggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');
    toggle.addEventListener('click', () => { menu.classList.toggle('active'); });

    function triggerClick(){ document.querySelector('#profile_Image').click(); }
    function displayImage(e){
      if (e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
          document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
      }
    }
  </script>
</body>
</html>
