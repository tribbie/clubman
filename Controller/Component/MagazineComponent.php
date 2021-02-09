<?php

App::uses('Component', 'Controller');

class MagazineComponent extends Component {

	public function fetchMagazines($season) {
		if ($season == null) {
			$season = $this->currentSeason;
		}
		$magazines = array();
		//	Fetch the magazines
		$UploadModel = ClassRegistry::init('Upload');
		$UploadModel->create(false);
		$magazinesfields = array('Upload.category', 'Upload.id', 'Upload.name', 'Upload.stamp', 'Upload.location');
		$magazinesconditions = array('Upload.category' => 'magazine', 'Upload.season' => $season);
		$magazinesorder = array('Upload.stamp DESC', 'Upload.modified DESC');
		$magazines = $UploadModel->find('all', array('fields' => $magazinesfields, 'conditions' => $magazinesconditions, 'recursive' => 2, 'order' => $magazinesorder));
		return $magazines;
	}

	public function fetchLastMagazine($season) {
		if ($season == null) {
			$season = $this->currentSeason;
		}
		$magazines = array();
		//	Fetch the magazines
		$UploadModel = ClassRegistry::init('Upload');
		$UploadModel->create(false);
		$magazinesfields = array('Upload.category', 'Upload.id', 'Upload.name', 'Upload.stamp', 'Upload.location');
		$magazinesconditions = array('Upload.category' => 'magazine', 'Upload.season' => $season);
		$magazinesorder = array('Upload.stamp DESC', 'Upload.modified DESC');
		//$magazines = $UploadModel->find('all', array('fields' => $magazinesfields, 'conditions' => $magazinesconditions, 'limit' => 1, 'recursive' => 2, 'order' => array('Upload.name')));
		$magazines = $UploadModel->find('all', array('fields' => $magazinesfields, 'conditions' => $magazinesconditions, 'limit' => 1, 'recursive' => 2, 'order' => $magazinesorder));
		return $magazines;
	}

	public function fetchCampMagazines($season) {
		if ($season == null) {
			$season = $this->currentSeason;
		}
		$campmagazines = array();
		//	Fetch the magazines
		$UploadModel = ClassRegistry::init('Upload');
		$UploadModel->create(false);
		$campmagazinesfields = array('Upload.category', 'Upload.id', 'Upload.name', 'Upload.name', 'Upload.location');
		$campmagazinesconditions = array('Upload.category' => 'kamp', 'Upload.season' => $season);
		$campmagazines = $UploadModel->find('all', array('fields' => $campmagazinesfields, 'conditions' => $campmagazinesconditions, 'recursive' => 2, 'order' => array('Upload.created DESC')));
		return $campmagazines;
	}

}
