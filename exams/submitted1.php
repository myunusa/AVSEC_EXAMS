<?php
session_start();
echo $_SESSION['nimc_no'];
echo $_SESSION['exam_status'];
echo $_SESSION['exam_score'];
echo $_SESSION['percentStr'];
echo $_SESSION['exam_remark'];
echo $_SESSION['success'];


if (isset($_POST['submit_exam'])) {
    $exam_id = $_SESSION['exam_id'] ?? null;
    $student_name = $_SESSION['student_name'] ?? null;
    $nimc_no = $_SESSION['nimc_no'] ?? null;
    $exam_type = $_SESSION['exam_type'] ?? null;

    // get selected questions saved earlier (must be an array of ['id'=>..., 'answer'=>...])
    $selectedQuestions = $_SESSION['selected_questions'] ?? [];
    if (!is_array($selectedQuestions)) $selectedQuestions = [];


    // determine total questions (use session value if valid else fallback to count())
    $no_question = null;
    if (isset($_SESSION['no_question']) && is_numeric($_SESSION['no_question']) && (int)$_SESSION['no_question'] > 0) {
        $no_question = (int)$_SESSION['no_question'];
    } else {
        $no_question = count($selectedQuestions);
    }

    // user answers from POST (name="answer[<question_id>]")
    $userAnswersRaw = $_POST['answer'] ?? [];

    // Normalize user answers: ensure keys are stringified ints matching question ids, and values trimmed
    $userAnswers = [];
    if (is_array($userAnswersRaw)) {
        foreach ($userAnswersRaw as $k => $v) {
            // convert the key to integer then back to string so '001' and 1 normalize to "1"
            $key = (string)(int)$k;
            $userAnswers[$key] = trim((string)$v);
        }
    }

    // compute exam score: increment only when chosen option matches the stored correct option
    $exam_score = 0;

    // Sanity: ensure selectedQuestions is structured as expected (each entry must have 'id' & 'answer')
    foreach ($selectedQuestions as $entry) {
        if (!isset($entry['id'])) continue;
        $qid = (int)$entry['id'];
        $qidKey = (string)$qid;

        // stored correct option (example: "option1")
        $correctRaw = $entry['answer'] ?? '';
        $correct = strtolower(trim((string)$correctRaw));

        // chosen answer (example: "option1" or "")
        $chosenRaw = $userAnswers[$qidKey] ?? '';
        $chosen = strtolower(trim((string)$chosenRaw));

        // count +1 only when chosen is equals correct
        if ($chosen === $correct) {
            $exam_score++;
        }
    }

    // percent uses total number of questions (denominator = $no_question)
    $percent = 0.0;
    if ($no_question > 0) {
        $percent = round(($exam_score / $no_question) * 100, 2);
    }

    // remark based on percent threshold 75
    $exam_remark = ($percent >= 75) ? "Pass" : "Fail";
    $percentStr = $percent . "%";

    // Set an exam status (adjust as you prefer)
    $exam_status = "Written"; // or "Submitted"

    // Check if a student_exam row exists for this exam_id
    $selectStmt = $conn->prepare("SELECT id FROM student_exam WHERE exam_id = ? LIMIT 1");
    $selectStmt->bind_param("s", $exam_id);
    $selectStmt->execute();
    $selectRes = $selectStmt->get_result();

    if ($student_exam_result->num_rows > 0){
        // Update existing record
        $update_query ="UPDATE student_exam SET  exam_status = '$exam_status', exam_score ='$exam_score', percent ='$percentStr', exam_remark ='$exam_remark' WHERE exam_id='$exam_id'";
        if(mysqli_query($conn, $update_query)){
            // $_SESSION['submitted'] = "true";
            $_SESSION['exam_status'] = $exam_status;
            $_SESSION['exam_score'] = $exam_score;
            $_SESSION['percentStr'] = $percentStr;
            $_SESSION['exam_remark'] = $exam_remark;
            $_SESSION['success'] = "Dear {$student_name}, you have successfully submitted your examination.";
            header("Location: ../exams/submitted.php");
        }
    } else {
        header("Location: ../exams/instruction.php");
    }
    exit();
}
?>

