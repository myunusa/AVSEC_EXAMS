<div class="questions-wrap">
	<div id="accordion">
	<?php foreach ($questions as $i => $q):
		$displayIndex = $i + 1;
		$qid = (int)$q['id'];
	?>
		<div class="card question-item" data-index="<?php echo $displayIndex; ?>" id="q<?php echo $displayIndex; ?>" style="display:none">
			<div class="card-header">
				<label class="btn btn-block<?php echo $displayIndex === 1 ? '' : ' collapsed'; ?>" data-toggle="collapse" data-target="#faq<?php echo $displayIndex; ?>">
					<strong style="font-size:20px;">Question <?php echo $displayIndex; ?>.</strong>
				</label>
			</div>

			<div id="faq<?php echo $displayIndex; ?>" class="collapse<?php echo $displayIndex === 1 ? ' show' : ''; ?>" data-parent="#accordion">
				<div class="card-body ml-5">
					<span style="font-size:23px;"><?php echo htmlspecialchars($q['question']); ?></span>
					<?php if (!empty($q['image'])): ?>
						<!-- thumbnail image; data-full attribute used for fullscreen -->
						<img src="./image/<?php echo htmlspecialchars($q['image']); ?>"
							style="max-width:200px; margin-top:10px; display:block; cursor:pointer;"
							alt="Question Image"
							class="q-image"
							data-full="./image/<?php echo htmlspecialchars($q['image']); ?>">
					<?php endif; ?>
				</div>

				<div class="row col-sm-12 ml-5">
					<!-- hidden default to avoid null post for validation -->
					<div class="col-6 custom-control custom-radio mb-5" hidden>
						<input type="radio" id="blank_<?php echo $displayIndex; ?>" checked="true" value="" name="answer[<?php echo $qid; ?>]" class="custom-control-input">
						<label class="custom-control-label" for="blank_<?php echo $displayIndex; ?>"></label>
					</div>

					<!-- Option 1 -->
					<div class="col-6 custom-control custom-radio mb-5">
						<input type="radio" id="q<?php echo $displayIndex; ?>_o1" name="answer[<?php echo $qid; ?>]" value="option1" class="custom-control-input answer-radio" data-qindex="<?php echo $displayIndex; ?>">
						<label class="custom-control-label" style="font-size:20px;" for="q<?php echo $displayIndex; ?>_o1"><strong style="font-size:20px;">A. </strong><?php echo htmlspecialchars($q['option1']); ?></label>
					</div>

					<!-- Option 2 -->
					<div class="col-6 custom-control custom-radio mb-5">
						<input type="radio" id="q<?php echo $displayIndex; ?>_o2" name="answer[<?php echo $qid; ?>]" value="option2" class="custom-control-input answer-radio" data-qindex="<?php echo $displayIndex; ?>">
						<label class="custom-control-label" style="font-size:20px;" for="q<?php echo $displayIndex; ?>_o2"><strong style="font-size:20px;">B. </strong><?php echo htmlspecialchars($q['option2']); ?></label>
					</div>

					<!-- Option 3 -->
					<div class="col-6 custom-control custom-radio mb-5">
						<input type="radio" id="q<?php echo $displayIndex; ?>_o3" name="answer[<?php echo $qid; ?>]" value="option3" class="custom-control-input answer-radio" data-qindex="<?php echo $displayIndex; ?>">
						<label class="custom-control-label" style="font-size:20px;" for="q<?php echo $displayIndex; ?>_o3"><strong style="font-size:20px;">C. </strong><?php echo htmlspecialchars($q['option3']); ?></label>
					</div>

					<!-- Option 4 -->
					<div class="col-6 custom-control custom-radio mb-5">
						<input type="radio" id="q<?php echo $displayIndex; ?>_o4" name="answer[<?php echo $qid; ?>]" value="option4" class="custom-control-input answer-radio" data-qindex="<?php echo $displayIndex; ?>">
						<label class="custom-control-label" style="font-size:20px;" for="q<?php echo $displayIndex; ?>_o4"><strong style="font-size:20px;">D. </strong><?php echo htmlspecialchars($q['option4']); ?></label>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>
