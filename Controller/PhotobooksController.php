<?php
class PhotobooksController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
		//$this->Auth->deny('index');
	}

	public function index() {
		//$photobooks = $this->Photobook->findalbums('last', 2);
		$photobooks = $this->Photobook->findalbums('all');
		$this->set('files', $photobooks['files']);
		$this->set('photobooks', $photobooks['data']);
	}

}
