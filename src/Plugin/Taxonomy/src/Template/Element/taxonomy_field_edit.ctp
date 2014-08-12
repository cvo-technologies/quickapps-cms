<?php if (!$field->metadata->settings['vocabulary']): ?>
	<div class="alert alert-warning"><?php echo __d('taxonomy', 'You must select a vocabulary for this field!'); ?></div>
<?php else: ?>
	<?php
		// considering "max_values" > 1
		$id = "taxonomy-{$field->metadata->field_instance_id}-{$field->metadata->field_value_id}";
		$label = (!$field->metadata->required ? $field->label : $field->label . ' *');
		$inputOptions = [
			'type' => 'select',
			'id' => $id,
			'options' => $terms,
			'escape' => false,
			'label' => $label,
			'multiple' => ($field->metadata->settings['type'] === 'checkbox' ? 'checkbox' : true),
			'value' => $field->extra,
		];

		if (
			intval($field->metadata->settings['max_values']) === 1 &&
			in_array($field->metadata->settings['type'], ['checkbox', 'select'])
		) {
			if ($field->metadata->settings['type'] === 'select') {
				$inputOptions['multiple'] = false;
			} elseif ($field->metadata->settings['type'] === 'checkbox') {
				$inputOptions['type'] = 'radio';
				$inputOptions['separator'] = '<br />';
				$inputOptions['label'] = true;
				unset($inputOptions['multiple']);
				echo $this->Form->label($label);
			}
		} elseif($field->metadata->settings['type'] === 'autocomplete') {
			$inputOptions['type'] = 'text';
			$inputOptions['class'] = 'taxonomy-tags';
			unset($inputOptions['multiple'], $inputOptions['options']);
			// TODO: taxonomy field: auto-complete tagging
			echo $this->element('Taxonomy.taxonomy_field_tagging_widget', ['fieldId' => $id, 'field' => $field]);
		}
	?>

	<!-- taxonomy field -->
	<?php echo $this->Form->input(":{$field->name}", $inputOptions); ?>
	<em class="help-block"><?php echo $field->metadata->description; ?></em>
<?php endif; ?>