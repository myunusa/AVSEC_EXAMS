<?php
// exams/exam.php
include("../database/random_question.php"); // provides $questions, $Remain_time, etc.

// Store questions and correct answers in session for scoring later
$_SESSION['selected_questions'] = array_map(function($q){
    return [
        'id' => $q['id'],
        'answer' => $q['answer'] // option1|option2|option3|option4
    ];
}, $questions);

// Easy access counts
$total_questions = count($questions);
$per_page = 5;
$total_pages = (int)ceil($total_questions / $per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Examination</title>

    <!-- DO NOT CHANGE CSS (kept exactly) -->
	<link rel="apple-touch-icon" sizes="180x180" href="../image/ncaa.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../image/ncaa.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../image/ncaa.png">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="../vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="../vendors/styles/mystyle.css">
	<link rel="stylesheet" type="text/css" href="../vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="../src/plugins/fancybox/dist/jquery.fancybox.css">
	<link rel="stylesheet" href="../vendors/styles/TimeCircles.css">
    <link rel="stylesheet" href="../vendors/styles/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../vendors/styles/style.css">

	<style>
		/* Fullscreen image overlay */
		.fullscreen-overlay {
			display: none;
			position: fixed;
			inset: 0;
			background: rgba(0,0,0,0.92);
			justify-content: center;
			align-items: center;
			z-index: 99999;
			padding: 20px;
		}
		.fullscreen-overlay img {
			max-width: 95%;
			max-height: 95%;
			box-shadow: 0 16px 50px rgba(0,0,0,0.6);
			border-radius: 6px;
			transition: transform 220ms ease, opacity 150ms ease;
			transform-origin: center center;
			opacity: 0;
		}
		.fullscreen-overlay.show img { opacity: 1; transform: scale(1.02); }
		.fullscreen-overlay .close-btn {
			position: absolute;
			top: 18px;
			right: 22px;
			font-size: 40px;
			color: #fff;
			cursor: pointer;
			user-select: none;
			z-index: 100000;
		}
		.disabled-link { pointer-events: none; opacity: 0.5; }
	</style>

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script type="text/javascript">
		function preventBack(){window.history.forward();}
		setTimeout("preventBack()", 0);
		window.onunload=function(){null};
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body>
	<!-- Header (unchanged) -->
    <div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-user" data-toggle="header_search"></div>
			<div class="header-search">
				<h4 class="text-danger">Active: <strong class="text-uppercase text-primary"><?php echo $_SESSION['student_name']; ?></strong></h4>
			</div>
		</div>
		<div class="header-right">
            <!-- Timer: DO NOT MODIFY Remain_time -->
            <div id="CountDownTimer" data-timer="<?php echo $Remain_time; ?>" style="width: 200px; height: 90px; float:right;"></div>

			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="javascript:;" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="../student/profile/<?php echo $_SESSION['student_image'];?>" style="width:100%; height:100%" alt="">
						</span>
						<span class="user-name text-uppercase"><?php echo $_SESSION['exam_id'];?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item active" href="javascript:;"><i class="dw dw-user1"></i> Profile</a>
						<a class="dropdown-item" href="javascript:;"><i class="dw dw-cloud"></i>NIMC NO.: <?php echo $_SESSION['nimc_no'];?></a>
						<a class="dropdown-item" href="javascript:;"><i class="dw dw-box"></i> Exam Code: <?php echo $_SESSION['e_code'];?></a>
						<a class="dropdown-item" href="javascript:;"><i class="dw dw-house1"></i><?php echo $_SESSION['exam_name'];?></a>
						<a href="../database/logout.php" class="dropdown-item"><i class="dw dw-logout"></i>Log Out</a>
					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- Sidebar -->
    <div class="left-side-bar">
		<div class="brand-logo">
			<a href="javascript:;">
				<img src="../image/buk_title.png" alt="logo" class="dark-logo">
				<img src="../image/buk_title.png" alt="" class="light-logo">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul style="margin-top:10px" id="accordion-menu">
					<li class="mb-3">
						<a href="javascript:;" class="dropdown-toggle no-arrow passed">
							<span class="micon dw dw-edit-2"></span><span class="mtext">INSTRUCTION</span>
						</a>
					</li>
					<li class="mb-3">
						<a href="javascript:;" class="dropdown-toggle no-arrow active exam1">
							<span class="micon dw dw-edit-1"></span><span class="mtext">EXAMINATION</span>
						</a>
						<a href="javascript:;" class="dropdown-toggle no-arrow passed exam2" style="display:none">
							<span class="micon dw dw-edit-1"></span><span class="mtext">EXAMINATION</span>
						</a>
					</li>
					<li class="mb-3">
						<!-- Review starts disabled -->
						<a href="javascript:;" id="reviewBtn" class="dropdown-toggle no-arrow review1 disabled-link">
							<span class="micon dw dw-id-card"></span><span class="mtext">REVIEW</span>
						</a>
						<a href="javascript:;" style="display:none" class="dropdown-toggle no-arrow active review2">
							<span class="micon dw dw-id-card"></span><span class="mtext">REVIEW</span>
						</a>
					</li>
					<li class="mb-3">
						<a href="javascript:;" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-paper-plane1"></span><span class="mtext">SUBMIT</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
        <div class="pd-ltr-0 xs-pd-20-10">
            <div class="faq-wrap">
                <h3 class="text-blue"><span class="text-red" style="color:red">Exam Name: </span> <?php echo htmlspecialchars($e_code); ?></h3>
                <h3 class="mb-2 text-blue"><span class="text-red" style="color:red">Total Question: </span> <?php echo $no_question; ?></h3>

				<form method="post" action="" enctype="multipart/form-data" id="examForm">
					<!-- QUESTIONS -->
					<?php include __DIR__ . '/partials/questions.php'; ?>

					<!-- Pagination Controls -->
					<div class="card" id="pagerControls">
						<div class="p-3">
							<button type="button" class="btn btn-primary" id="btnPrev" style="float:left; display:none">
								<span class="icon-copy ti-angle-double-left">Previous</span>
							</button>
							<button type="button" class="btn btn-primary" id="btnNext" style="float:right; display:<?php echo ($total_pages > 1 ? 'block' : 'none'); ?>">
								<span class="icon-copy">Next</span><span class="icon-copy ti-angle-double-right"></span>
							</button>
							<input class="btn btn-success" id="btnSubmit" type="submit" name="submit_exam" value="Submit" style="float:right; display:none; margin-right:10px;">
							<div style="clear:both"></div>
						</div>
					</div>

					<!-- ANSWERS SECTION -->
					<?php include __DIR__ . '/partials/answers_nav.php'; ?>

					<!-- TIME OUT SCREEN -->
					<div class="exam_over" style="display:none">
						<div class="card text-center">
							<h2 class="text-danger mt-4">TIME OUT EXAM IS OVER!!!</h2>
							<div id="submit">
								<h4 class="card-body mt-3">You can only Submit!!!</h4>
								<img src="../vendors/images/background/Online_Exam_5.webp" alt="">
								<h3 class="card-body mb-2 text-primary">Click on Submit button to submit your exam!!!</h3>
								<div class="row">
									<div class="input-group mb-0">
										<input class="btn btn-success btn-lg btn-block" type="submit" name="submit_exam" value="Submit">
									</div>
								</div>
							</div>
						</div>
					</div>
	            </form>
            </div>
	    </div>
	</div>

	<!-- Fullscreen overlay for images -->
	<div class="fullscreen-overlay" id="fullscreenOverlay" aria-hidden="true">
		<span class="close-btn" id="closeFullscreen" aria-label="Close image">&times;</span>
		<img id="fullscreenImg" src="" alt="Full screen question image">
	</div>

	<!-- Scripts (kept) -->
	<script src="vendors/scripts/app.js"></script>
	<script src="../vendors/scripts/core.js"></script>
	<script src="../vendors/scripts/main.js"></script>
	<script src="../vendors/scripts/script.min.js"></script>
	<script src="../vendors/scripts/process.js"></script>
	<script src="../vendors/scripts/layout-settings.js"></script>
	<script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<script src="../vendors/scripts/dashboard.js"></script>
	<script type="text/javascript" src="../vendors/scripts/TimeCircles.js"></script>
	<script src="../src/plugins/fancybox/dist/jquery.fancybox.js"></script>

	<script>
		// Initialize timer (leave Remain_time logic untouched)
        $("#CountDownTimer").TimeCircles({ time: { Days: { show: false }, Hours: { show: true } } });

        var timerInterval = setInterval(function() {
            var remaining_time = $('#CountDownTimer').TimeCircles().getTime();
            if (remaining_time < 1) {
                clearInterval(timerInterval);
                $("#CountDownTimer").TimeCircles().stop();

                // Hide ONLY the question area, pager and answers nav.
                var qwrap = document.querySelector('.questions-wrap');
                if (qwrap) qwrap.style.display = "none";
                var pager = document.querySelector('#pagerControls');
                if (pager) pager.style.display = "none";
                var footer = document.querySelector('.footer-wrap');
                if (footer) footer.style.display = "none";

                // Show only exam_over block
                var examOver = document.querySelector('.exam_over');
                if (examOver) examOver.style.display = "block";

                // Do not disable header or sidebar interactions
                // (we purposely avoid disabling all buttons or links)
            }
        }, 1000);
	</script>

	<!-- Main exam JS -->
	<script src="./js/exam.js"></script>
</body>
</html>
