<?php 
include("../database/register.php");
// Fetch exam_type from database
$exam_type = [];
$sql = "SELECT id, e_code, name FROM exam_type ORDER BY id ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $exam_type[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Exam</title>
  <link rel="icon" href="../image/ncaa.png" type="image/x-icon">
  <link rel="stylesheet" href="../src/main.css">
  <script type="text/javascript">
    function preventBack() { window.history.forward(); }
    setTimeout("preventBack()", 0);
    window.onunload = function () { null };
  </script>
</head>
<body>

  <!-- Navbar -->
  <nav>
    <div class="logo">NCAA AVSEC EXAMINATION</div>
    <ul id="menu">
      <li><a href="../user/dashboard.php">Dashboard</a></li>
    </ul>
    <div class="menu-toggle" id="menu-toggle">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="hero center">
    <div class="hero-content login-box" style="margin-top:-110px;">
      <h2>Register Exam</h2>
      <div class="message"><?php echo $message; ?></div>
      <form method="POST" autocomplete="off">
        <input type="text" name="nimc_no" placeholder="Student NIMC No." autocomplete="off" value="<?php echo $nimc_no; ?>">

        <select name="exam_type" id="exam_type">
          <option value="">Select Exam</option>
          <?php foreach ($exam_type as $exams): ?>
            <option value="<?php echo $exams['e_code']; ?>">
              <?php echo $exams['name'].' ('.$exams['e_code'].')'; ?>
            </option>
          <?php endforeach; ?>
        </select>
       <div style="display:flex; justify-content:center; margin-bottom:0px;">
          <label style="font-weight:bold;">Exam Date</label>
        </div>
        <input type="date" name="exam_date" value="<?php echo $exam_date; ?>">
         <div style="display:flex; justify-content:center; margin-bottom:0px;">
          <label style="font-weight:bold;">Exam Time</label>
        </div>
        <input type="time" name="exam_time" value="<?php echo $exam_time; ?>">

        <button type="submit" name="reg_exam">Submit</button>
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
