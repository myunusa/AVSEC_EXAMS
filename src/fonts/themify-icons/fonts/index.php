<?php
    date_default_timezone_set('Africa/Lagos');

    // Current date (midnight timestamp)
    $exam_date = strtotime(date("Y-m-d"));

    // Exam start date (fixed)
    $exam_start = strtotime("2025-09-07");

      if ($exam_date < $exam_start) {
        header("Location: ./home.php"); // corrected typo from indax.php
        exit;
    }
  
?>
