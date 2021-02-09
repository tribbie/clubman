<?php
class TrainingmomentsController extends AppController {

	// var $scaffold;
	public $helpers = array('Link');

	public function index() {
		$this->Trainingmoment->recursive = 1;
		$this->set('trainingmoments', $this->Trainingmoment->find('all', array('order' => array('Trainingmoment.weekday' => 'ASC', 'Trainingmoment.start_time' => 'ASC'))));
	}

	public function add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Trainingmoment->save($this->request->data)) {
				$this->Session->setFlash(__('Het trainingsmoment werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'trainingmoment', $this->Trainingmoment->id);
				$this->redirect(array('controller' => 'trainingmoments', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het trainingsmoment kon niet worden bewaard.'), "flash-error");
			}
		}
	}

	public function edit($id = null) {
		$this->Trainingmoment->id = $id;
		if (!$this->Trainingmoment->exists()) {
			throw new NotFoundException(__('Dit trainingsmoment bestaat niet.'));
		}
		$trainingmoment = $this->Trainingmoment->read(null, $id);
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Trainingmoment->save($this->request->data)) {
				$this->Session->setFlash(__('Het trainingsmoment werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'training', $id);
				$this->redirect(array('controller' => 'trainingmoments', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het trainingsmoment kon niet worden bewaard.'), "flash-error");
			}
		} else {
			$this->request->data = $trainingmoment;
//			$this->set('trainingmoment', $trainingmoment);
		}
	}


}
