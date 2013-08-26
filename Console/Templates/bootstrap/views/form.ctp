<?php echo "<?php\n"; ?>
<?php echo "/**\n"; ?>
<?php echo " * @var \$this View\n"; ?>
<?php echo " */\n"; ?>
<?php echo "?>\n"; ?>
<div class="page-header">
    <div class="btn-group pull-right">
        <?php echo "<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-list-alt')).' '.__('List " . $singularHumanName . "'), array('action' => 'index'), array('class'=>'btn btn-default visible-md visible-lg','escape'=>false)); ?>\n";?>
        <?php echo "<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-list-alt')), array('action' => 'index'), array('class'=>'btn btn-default visible-xs visible-sm','escape'=>false)); ?>\n";?>
    </div>
    <h1 class="visible-md visible-lg"><?php echo "<?php echo __('{$pluralHumanName}');?>";?> <small><?php echo "<?php echo __('" . Inflector::humanize($action) . " %s', __('" . $singularHumanName . "')); ?>"; ?></small></h1>
    <h1 class="visible-xs visible-sm"><?php echo "<?php echo __('{$pluralHumanName}');?>";?></h1>
</div>
<?php if (in_array('filename',$fields)&&in_array('dir',$fields)&&in_array('mimetype',$fields)&&in_array('filesize',$fields)) { ?>
		<?php echo "<?php echo \$this->Form->create('{$modelClass}', array(
            'inputDefaults' => array(
                'div' => 'form-group',
                'wrapInput' => false,
                'class' => 'form-control'
            ),
            'class' => 'well',
            'type' => 'form'
        ));?>\n";?>
<?php $file = true; ?>
<?php } else { ?>
		<?php echo "<?php echo \$this->Form->create('{$modelClass}', array(
            'inputDefaults' => array(
                'div' => 'form-group',
                'wrapInput' => false,
                'class' => 'form-control'
            ),
            'class' => 'well'
        ));?>\n";?>
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
								$required = ", array(\n\t\t\t\t\t\t'empty' => true,\n\t\t\t\t\t\t'required' => 'required',\n\t\t\t\t\t\t'label' => __('".Inflector::humanize($field)."'),\n\t\t\t\t\t\t'after' => '<span class=\"label label-danger label-xs pull-right\">* Required</span><span class=\"help-block\">&nbsp;</span>'\n\t\t\t\t\t)\n\t\t\t\t";
							} else if ($field == 'filename') {
								$required = ", array(\n\t\t\t\t\t\t'type' => 'file',\n\t\t\t\t\t\t'required' => 'required',\n\t\t\t\t\t\t'label' => __('".Inflector::humanize($field)."'),\n\t\t\t\t\t\t'after' => '<span class=\"label label-danger label-xs pull-right\">* Required</span><span class=\"help-block\">&nbsp;</span>'\n\t\t\t\t\t)\n\t\t\t\t";
							} else if (substr($field,0,3)=="is_") {
                                $required = ", array(\n\t\t\t\t\t\t'checked' => true,\n\t\t\t\t\t\t'label' => __('".Inflector::humanize(substr($field,3,strlen($field)))."'),\n\t\t\t\t\t\t'class' => '',\n\t\t\t\t\t)\n\t\t\t\t";
							} else {
								$required = ", array(\n\t\t\t\t\t\t'required' => 'required',\n\t\t\t\t\t\t'label' => __('".Inflector::humanize($field)."'),\n\t\t\t\t\t\t'after' => '<span class=\"label label-danger label-xs pull-right\">* Required</span><span class=\"help-block\">&nbsp;</span>'\n\t\t\t\t\t)\n\t\t\t\t";
							}
						} else {
                            if (substr($field,strlen($field)-3,3)=="_id") {
                                $required = ", array(\n\t\t\t\t\t\t'empty' => true,\n\t\t\t\t\t\t'label' => __('".Inflector::humanize($field)."'),\n\t\t\t\t\t)\n\t\t\t\t";
                            } else if ($field == 'filename') {
                                $required = ", array(\n\t\t\t\t\t\t'type' => 'file,'\n\t\t\t\t\t\t'label' => __('".Inflector::humanize($field)."'),\n\t\t\t\t\t)\n\t\t\t\t";
                            } else if (substr($field,0,3)=="is_") {
                                $required = ", array(\n\t\t\t\t\t\t'checked' => true,\n\t\t\t\t\t\t'label' => __('".Inflector::humanize(substr($field,3,strlen($field)))."'),\n\t\t\t\t\t\t'class' => '',\n\t\t\t\t\t)\n\t\t\t\t";
                            } else {
                                $required = null;
                            }
						}
						if ($field == $primaryKey || ($file&&($field=='dir'||$field=='mimetype'||$field=='filesize'))) {
							echo "\t\t\t\t\techo \$this->Form->hidden('{$field}');\n";
						} else {
							echo "\t\t\t\t\techo \$this->Form->input('{$field}'{$required});\n";
						}
					}
				}
				if (!empty($associations['hasAndBelongsToMany'])) {
					foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
						echo "\t\t\t\t\techo \$this->Form->input('{$assocName}');\n";
					}
				}
				echo "\t\t\t\t?>\n";
				echo "\t\t\t\t<?php echo \$this->Form->submit(__('Submit'), array('class'=>'btn btn-primary'));?>\n";
?>
			</fieldset>
		<?php
			echo "<?php echo \$this->Form->end();?>\n";
		?>