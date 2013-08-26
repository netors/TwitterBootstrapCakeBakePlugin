<?php echo "<?php\n"; ?>
<?php echo "/**\n"; ?>
<?php echo " * @var \$this View\n"; ?>
<?php echo " */\n"; ?>
<?php echo "?>\n"; ?>
<div class="page-header">
	<div class="btn-group pull-right">
<?php
    echo "\t\t<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-list-alt')).' '.__('List " . $pluralHumanName . "'), array('action' => 'index'), array('escape'=>false,'class'=>'btn btn-default btn-small visible-md visible-lg')); ?>\n";
    echo "\t\t<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil')).' '.__('Edit " . $singularHumanName ."'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false,'class'=>'btn btn-default btn-small visible-md visible-lg')); ?>\n";
    echo "\t\t<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-list-alt')), array('action' => 'index'), array('escape'=>false,'class'=>'btn btn-default btn-small visible-xs visible-sm')); ?>\n";
    echo "\t\t<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil')), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false,'class'=>'btn btn-default btn-small visible-xs visible-sm')); ?>\n";
	if (in_array('is_active',$fields)) {
		echo "\t\t<?php if (\${$singularVar}['{$modelClass}']['is_active']) { ?>\n";
        echo "\t\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-remove-sign')).' '.__('Deactivate'), array('action' => 'deactivate', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-small btn-danger visible-md visible-lg'), __('Are you sure you want to deactivate # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
        echo "\t\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-remove-sign')), array('action' => 'deactivate', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-small btn-danger visible-xs visible-sm'), __('Are you sure you want to deactivate # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "\t\t<?php } else { ?>\n";
        echo "\t\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-ok-sign')).' '.__('Activate'), array('action' => 'activate', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-small btn-success visible-md visible-lg'), __('Are you sure you want to activate # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
        echo "\t\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-ok-sign')), array('action' => 'activate', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false, 'class'=>'btn btn-small btn-success visible-xs visible-sm'), __('Are you sure you want to activate # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "\t\t<?php } ?>\n";
	} else {
        echo "\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')).' '.__('Delete " . $singularHumanName . "'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false,'class'=>'btn btn-danger btn-small visible-md visible-lg'), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
        echo "\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape'=>false,'class'=>'btn btn-danger btn-small visible-xs visible-sm'), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
	}
    echo "\t\t<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus-sign')).' '.__('New " . $singularHumanName . "'), array('action' => 'add'), array('escape'=>false,'class'=>'btn btn-primary btn-small visible-md visible-lg')); ?>\n";
    echo "\t\t<?php echo \$this->Html->link(\$this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus-sign')), array('action' => 'add'), array('escape'=>false,'class'=>'btn btn-primary btn-small visible-xs visible-sm')); ?>\n";
?>
	</div>
    <h1 class="visible-md visible-lg"><?php echo "<?php  echo __('{$singularHumanName}');?>";?> <small><?php echo "<?php echo __('{$pluralHumanName} Details');?>";?></small></h1>
    <h1 class="visible-xs visible-sm"><?php echo "<?php  echo __('{$singularHumanName}');?>";?></h1>
</div>
<div class="row">
	<div class="span12">
		<table class="table">
			<tbody>
