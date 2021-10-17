<?php
if(!empty($errors) OR (!empty($modelName) AND !empty($this->validationErrors[$modelName]))) {
	if(empty($errors)) {
		$errors = [];
		if($modelName AND !empty($this->validationErrors[$modelName]))
			$errors = $this->validationErrors[$modelName];
	}
	?>
	<div class="validation-errors">
		<h3>We have Errors!</h3>
        <p>Please check the following fields:</p>
		<dl>
			<?php
			foreach($errors as $field => $error) {
				?>
				<dt><?= Inflector::humanize($field) ?></dt>
				<dd><?= implode('<br>', $error) ?></dd>
				<?php
			}
			?>
		</dl>
	</div>
	<?php
}
?>
