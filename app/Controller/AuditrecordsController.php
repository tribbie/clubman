<?php
class AuditrecordsController extends AppController {

	// var $scaffold;

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function index() {
		$fields = array('username', 'COUNT(id) as akties', 'MAX(created) as recentste');
		$conditions = array('Auditrecord.id >' => 0);
		$group = 'Auditrecord.username';
		$order = array('recentste DESC');
		$records = $this->Auditrecord->find('all', array('fields' => $fields, 'group' => $group, 'conditions' => $conditions, 'order' => $order));
		$this->set('records', $records);
	}

	public function listing($username = null) {
		$fields = array(
			'id', 'userid', 'username', 'userrole', 'action', 'model', 'modelid', 'userip', 'created'
		);
		$conditions = array('Auditrecord.username' => $username);
		$order = array('Auditrecord.created DESC');
		$records = $this->Auditrecord->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order));
		$this->set('records', $records);
		$this->set('filter', array('username' => $username));
	}

	public function listaction($action = 'login', $model = 'all') {
		$fields = array(
			'id', 'userid', 'username', 'userrole', 'action', 'model', 'modelid', 'userip', 'created'
		);
		$conditions = array('Auditrecord.action' => $action);
		if ($model <> 'all') {
			$conditions['Auditrecord.model'] = $model;
		}
		$order = array('Auditrecord.created DESC');
		$records = $this->Auditrecord->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order));
		$this->set('records', $records);
		$this->set('filter', array('action' => $action, 'model' => $model));
	}

	public function list() {
		$model = '';
		$action = '';
		$fields = array(
			'id', 'userid', 'username', 'userrole', 'action', 'model', 'modelid', 'userip', 'created'
		);
		$conditions = array();
		if (isset($this->params['named']['m'])) {
			$model = $this->params['named']['m'];
			$conditions['Auditrecord.model'] = $model;
		}
		if (isset($this->params['named']['a'])) {
			$action = $this->params['named']['a'];
			$conditions['Auditrecord.action'] = $action;
		}
		$order = array('Auditrecord.created DESC');
		$records = $this->Auditrecord->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order));
		$this->set('records', $records);
		$this->set('filter', array('model' => $model, 'action' => $action));
	}

	public function view($id = null) {
		$this->Auditrecord->id = $id;
		$this->set('record', $this->Auditrecord->read());
	}

}