<?php
					$skip_fields = array('id','hash','password');
					foreach ($fields as $field) {
						if (in_array($field,$skip_fields)) continue;
						echo "\t\t\t\t<tr>\n";
						$is_active = false;
						$isKey = false;
						if (!empty($associations['belongsTo'])) {
							foreach ($associations['belongsTo'] as $alias => $details) {
								if ($field === $details['foreignKey']) {
									$isKey = true;
									echo "\t\t\t\t\t<th class=\"span4\"><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></th>\n";
									echo "\t\t\t\t\t<td><?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>&nbsp;</td>\n";
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
								echo "\t\t\t\t\t<th class=\"span4\"><?php echo __('" . substr(Inflector::humanize($field),3,strlen($field)) . "');?></th>\n";
								echo "\t\t\t\t\t<td>\n\t\t\t\t\t\t<?php if (\${$singularVar}['{$modelClass}']['{$field}']) { ?>\n\t\t\t\t\t\t\t<span class=\"label label-success\"><?php echo __('".$label['true']."'); ?></span>\n\t\t\t\t\t\t<?php } else { ?>\n\t\t\t\t\t\t\t<span class=\"label label-important\"><?php echo __('".$label['false']."'); ?></span>\n\t\t\t\t\t\t<?php } ?>\n\t\t\t\t\t</td>\n";
							} else if ($field === "created"||$field === "modified"||$field === "updated") {
								echo "\t\t\t\t\t<th class=\"span4\"><?php echo __('" . Inflector::humanize($field) . "');?></th>\n";
								echo "\t\t\t\t\t<td><?php echo \$this->Time->format('m/d/Y g:ia', \${$singularVar}['{$modelClass}']['{$field}']);?>&nbsp;</td>\n";
							} else {
								echo "\t\t\t\t\t<th class=\"span4\"><?php echo __('" . Inflector::humanize($field) . "');?></th>\n";
								echo "\t\t\t\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']);?>&nbsp;</td>\n";
							}
						}
						echo "\t\t\t\t</tr>\n";
					}
?>
			</tbody>
        </table>
    </div>
</div>
<?php
if (!empty($associations['hasOne'])) :
    foreach ($associations['hasOne'] as $alias => $details): ?>
<div class="row">
    <div class="span12">
		<?php echo "<?php echo \$this->Html->link(__('Edit " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('class'=>'btn btn-small btn-default pull-right','escape'=>false)); ?>\n";?>
        <h3><?php echo "<?php echo __('" . Inflector::humanize($details['controller']) . "');?>";?></h3>
        <?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])):?>\n";?>
        <table class="table">
			<tbody>
<?php
				$skip_fields = array('id','hash','password','created','modified','updated');
				$foreignKey = strtolower($singularHumanName).'_id';
				foreach ($details['fields'] as $field) {
					$is_active = false;
					if (in_array($field,$skip_fields)||$field===$foreignKey) continue;
					echo "\t\t\t\t<tr>\n";
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
						echo "\t\t\t\t\t<th class=\"span4\"><?php echo __('" . substr(Inflector::humanize($field),3,strlen($field)) . "');?></th>\n";
						echo "\t\t\t\t\t<td>\n\t\t\t\t\t\t<?php if (\${$singularVar}['{$modelClass}']['{$field}']) { ?>\n\t\t\t\t\t\t\t<span class=\"label label-success\"><?php echo __('".$label['true']."'); ?></span>\n\t\t\t\t\t\t<?php } else { ?>\n\t\t\t\t\t\t\t<span class=\"label label-important\"><?php echo __('".$label['false']."'); ?></span>\n\t\t\t\t\t\t<?php } ?>\n\t\t\t\t\t</td>\n";
					} else if ($field === "created"||$field === "modified"||$field === "updated") {
						echo "\t\t\t\t\t<th class=\"span4\"><?php echo __('" . Inflector::humanize($field) . "');?></th>\n";
						echo "\t\t\t\t\t<td><?php echo \$this->Time->format('m/d/Y g:ia', \${$singularVar}['{$alias}']['{$field}']);?>&nbsp;</td>\n";
					} else {
						echo "\t\t\t\t\t<th class=\"span4\"><?php echo __('" . Inflector::humanize($field) . "');?></th>\n";
						echo "\t\t\t\t\t<td><?php echo h(\${$singularVar}['{$alias}']['{$field}']);?>&nbsp;</td>\n";
					}
					echo "\t\t\t\t</tr>\n";
				}
?>
			</tbody>
        </table>
        <?php echo "<?php endif; ?>\n";?>
    </div>
</div>
<?php
    endforeach;
