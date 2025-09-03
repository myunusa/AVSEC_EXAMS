<?php 
    session_start();
    include("config.php");

    if (!isset($_SESSION['exam_id'])) {header('location: ../index.php');}

    $timezone=date_default_timezone_set('Africa/Lagos');
    // Exam duration (from session) e.g. "01:30:00"
    $exam_duration = $_SESSION['exam_duration'];
    list($hours, $minutes, $seconds) = explode(":", $exam_duration);
    $total_seconds = ($hours * 3600 + $minutes * 60 + $seconds); // total duration in seconds

    // If this is the first time exam page is opened, set exam start time
    if (!isset($_SESSION['exam_start_time'])) {$_SESSION['exam_start_time'] = time(); }

    $exam_start_time = $_SESSION['exam_start_time'];

    // Remaining time = total duration - elapsed
    $elapsed = time() - $exam_start_time;
    $Remain_time = $total_seconds - $elapsed;

    // Prevent negative values
    if ($Remain_time < 0) {$Remain_time = 0;}

    // Instruction duration string
    if ($hours > 0) {$instruction_duration = $hours . "Hrs " . $minutes . "Mins" . $seconds . "seconds";
    } elseif($minutes > 0) {
        $instruction_duration = $minutes . " Mins ";
    } else {$instruction_duration = $seconds . " seconds";}

    // Exam code
    $e_code = $_SESSION['e_code'] ?? $_GET['e_code'] ?? null;
    if (!$e_code) {die("No exam selected.");}

    $message = "";

   
    // Instruction code to start exam
    if (isset($_POST['instruction'])) {
        // $End_Time= strtotime($End_Time);
        $exam_id = $_SESSION['exam_id'];

        // Check exam id in the student_exam table
        $stmt = $conn->prepare("SELECT * FROM student_exam WHERE exam_id = ?");
        $stmt->bind_param("s", $exam_id);
        $stmt->execute();
        $student_exam_result = $stmt->get_result();

        if ($student_exam_result->num_rows > 0){
            $exam_score= 0;
            $percent="0%";
            $exam_status="Logout";
            $exam_remark="Fail";
            $update_query ="UPDATE student_exam SET exam_status ='$exam_status', exam_score ='$exam_score', percent ='$percent', exam_remark ='$exam_remark' WHERE exam_id='$exam_id'";
            if(mysqli_query($conn, $update_query)){
        // $exam_started="exam_started";
        // $_SESSION['exam_started'] = $exam_started;
        // $_SESSION['End_Time'] = $End_Time;
        header('location: ../exams/start_exam.php');
            }
        }       
    }

    // exams/submit_exam.php
   if (isset($_POST['submit_exam'])) {
    $exam_id = $_SESSION['exam_id'];
    $student_name = $_SESSION['student_name'];
    $nimc_no = $_SESSION['nimc_no'];
    $exam_type = $_SESSION['exam_type'];

    $exam_score = 0;
    $exam_status = "Written";

    $selectedQuestions = $_SESSION['selected_questions'] ?? [];
    $userAnswers = $_POST['answer'] ?? [];

    // total number of questions in the exam
    $no_question = count($selectedQuestions);

    foreach ($selectedQuestions as $q) { 
        $qid = (int)$q['id']; 
        $correct = $q['answer']; // e.g., option3 
        $chosen = $userAnswers[$qid] ?? ''; 

        // Count score only if the chosen option is correct
        if ($chosen !== '' && $chosen === $correct) { 
            $exam_score++; 
        }
    }

    // Percent calculation (denominator = all questions, answered or not)
    $percent = 0;
    if ($no_question > 0) {
        $percent = round(($exam_score / $no_question) * 100, 2);
    }

    $exam_remark = ($percent >= 75) ? "Pass" : "Fail";
    $percentStr = $percent . "%";

    // Check if exam already exists
    $stmt = $conn->prepare("SELECT * FROM student_exam WHERE exam_id = ?");
    $stmt->bind_param("s", $exam_id);
    $stmt->execute();
    $student_exam_result = $stmt->get_result();

    if ($student_exam_result->num_rows > 0){
        // Update existing record
        $update_query ="UPDATE student_exam SET  exam_status = '$exam_status', exam_score ='$exam_score', percent ='$percentStr', exam_remark ='$exam_remark' WHERE exam_id='$exam_id'";
        if(mysqli_query($conn, $update_query)){
            // $_SESSION['submitted'] = "true";
            $_SESSION['e_code'] = $e_code;
            $_SESSION['exam_status'] = $exam_status;
            $_SESSION['exam_score'] = $exam_score;
            $_SESSION['percentStr'] = $percentStr;
            $_SESSION['exam_remark'] = $exam_remark;
            $_SESSION['remark'] = "Dear {$student_name}, you have score {$percentStr} in your {$e_code}";
            $_SESSION['success'] = "You have successfully submitted your examination.";
            header("Location: ../exams/submitted.php");
        }
    } else {
        header("Location: ../exams/instraction.php");
    }
    exit();
}
        
?>
