<?php echo "<?php\n"; ?>
<?php echo "/**\n"; ?>
<?php echo " * @var \$this View\n"; ?>
<?php echo " */\n"; ?>
<?php echo "?>\n"; ?>
<div class="page-header">
	<?php echo "<?php echo \$this->Html->link(\$this->BootstrapIcon->css('list-alt','black').' '.__('List " . $singularHumanName . "'), array('action' => 'index'), array('class'=>'btn btn-default btn-small pull-right','escape'=>false)); ?>\n";?>
    <h1><?php echo "<?php echo __('{$pluralHumanName}');?>";?> <small><?php echo "<?php echo __('" . Inflector::humanize($action) . " %s', __('" . $singularHumanName . "')); ?>"; ?></small></h1>
</div>
<div class="row">
    <div class="span12">
<?php if (in_array('filename',$fields)&&in_array('dir',$fields)&&in_array('mimetype',$fields)&&in_array('filesize',$fields)) { ?>
		<?php echo "<?php echo \$this->BootstrapForm->create('{$modelClass}', array('class' => 'form-horizontal', 'type' => 'file'));?>\n";?>
<?php $file = true; ?>
<?php } else { ?>
		<?php echo "<?php echo \$this->BootstrapForm->create('{$modelClass}', array('class' => 'form-horizontal'));?>\n";?>
<?php $file = false; ?>
<?php } ?>
			<fieldset>
<?php $skip_fields = array('created','modified','updated'); ?>
<?php
				echo "\t\t\t\t<?php\n";
				foreach ($fields as $field) {
					if ((strpos($action, 'add') !== false && $field == $primaryKey) || in_array($field, $skip_fields)) {
						continue;
					} else {
						if ($this->templateVars['schema'][$field]['null'] == false) {
							if (substr($field,strlen($field)-3,3)=="_id") {
								$required = ", array(\n\t\t\t\t\t\t'empty' => true,\n\t\t\t\t\t\t'required' => 'required',\n\t\t\t\t\t\t'helpInline' => '<span class=\"label label-important\">' . __('Required') . '</span>&nbsp;')\n\t\t\t\t\t";
							} else if ($field == 'filename') {
								$required = ", array(\n\t\t\t\t\t\t'type' => 'file',\n\t\t\t\t\t\t'required' => 'required',\n\t\t\t\t\t\t'helpInline' => '<span class=\"label label-important\">' . __('Required') . '</span>&nbsp;')\n\t\t\t\t\t";
							} else if (substr($field,0,3)=="is_") {
								$required = null;
							} else {
								$required = ", array(\n\t\t\t\t\t\t'required' => 'required',\n\t\t\t\t\t\t'helpInline' => '<span class=\"label label-important\">' . __('Required') . '</span>&nbsp;')\n\t\t\t\t\t";
							}
						} else {
							$required = null;
						}
						if ($field == $primaryKey || ($file&&($field=='dir'||$field=='mimetype'||$field=='filesize'))) {
							echo "\t\t\t\t\techo \$this->BootstrapForm->hidden('{$field}');\n";
						} else {
							echo "\t\t\t\t\techo \$this->BootstrapForm->input('{$field}'{$required});\n";
						}
					}
				}
				if (!empty($associations['hasAndBelongsToMany'])) {
					foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
						echo "\t\t\t\t\techo \$this->BootstrapForm->input('{$assocName}');\n";
					}
				}
				echo "\t\t\t\t?>\n";
				echo "\t\t\t\t<?php echo \$this->BootstrapForm->submit(__('Submit'), array('class'=>'btn btn-primary'));?>\n";
?>
			</fieldset>
		<?php
			echo "<?php echo \$this->BootstrapForm->end();?>\n";
		?>
	</div>
</div>