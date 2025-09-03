<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$role = $_SESSION['role'];
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

include("../database/config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Dashboard</title>
	<!-- Site favicon -->
    <link rel="icon" href="../image/ncaa.png" type="image/x-icon">

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
				<h6 class="text-danger">Active: <strong class="text-uppercase text-primary">  <?php echo $_SESSION['username']; ?></strong></h6>
			</div>
		</div>
		<div class="header-right">
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="javascript:;" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="../image/ncaa.png" style="width:100%; height:100%"alt="">
						</span>
						<span class="user-name text-capitalize"><?php echo $_SESSION['username']; ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item active" href="javascript:;"><i class="dw dw-user1"></i> <?php echo strtoupper($role); ?></a>
						<a class="dropdown-item" href="../register/admin_update.php"><i class="dw dw-settings2"></i> Change Password</a>
              			<a href="../database/logout.php" class="dropdown-item"><i class="dw dw-logout"></i>Log Out</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="javascript:;">
				<img src="../image/buk_title.png" alt="logo" class="dark-logo">
				<img src="../vendors/images/background/buk_title2.png" alt="" class="light-logo">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul style="margin-top:20px"id="accordion-menu">
					<li>
						<a href="javascript:;" class="dropdown-toggle no-arrow active">
							<span class="micon dw dw-house"></span><span class="mtext">Dashboard</span>
						</a>
					</li>

					<li class="dropdown">
						<a  class="dropdown-toggle">
							<span class="micon dw dw-user-2"></span><span class="mtext">Register</span>
						</a>
						<ul class="submenu">
                            <?php if ($role == "Admin"): ?>
                                <li><a href="new_user.php">Add User</a></li>
                            <?php endif; ?>
							<li><a href="../student/add_student.php">Add student</a></li>
							<li><a href="../exams/reg_exam.php">Register Student </a></li>
						</ul>
					</li>

					<li class="dropdown">
						<a  class="dropdown-toggle">
							<span class="micon dw dw-user"></span><span class="mtext">Manager Users</span>
						</a>
						<ul class="submenu">
							<?php if ($role == "Admin"): ?>
								<li><a href="./admins.php">Users</a></li>
							<?php endif ?>
							<li><a href="./utme_applicant.php">Student</a></li>
						</ul>
					</li>
                    <?php if ($role == "Admin"): ?>
                        <li class="dropdown">
                            <a  class="dropdown-toggle">
                                <span class="micon dw dw-edit-1"></span><span class="mtext">Exams</span>
                            </a>
                            <ul class="submenu">
                                 <li><a href="../exams/add_exam.php">Add Exams</a></li>
                                 <li><a href="../exams/add_question.php">Add Questions</a></li>
                                 <li><a href="../exams/manage_exam.php">Manage Exams</a></li>
                                 <li><a href="../exams/manage_question.php">Manage Question</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                     <li class="dropdown">
						<a  class="dropdown-toggle">
							<span class="micon fa fa-graduation-cap"></span><span class="mtext">Exam Records</span>
						</a>
						<ul class="submenu">
                            <li><a href="new_user.php">Add Exams</a></li>
                            <li><a href="new_user.php">Add Questions</a></li>
                            <li><a href="new_user.php">Manage Exams</a></li>
                            <li><a href="new_user.php">Manage Question</a></li>
						</ul>
					</li>

					<li>
						<a href="../admin_exam/check_result.php" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-eye"></span><span class="mtext">Check Result</span>
						</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>
	<div class="mobile-menu-overlay"></div>
	<div class="main-container">
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success">
				<h3 style="font-size: 18px;">
					<?php 
					echo $_SESSION['success']; 
					unset($_SESSION['success']);
					?>
				</h3>
			</div>
	  	<?php endif ?>		  
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="product-wrap">
					<div class="product-detail-wrap mb-30">
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
									<ol class="carousel-indicators">
										<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
										<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
										<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
									</ol>
									<div class="carousel-inner">
										<div class="carousel-item active">
											<img class="d-block w-100" src="../vendors/images/background/slider1.jpg" alt="First slide">
										</div>
										<div class="carousel-item">
											<img class="d-block w-100" src="../vendors/images/background/slider2.jpg" alt="Second slide">
										</div>
										<div class="carousel-item">
											<img class="d-block w-100" src="../vendors/images/background/slider3.jpg" alt="Third slide">
										</div>
										<div class="carousel-item">
											<img class="d-block w-100" src="../vendors/images/background/slider4.jpg" alt="Third slide">
										</div>
									</div>
									<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
										<span class="carousel-control-prev-icon" aria-hidden="true"></span>
										<span class="sr-only">Previous</span>
									</a>
									<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
										<span class="carousel-control-next-icon" aria-hidden="true"></span>
										<span class="sr-only">Next</span>
									</a>
								</div>
								<div>&nbsp;&nbsp;&nbsp;&nbsp; </div>
								<div class="page-header">
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<div class="title">
												<h4>CHECK RESULT</h4>
											</div>
											<p>Check students Post Utme examination result.</p>
											<div class="row">
												<a href="../admin_exam/check_result.php"class="btn btn-outline-primary btn-block">Check Result</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div id="user-info">
									<h4>NOTIFICATIONS</h4>
									<ul>
										<li>NUMBER OF REGISTERED ADMINS: <strong><?php if ($admin_row){ echo $admin_row." Admins";}else{ echo "No Admin";} ?></strong></li>
										<li>NUMBER OF DE STUDENTS : <strong><?php if ($de_row){ echo $de_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>NUMBER OF UTME STUDENTS : <strong><?php if ($utme_row){ echo $utme_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>APPLIED DE STUDENTS : <strong><?php if ($de_infor_row){ echo $de_infor_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>APPLIED UTME STUDENTS : <strong><?php if ($utme_info_row){ echo $utme_info_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>APPLIED FOR FACULTY OF AGRICULTURE: <strong><?php if ($fagri_row){ echo $fagri_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>APPLIED FOR Faculty of Computer Science & Information Technology: <strong><?php if ($fcsit_row){ echo $fcsit_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>APPLIED FOR FACULTY OF ENGINEERING: <strong><?php if ($feng_row){ echo $feng_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>APPLIED FOR FACULTY OF HEALTH SCI: <strong><?php if ($fhs_row){ echo $fhs_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>APPLIED FOR FACULTY OF SCOIAL SCI: <strong><?php if ($fss_row){ echo $fss_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>STUDENTS THAT SAT FOR EXAMS: <strong><?php if ($fss_row){ echo $fss_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>STUDENTS THAT NOT SAT FOR EXAMS: <strong><?php if ($fss_row){ echo $fss_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>UTME THAT PASS EXAMS: <strong><?php if ($fss_row){ echo $fss_row." Students";}else{ echo "No Student";} ?></strong></li>
										<li>UTME THAT FAIL EXAMS: <strong><?php if ($fss_row){ echo $fss_row." Students";}else{ echo "No Student";} ?></strong></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- <a href="https://wa.me/+2349048429539/?Hi sent payment slip" target="_blank" class="whatsapp whatsapp1 "><i class="fa fa-whatsapp"></i></a> -->

	<!-- js -->
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
		<!-- fancybox Popup Js -->
		<script src="../src/plugins/fancybox/dist/jquery.fancybox.js"></script>
</body>
</html>