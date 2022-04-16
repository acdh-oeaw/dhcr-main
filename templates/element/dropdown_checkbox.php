<?php

use Cake\Utility\Inflector;

$classes = (empty($classes)) ? 'input dropdown-checkbox' : $classes;
//TODO: check how errors are delivered in Cake.3
$classes .= (!empty($errors) and !empty($habtmModel) and !empty($errors[$habtmModel])) ? ' error' : '';
$tableName = preg_replace('/._ids$/', '', $fieldname);
$variableName = Inflector::variable($tableName);
if (empty($label)) $label = ucwords(str_replace(['-', '_'], ' ', $tableName));
?>
<div class="<?= $classes ?>">
	<label for="<?= $fieldname ?>">
		<?= $label ?>
	</label>
	<div id="<?= $variableName . '-ids-toggle' ?>" class="checklist-toggle">
		<span class="display"> - none selected - </span>
	</div>
	<div id="<?= $variableName . '-ids-checklist' ?>" class="checklist" style="display:none">
		<?php
		echo $this->Form->select($fieldname, $$variableName, [
			'multiple' => 'checkbox'
		]);
		echo $this->Form->button('Deselect all', array(
			'onclick' => "deselectList('#" . $variableName . "-ids-checklist');",
			'type' => 'button',
			'style' => 'margin-bottom:8px;',
			'class' => 'small blue button'
		));
		?>
	</div>
</div>
<?php
if (empty($dropdownScript)) {
	$this->set('dropdownScript', true);
	$this->Html->scriptStart(['block' => true]);
?>
	if(!dropdownScript) {
	var dropdownScript = 1;
	jQuery(document).ready(function() {
	var toggle = $('.checklist-toggle');
	var checklist = $('.checklist');
	toggle.each(function() {
	$(this).on('click', function() {
	$(this).next('.checklist').toggle();
	});
	});
	toggle.each(function(index) {
	var checklist = $(this).next('.checklist');
	dc_writeDisplay(this, checklist);
	var currentToggle = this;
	// rewrite the display on-change
	var inputlist = checklist.find('input[type=checkbox]');
	inputlist.each(function(key) {
	$(this).on('change', function() {
	dc_writeDisplay(currentToggle, checklist);
	});
	});
	});
	});
	// dc - namespace for dropdown-checklist
	function dc_writeDisplay(toggle, checklist) {
	var selected = checklist.find('input[type=checkbox]:checked');
	var values = [];
	selected.each(function(key) {
	values.push($(this).parent('label').text());
	});
	var display = values.join(', ');
	if(!display) display = ' - none selected - ';
	$(toggle).find('.display').text(display);
	}
	function closeList(selector) {
	$(selector).toggle();
	}
	function deselectList(selector) {
	console.log(selector);
	$(selector + ' :checkbox').prop('checked', false);
	dc_writeDisplay($(selector).prev(".checklist-toggle"), $(selector));
	}
	}
<?php
	$this->Html->scriptEnd();
}
?>