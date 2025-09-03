<?php 
include("config.php");
include("input.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$role = $_SESSION['role'];
$username = $_SESSION['username'];

$message = "";
$name = $no_question = $e_code = "";
$hours = 0;
$minutes = 0;

// ADD NEW USER
if (isset($_POST['newn_user'])) {
    $roleForm = $_POST['role'];
    $name = trim($_POST['name']);
    $user_name = trim($_POST['username']);
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $name=ucwords($name);
    $user_name=strtolower($user_name);

    $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkUser->bind_param("s", $user_name);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if(empty($roleForm)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Select Role</p>";} 
    elseif(empty($name)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Staff Name</p>";}
    elseif(empty($user_name)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Staff user name</p>";}
    elseif($result->num_rows > 0) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'> Username already exists</p>";}
    elseif (empty($password)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Password</p>";}
    elseif (empty($c_password)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Confirm Password</p>";}
    elseif(strlen($password) < 6){$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Password must be atleast 6</p>";}
    elseif ($password != $c_password) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>passwords not match</p>";}

    if ($message === "") {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO users (role, name, username, password, added_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $roleForm, $name, $user_name, $password, $username);
        
          if ($stmt->execute()) {
            $message = "<p style='color:green; font-weight:bold; font-size:18px;'>✅ Student added successfully!</p>";
            $name = "";
            $user_name = "";;
            $password = "";
            $c_password = "";
          } else {
              $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Error: " . $conn->error . "</p>";
          }
          $stmt->close();
    }
    $checkUser->close();
}

// ADD NEW STUDENT
if (isset($_POST['add_student'])) {
    $nimc_no = trim($_POST['nimc_no']);
    $name = trim($_POST['name']);
    $phone_no = trim($_POST['phone_no']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $fileName =$_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError =$_FILES['file']['error'];
    $fileTpye= $_FILES['file']['type'];
    $fileExt =explode('.', $fileName);
    $fileActualExt= strtolower(end($fileExt));
    $allowed= array('jpg', 'jpeg', 'png', 'jfif');
    $name=ucwords($name);

    // Check if nimc_no already exists
    $checkNimc = $conn->prepare("SELECT * FROM student WHERE nimc_no = ?");
    $checkNimc->bind_param("s", $nimc_no);
    $checkNimc->execute();
    $result = $checkNimc->get_result();

    $today = new DateTime();
    $birthDate = new DateTime($dob);
    $age = $today->diff($birthDate)->y;

    // Ensure nimc_no is numeric
    if (empty($nimc_no)|| !is_numeric($nimc_no)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Student NIMC Number</p>";}
    elseif(strlen($nimc_no) !== 11 || !ctype_digit($nimc_no)){$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Invalid NIMC Number</p>";}
    elseif ($result->num_rows > 0){$message = "<p style='color:red; font-weight:bold; font-size:18px;'>NIMC Number already exists</p>";} 
    elseif(empty($name)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Student Name</p>";}
    elseif(strlen($phone_no) !== 11){$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Invalid Phone Number</p>";}
    elseif (empty($dob)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Select Date of Birth</p>";}    
    elseif ($age < 18 || $dob > date("Y-m-d")) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Invalid Date of Birth</p>";}    
    elseif (empty($gender)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Select Gender</p>";} 
    elseif (!in_array($fileActualExt, $allowed)){$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Upload jpg, jpeg or png image</p>";}
    elseif(in_array($fileActualExt, $allowed)){
        if($fileError == 0){
            $fileNewName = "$nimc_no".".".$fileActualExt;
            $fileDestination ='./profile/'.$fileNewName;
        }else{$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Image not uploaded</p>";}
    }
    if ($message === "") {
        // Insert into database
          $stmt = $conn->prepare("INSERT INTO student (nimc_no, name, phone_no, dob, gender, image) VALUES (?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("ssssss", $nimc_no, $name, $phone_no, $dob, $gender, $fileNewName);

          if ($stmt->execute()) {
            move_uploaded_file($fileTmpName, $fileDestination);
            $message = "<p style='color:green; font-weight:bold; font-size:18px;'>✅ Student added successfully!</p>";
            $nimc_no = "";
            $name = "";
            $dob = "";;
            $gender = "";
          } else {
              $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Error: " . $conn->error . "</p>";
          }
          $stmt->close();
    }
 $checkNimc->close();
}

// ADD NEW EXAMS
if (isset($_POST['add_exam'])) {
    $name = ucwords(trim($_POST['name']));
    $e_code = strtoupper(trim($_POST['e_code']));
    $no_question = trim($_POST['no_question']);
    $hours = intval($_POST['hours']);
    $minutes = intval($_POST['minutes']);

    $checkUser = $conn->prepare("SELECT * FROM exam_type WHERE e_code = ? OR name = ?");
    $checkUser->bind_param("ss", $e_code, $name);
    $checkUser->execute();
    $result = $checkUser->get_result();

    // Validate inputs based on your requirements
    if(empty($name)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Exam Name</p>";}
    elseif(empty($e_code)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Exam Code</p>";}
    elseif (!preg_match("/^[A-Za-z]{3}[0-9]{3}$/", $e_code)) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Invalid Exam Code (e.g., ABC123).</p>";}
    elseif(empty($no_question)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Question Numbers</p>";}
    elseif ($no_question < 60 || $no_question > 150) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Questions must be above 59</p>";}
    elseif ($hours > 4) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Maximum of 4Hours</p>";
    } elseif (empty($minutes)||$minutes < 0 || $minutes > 59) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Maximum of 59Sec.</p>";}
    elseif($result->num_rows > 0) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'> Exam already exists</p>";}
        
        // elseif (empty($e_time)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Exam Time</p>";}
     // --- MODIFIED VALIDATION ---
  
    if ($message === "") {
        // Pad single-digit numbers with a leading zero
        $formatted_hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
        $formatted_minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
        
        // Combine into the required HH:MM:SS format
        $e_duration = "$formatted_hours:$formatted_minutes:00";

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO exam_type (e_code, name,no_question, duration) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $e_code, $name, $no_question, $e_duration);
        
          if ($stmt->execute()) {
            // Create new table for the exam
            $createTable = "
                CREATE TABLE `$e_code` (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    question TEXT NOT NULL,
                    option1 VARCHAR(255) NOT NULL,
                    option2 VARCHAR(255) NOT NULL,
                    option3 VARCHAR(255) NOT NULL,
                    option4 VARCHAR(255) NOT NULL,
                    answer VARCHAR(255) NOT NULL,
                    image VARCHAR(255) DEFAULT NULL
                ) ENGINE=InnoDB;
            ";

            if ($conn->query($createTable) === TRUE) {
                $message = "<p style='color:green; font-weight:bold; font-size:18px;'>✅ Exam added and table '$e_code' created successfully!</p>";
            } else {
                $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Exam added, but error creating table: " . $conn->error . "</p>";
            }
            // $message = "<p style='color:green; font-weight:bold; font-size:18px;'>✅ Exam added successfully!</p>";
            $name = $no_question = $e_code = "";
            $hours = 0;
            $minutes = 0;
          } else {
              $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Error: " . $conn->error . "</p>";
          }
          $stmt->close();
    }
    $checkUser->close();
}

// REGISTER STUDDENT TO EXAM.....
if (isset($_POST['reg_exam'])) {
    $nimc_no = trim($_POST['nimc_no']);
    $exam_type = trim($_POST['exam_type']);
    $exam_date = trim($_POST['exam_date']);
    $exam_time = trim($_POST['exam_time']); // in format HH:MM

    // ====== CHECK if NIMC exists in student table ======
    $checkStudent = $conn->prepare("SELECT nimc_no FROM student WHERE nimc_no = ?");
    $checkStudent->bind_param("s", $nimc_no);
    $checkStudent->execute();
    $resultStudent = $checkStudent->get_result();

    if (empty($nimc_no)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Student NIMC Number</p>";}
    elseif (!preg_match("/^[0-9]{11}$/", $nimc_no)){
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Invalid NIMC Number</p>";}
    elseif ($resultStudent->num_rows == 0){
            $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Student NIMC not found!</p>";}
    elseif (empty($exam_type)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Select Exam Type</p>";}
    elseif (empty($exam_date)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Exam Date</p>";}
    elseif (strtotime($exam_date) < strtotime(date("Y-m-d"))){
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Invalid Exam Date</p>";}
    elseif (empty($exam_time)) {$message = "<p style='color:red; font-weight:bold; font-size:18px;'>Enter Exam Time</p>";}
    elseif (!preg_match("/^[0-9]{2,}$/", str_replace(":", "", $exam_time))) {  
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Invalid Exam Time</p>";
    }
    
    if ($message === "") {
        // Get exam type name (for foreign key reference)
        $stmtExam = $conn->prepare("SELECT name, e_code FROM exam_type WHERE name = ?");
        $stmtExam->bind_param("i", $exam_type);
        $stmtExam->execute();
        $resultExam = $stmtExam->get_result();

        if ($resultExam->num_rows > 0) {
            $examRow = $resultExam->fetch_assoc();
            $exam_name = $examRow['name'];
            $exam_code = $examRow['e_code'];

            // Function for random 5 characters
            function randCode($len = 5) {
            return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $len);
            }

            // Generate unique exam_id
            do {
            $exam_id = $exam_code . randCode();
            $check = $conn->prepare("SELECT * FROM student_exam WHERE exam_id=?");
            $check->bind_param("s", $exam_id);
            $check->execute();
            $exists = $check->get_result()->num_rows > 0;
            } while ($exists);

            $exam_status   = "Not written";
            $exam_score   = "";
            $exam_remark   = "";

            // Insert into student_exam
            $stmt = $conn->prepare("INSERT INTO student_exam (nimc_no, exam_id, exam_type, exam_date, exam_time, exam_status, exam_score, exam_remark) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
            $stmt->bind_param("ssssssss", $nimc_no, $exam_id, $exam_code, $exam_date, $exam_time, $exam_status, $exam_score, $exam_remark);

            if ($stmt->execute()) {
                $message = "<p style='color:green; font-weight:bold; font-size:18px;'>Exam registered successfully!</p>";
                // Clear form values
                $nimc_no = $exam_type_id = $exam_date = $exam_time = "";
            } else {
                $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Error: " . $conn->error . "</p>";
            }
            $stmt->close();
        } else {
                $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Invalid Exam Type selected</p>";
            }
        $stmtExam->close();
    } 
    $checkStudent->close();
}

?>