endif;
if (empty($associations['hasMany'])) {
    $associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
    $associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $alias => $details):
    $otherSingularVar = Inflector::variable($alias);
    $otherPluralHumanName = Inflector::humanize($details['controller']);
?>
<div class="row">
    <div class="span12">
		<?php echo "<?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class'=>'btn btn-small btn-primary pull-right','escape'=>false));?>\n";?>
        <h3><?php echo "<?php echo __('" . $otherPluralHumanName . "');?>";?></h3>
        <?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])):?>\n";?>
        <table cellpatding="0" cellspacing="0" class="table table-striped">
            <tr>
<?php
			$skip_fields = array('id','hash','password','created','modified','updated');
			$foreignKey = strtolower($singularHumanName).'_id';
			foreach ($details['fields'] as $field) {
				if (in_array($field,$skip_fields)||$field===$foreignKey) continue;
				echo "\t\t\t\t<th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
            }
?>
                <th class="span3"><?php echo "<?php echo __('Actions');?>";?></th>
            </tr>
<?php
echo "\t\t\t<?php
        \$i = 0;
        foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}): ?>\n";
        echo "\t\t\t<tr>\n";
            foreach ($details['fields'] as $field) {
				$is_active = false;
				if (in_array($field,$skip_fields)||$field===$foreignKey) continue;
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
					echo "\t\t\t\t<td>\n\t\t\t\t<?php if (\${$otherSingularVar}['{$field}']) { ?>\n\t\t\t\t\t<span class=\"label label-success\"><?php echo __('".$label['true']."'); ?></span>\n\t\t\t\t<?php } else { ?>\n\t\t\t\t\t<span class=\"label label-important\"><?php echo __('".$label['false']."'); ?></span>\n\t\t\t\t<?php } ?>\n\t\t\t\t</td>\n";
				} else {
                    echo "\t\t\t\t<td><?php echo \${$otherSingularVar}['{$field}'];?></td>\n";
                }
            }

			echo "\t\t\t\t<td>\n";
				echo "\t\t\t\t\t<div class=\"btn-group\">\n";
					echo "\t\t\t\t\t\t<?php echo \$this->Html->link(__('View'), array('controller' => '{$details['controller']}', 'action' => 'view', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape'=>false, 'class'=>'btn btn-small btn-primary')); ?>\n";
					echo "\t\t\t\t\t\t<?php echo \$this->Html->link(__('Edit'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape'=>false, 'class'=>'btn btn-small btn-default')); ?>\n";
					if ($is_active) {
						echo "\t\t\t\t\t\t<?php if (\${$otherSingularVar}['is_active']) { ?>\n";
						echo "\t\t\t\t\t\t\t<?php echo \$this->Form->postLink(__('Deactivate'), array('controller' => '{$details['controller']}', 'action' => 'deactivate', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape'=>false, 'class'=>'btn btn-small btn-danger'), __('Are you sure you want to deactivate # %s?', \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
						echo "\t\t\t\t\t\t<?php } else { ?>\n";
						echo "\t\t\t\t\t\t\t<?php echo \$this->Form->postLink(__('Activate'), array('controller' => '{$details['controller']}', 'action' => 'activate', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape'=>false, 'class'=>'btn btn-small btn-success'), __('Are you sure you want to activate # %s?', \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
						echo "\t\t\t\t\t\t<?php } ?>\n";
					} else {
						echo "\t\t\t\t\t\t<?php echo \$this->Form->postLink(__('Delete'), array('controller' => '{$details['controller']}', 'action' => 'delete', \${$otherSingularVar}['{$details['primaryKey']}']), array('escape'=>false, 'class'=>'btn btn-small btn-danger'), __('Are you sure you want to delete # %s?', \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
					}
				echo "\t\t\t\t\t</div>\n";
			echo "\t\t\t\t</td>\n";
        echo "\t\t\t</tr>\n";

echo "\t\t<?php endforeach; ?>\n";
?>
        </table>
<?php echo "\t\t<?php endif; ?>\n";?>
    </div>
</div>
<?php endforeach;?>