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

// ADD NEW Question
if (isset($_POST['add_question'])) {
    $exam_type = trim($_POST['exam_type']);
    $question  = trim($_POST['question']);
    $option1   = trim($_POST['option1']);
    $option2   = trim($_POST['option2']);
    $option3   = trim($_POST['option3']);
    $option4   = trim($_POST['option4']);
    $answer    = trim($_POST['answer']);
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'jfif');

    // Default image name to empty (if no upload)
    $imageName = "";

    if (empty($exam_type)) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Select Exam Type</p>";
    } elseif (empty($question)) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Type Exam Question</p>";
    } elseif (empty($option1)) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Type Option 1</p>";
    } elseif (empty($option2)) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Type Option 2</p>";
    } elseif (empty($option3)) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Type Option 3</p>";
    } elseif (empty($option4)) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Type Option 4</p>";
    } elseif (empty($answer)) {
        $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Select Answer</p>";
    } else {
        // Check if file was uploaded
        if (!empty($fileName)) {
            if (!in_array($fileActualExt, $allowed)) {
                $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Upload jpg, jpeg or png image</p>";
            } elseif ($fileError == 0) {
                // Function for random 2 characters
                function randCode($len = 2) {
                    return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $len);
                }
                // Generate unique image name
                do {
                    $tempName = $exam_type . randCode();
                    $check = $conn->prepare("SELECT * FROM `$exam_type` WHERE image=?");
                    $check->bind_param("s", $tempName);
                    $check->execute();
                    $exists = $check->get_result()->num_rows > 0;
                } while ($exists);

                $imageName = "$tempName.$fileActualExt";
                $fileDestination = './image/' . $imageName;
            } else {
                $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Image not uploaded</p>";
            }
        } else {
            // No image uploaded → keep $imageName as ""
            $imageName = "";
        }
    }
    if ($message === "") {
        // Insert into database
          $stmt = $conn->prepare("INSERT INTO `$exam_type` (question, option1, option2, option3, option4, answer, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("sssssss", $question, $option1, $option2, $option3, $option4, $answer, $imageName);

          if ($stmt->execute()) {
            if (!empty($imageName)) {move_uploaded_file($fileTmpName, $fileDestination);}
            $message = "<p style='color:green; font-weight:bold; font-size:18px;'>✅ Question added successfully to $exam_type.</p>";
            $question = "";
            $option1 = "";
            $option2 = "";;
            $option3 = "";
            $option4 = "";
          } else {
              $message = "<p style='color:red; font-weight:bold; font-size:18px;'>Error: " . $conn->error . "</p>";
          }
          $stmt->close();
    }
}
?>
