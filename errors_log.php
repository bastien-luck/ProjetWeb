<?php  if (count($errors_log) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors_log as $error) : ?>
  	  <p><?php echo htmlspecialchars($error) ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>