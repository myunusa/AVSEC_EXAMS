<?php 
    // session_start();
    include("exam.php");

    // Exam duration (from session) e.g. "01:30:00"
    $exam_duration = $_SESSION['exam_duration'];
    list($hours, $minutes, $seconds) = explode(":", $exam_duration);
    $total_seconds = ($hours * 3600 + $minutes * 60 + $seconds); // total duration in seconds

    // If this is the first time exam page is opened, set exam start time
    if (!isset($_SESSION['exam_start_time'])) {
        $_SESSION['exam_start_time'] = time();  // <-- this creates the starting time
    }

    $exam_start_time = $_SESSION['exam_start_time'];

    // Remaining time = total duration - elapsed
    $elapsed = time() - $exam_start_time;
    $Remain_time = $total_seconds - $elapsed;

    // Prevent negative values
    if ($Remain_time < 0) {
        $Remain_time = 0;
    }

    // Instruction duration string
    if ($hours > 0) {
        $instruction_duration = $hours . " Hrs " . $minutes . " Mins";
    } else {
        $instruction_duration = $minutes . " Mins";
    }

    // Exam code
    $e_code = $_SESSION['e_code'] ?? $_GET['e_code'] ?? null;
    if (!$e_code) {
        die("No exam selected.");
    }


    // Validate exam type to fetch random questions
    $sql = "SELECT e_code, no_question FROM exam_type WHERE e_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $e_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("Invalid exam type.");
    }

    $exam = $result->fetch_assoc();
    $e_code = $exam['e_code'];
    $no_question = (int) $exam['no_question'];

    // Count questions
    $count_sql = "SELECT COUNT(*) AS total FROM `$e_code`";
    $count_result = $conn->query($count_sql);
    $count_row = $count_result->fetch_assoc();
    $total_questions = (int) $count_row['total'];

    if ($total_questions == 0) {
        die("No questions available for this exam.");
    }

    // Fetch questions
    $questions = [];
    if ($total_questions >= $no_question) {
        $q_sql = "SELECT * FROM `$e_code` ORDER BY RAND() LIMIT $no_question";
        $q_result = $conn->query($q_sql);
        while ($row = $q_result->fetch_assoc()) {
            $questions[] = $row;
        }
    } else {
        $q_sql = "SELECT * FROM `$e_code`";
        $q_result = $conn->query($q_sql);
        while ($row = $q_result->fetch_assoc()) {
            $questions[] = $row;
        }

        while (count($questions) < $no_question) {
            $random_index = array_rand($questions);
            $questions[] = $questions[$random_index];
        }
    }

    // Shuffle final
    shuffle($questions);

    // Save in session for consistency
    $_SESSION['questions'] = $questions;
?>
