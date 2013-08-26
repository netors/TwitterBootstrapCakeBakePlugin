<?php echo "<?php\n"; ?>
<?php echo "/**\n"; ?>
<?php echo " * @var \$this View\n"; ?>
<?php echo " */\n"; ?>
<?php echo "?>\n"; ?>
<div class="page-header">
    <div class="btn-group pull-right">
        <?php echo "<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus-sign')).' '.__('New " . $singularHumanName . "'), array('action' => 'add'), array('class'=>'btn btn-primary visible-md visible-lg','escape'=>false)); ?>\n";?>
        <?php echo "<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus-sign')), array('action' => 'add'), array('class'=>'btn btn-primary visible-xs visible-sm','escape'=>false)); ?>\n";?>
    </div>
    <h1 class="visible-md visible-lg"><?php echo "<?php echo __('{$pluralHumanName}');?>";?> <small><?php echo "<?php echo __('List of {$pluralHumanName}');?>";?></small></h1>
    <h1 class="visible-xs visible-sm"><?php echo "<?php echo __('{$pluralHumanName}');?>";?></h1>
</div>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
<?php $skip_fields = array('id','hash','password','created','modified','updated','lft','rght'); ?>
<?php
	if (in_array('filename',$fields)&&in_array('dir',$fields)&&in_array('mimetype',$fields)&&in_array('filesize',$fields)) {
		$filefields = array('dir','mimetype');
		$skip_fields = array_merge($skip_fields,$filefields);
	}
?>
<?php $is_active = false; ?>
<?php foreach ($fields as $field) { ?>
<?php if (in_array($field,$skip_fields)) continue; ?>
<?php if (substr($field,0,3)=="is_") { ?>
                <th><?php echo "<?php echo \$this->Paginator->sort('{$field}',__('".Inflector::humanize((substr($field,3,strlen($field))))."'));?>";?></th>
<?php } else { ?>
                <th><?php echo "<?php echo \$this->Paginator->sort('{$field}');?>";?></th>
<?php } ?>
<?php } ?>
                <th class="col-md-2"><?php echo "<?php echo __('Actions');?>";?></th>
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
						echo "\t\t\t\t<td class=\"col-md-1\">\n";
                        echo "\t\t\t\t<?php if (\${$singularVar}['{$modelClass}']['{$field}']) { ?>\n";
                        echo "\t\t\t\t\t<?php echo \$this->Html->tag('span',__('".$label['true']."'),array('class'=>'label label-success visible-md visible-lg')); ?>\n";
                        echo "\t\t\t\t\t<?php echo \$this->Html->tag('span',\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-ok-sign')),array('class'=>'label label-success visible-xs visible-sm')); ?>\n";
                        echo "\t\t\t\t<?php } else { ?>\n";
                        echo "\t\t\t\t\t<?php echo \$this->Html->tag('span',__('".$label['false']."'),array('class'=>'label label-danger visible-md visible-lg')); ?>\n";
                        echo "\t\t\t\t\t<?php echo \$this->Html->tag('span',\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-remove-sign')),array('class'=>'label label-danger visible-xs visible-sm')); ?>\n";
                        echo "\t\t\t\t<?php } ?>";
                        echo "\n\t\t\t\t</td>\n";
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
                    echo "\t\t\t\t\t\t<?php echo \$this->Html->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-sm btn-primary visible-md visible-lg')); ?>\n";
                    echo "\t\t\t\t\t\t<?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-sm btn-default visible-md visible-lg')); ?>\n";
                    echo "\t\t\t\t\t\t<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-search')), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-sm btn-primary visible-xs visible-sm')); ?>\n";
                    echo "\t\t\t\t\t\t<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil')), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-sm btn-default visible-xs visible-sm')); ?>\n";
					if ($is_active) {
						echo "\t\t\t\t\t\t<?php if (\${$singularVar}['{$modelClass}']['is_active']) { ?>\n";
                        echo "\t\t\t\t\t\t\t<?php echo \$this->Form->postLink(__('Deactivate'), array('action' => 'deactivate', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-sm btn-danger visible-md visible-lg'), __('Are you sure you want to deactivate # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
                        echo "\t\t\t\t\t\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-remove-sign')), array('action' => 'deactivate', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-sm btn-danger visible-xs visible-sm'), __('Are you sure you want to deactivate # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
						echo "\t\t\t\t\t\t<?php } else { ?>\n";
                        echo "\t\t\t\t\t\t\t<?php echo \$this->Form->postLink(__('Activate'), array('action' => 'activate', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-sm btn-success visible-md visible-lg'), __('Are you sure you want to activate # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
                        echo "\t\t\t\t\t\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-ok-sign')), array('action' => 'activate', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-sm btn-success visible-xs visible-sm'), __('Are you sure you want to activate # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
						echo "\t\t\t\t\t\t<?php } ?>\n";
					} else {
						echo "\t\t\t\t\t\t<?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-sm btn-danger visible-md visible-lg'), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
                        echo "\t\t\t\t\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-sm btn-danger visible-xs visible-sm'), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
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
        <?php echo "<?php echo \$this->Paginator->pagination(array('ul' => 'pagination')); ?>\n"; ?>