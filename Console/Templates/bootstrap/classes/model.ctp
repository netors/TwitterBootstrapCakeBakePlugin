<?php
echo "<?php\n";
echo "App::uses('{$plugin}AppModel', '{$pluginPath}Model');\n";
?>
/**
 * <?php echo $name ?> Model
 *
<?php
	foreach (array('hasOne', 'belongsTo', 'hasMany', 'hasAndBelongsToMany') as $assocType) {
		if (!empty($associations[$assocType])) {
			foreach ($associations[$assocType] as $relation) {
				echo " * @property {$relation['className']} \${$relation['alias']}\n";
			}
		}
	}
?>
 */
class <?php echo $name ?> extends <?php echo $plugin; ?>AppModel {
<?php if ($useDbConfig != 'default'): ?>

	/**
	 * Use database config
	 *
	 * @var string
	 */
	public $useDbConfig = '<?php echo $useDbConfig; ?>';
<?php endif;?>
<?php if ($useTable && $useTable !== Inflector::tableize($name)): ?>

    /**
     * Use table
     *
     * @var mixed False or table name
     */
<?php
	$table = "'$useTable'";
	echo "\tpublic \$useTable = $table;\n";
endif;
if ($primaryKey !== 'id'): ?>

	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = '<?php echo $primaryKey; ?>';
<?php endif;
if ($displayField): ?>

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = '<?php echo $displayField; ?>';
<?php endif;
// @todo: create a bootstrap cake bake, and have it ask for behaviors to make it more intelligent, for now, guess them!
$behaviors = array();
$fields = array_keys($validate);
$file = false;
if (in_array('filename',$fields)&&in_array('dir',$fields)&&in_array('mimetype',$fields)&&in_array('filesize',$fields)) {
	$file = true;
	$behaviors = array('MeioUpload','CakeAttachment');
	$meioUploadFields = array('filename');
	$cakeAttachmentFields = array('filename');
}

if (count($behaviors)):
	echo "\n\t/**\n\t * Behaviors\n\t *\n\t * @var array\n\t */\n";
	if (count($behaviors)==1) {
		echo "\tpublic \$actsAs = array(".$behaviors[0].");";
	} else {
		echo "\tpublic \$actsAs = array(\n";
		for ($i = 0, $len = count($behaviors); $i < $len; $i++):
			if (Inflector::camelize($behaviors[$i])=='MeioUpload') {
				echo "\t\t'" . Inflector::camelize($behaviors[$i]) . ".MeioUpload' => array(\n";
				foreach ($cakeAttachmentFields as $field) {
					echo "\t\t\t'".$field."' => array(\n";
					echo "\t\t\t\t//'dir' => 'uploads{DS}{model}{DS}{field}'\n";
					echo "\t\t\t\t'maxSize' => '10 Mb',\n";
					echo "\t\t\t\t'createDirectory' => true,\n";
					echo "\t\t\t\t'allowedMime' => array('image/jpeg', 'image/pjpeg', 'image/png','image/jpeg'),\n";
					echo "\t\t\t\t'allowedExt' => array('.jpg', '.jpeg', '.png', '.gif'),\n";
					echo "\t\t\t\t'thumbsizes' => array(\n";
					echo "\t\t\t\t\t'index' => array('width'=>110, 'height'=>70, 'zoomCrop' => true),\n";
					echo "\t\t\t\t),\n";
					echo "\t\t\t\t//'default' => 'default.jpg',\n";
					echo "\t\t\t),\n";
				}
				echo "\t\t),\n";
			} else if (Inflector::camelize($behaviors[$i])=='CakeAttachment') {
				echo "\t\t/*'" . Inflector::camelize($behaviors[$i]) . ".Upload' => array(\n";
					foreach ($cakeAttachmentFields as $field) {
						echo "\t\t\t'".$field."' => array(\n";
						echo "\t\t\t\t'uniqidAsFilenames' => true,\n";
						echo "\t\t\t\t'dir' => '{FILES}".$field."',\n";
						echo "\t\t\t\t'thumbsizes' => array(\n";
						echo "\t\t\t\t\t'index' => array('width'=>110, 'height'=>70, 'proportional' => false),\n";
						echo "\t\t\t\t),\n";
						echo "\t\t\t)\n";
					}
				echo "\t\t),*/\n";
				if ($i != $len - 1) echo ",\n";
			} else {
				if ($i != $len - 1):
					echo "\t\t'" . Inflector::camelize($behaviors[$i]) . "',\n";
				else:
					echo "\t\t'" . Inflector::camelize($behaviors[$i]) . "'\n";
				endif;
			}
		endfor;
		echo "\t);\n";
	}
endif;
if (!empty($validate)):
	echo "\n\t/**\n\t * Validation rules\n\t *\n\t * @var array\n\t */\n";
	echo "\tpublic \$validate = array(\n";
	foreach ($validate as $field => $validations):
		if ($file&&($field=='filename'||$field=='dir'||$field=='mimetype'||$field=='filesize')) continue;
		echo "\t\t'$field' => array(\n";
		foreach ($validations as $key => $validator):
			echo "\t\t\t'$key' => array(\n";
			echo "\t\t\t\t'rule' => array('$validator'),\n";
			echo "\t\t\t\t//'message' => 'Your custom message here',\n";
			echo "\t\t\t\t//'allowEmpty' => false,\n";
			echo "\t\t\t\t//'required' => false,\n";
			echo "\t\t\t\t//'last' => false, // Stop validation after this rule\n";
			echo "\t\t\t\t//'on' => 'create', // Limit validation to 'create' or 'update' operations\n";
			echo "\t\t\t),\n";
		endforeach;
		echo "\t\t),\n";
	endforeach;
	echo "\t);\n";
endif;

foreach ($associations as $assoc):
	if (!empty($assoc)):
		break;
	endif;
endforeach;

foreach (array('hasOne', 'belongsTo') as $assocType):
	if (!empty($associations[$assocType])):
		$typeCount = count($associations[$assocType]);
		echo "\n\t/**\n\t * $assocType associations\n\t *\n\t * @var array\n\t */";
		echo "\n\tpublic \$$assocType = array(";
		foreach ($associations[$assocType] as $i => $relation):
			$out = "\n\t\t'{$relation['alias']}' => array(\n";
			$out .= "\t\t\t'className' => '{$relation['className']}',\n";
			$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
			$out .= "\t\t\t'conditions' => '',\n";
			$out .= "\t\t\t'fields' => '',\n";
			$out .= "\t\t\t'order' => ''\n";
			$out .= "\t\t)";
			if ($i + 1 < $typeCount) {
				$out .= ",";
			}
			echo $out;
		endforeach;
		echo "\n\t);\n";
	endif;
endforeach;

if (!empty($associations['hasMany'])):
	$belongsToCount = count($associations['hasMany']);
	echo "\n\t/**\n\t * hasMany associations\n\t *\n\t * @var array\n\t */";
	echo "\n\tpublic \$hasMany = array(";
	foreach ($associations['hasMany'] as $i => $relation):
		$out = "\n\t\t'{$relation['alias']}' => array(\n";
		$out .= "\t\t\t'className' => '{$relation['className']}',\n";
		$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
		$out .= "\t\t\t'dependent' => false,\n";
		$out .= "\t\t\t'conditions' => '',\n";
		$out .= "\t\t\t'fields' => '',\n";
		$out .= "\t\t\t'order' => '',\n";
		$out .= "\t\t\t'limit' => '',\n";
		$out .= "\t\t\t'offset' => '',\n";
		$out .= "\t\t\t'exclusive' => '',\n";
		$out .= "\t\t\t'finderQuery' => '',\n";
		$out .= "\t\t\t'counterQuery' => ''\n";
		$out .= "\t\t)";
		if ($i + 1 < $belongsToCount) {
			$out .= ",";
		}
		echo $out;
	endforeach;
	echo "\n\t);\n\n";
endif;

if (!empty($associations['hasAndBelongsToMany'])):
	$habtmCount = count($associations['hasAndBelongsToMany']);
	echo "\n\t/**\n\t * hasAndBelongsToMany associations\n\t *\n\t * @var array\n\t */";
	echo "\n\tpublic \$hasAndBelongsToMany = array(";
	foreach ($associations['hasAndBelongsToMany'] as $i => $relation):
		$out = "\n\t\t'{$relation['alias']}' => array(\n";
		$out .= "\t\t\t'className' => '{$relation['className']}',\n";
		$out .= "\t\t\t'joinTable' => '{$relation['joinTable']}',\n";
		$out .= "\t\t\t'foreignKey' => '{$relation['foreignKey']}',\n";
		$out .= "\t\t\t'associationForeignKey' => '{$relation['associationForeignKey']}',\n";
		$out .= "\t\t\t'unique' => 'keepExisting',\n";
		$out .= "\t\t\t'conditions' => '',\n";
		$out .= "\t\t\t'fields' => '',\n";
		$out .= "\t\t\t'order' => '',\n";
		$out .= "\t\t\t'limit' => '',\n";
		$out .= "\t\t\t'offset' => '',\n";
		$out .= "\t\t\t'finderQuery' => '',\n";
		$out .= "\t\t\t'deleteQuery' => '',\n";
		$out .= "\t\t\t'insertQuery' => ''\n";
		$out .= "\t\t)";
		if ($i + 1 < $habtmCount) {
			$out .= ",";
		}
		echo $out;
	endforeach;
	echo "\n\t);\n\n";
endif;
?>
}