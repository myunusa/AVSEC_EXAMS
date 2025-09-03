<?php
    date_default_timezone_set('Africa/Lagos');

    // Current date (midnight timestamp)
    $exam_date = strtotime(date("Y-m-d"));

    // Exam start date (fixed)
    $exam_start = strtotime("2025-09-07");

    // If today's date is before or equal to exam start date → redirect
    if ($exam_date >= $exam_start) {
        header("Location: ./index.php"); // corrected typo from indax.php
        exit;
    }
?>
