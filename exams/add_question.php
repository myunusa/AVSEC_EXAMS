<?php 
include("../database/question.php");
// Fetch exam_type from database
$exam_type = [];
$sql = "SELECT id, e_code, name FROM exam_type ORDER BY id ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $exam_type[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Questions</title>
  <link rel="icon" href="../image/ncaa.png" type="image/x-icon">
  <link rel="stylesheet" href="../src/questionform.css">
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
  <!-- Navbar -->
  <nav>
    <div class="logo">NCAA AVSEC EXAMINATION</div>
    <ul id="menu">
      <li><a href="../user/dashboard.php">Dashboard</a></li>
    </ul>
    <div class="menu-toggle" id="menu-toggle">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="hero center">
    <div class="hero-content login-box">
      <h2>Add New Student</h2>
      <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <div id="img">
          <img src="../vendors/images/profile/defaultimage.JPG" onclick="triggerClick()" id="profileDisplay">
          <input type="file" id="profile_Image" onchange="displayImage(this)" name="file" style="display: none;">
        </div>
        <div class="message"><?php echo $message ?? ''; ?></div>

        <!-- Exam type -->
        <select name="exam_type" id="exam_type">
          <option value="">Select Exam</option>
          <?php foreach ($exam_type as $exams): ?>
            <option value="<?php echo $exams['e_code']; ?>">
              <?php echo $exams['name'].' ('.$exams['e_code'].')'; ?>
            </option>
          <?php endforeach; ?>
        </select>

        <!-- Question -->
        <textarea name="question" placeholder="Type Question" rows="3" autocomplete="off"><?php echo $question; ?></textarea>

        <!-- Options -->
        <textarea id="option1" name="option1" placeholder="Type Option 1" rows="2" autocomplete="off"><?php echo $option1; ?></textarea>
        <textarea id="option2" name="option2" placeholder="Type Option 2" rows="2" autocomplete="off"><?php echo $option2; ?></textarea>
        <textarea id="option3" name="option3" placeholder="Type Option 3" rows="2" autocomplete="off"><?php echo $option3; ?></textarea>
        <textarea id="option4" name="option4" placeholder="Type Option 4" rows="2" autocomplete="off"><?php echo $option4; ?></textarea>

        <!-- Answer -->
        <select name="answer" id="answer">
          <option value="">Select Answer</option>
        </select>

        <div style="margin-top:40px"></div>
        <!-- Button -->
        <button type="submit" name="add_question">Add Question</button>
      </form>
    </div>
  </div>

  <script>
    const toggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');
    toggle.addEventListener('click', () => { menu.classList.toggle('active'); });

    function triggerClick(){ document.querySelector('#profile_Image').click(); }
    function displayImage(e){
      if (e.files[0]){
        var reader = new FileReader();
        reader.onload = function(e){
          document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
      }
    }
      const optionFields = [
    document.getElementById('option1'),
    document.getElementById('option2'),
    document.getElementById('option3'),
    document.getElementById('option4')
  ];
  const answerSelect = document.getElementById('answer');

  function updateAnswerOptions() {
    // Clear old options
    answerSelect.innerHTML = '<option value="">Select Answer</option>';

    optionFields.forEach((field, index) => {
      if (field.value.trim() !== "") {
        const opt = document.createElement("option");
        opt.value = field.value.trim();
        opt.textContent = field.value.trim();
        answerSelect.appendChild(opt);
      }
    });
  }

  // Listen for typing/changes in option fields
  optionFields.forEach(field => {
    field.addEventListener('input', updateAnswerOptions);
  });

  // Run on page load (in case values come from PHP)
  updateAnswerOptions();
  </script>
</body>
</html>
