<?php echo "<?php\n"; ?>
<?php echo "/**\n"; ?>
<?php echo " * @var \$this View\n"; ?>
<?php echo " */\n"; ?>
<?php echo "?>\n"; ?>
<div class="page-header">
	<?php echo "<?php echo \$this->Html->link(\$this->BootstrapIcon->css('plus','white').' '.__('New " . $singularHumanName . "'), array('action' => 'add'), array('class'=>'btn btn-primary btn-small pull-right','escape'=>false)); ?>\n";?>
    <h1><?php echo "<?php echo __('{$pluralHumanName}');?>";?> <small><?php echo "<?php echo __('List of {$pluralHumanName}');?>";?></small></h1>
</div>
<div class="row">
    <div class="span12">
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
<?php $skip_fields = array('id','hash','password','created','modified','updated'); ?>
<?php
	if (in_array('filename',$fields)&&in_array('dir',$fields)&&in_array('mimetype',$fields)&&in_array('filesize',$fields)) {
		$filefields = array('dir','mimetype');
		$skip_fields = array_merge($skip_fields,$filefields);
	}
?>
<?php $is_active = false; ?>
<?php foreach ($fields as $field) { ?>
<?php if (in_array($field,$skip_fields)) continue; ?>
                <th><?php echo "<?php echo \$this->Paginator->sort('{$field}');?>";?></th>
<?php } ?>
                <th class="span3"><?php echo "<?php echo __('Actions');?>";?></th>
            </tr>
<?php
        echo "\t\t\t<?php foreach (\${$pluralVar} as \${$singularVar}) { ?>\n";
        echo "\t\t\t<tr>\n";
            foreach ($fields as $field) {
				if (in_array($field,$skip_fields)) continue;
                $isKey = false;
                if (!empty($associations['belongsTo'])) {
                    foreach ($associations['belongsTo'] as $alias => $details) {
                        if ($field === $details['foreignKey']) {
                            $isKey = true;
                            echo "\t\t\t\t<td><?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?></td>\n";
                            break;
                        }
                    }
                }
                if ($isKey !== true) {
					if (substr($field,0,3)=="is_") {
						if ($field == 'is_active') {
							$is_active = true;
							$label = array(
								'true' => 'ACTIVE',
								'false' => 'INACTIVE'
								);
						} else {
							$label = array(
								'true' => 'YES',
								'false' => 'NO'
								);
						}
						echo "\t\t\t\t<td>\n\t\t\t\t<?php if (\${$singularVar}['{$modelClass}']['{$field}']) { ?>\n\t\t\t\t\t<span class=\"label label-success\"><?php echo __('".$label['true']."'); ?></span>\n\t\t\t\t<?php } else { ?>\n\t\t\t\t\t<span class=\"label label-important\"><?php echo __('".$label['false']."'); ?></span>\n\t\t\t\t<?php } ?>\n\t\t\t\t</td>\n";
                    } else {
						if ($field == 'filesize') {
							echo "\t\t\t\t<td><?php echo \$this->Number->toReadableSize(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
						} else {
							echo "\t\t\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
						}
                    }
                }
            }

			echo "\t\t\t\t<td>\n";
				echo "\t\t\t\t\t<div class=\"btn-group\">\n";
					echo "\t\t\t\t\t\t<?php echo \$this->Html->link(\$this->BootstrapIcon->css('search','white').' '.__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-small btn-primary')); ?>\n";
					echo "\t\t\t\t\t\t<?php echo \$this->Html->link(\$this->BootstrapIcon->css('pencil').' '.__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-small btn-default')); ?>\n";
					if ($is_active) {
						echo "\t\t\t\t\t\t<?php if (\${$singularVar}['{$modelClass}']['is_active']) { ?>\n";
						echo "\t\t\t\t\t\t\t<?php echo \$this->Form->postLink(\$this->BootstrapIcon->css('remove','white').' '.__('Deactivate'), array('action' => 'deactivate', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-small btn-danger'), __('Are you sure you want to deactivate # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
						echo "\t\t\t\t\t\t<?php } else { ?>\n";
						echo "\t\t\t\t\t\t\t<?php echo \$this->Form->postLink(\$this->BootstrapIcon->css('ok','white').' '.__('Activate'), array('action' => 'activate', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-small btn-success'), __('Are you sure you want to activate # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
						echo "\t\t\t\t\t\t<?php } ?>\n";
					} else {
						echo "\t\t\t\t\t\t<?php echo \$this->Form->postLink(\$this->BootstrapIcon->css('trash','white').' '.__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-small btn-danger'), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
					}
				echo "\t\t\t\t\t</div>\n";
			echo "\t\t\t\t</td>\n";
        echo "\t\t\t</tr>\n";

        echo "\t\t\t<?php } ?>\n";
        ?>
        </table>
        <p>
		<?php echo "<?php
			echo \$this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
			));
		?>\n";?>
        </p>
        <div class="pagination pagination-centered">
            <ul>
            <?php
                echo "<?php\n";
                echo "\t\t\t\techo \$this->Paginator->prev('&larr; '.__('Previous', true), array('tag'=>'li','class'=>'prev', 'escape'=>false), '<a href=\"#\">&larr; '.__('Previous',true).'</a>', array('tag'=>'li','class'=>'prev disabled', 'escape'=>false));\n";
                echo "\t\t\t\techo \$this->Paginator->numbers(array('tag'=>'li','separator'=>'','disabled'=>'active'));\n";
                echo "\t\t\t\techo \$this->Paginator->next(__('Next', true).' &rarr;', array('tag'=>'li','class'=>'next','escape'=>false), '<a href=\"#\">'.__('Next',true).' &rarr;</a>', array('tag'=>'li','class' => 'next disabled', 'escape'=>false));\n";
                echo "\t\t\t?>\n";
            ?>
            </ul>
        </div>
    </div>
</div>