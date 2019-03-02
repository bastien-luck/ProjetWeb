<?php  if (count($errors_reg) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors_reg as $error) : ?>
  	  <p><?php echo htmlspecialchars($error) ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>