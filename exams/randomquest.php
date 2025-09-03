<?php
// db connection
session_start();

include("../database/config.php");


$e_code = $_SESSION['e_code'] ?? $_GET['e_code'] ?? null;

if (!$e_code) {
    die("No exam selected.");
}

// Fetch exam type details
$sql = "SELECT e_code, no_question FROM exam_type WHERE e_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $e_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Invalid exam type.");
}

$exam = $result->fetch_assoc();
$e_code = $exam['e_code'];
$no_question = (int) $exam['no_question'];

// Count available questions in the exam's table
$count_sql = "SELECT COUNT(*) AS total FROM `$e_code`";
$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$total_questions = (int) $count_row['total'];

if ($total_questions == 0) {
    die("No questions available for this exam.");
}

// Fetch random questions
$questions = [];
if ($total_questions >= $no_question) {
    // If enough questions, just get random set
    $q_sql = "SELECT * FROM `$e_code` ORDER BY RAND() LIMIT $no_question";
    $q_result = $conn->query($q_sql);
    while ($row = $q_result->fetch_assoc()) {
        $questions[] = $row;
    }
} else {
    // If not enough, fetch all and then repeat randomly
    $q_sql = "SELECT * FROM `$e_code`";
    $q_result = $conn->query($q_sql);
    while ($row = $q_result->fetch_assoc()) {
        $questions[] = $row;
    }

    // Repeat random questions until we reach no_question
    while (count($questions) < $no_question) {
        $random_index = array_rand($questions);
        $questions[] = $questions[$random_index];
    }
}

// Shuffle final questions to mix repeated ones
shuffle($questions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Questions</title>
    <link rel="stylesheet" href="style.css"> <!-- your existing CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .question-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0px 3px 6px rgba(0,0,0,0.1);
        }
        .question-card h3 {
            margin-bottom: 10px;
        }
        .options label {
            display: block;
            margin: 5px 0;
            cursor: pointer;
        }
        .q-image {
            max-width: 200px;
            margin-top: 10px;
            display: block;
        }
    </style>
</head>
<body>
    <h1>Exam: <?php echo htmlspecialchars($e_code); ?></h1>
    <h3>Total Questions: <?php echo $no_question; ?></h3>

    <form method="post" action="">
        <?php foreach ($questions as $index => $q): ?>
            <div class="question-card">
                <h3>Q<?php echo $index + 1; ?>: <?php echo htmlspecialchars($q['question']); ?></h3>

                <?php if (!empty($q['image'])): ?>
                    <img src="./image/<?php echo htmlspecialchars($q['image']); ?>" alt="Question Image" class="q-image">
                <?php endif; ?>

                <div class="options">
                    <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="option1"> <?php echo htmlspecialchars($q['option1']); ?></label>
                    <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="option2"> <?php echo htmlspecialchars($q['option2']); ?></label>
                    <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="option3"> <?php echo htmlspecialchars($q['option3']); ?></label>
                    <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="option4"> <?php echo htmlspecialchars($q['option4']); ?></label>
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit">Submit Exam</button>
    </form>
</body>
</html>
