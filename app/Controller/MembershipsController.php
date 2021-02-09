<?php
class MembershipsController extends AppController {

	// var $scaffold;

	public $components = array('RequestHandler');


	public function index() {
		//$this->Membership->recursive = -1;
		$this->Membership->Behaviors->load('Containable');
		$fields = array('id', 'person_id', 'licensenumber', 'active');
		$contain = array(
									'Person' => array('fields' => array('id', 'lastname', 'firstname', 'uniquenumber'), 'order' => array('Person.lastname', 'Person.firstname'))
							);
		$this->Membership->contain($contain);
		//$conditions = array('Membership.id <' => '20');
		$conditions = array('Membership.id >' => '0');
		$this->set('memberships', $this->Membership->find('all', array('fields' => $fields, 'conditions' => $conditions)));
	}


	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Ongeldig lid', true), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
		$this->Membership->id = $id;
		if (!$this->Membership->exists()) {
			$this->Session->setFlash(__('Lid bestaat niet', true), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
		//$this->Membership->recursive = 4;
		$fields = array('id', 'person_id', 'picturelicense_id', 'licensenumber', 'active', 'remark');
		$this->Membership->Behaviors->load('Containable');
		$contain = array(
				'Person' => array(
					'fields' => array('id', 'picture_id', 'contactaddress_id', 'lastname', 'firstname', 'uniquenumber', 'nickname', 'gender', 'birthdate', 'status', 'email', 'mobile', 'remark', 'metadata'),
					//'conditions' => array('gender' => 'female'),
					'Picture' => array(
						'fields' => array('id', 'location')
					),
					'Contactaddress' => array(
						'fields' => array('id', 'address', 'postcode', 'city', 'remark', 'metadata')
					),
					'Dad' => array(
						'fields' => array('id', 'person_id', 'parent_id', 'type'),
						'Parent' => array(
							'fields' => array('id', 'picture_id', 'contactaddress_id', 'lastname', 'firstname', 'nickname', 'gender', 'birthdate', 'status', 'email', 'mobile', 'remark', 'metadata'),
							//'conditions' => array('gender' => 'female'),
							'Picture' => array(
								'fields' => array('id', 'location')
							),
							'Contactaddress' => array(
								'fields' => array('id', 'address', 'postcode', 'city', 'remark', 'metadata')
							)
						)
					),
					'Mom' => array(
						'fields' => array('id', 'person_id', 'parent_id', 'type'),
						'Parent' => array(
							'fields' => array('id', 'picture_id', 'contactaddress_id', 'lastname', 'firstname', 'nickname', 'gender', 'birthdate', 'status', 'email', 'mobile', 'remark', 'metadata'),
							//'conditions' => array('gender' => 'female'),
							'Picture' => array(
								'fields' => array('id', 'location')
							),
							'Contactaddress' => array(
								'fields' => array('id', 'address', 'postcode', 'city', 'remark', 'metadata')
							),
						)
					)
				)
		);
		$this->Membership->contain($contain);

		$this->set('membership', $this->Membership->read());
	}


	/// This is the new add method for the newly migrated members
	public function add() {
		$membershipdata = array();
		if ($this->request->is('post') || $this->request->is('put')) {
			//$this->Membership->create();
			//if ($this->Membership->save($this->request->data)) {
			//	$this->Session->setFlash(__('Het lid werd bewaard.'), 'flash-info');
			//	parent::logAction(__FUNCTION__, 'membership', $this->Membership->id);
			//	$this->redirect(array('action' => 'view', $this->Membership->id));
			//} else {
			//	$this->Session->setFlash(__('Het lid kon niet worden bewaard.'), 'flash-error');
			//}
			$membershipdata = $this->request->data;
		}
		$this->set('membershipdata', $membershipdata);
	}


	public function ajlookupperson() {
		$this->autoRender = false; // We don't render a view in this example
		//$this->request->onlyAllow('ajax'); // No direct access via browser URL

		$response = array();
		$error = array();
		$persons = array();
		$data = array();

		$this->loadModel('Person');
		if (isset($this->request->query['lastname']) and isset($this->request->query['firstname'])) {
			$this->Person->Behaviors->load('Containable');
			$contain = array(
				//'Picture' => array('fields' => array('id', 'location')),
				//'Contactaddress' => array('fields' => array('id', 'address', 'postcode', 'city')),
				'Membership' => array('fields' => array('id', 'person_id', 'active'))
			);
			$this->Person->contain($contain);
			$fields = array('id', 'contactaddress_id', 'lastname', 'firstname', 'uniquenumber', 'nickname');
			$conditions = array(
											'Person.lastname LIKE' => '%' . trim($this->request->query['lastname'] . '%'),
											'Person.firstname LIKE' => '%' . trim($this->request->query['firstname'] . '%'),
											// 'OR' => array(
											// 	'Membership.person_id' => null,
											// 	'Membership.active' => false
											// )
										);
			$persons = $this->Person->find('all', array('fields' => $fields, 'conditions' => $conditions));
		} else {
			$response['error'][] = array('status' => 400, 'detail' => "invalid url");
		}

		$request = $this->request;
		$response['meta'] = array('request' => $request, 'cakedata' => array('persons' => $persons));
		return json_encode($response);
	}


	public function ajfetchperson() {
		$this->autoRender = false; // We don't render a view in this example
		//$this->request->onlyAllow('ajax'); // No direct access via browser URL

		$response = array();
		$error = array();
		$person = array();
		$data = array();

		$this->loadModel('Person');
		if (isset($this->request->query['id'])) {
			$id = $this->request->query['id'];
			$this->Person->id = $id;
			if (!$this->Person->exists()) {
				$response['error'][] = array('status' => '404', 'detail' => "person $id does not exist");
			} else {
				$this->Person->Behaviors->load('Containable');
				$contain = array(
											'Personparent' => array(
												'fields' => array('id', 'person_id', 'parent_id', 'type'),
												'Parent' => array(
													'fields' => array('id', 'lastname', 'firstname'),
													'Contactaddress' => array(
														'fields' => array('id', 'address', 'postcode', 'city', 'countrycode', 'landline')
													)
												)
											),
											'Contactaddress' => array(
												'fields' => array('id', 'address', 'postcode', 'city', 'countrycode', 'landline')
											),
											'Picture' => array(
												'fields' => array('id', 'season', 'location', 'stamp')
											),
											'Membership' => array(
												'fields' => array('id', 'person_id', 'licensenumber', 'active')
											)
							    );
				$this->Person->contain($contain);
				$fields = array('id', 'picture_id', 'contactaddress_id', 'lastname', 'firstname', 'uniquenumber', 'nickname', 'gender', 'birthdate', 'status', 'email', 'mobile', 'remark', 'metadata');
				$person = $this->Person->read($fields);
				if (!$person) {
					$response['error'][] = array('status' => 404, 'detail' => "person $id is invalid");
				}
			 	else {
				}
			}
		}
		else {
			$response['error'][] = array('status' => 400, 'detail' => "invalid url");
		}

		$request = $this->request;
		$response['meta'] = array('request' => $request, 'cakedata' => array('person' => $person));
		return json_encode($response);

	}


	public function ajsavemembership() {
		/// We don't render a view in this example
		$this->autoRender = false;
		/// No direct access via browser URL
		$this->request->onlyAllow('ajax');
		$response = array();
		$saveResult = array();
		$membership = array();
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Membership->saveAssociated($this->request->data)) {
				$saveResult = array('status' => '200', 'detail' => 'Membership and associations successfully saved');
				parent::logAction(__FUNCTION__, 'membership', $this->Membership->id);
			} else {
				$saveResult = array('status' => '404', 'detail' => 'Error: Membership and associations not successfully saved');
			}
		}
		$this->Membership->Behaviors->load('Containable');
		$contain = array(
									'Person' => array(
										'fields' => array('id', 'firstname', 'lastname', 'uniquenumber', 'nickname', 'birthdate', 'email', 'mobile'),
										'Contactaddress' => array(
											'fields' => array('id', 'address', 'street', 'streetnumber', 'streetnumbersuffix', 'postcode', 'city', 'countrycode', 'landline')
										),
									),
							);
		$this->Membership->contain($contain);
		$fields = array('id', 'person_id', 'active', 'licensenumber', 'remark');
		$membership = $this->Membership->read($fields);
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('member' => $membership),
			 						'result' => $saveResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}


	public function notused__ajlookupaddress() {
		$this->autoRender = false; // We don't render a view in this example
		//$this->request->onlyAllow('ajax'); // No direct access via browser URL

		$response = array();
		$error = array();
		$addresses = array();
		$data = array();

		$this->loadModel('Contactaddress');
		if (isset($this->request->query['address'])) {
			// $this->Contactaddress->Behaviors->load('Containable');
			// $contain = array(
			// 	'Picture' => array('fields' => array('id', 'location')),
			// 	'Contactaddress' => array('fields' => array('id', 'address', 'postcode', 'city')),
			// 	'Membership' => array('fields' => array('person_id', 'active'))
			// );
			// $this->Contactaddress->contain($contain);
			$fields = array('id', 'address', 'postcode', 'city', 'landline');
			$conditions = array(
											'Contactaddress.address LIKE' => '%' . trim($this->request->query['address'] . '%'),
										);
			$addresses = $this->Contactaddress->find('all', array('fields' => $fields, 'conditions' => $conditions));
		} else {
			$response['error'][] = array('status' => 400, 'detail' => "invalid url");
		}

		$request = $this->request;
		$response['meta'] = array('request' => $request, 'cakedata' => array('addresses' => $addresses));
		return json_encode($response);
	}


	public function ajlookupstreet() {
		$this->autoRender = false; // We don't render a view in this example
		//$this->request->onlyAllow('ajax'); // No direct access via browser URL

		$response = array();
		$error = array();
		$listAllStreets = array();
		$streets = array();
		$uniqueStreets = array();
		$data = array();

		$this->loadModel('Contactaddress');
		if (isset($this->request->query['street'])) {
			$fields = array('DISTINCT Contactaddress.street as uniquestreet');
			$conditions = array('street LIKE' => '%' . trim($this->request->query['street'] . '%'));
			$listAllStreets = $this->Contactaddress->find('list', array('fields' => 'street', 'conditions' => $conditions));
			$streets = $this->Contactaddress->find('all', array('fields' => $fields, 'conditions' => $conditions));
			$uniqueStreets = Hash::combine($streets, '{n}.Contactaddress.uniquestreet', '{n}.Contactaddress.uniquestreet');
			//$uniqueStreets = $streets;
		} else {
			$response['error'][] = array('status' => 400, 'detail' => "invalid url");
		}

		$request = $this->request;
		$response['meta'] = array('request' => $request, 'cakedata' => array('uniqueStreets' => $uniqueStreets, 'streets' => $streets, 'listAllStreets' => $listAllStreets));
		return json_encode($response);
	}


	public function ajsavemembershipcontactaddress() {
		/// We don't render a view in this example
		$this->autoRender = false;
		/// No direct access via browser URL
		$this->request->onlyAllow('ajax');
		$response = array();
		$saveResult = array();
		$membership = array();
		$contactaddressId = 0;

		$membershipId = $this->request->data['MembershipContactaddress']['membership_id'];;
		$personData = array();
		$personData['Person']['id'] = $this->request->data['MembershipContactaddress']['person_id'];
		$foundContactaddress = array();

		if ($this->request->is('post') || $this->request->is('put')) {
			$foundContactaddress = $this->lookupContactaddress($this->request->data['Contactaddress']);
			if ( $foundContactaddress['id'] == 0 ) {
				$this->loadModel('Contactaddress');
				if ($this->Contactaddress->save($this->request->data['Contactaddress'])) {
					$saveResult = array('status' => '200', 'detail' => 'Contactaddress successfully saved');
					parent::logAction(__FUNCTION__, 'contactaddress', $this->Contactaddress->id);
				} else {
					$saveResult = array('status' => '404', 'detail' => 'Error: Contactaddress not successfully saved');
				}
				$contactaddressId = $this->Contactaddress->id;
			} else {
				/// If the newly entered contactaddress has additional fileds filled in,
				/// we need to update the existing contactaddress
				$contactaddressId = $foundContactaddress['id'];
			}
		}
		$personData['Person']['contactaddress_id'] = $contactaddressId;
		$this->loadModel('Person');
		if ($this->Person->save($personData)) {
			$saveResult = array('status' => '200', 'detail' => 'Contactaddress into Person successfully saved');
			parent::logAction(__FUNCTION__, 'person', $personData['Person']['id']);
		} else {
			$saveResult = array('status' => '404', 'detail' => 'Error: Contactaddress into Person not successfully saved');
		}
		$this->Membership->Behaviors->load('Containable');
		$contain = array(
									'Person' => array(
										'fields' => array('id', 'firstname', 'lastname', 'uniquenumber', 'nickname', 'birthdate', 'email', 'mobile'),
										'Contactaddress' => array(
											'fields' => array('id', 'address', 'street', 'streetnumber', 'streetnumbersuffix', 'postcode', 'city', 'countrycode', 'landline')
										),
									),
							);
		$this->Membership->contain($contain);
		$fields = array('id', 'person_id', 'active', 'licensenumber', 'remark');
		$membership = $this->Membership->read($fields, $membershipId);
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('member' => $membership),
			 						'result' => $saveResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}


	private function lookupContactaddress($contactaddressData) {
		$foundContactaddressId = 0;
		$foundContactaddress = array();
		$this->loadModel('Contactaddress');
		$conditions = array(
										'street' => $contactaddressData['street'],
										'streetnumber' => $contactaddressData['streetnumber'],
										'streetnumbersuffix' => $contactaddressData['streetnumbersuffix'],
										'postcode' => $contactaddressData['postcode'],
										'city' => $contactaddressData['city']
									);
		$foundContactaddress = $this->Contactaddress->find('first', array('conditions' => $conditions));
		if (empty($foundContactaddress)) {
			$foundContactaddress['id'] = 0;
		}
		return $foundContactaddress;
	}


}
