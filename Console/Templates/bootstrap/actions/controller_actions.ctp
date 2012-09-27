	/**
	 * <?php echo $admin ?>index method
	 *
	 * @return void
	 */
	public function <?php echo $admin ?>index() {
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$<?php echo $pluralName ?> = $this->paginate();
		$this->set(compact('<?php echo $pluralName ?>'));
	}

	/**
	 * <?php echo $admin ?>view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function <?php echo $admin ?>view($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		$conditions = array('<?php echo $currentModelName; ?>.id' => $id);
		$<?php echo $singularName; ?> = $this-><?php echo $currentModelName; ?>->find('first', compact('conditions'));
		$this->set(compact('<?php echo $singularName; ?>'));
	}

<?php $compact = array(); ?>
	/**
	 * <?php echo $admin ?>add method
	 *
	 * @return void
	 */
	public function <?php echo $admin ?>add() {
		if ($this->request->is('post')) {
			$this-><?php echo $currentModelName; ?>->create();
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved'),'Flash/success');
				$this->redirect(array('action'=>'index'));
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($currentModelName)); ?> saved.'), array('action' => 'index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'),'Flash/error');
<?php endif; ?>
			}
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
	foreach ($modelObj->{$assoc} as $associationName => $relation):
		if (!empty($associationName)):
			$otherModelName = $this->_modelName($associationName);
			$otherPluralName = $this->_pluralName($associationName);
			echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
			$compact[] = "'{$otherPluralName}'";
		endif;
	endforeach;
	endforeach;
	if (!empty($compact)):
	echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	}

<?php $compact = array(); ?>
	/**
	 * <?php echo $admin ?>edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function <?php echo $admin; ?>edit($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved'),'Flash/success');
                $this->redirect(array('action'=>'index'));
<?php else: ?>
				$this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), array('action' => 'index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'),'Flash/error');
<?php endif; ?>
			}
		} else {
			$this->request->data = $this-><?php echo $currentModelName; ?>->read(null, $id);
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	}

	/**
	 * <?php echo $admin ?>delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function <?php echo $admin; ?>delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		if ($this-><?php echo $currentModelName; ?>->delete()) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted'),'Flash/success');
			$this->redirect(array('action' => 'index'));
<?php else: ?>
			$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted'), array('action' => 'index'));
<?php endif; ?>
		}
<?php if ($wannaUseSession): ?>
		$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted'),'Flash/error');
<?php else: ?>
		$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted'), array('action' => 'index'));
<?php endif; ?>
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * <?php echo $admin ?>deactivate method
	 *
	 * @param string $id
	 * @return void
	 */
	public function <?php echo $admin ?>deactivate($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid <?php echo ucfirst(strtolower($singularHumanName)); ?>'));
		}
		if ($this-><?php echo $currentModelName; ?>->updateAll(array('is_active'=>0),array('<?php echo $currentModelName; ?>.id'=>$id))) {
			$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deactivated'),'Flash/success');
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deactivated'),'Flash/error');
		$this->redirect($this->referer());
	}

	/**
	 * <?php echo $admin ?>activate method
	 *
	 * @param string $id
	 * @return void
	 */
	public function <?php echo $admin ?>activate($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid <?php echo ucfirst(strtolower($singularHumanName)); ?>'));
		}
		if ($this-><?php echo $currentModelName; ?>->updateAll(array('is_active'=>1),array('<?php echo $currentModelName; ?>.id'=>$id))) {
			$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> activated'),'Flash/success');
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not activated'),'Flash/error');
		$this->redirect($this->referer());
	}