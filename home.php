<?php
session_start();
include("database/config.php");
include("src/fonts/themify-icons/fonts/fonts.php");

// Destroy any previous session data if a user is trying to log in for a new exam.
if (isset($_SESSION['exam_id']) || isset($_SESSION['user_id'])) {
    session_unset();   // Clear session variables
    session_destroy(); // Destroy the old session
    session_start();   // Start a fresh, clean session for this attempt
}

$message = "";
$exam_id = "";

// LOGIN TO WRITE EXAM
if (isset($_POST['signin'])) {
    date_default_timezone_set('Africa/Lagos');
    $exam_id = strtoupper(trim($_POST['exam_id']));

    if (empty($exam_id)) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Exam ID</p>";
    } else {
        // Check exam id in the student_exam table
        $stmt = $conn->prepare("SELECT * FROM student_exam WHERE exam_id = ?");
        $stmt->bind_param("s", $exam_id);
        $stmt->execute();
        $student_exam_result = $stmt->get_result();

        if ($student_exam_result->num_rows == 0) {
            $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Exam ID not found!</p>";
        } else {
            $student_exam_row = $student_exam_result->fetch_assoc();
            $nimc_no          = $student_exam_row['nimc_no'];
            $e_code           = $student_exam_row['exam_type'];
            $exam_date        = $student_exam_row['exam_date']; // YYYY-MM-DD
            $exam_time        = $student_exam_row['exam_time']; // HH:MM:SS
            $exam_status      = $student_exam_row['exam_status'];
            
            $today_date = date("Y-m-d");
            // $now_time   = date("h:i:s");  // 24-hour format
            
            $now_time   = strtotime(date("H:i:s"));  // current time as timestamp
            $exam_time1  = strtotime($exam_time);     // exam time string converted to timestamp

            // Fetch exam type details
            $stmt = $conn->prepare("SELECT * FROM exam_type WHERE e_code = ?");
            $stmt->bind_param("s", $e_code);
            $stmt->execute();
            $exam_type_result = $stmt->get_result();

            // Fetch student details
            $stmt = $conn->prepare("SELECT * FROM student WHERE nimc_no = ?");
            $stmt->bind_param("s", $nimc_no);
            $stmt->execute();
            $student_result = $stmt->get_result();

            if ($exam_type_result->num_rows > 0 && $student_result->num_rows > 0) {
                $exam_type_row = $exam_type_result->fetch_assoc();
                $student_row   = $student_result->fetch_assoc();

                $exam_name      = $exam_type_row['name'];
                $no_question      = $exam_type_row['no_question'];
                $exam_duration  = $exam_type_row['duration']; // HH:MM:SS
                $student_name   = $student_row['name'];
                $student_image  = $student_row['image'];

                // Check date and time
                if ($today_date == $exam_date) {
                    if ($now_time >= $exam_time1) {
                        if ($exam_status == "Not written") {
                            // Set session variables
                            $_SESSION['exam_id']       = $exam_id;
                            $_SESSION['nimc_no']       = $nimc_no;
                            $_SESSION['e_code']        = $e_code;
                            $_SESSION['exam_name']     = $exam_name;
                            $_SESSION['exam_date']     = $exam_date;
                            $_SESSION['exam_time']     = $exam_time;
                            $_SESSION['exam_time1']    = $exam_time1;
                            $_SESSION['no_question'] = $no_question;
                            $_SESSION['exam_duration'] = $exam_duration;
                            $_SESSION['student_name']  = $student_name;
                            $_SESSION['student_image'] = $student_image;
                            
                            header('location: ./exams/instruction.php');
                        // header('location: home.php');

                            exit;
                        } else {
                            $message = "<p style='color:red; font-weight:bold; font-size:18px;'>You have already written the exam</p>";
                        }
                    } else {
                        $message = "<p style='color:orange; font-weight:bold; font-size:18px;'>Exam not yet time</p>";
                    }
                } else {
                    $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Your exam is not today</p>";
                }
            } else {
                $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Record of student not found.</p>";
            }
        }
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
  <link rel="icon" href="./image/ncaa.png" type="image/x-icon">
  <!-- CSS Links -->
  <link rel="stylesheet" href="src/in_log.css">
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
  <script type="text/javascript">
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
    <div class="logo"><a href="./user_log.php" style="all:unset;cursor:pointer;"> NCAA AVSEC EXAMINATION</a></div>

    <ul id="menu">
      <li><a href="home.php">HOME</a></li>
    </ul>
    <div class="menu-toggle" id="menu-toggle">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="hero">
    <div class="hero-content login-box">
      <h2>ENTER YOUR EXAM ID</h2>
      <div class="message"><?php echo $message; ?></div>
      <form method="post" action="" autocomplete="off" enctype="multipart/form-data">
          <input type="text" name="exam_id" placeholder="Exam ID" autocomplete="off" value="<?php echo $exam_id; ?>">
          <button type="submit" name="signin">Login</button>
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
