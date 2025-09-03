<?php 
include("../database/exam.php");  
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Exam Instruction</title>
	<!-- Site favicon -->
	<!-- <link rel="apple-touch-icon" sizes="180x180" href="../vendors/images/background/buk-logo.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../vendors/images/background/buk-logo.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../vendors/images/background/buk-logo.png">
	 -->
	<link rel="apple-touch-icon" sizes="180x180" href="../image/ncaa.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../image/ncaa.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../image/ncaa.png">


	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
  	<link rel="stylesheet" type="text/css" href="../vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="../vendors/styles/mystyle.css">
	<link rel="stylesheet" type="text/css" href="../vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="../src/plugins/fancybox/dist/jquery.fancybox.css">
	<link rel="stylesheet" href="../vendors/styles/TimeCircles.css">
    <link rel="stylesheet" href="../vendors/styles/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../vendors/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script type = "text/javascript" >
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
	<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-user" data-toggle="header_search"></div>
			<div class="header-search">
				<h4 class="text-danger">Active: <strong class="text-uppercase text-primary"><?php echo $_SESSION['student_name'];?></strong></h4>
			</div>
		</div>
		<div class="header-right">
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="javascript:;" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="../student/profile/<?php echo $_SESSION['student_image'];?>" style="width:100%; height:100%"alt="">
						</span>
						<span class="user-name text-uppercase"><?php echo $_SESSION['exam_id'];?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item active" href="javascript:;"><i class="dw dw-user1"></i> Profile</a>
						<a class="dropdown-item" href="javascript:;"><i class="dw dw-cloud"></i>NIMC NO.: <?php echo $_SESSION['nimc_no'];?></a>
						<a class="dropdown-item" href="javascript:;"><i class="dw dw-box"></i> Exam Code: <?php echo $_SESSION['e_code'];?></a>
						<a class="dropdown-item" href="javascript:;"><i class="dw dw-house1"></i><?php echo $_SESSION['exam_name'];?></a>
						<a href="../database/logout.php" class="dropdown-item"><i class="dw dw-logout"></i>Log Out</a>
              			<!-- <a href="../database/logout.php" class="dropdown-item"><i class="dw dw-logout"></i>Log Out</a> -->
					</div>
				</div>
			</div>
		</div>
	</div>
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
				<ul style="margin-top:10px"id="accordion-menu">
					<li class="mb-3">
						<a href="javascript:;" class="dropdown-toggle no-arrow active">
							<span class="micon dw dw-edit-2"></span><span class="mtext">INSTRUCTION</span>
						</a>
					</li>
					<li class="mb-3">
						<a href="javascript:;" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-edit-1"></span><span class="mtext">EXAMINATION</span>
						</a>
					</li>
					<li class="mb-3">
						<a href="javascript:;" class="dropdown-toggle no-arrow">
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
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="faq-wrap">
				<div class="card">
					<div class="row align-items-center">
						<div class="col-md-4 pl-30">
							<img src="../vendors/images/background/ex.jpg" alt="">
						</div>
						<div class="col-md-8">
							<h2 class=" text-danger mt-4 mb-4">EXAMINATION INSTRUCTIONS!!!</h2>
							<p class="font-18 text-justify max-width-600">
								You are about to write <strong><?php echo $_SESSION['exam_name'];?></strong>, the duration of this examination is <strong><?php echo $instruction_duration;?></strong>, you are advised to allocate your time accordingly.
							</p>
							<p class="font-18 text-justify max-width-600">
								There are <strong><?php echo $_SESSION['no_question'];?></strong> questions in this exam and each question is worth the same marks. 
								You must only attempt this exam once. If you have technical difficulties with your exam, contact any of the examination invigilators in the exam hall for assist. 																
							</p>
							<p class="font-18 text-justify max-width-600"> 
								You are not permitted to have any unauthorised material during this examination, such as Mobile phones, Smart watches and bands,etc.
							</p>							
						</div>
					</div>
					<div class="text-center">
						<img src="../vendors/images/background/exam_time.jpg" alt="">
						<div class="row">
							<div class="input-group mb-0">
								<form method="post" action="" enctype="multipart/form-data">
									<input class="btn btn-success btn-lg btn-block" type="submit" name="instruction" value="START EXAM NOW">
								</form>
							</div>
						</div>					
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
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
	<script type="text/javascript" src="../vendors/scripts/TimeCircles.js"></script>
	<script src="../vendors/scripts/dashboard.js"></script>
		<!-- fancybox Popup Js -->
		<script src="../src/plugins/fancybox/dist/jquery.fancybox.js"></script>
</body>
</html>