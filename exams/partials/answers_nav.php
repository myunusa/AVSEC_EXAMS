<?php
// exams/partials/answers_nav.php
?>
<div class="footer-wrap pd-20 mb-20 card-box display-flex" style="bottom: 15px;">
	<?php for ($i = 1; $i <= $total_questions; $i++): ?>
		<span class="answered-<?php echo $i; ?>" style="display:none;">
			<a href="javascript:;" class="mb-2 text-decoration-none btn btn-answered" data-qindex="<?php echo $i; ?>" data-bgcolor="#00b489" data-color="#ffffff">Q<?php echo $i; ?></a>
		</span>
		<span class="not-answered-<?php echo $i; ?>">
			<a href="javascript:;" class="mb-2 text-decoration-none btn btn-not-answered" data-qindex="<?php echo $i; ?>" data-bgcolor="#db4437" data-color="#ffffff">Q<?php echo $i; ?></a>
		</span>
	<?php endfor; ?>

	<div style="margin-left:auto;">
		<a href="javascript:;" class="scroll_top"><i class="icon-copy ion-arrow-up-a"></i></a>
		<p>All questions in green color have been answered and the one in red color have not been answered.</p>
	</div>
</div>
