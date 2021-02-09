<?php
class MigratemembersController extends AppController {

	//var $scaffold;

	public $components = array('RequestHandler');

	/// Some members
	//var $theMembers = array('Migratemember.id' => array(6,95,97,99,101,102,104));
	//var $theMembers = array('Migratemember.id' => array(17,89,91,97,99,101));
	//var $theMembers = array('Migratemember.id' => array(22,112));
	/// Get a bunch
	//var $theMembers = array('Migratemember.id <' => 100);
	/// Fam Seghers
	//var $theMembers = array('Migratemember.id' => array(22,112,127,172));
	/// Fam Seghers + some Peeters + Zanon
	//var $theMembers = array('Migratemember.id' => array(22,112,127,172,19,157,409,453));
	/// Get the active ones
	//var $theMembers = array('Migratemember.active' => true);
	/// Get them all
	var $theMembers = array('Migratemember.id >' => 0);

	public function index() {
		$this->Migratemember->recursive = -1;
		$this->set('members', $this->Migratemember->find('all'));
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Ongeldig lid', true), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
		$this->Migratemember->id = $id;
		if (!$this->Migratemember->exists()) {
			$this->Session->setFlash(__('Lid bestaat niet', true), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
		$this->Migratemember->recursive = 3;
		$this->set('member', $this->Migratemember->read());
	}

	public function migrate_1_schema() {
	}

	public function ajfetchmembercount() {
		// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$fetchResult = array();
		$counts = array();

		$this->loadModel('Member');
		$counts['members'] = $this->Member->find('count');

		$resultMessage = $counts['members'] . ' members';
		$fetchResult = array('status' => '200', 'detail' => $resultMessage);

		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('counts' => $counts),
									'result' => $fetchResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajfetchtablecounts() {
		// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$fetchResult = array();
		$counts = array();

		$counts['migratemembers'] = $this->Migratemember->find('count');
		$queryResult = $this->Migratemember->query('SELECT count(*) as membersbackupcount from cm_members_backup as m;');
		//$counts['members_backup'] = $queryResult;
		$counts['members_backup'] = $queryResult[0][0]['membersbackupcount'];
		$this->loadModel('Member');
		$counts['members'] = $this->Member->find('count');
		$this->loadModel('Person');
		$counts['persons'] = $this->Person->find('count');
		$this->loadModel('Personparent');
		$counts['personparents'] = $this->Personparent->find('count');
		$this->loadModel('Contactaddress');
		$counts['contactaddresses'] = $this->Contactaddress->find('count');

		$resultMessage = count($counts) . ' members';
		$fetchResult = array('status' => '200', 'detail' => $resultMessage);

		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('counts' => $counts),
									'result' => $fetchResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajbackupmemberstable() {
		/// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$queryResult = array();

		$this->loadModel('Member');
		// DROP TABLE `cm_members_backup`;
  	// CREATE TABLE `cm_members_backup` LIKE cm_members;
  	// INSERT `cm_members_backup` SELECT * FROM cm_members;
		$queryResult['1-drop'] = $this->Member->query("DROP TABLE IF EXISTS cm_members_backup;");
		$queryResult['2-create'] = $this->Member->query("CREATE TABLE cm_members_backup LIKE cm_members;");
		$queryResult['3-insert'] = $this->Member->query("INSERT cm_members_backup SELECT * FROM cm_members;");
		$querySelectResult = $this->Member->query("SELECT count(*) as membersbackupcount from cm_members_backup as m;");
		$queryResult['4-count'] = $querySelectResult[0][0]['membersbackupcount'];
		$request = $this->request;
		parent::logAction(__FUNCTION__, 'members_backup', 0);
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => $queryResult,
			 						'result' => array('status' => '200', 'detail' => 'members table backed up'),
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajdropcreatenewtables() {
		/// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$queryResult = array();

		$dropMigratemembers = 'DROP TABLE IF EXISTS cm_migratemembers;';
		$createMigratemembers = 'CREATE TABLE cm_migratemembers LIKE cm_members;';
		$insertMigratemembers = 'INSERT cm_migratemembers SELECT * FROM cm_members;';
		$alterMigratemembersPersonId = 'ALTER TABLE cm_migratemembers ADD COLUMN person_id INT(11) UNSIGNED DEFAULT NULL AFTER ID;';
  	$alterMigratemembersLicensenumber = 'ALTER TABLE cm_migratemembers MODIFY COLUMN licensenumber VARCHAR(20);';

		$dropPersons = 'DROP TABLE IF EXISTS cm_persons;';
		$createPersons = <<<EODPERSONS
CREATE TABLE `cm_persons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `picture_id` int(11) unsigned DEFAULT NULL,
  `contactaddress_id` int(11) unsigned DEFAULT NULL,
  `uniquenumber` char(255) DEFAULT NULL,
  `lastname` varchar(64) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `gender` varchar(16) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthday_public` tinyint(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `bankaccount` varchar(48) DEFAULT NULL,
  `nickname` varchar(64) DEFAULT NULL,
  `status` varchar(16) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `metadata` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EODPERSONS;

	$dropPersonparents = 'DROP TABLE `cm_personparents`;';
	$createPersonparents = <<<EODPERSONPARENTS
CREATE TABLE `cm_personparents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) unsigned DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `metadata` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EODPERSONPARENTS;

	$dropContactaddresses = 'DROP TABLE `cm_contactaddresses`;';
	$createContactaddresses = <<<EODCONTACTADDRESSES
CREATE TABLE `cm_contactaddresses` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`address` varchar(64) DEFAULT NULL,
	`street` varchar(128) DEFAULT NULL,
	`streetnumber` varchar(16) DEFAULT NULL,
	`streetnumbersuffix` varchar(16) DEFAULT NULL,
	`postcode` varchar(16) DEFAULT NULL,
	`city` varchar(64) DEFAULT NULL,
	`countrycode` char(2) DEFAULT NULL,
	`landline` varchar(40) DEFAULT NULL,
	`remark` varchar(255) DEFAULT NULL,
	`metadata` varchar(255) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EODCONTACTADDRESSES;

		$this->loadModel('Member');
		$queryResult['Migratemembers']['1-drop'] = $this->Member->query($dropMigratemembers);
		$queryResult['Migratemembers']['2-create'] = $this->Member->query($createMigratemembers);
		$queryResult['Migratemembers']['3-insert'] = $this->Member->query($insertMigratemembers);
		$queryResult['Migratemembers']['4-person_id'] = $this->Member->query($alterMigratemembersPersonId);
		$queryResult['Migratemembers']['5-licensenumber'] = $this->Member->query($alterMigratemembersLicensenumber);
		$queryResult['Migratemembers']['count'] = $this->Migratemember->find('count');

		$queryResult['Persons']['1-drop'] = $this->Migratemember->query($dropPersons);
		$queryResult['Persons']['2-create'] = $this->Migratemember->query($createPersons);
		$this->loadModel('Person');
		$queryResult['Persons']['count'] = $this->Person->find('count');

		$queryResult['Personparents']['1-drop'] = $this->Migratemember->query($dropPersonparents);
		$queryResult['Personparents']['2-create'] = $this->Migratemember->query($createPersonparents);
		$this->loadModel('Personparent');
		$queryResult['Personparents']['count'] = $this->Personparent->find('count');

		$queryResult['Contactaddresses']['1-drop'] = $this->Migratemember->query($dropContactaddresses);
		$queryResult['Contactaddresses']['2-create'] = $this->Migratemember->query($createContactaddresses);
		$this->loadModel('Contactaddress');
		$queryResult['Contactaddresses']['count'] = $this->Contactaddress->find('count');

		$request = $this->request;
		parent::logAction(__FUNCTION__, 'migrate_tables', 0);
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => $queryResult,
			 						'result' => array('status' => '200', 'detail' => 'drop-created new tables'),
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajemptypersonparents() {
		/// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$queryresult = array();

		$this->loadModel('Personparent');
		$queryresult = $this->Personparent->query('TRUNCATE TABLE cm_personparents;');
		$request = $this->request;
		parent::logAction(__FUNCTION__, 'personparent', 0);
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => $queryresult,
			 						'result' => array('status' => '200', 'detail' => 'personparents table truncated'),
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajemptycontactaddresses() {
		/// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$queryresult = array();

		$this->loadModel('Contactaddress');
		$queryresult = $this->Contactaddress->query('TRUNCATE TABLE cm_contactaddresses;');
		$request = $this->request;
		parent::logAction(__FUNCTION__, 'contactaddress', 0);
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => $queryresult,
			 						'result' => array('status' => '200', 'detail' => 'contacts table truncated'),
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajemptypersons() {
		/// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$queryresult = array();

		$this->loadModel('Person');
		$queryresult = $this->Person->query('TRUNCATE TABLE cm_persons;');
		$request = $this->request;
		parent::logAction(__FUNCTION__, 'person', 0);
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => $queryresult,
			 						'result' => array('status' => '200', 'detail' => 'persons table truncated'),
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajresetpersonid() {
		/// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$queryresult = array();

		$queryresult = $this->Migratemember->updateAll(
												    array('Migratemember.person_id' => null),
												    array('Migratemember.id >' => 0)
												);
		parent::logAction(__FUNCTION__, 'migratemember', 0);
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => $queryresult,
			 						'result' => array('status' => '200', 'detail' => 'person_id reset in migratemembers'),
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function migrate_2_members() {
	}

	public function ajjsonapiexample() {
		// We don't render a view in this example
		$this->autoRender = false;
		//$this->request->onlyAllow('ajax'); // No direct access via browser URL
	  $json_string='
			{
			  "links": {
			    "self": "http://example.com/articles",
			    "next": "http://example.com/articles?page[offset]=2",
			    "last": "http://example.com/articles?page[offset]=10"
			  },
			  "data": [{
			    "type": "articles",
			    "id": "1",
			    "attributes": {
			      "title": "JSON API paints my bikeshed!"
			    },
			    "relationships": {
			      "author": {
			        "links": {
			          "self": "http://example.com/articles/1/relationships/author",
			          "related": "http://example.com/articles/1/author"
			        },
			        "data": { "type": "people", "id": "9" }
			      },
			      "comments": {
			        "links": {
			          "self": "http://example.com/articles/1/relationships/comments",
			          "related": "http://example.com/articles/1/comments"
			        },
			        "data": [
			          { "type": "comments", "id": "5" },
			          { "type": "comments", "id": "12" }
			        ]
			      }
			    },
			    "links": {
			      "self": "http://example.com/articles/1"
			    }
			  }],
			  "included": [{
			    "type": "people",
			    "id": "9",
			    "attributes": {
			      "first-name": "Dan",
			      "last-name": "Gebhardt",
			      "twitter": "dgeb"
			    },
			    "links": {
			      "self": "http://example.com/people/9"
			    }
			  }, {
			    "type": "comments",
			    "id": "5",
			    "attributes": {
			      "body": "First!"
			    },
			    "relationships": {
			      "author": {
			        "data": { "type": "people", "id": "2" }
			      }
			    },
			    "links": {
			      "self": "http://example.com/comments/5"
			    }
			  }, {
			    "type": "comments",
			    "id": "12",
			    "attributes": {
			      "body": "I like XML better"
			    },
			    "relationships": {
			      "author": {
			        "data": { "type": "people", "id": "9" }
			      }
			    },
			    "links": {
			      "self": "http://example.com/comments/12"
			    }
			  }]
			}
		';
	  return $json_string;
	}

	public function ajfetchall() {
		/// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$allmembers = array();
		//$this->Migratemember->recursive = -1;
		/// See above for theMembers
		$conditions = $this->theMembers;
		$allmembers = $this->Migratemember->find('all', array('conditions' => $conditions, 'order' => array('Migratemember.lastname', 'Migratemember.firstname')));

		$request = $this->request;
		$response = array(
			'data' => array('members' => $allmembers),
			'meta' => array('request' => $request, 'cakedata' => array('members' => $allmembers)),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajfetchmember() {
		/// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$error = array();
		$member = array();
		$data = array();

		if (isset($this->request->query['id'])) {
			$id = $this->request->query['id'];
			$this->Migratemember->id = $id;
			if (!$this->Migratemember->exists()) {
				$response['error'][] = array('status' => '404', 'detail' => "member $id does not exist");
			} else {
				//$this->Migratemember->recursive = 3;
				$this->Migratemember->Behaviors->load('Containable');
				$contain = array(
											'Person' => array(
												'Personparent' => array(
													'Parent' => array('Contactaddress')
												),
												'Contactaddress',
												'Picture'
											)
							    );
				$this->Migratemember->contain($contain);
				$member = $this->Migratemember->read();
				if (!$member) {
					$response['error'][] = array('status' => 404, 'detail' => "member $id is invalid");
				} else {
					//$response['data'] = array('type' => 'migratemembers', 'id' => $member['Migratemember']['id'], 'attributes' => $member['Migratemember']);
				}
			}
		} else {
			$response['error'][] = array('status' => 400, 'detail' => "invalid url");
		}

		$request = $this->request;
		$response['meta'] = array('request' => $request, 'cakedata' => array('member' => $member));
		return json_encode($response);

	}

	public function ajmembertoperson() {
		/// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$saveResult = array();
		$person = array();
		$this->loadModel('Person');
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Person->create();
			if ($this->Person->save($this->request->data)) {
				$saveResult = array('status' => '200', 'detail' => 'person successfully added');
				parent::logAction(__FUNCTION__, 'person', $this->Person->id);
			} else {
				$saveResult = array('status' => '404', 'detail' => 'Error: person not successfully added');
			}
		}
		$person = $this->Person->read();
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('person' => $person),
			 						'result' => $saveResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajmembertocontactaddress() {
		/// We don't render a view in this example
		$this->autoRender = false;
	 	/// No direct access via browser URL - with this set, we cannot use it to test the url in the browser
		$this->request->onlyAllow('ajax');

		$response = array();
		$saveResult = array();
		$contactaddress = array();
		$this->loadModel('Contactaddress');
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Contactaddress->create();
			if ($this->Contactaddress->save($this->request->data)) {
				$saveResult = array('status' => '200', 'detail' => 'contactaddress successfully added');
				parent::logAction(__FUNCTION__, 'contactaddress', $this->Contactaddress->id);
			} else {
				$saveResult = array('status' => '404', 'detail' => 'Error: contactaddress not successfully added');
			}
		}
		$contactaddress = $this->Contactaddress->read();
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('contactaddress' => $contactaddress),
			 						'result' => $saveResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajlinkpersontomember() {
		/// We don't render a view in this example
		$this->autoRender = false;
		/// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$saveResult = array();
		$member = array();
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Migratemember->save($this->request->data)) {
				$saveResult = array('status' => '200', 'detail' => 'person successfully linked to member');
				parent::logAction(__FUNCTION__, 'migratemember', $this->Migratemember->id);
			} else {
				$saveResult = array('status' => '404', 'detail' => 'Error: person not successfully linked to member');
			}
		}
		$member = $this->Migratemember->read();
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('member' => $member),
			 						'result' => $saveResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajlinkcontactaddresstoperson() {
		/// We don't render a view in this example
		$this->autoRender = false;
		/// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$saveResult = array();
		$person = array();
		$this->loadModel('Person');
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Person->save($this->request->data)) {
				$saveResult = array('status' => '200', 'detail' => 'contactaddress successfully linked to person');
				parent::logAction(__FUNCTION__, 'person', $this->Person->id);
			} else {
				$saveResult = array('status' => '404', 'detail' => 'Error: contactaddress not successfully linked to person');
			}
		}
		$person = $this->Person->read();
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('person' => $person),
			 						'result' => $saveResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajmigrateallmoms() {
		/// This function will migrate all the moms serversite:
		/// - Fetch members
		/// - for each mom-with-data (non-empty-mom-data)
		///   - create person if there is none already (check duplicate)
		///   - create address if non-empty and there is none already (check duplicate)
		///   - create parent relation between mom and member

		/// We don't render a view in this example
		$this->autoRender = false;
		/// No direct access via browser URL - maybe set this in production env
		$this->request->onlyAllow('ajax');

		$response = array();
		$allmigratedmoms = array();
		$momResult = array();
		//$this->Migratemember->recursive = -1;
		/// fetch the members
		$conditions = $this->theMembers;
		$allmembers = $this->Migratemember->find('all', array('conditions' => $conditions, 'order' => array('Migratemember.id')));
		/// we will record a mom-person whenever we find any mom-information
		foreach ($allmembers as $oneMember) {

			$memberid = $oneMember['Migratemember']['id'];
			$oneMom = array();
			/// first, let's trim the info
			$oneMom['Person']['lastname']  = trim($oneMember['Migratemember']['mom_lastname']);
			$oneMom['Person']['firstname'] = trim($oneMember['Migratemember']['mom_firstname']);
			$oneMom['Person']['gender']    = 'female';
			$oneMom['Person']['email']     = trim($oneMember['Migratemember']['mom_email']);
			$oneMom['Person']['mobile']    = trim($oneMember['Migratemember']['mom_tel']);
			$oneMom['Person']['metadata']  = '{"source": {"mom_of_member": ' . $memberid . ', "mom_of_person": ' . $oneMember['Person']['id'] . '}}';
			//$oneMom['Person']['metadata']  = 'source:mom_of_member=' . $memberid . ';' . 'mom_of_person=' . $oneMember['Person']['id'];
			//$oneMom['Person']['remark']    = '_MOM_OF_memberid_ ' . $memberid . ' _MOM_OF_personid_ ' . $oneMember['Person']['id'];

			$oneMom['Contactaddress']['address']  = trim($oneMember['Migratemember']['mom_address']);
			$oneMom['Contactaddress']['postcode'] = trim($oneMember['Migratemember']['mom_postcode']);
			$oneMom['Contactaddress']['city']     = trim($oneMember['Migratemember']['mom_city']);
			if (
						($oneMom['Person']['lastname'] == '')
				and	($oneMom['Person']['firstname'] == '')
				and	($oneMom['Person']['email'] == '')
				and	($oneMom['Person']['mobile'] == '')
				and	($oneMom['Contactaddress']['address'] == '')
				and	($oneMom['Contactaddress']['postcode'] == '')
				and	($oneMom['Contactaddress']['city'] == '')
			) {
				/// No info found - no mom and no address needs to be created
				$momResult['hasnomom'][] = trim($oneMember['Migratemember']['lastname']) . ' ' . trim($oneMember['Migratemember']['firstname']);
			} else {
				/// We do have some mom info - so a mom wil need to be checked/created

				/// First mom Contactaddress (if needed)
				$newContactaddress = array();
				$newContactaddressId = null;
				if (
							($oneMom['Contactaddress']['address'] <> '')
					or	($oneMom['Contactaddress']['postcode'] <> '')
					or	($oneMom['Contactaddress']['city'] <> '')
				) {
					/// mom - contactaddress data found
					$newContactaddress = $this->addContactaddress($oneMom['Contactaddress']);
					$newContactaddressId = $newContactaddress['Contactaddress']['id'];
				}

				/// Then mom Person
				$newMomPerson = array();
				$newMomPersonId = null;
				if (
							($oneMom['Person']['lastname'] <> '')
					or	($oneMom['Person']['firstname'] <> '')
					or	($oneMom['Person']['email'] <> '')
					or	($oneMom['Person']['mobile'] <> '')
				) {
					/// mom - person data found
					/// if no name info - the we put a fake name (name of member with hyphen postfix)
					if ($oneMom['Person']['lastname'] == '') {
						$oneMom['Person']['lastname'] = trim($oneMember['Migratemember']['lastname']) . '-' . trim($oneMember['Migratemember']['firstname']) . '-id-' . trim($oneMember['Migratemember']['id']) . '-MOM-';
					}
					if ($oneMom['Person']['firstname'] == '') {
						$oneMom['Person']['firstname'] = trim($oneMember['Migratemember']['lastname']) . '-' . trim($oneMember['Migratemember']['firstname']) . '-id-' . trim($oneMember['Migratemember']['id']) . '-MOM-';
					}
					$oneMom['Person']['contactaddress_id'] = $newContactaddressId;
					$newMomPerson = $this->addPerson($oneMom['Person']);
					$newMomPersonId = $newMomPerson['Person']['id'];
				}
				/// put the person-id into the contactaddress.remark if applicable
				if (($newContactaddressId <> null) and ($newMomPersonId <> null)) {
					$rcContactaddressRemark = $this->addContactaddressRemarkMetadata($newContactaddressId, $newMomPersonId);
				}

				/// create the parent link between the new mom and the member
				$oneMom['Personparent']['person_id'] = $oneMember['Person']['id'];
				$oneMom['Personparent']['parent_id'] = $newMomPersonId;
				$oneMom['Personparent']['type'] = 'mother';
				$newPersonparent = $this->addPersonparent($oneMom['Personparent']);
				$newPersonparentId = $newPersonparent['Personparent']['id'];

				$momResult['hasmom'][] = trim($oneMember['Migratemember']['lastname']) . ' ' . trim($oneMember['Migratemember']['firstname']);

				$this->loadModel('Person');
				$this->Migratemember->recursive = -1;
				$this->Migratemember->id = $memberid;
				$this->Person->recursive = 1;
				$this->Person->id = $newMomPersonId;
				$allmigratedmoms[] = array('member' => $this->Migratemember->read(array('id', 'uname', 'person_id', 'mom_lastname', 'mom_firstname', 'dad_lastname', 'dad_firstname')), 'momperson' => $this->Person->read());
			}
		}
		parent::logAction(__FUNCTION__, 'mom', 0);

		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('migratedmoms' => $allmigratedmoms),
									'result' => $momResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajmigratealldads() {
		/// This function will migrate all the dads serversite:
		/// - Fetch members
		/// - for each dad-with-data (non-empty-dad-data)
		///   - create person if there is none already (check duplicate)
		///   - create address if non-empty and there is none already (check duplicate)
		///   - create parent relation between dad and member

		/// We don't render a view in this example
		$this->autoRender = false;
		/// No direct access via browser URL - maybe set this in production env
		$this->request->onlyAllow('ajax');

		$response = array();
		$allmigrateddads = array();
		$dadResult = array();
		//$this->Migratemember->recursive = -1;
		/// fetch the members
		$conditions = $this->theMembers;
		$allmembers = $this->Migratemember->find('all', array('conditions' => $conditions, 'order' => array('Migratemember.id')));
		/// we will record a dad-person whenever we find any dad-information
		foreach ($allmembers as $oneMember) {

			$memberid = $oneMember['Migratemember']['id'];
			$oneDad = array();
			/// first, let's trim the info
			$oneDad['Person']['lastname']  = trim($oneMember['Migratemember']['dad_lastname']);
			$oneDad['Person']['firstname'] = trim($oneMember['Migratemember']['dad_firstname']);
			$oneDad['Person']['gender']    = 'male';
			$oneDad['Person']['email']     = trim($oneMember['Migratemember']['dad_email']);
			$oneDad['Person']['mobile']    = trim($oneMember['Migratemember']['dad_tel']);
			$oneDad['Person']['metadata']  = '{"source": {"dad_of_member": ' . $memberid . ', "dad_of_person": ' . $oneMember['Person']['id'] . '}}';
			//$oneDad['Person']['metadata']  = 'source:dad_of_member=' . $memberid  . ';' . 'dad_of_person=' . $oneMember['Person']['id'];
			//$oneDad['Person']['remark']    = '_DAD_OF_memberid_ ' . $oneMember['Migratemember']['id'] . ' _DAD_OF_personid_ ' . $oneMember['Person']['id'];

			$oneDad['Contactaddress']['address']  = trim($oneMember['Migratemember']['dad_address']);
			$oneDad['Contactaddress']['postcode'] = trim($oneMember['Migratemember']['dad_postcode']);
			$oneDad['Contactaddress']['city']     = trim($oneMember['Migratemember']['dad_city']);
			if (
						($oneDad['Person']['lastname'] == '')
				and	($oneDad['Person']['firstname'] == '')
				and	($oneDad['Person']['email'] == '')
				and	($oneDad['Person']['mobile'] == '')
				and	($oneDad['Contactaddress']['address'] == '')
				and	($oneDad['Contactaddress']['postcode'] == '')
				and	($oneDad['Contactaddress']['city'] == '')
			) {
				/// No info found - no dad and no address needs to be created
				$dadResult['hasnodad'][] = trim($oneMember['Migratemember']['lastname']) . ' ' . trim($oneMember['Migratemember']['firstname']);
			} else {
				/// We do have some dad info - so a dad wil need to be checked/created

				/// First dad Contactaddress (if needed)
				$newContactaddress = array();
				$newContactaddressId = null;
				if (
							($oneDad['Contactaddress']['address'] <> '')
					or	($oneDad['Contactaddress']['postcode'] <> '')
					or	($oneDad['Contactaddress']['city'] <> '')
				) {
					/// dad - contactaddress data found
					$newContactaddress = $this->addContactaddress($oneDad['Contactaddress']);
					$newContactaddressId = $newContactaddress['Contactaddress']['id'];
				}

				/// Then dad Person
				$newDadPerson = array();
				$newDadPersonId = null;
				if (
							($oneDad['Person']['lastname'] <> '')
					or	($oneDad['Person']['firstname'] <> '')
					or	($oneDad['Person']['email'] <> '')
					or	($oneDad['Person']['mobile'] <> '')
				) {
					/// dad - person data found
					/// if no name info - the we put a fake name (name of member with hyphen postfix)
					if ($oneDad['Person']['lastname'] == '') {
						$oneDad['Person']['lastname'] = trim($oneMember['Migratemember']['lastname']) . '-' . trim($oneMember['Migratemember']['firstname']) . '-id-' . trim($oneMember['Migratemember']['id']) . '-DAD-';
					}
					if ($oneDad['Person']['firstname'] == '') {
						$oneDad['Person']['firstname'] = trim($oneMember['Migratemember']['lastname']) . '-' . trim($oneMember['Migratemember']['firstname']) . '-id-' . trim($oneMember['Migratemember']['id']) . '-DAD-';
					}
					$oneDad['Person']['contactaddress_id'] = $newContactaddressId;
					$newDadPerson = $this->addPerson($oneDad['Person']);
					$newDadPersonId = $newDadPerson['Person']['id'];
				}
				/// put the person-id into the contactaddress.remark
				if (($newContactaddressId <> null) and ($newDadPersonId <> null)) {
					$rcContactaddressRemark = $this->addContactaddressRemarkMetadata($newContactaddressId, $newDadPersonId);
				}

				/// create the parent link between the new dad and the member
				$oneDad['Personparent']['person_id'] = $oneMember['Person']['id'];
				$oneDad['Personparent']['parent_id'] = $newDadPersonId;
				$oneDad['Personparent']['type'] = 'father';
				$newPersonparent = $this->addPersonparent($oneDad['Personparent']);
				$newPersonparentId = $newPersonparent['Personparent']['id'];

				$dadResult['hasdad'][] = trim($oneMember['Migratemember']['lastname']) . ' ' . trim($oneMember['Migratemember']['firstname']);

				$this->loadModel('Person');
				$this->Migratemember->recursive = -1;
				$this->Migratemember->id = $memberid;
				$this->Person->recursive = 1;
				$this->Person->id = $newDadPersonId;
				$allmigrateddads[] = array('member' => $this->Migratemember->read(array('id', 'uname', 'person_id', 'mom_lastname', 'mom_firstname', 'dad_lastname', 'dad_firstname')), 'dadperson' => $this->Person->read());
			}
		}
		parent::logAction(__FUNCTION__, 'dad', 0);
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('migrateddads' => $allmigrateddads),
									'result' => $dadResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	private function addContactaddress($theContactaddress) {
		/// Write the contactaddress to the database
		$newcontactaddressdata['Contactaddress'] = $theContactaddress;
		$contactaddress = array();
		$this->loadModel('Contactaddress');
		$this->Contactaddress->create();
		if ($this->Contactaddress->save($newcontactaddressdata)) {
			$saveResult[] = array('status' => '200', 'detail' => 'contactaddress successfully added');
			parent::logAction(__FUNCTION__, 'contactaddress', $this->Contactaddress->id);
		} else {
			$saveResult[] = array('status' => '404', 'detail' => 'Error: contactaddress not successfully added');
		}
		$contactaddress = $this->Contactaddress->read();
		return $contactaddress;
	}

	private function addPerson($thePerson) {
		/// Write the person to the database
		$newpersondata['Person'] = $thePerson;
		$person = array();
		$this->loadModel('Person');
		$this->Person->create();
		if ($this->Person->save($newpersondata)) {
			$saveResult[] = array('status' => '200', 'detail' => 'person successfully added');
			parent::logAction(__FUNCTION__, 'person', $this->Person->id);
		} else {
			$saveResult[] = array('status' => '404', 'detail' => 'Error: person not successfully added');
		}
		$person = $this->Person->read();
		return $person;
	}

	private function addContactaddressRemarkMetadata($theContactaddressId, $thePersonId) {
		/// Write the contactaddress to the database
		$this->loadModel('Contactaddress');
		$this->Contactaddress->read(null, $theContactaddressId);
		$this->Contactaddress->set(array(
		    'remark' => $thePersonId,
		    'metadata' => '{"source": {"person": ' . $thePersonId . '}}',
		));
		$rcSave = $this->Contactaddress->save();
		if ($rcSave) {
			$saveResult[] = array('status' => '200', 'detail' => 'contactaddress remark successfully added');
			parent::logAction(__FUNCTION__, 'contactaddress', $theContactaddressId);
		} else {
			$saveResult[] = array('status' => '404', 'detail' => 'Error: contactaddress remark not successfully added');
		}
		return $rcSave;
	}

	private function addPersonparent($thePersonparent) {
		/// Write the personparent to the database
		$newpersonparentdata['Personparent'] = $thePersonparent;
		$personparent = array();
		$this->loadModel('Personparent');
		$this->Personparent->create();
		if ($this->Personparent->save($newpersonparentdata)) {
			$saveResult[] = array('status' => '200', 'detail' => 'personparent successfully added');
			parent::logAction(__FUNCTION__, 'personparent', $this->Personparent->id);
		} else {
			$saveResult[] = array('status' => '404', 'detail' => 'Error: personparent not successfully added');
		}
		$personparent = $this->Personparent->read();
		return $personparent;
	}

	public function migrate_3_double_addresses() {
		/// the logoonly layout does not load jquery and vue and shit :-)
		//$this->layout = 'logoonly';

		/// No processing here - all processing through buttons and ajax
	}

	public function ajfetchdoubleaddresses() {
		// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$fetchResult = array();
		$allAddresses = array();
		$addressesDuplicates = array();

		$this->loadModel('Contactaddress');
		$this->Contactaddress->recursive = -1;
		$fields = array('id', 'address', 'postcode', 'metadata', 'remark');
		$conditions = array('id >' => 0);
		$allAddresses = $this->Contactaddress->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => array('Contactaddress.address', 'Contactaddress.id')));
		$prevItem = '';
		$thisItem = '';

		/// Put the addresses in a distinct array
		$addressesByName = array();
		$distinctAddressCount = 0;
		foreach ($allAddresses as $oneAddress) {
			$thisItem = $oneAddress['Contactaddress']['address'] . '--' . $oneAddress['Contactaddress']['postcode'];
			if ($thisItem <> $prevItem) {
				$distinctAddressCount += 1;
			}
			$addressesByName[$thisItem][] = $oneAddress;
			$prevItem = $thisItem;
		}

		/// Only keep addresses with duplicates
		foreach ($addressesByName as $oneAddress) {
			if (count($oneAddress) > 1) {
				$addressesDuplicates[] = $oneAddress;
			}
		}

		$resultMessage = count($allAddresses) . ' addresses checked';
		$resultMessage .= ' - ' . $distinctAddressCount . ' distinct addresses found';
		$resultMessage .= ' - ' . count($addressesDuplicates) . ' addresses found with doubles';
		$fetchResult = array('status' => '200', 'detail' => $resultMessage);

		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('alladdresses' => $allAddresses, 'distinctaddresses' => $addressesByName, 'doubleaddresses' => $addressesDuplicates),
									'result' => $fetchResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajremovecontactaddress() {
		/// We don't render a view in this example
		$this->autoRender = false;
		/// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$removeResult = array();
		$theId = $this->request->data('Contactaddress.id');
		$this->loadModel('Contactaddress');
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Contactaddress->delete($theId)) {
				$removeResult = array('status' => '200', 'detail' => 'contactaddress successfully removed');
				parent::logAction(__FUNCTION__, 'contactaddress', $theId);
			} else {
				$removeResult = array('status' => '404', 'detail' => 'Error: contactaddress not successfully removed');
			}
		}
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('theRemovedId' => $theId),
			 						'result' => $removeResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function migrate_4_double_persons() {
		/// the logoonly layout does not load jquery and vue and shit :-)
		//$this->layout = 'logoonly';

		/// No processing here - all processing through buttons and ajax
	}

	public function ajfetchdoublepersons() {
		// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$fetchResult = array();
		$allPersons = array();
		$personsDuplicates = array();

		$this->loadModel('Person');
		$this->Person->recursive = -1;
		$fields = array('id', 'lastname', 'firstname', 'gender', 'email', 'mobile', 'metadata', 'contactaddress_id');
		$conditions = array('id >' => 0);
		$allPersons = $this->Person->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => array('Person.lastname', 'Person.firstname')));
		$prevFullname = '';
		$thisFullname = '';

		/// Put the persons in a distinct array
		$personsByName = array();
		$distinctPersonCount = 0;
		foreach ($allPersons as $onePerson) {
			$thisFullname = $onePerson['Person']['lastname'] . '--' . $onePerson['Person']['firstname'];
			if ($thisFullname <> $prevFullname) {
				$distinctPersonCount += 1;
			}
			$personsByName[$thisFullname][] = $onePerson;
			$prevFullname = $thisFullname;
		}

		foreach ($personsByName as $onePerson) {
			if (count($onePerson) > 1) {
				$personsDuplicates[] = $onePerson;
			}
		}

		$resultMessage = count($allPersons) . ' persons checked';
		$resultMessage .= ' - ' . $distinctPersonCount . ' distinct names found';
		$resultMessage .= ' - ' . count($personsDuplicates) . ' names found with doubles';
		$fetchResult = array('status' => '200', 'detail' => $resultMessage);

		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('allpersons' => $allPersons, 'distinctpersons' => $personsByName, 'doubles' => $personsDuplicates),
									'result' => $fetchResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajmergeperson() {
		/// We don't render a view in this example
		$this->autoRender = false;
		/// No direct access via browser URL - with this set, we cannot use it to test the url in the browser
		$this->request->onlyAllow('ajax');

		$response = array();
		$mergeResult = array();

		$mergePersonInput = $this->request->data;
		$mergeMainPerson = $mergePersonInput['mainPerson']['Person'];
		$mergeMainPersonId = $mergeMainPerson['id'];
		$mergeMainPersonContactaddressId = $mergePersonInput['mainPerson']['Person']['contactaddress_id'];
		foreach ($mergePersonInput['mergeData']['tasks'] as $oneMergeTask) {
			switch ($oneMergeTask['taskType']) {
  		case "moveParent":
      	$mergeResult['subresults'][] = $this->mergeTaskMoveParent($oneMergeTask, $mergeMainPersonId);
      	break;
  		case "moveContactaddress":
				$mergeResult['subresults'][] = $this->mergeTaskMoveContactaddress($oneMergeTask, $mergeMainPersonId, $mergeMainPersonContactaddressId);
      	break;
    	case "mergePersonData":
				$mergeResult['subresults'][] = $this->mergeTaskMergePersonData($oneMergeTask, $mergeMainPerson);
      	break;
			case "removeMergePerson":
				$mergeResult['subresults'][] = $this->mergeTaskRemoveMergePerson($oneMergeTask, $mergeMainPersonId);
      	break;
			}
		}
		/// Fetch the merged person for the response
		$person = array();
		$this->loadModel('Person');
		$this->Person->id = $mergeMainPersonId;
		$person = $this->Person->read();
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('person' => $person),
									'result' => $mergeResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	private function mergeTaskMoveParent($oneMergeTask, $mergeMainPersonId) {
		/*
			"taskType": "moveParent",
			"taskDescription": "Personparent ==> set parent_id to "newParentId" where type is "parentType" and person_id is "forPersonId"",
			"parentType": "father",
			"forPersonId": 6,
			"newParentId": "mainPerson.id",
			"oldParentId": "13"
		*/
		$this->loadModel('Personparent');
		$thisQuery = 'UPDATE cm_personparents SET parent_id = ' . $mergeMainPersonId . ' WHERE type = "'.$oneMergeTask['parentType'].'" AND person_id="'.$oneMergeTask['forPersonId'].'";';
		$queryresult = $this->Personparent->query($thisQuery);
		parent::logAction(__FUNCTION__, 'person', $mergeMainPersonId);
		return $thisQuery;
	}

	private function mergeTaskMoveContactaddress($oneMergeTask, $mergeMainPersonId, $mergeMainPersonContactaddressId) {
		/*
			"taskType": "moveContactaddress",
			"taskDescription": "Person ==> set contactaddress_id to "newContactaddressId" where id is "personId" and contactaddress_id is null",
			"personId": "mainPerson.id",
			"newContactaddressId": null,
			"oldContactaddressId": "mainPerson.contactaddress_id"
		*/
		if ($mergeMainPersonContactaddressId == null) {
			if ($oneMergeTask['newContactaddressId'] != null) {
				$this->loadModel('Person');
				$thisQuery = 'UPDATE cm_persons SET contactaddress_id = ' . $oneMergeTask['newContactaddressId'] . ' WHERE id = "'.$mergeMainPersonId.'" AND contactaddress_id IS NOT null;';
				$queryresult = $this->Personparent->query($thisQuery);
				parent::logAction(__FUNCTION__, 'person', $mergeMainPersonId);
				return $thisQuery;
			} else {
				return 'NO QUERY - no contactaddress to move';
			}
		} else {
			return 'NO QUERY - main person already has a contactaddress';
		}
	}

	private function mergeTaskMergePersonData($oneMergeTask, $mergeMainPerson) {
		/*
			"taskType": "mergePersonData",
			"taskDescription": "set Person.data to \"mergePerson\".data where Person.id is \"mainPerson\".id and Person.data is null",
			"personId": "mainPerson.id",
			"email": "seghersb@gmail.com",
			"mobile": "0473/84.18.23",
			"gender": "male"
		*/
		$somethingToMerge = false;
		$thisResult = array();
		$mergeData = array();
		$mergeData['Person']['id'] = $mergeMainPerson['id'];
		if (($oneMergeTask['email'] <> null) and (($mergeMainPerson['email'] == null) or ($mergeMainPerson['email'] == ''))) {
			$mergeData['Person']['email'] = $oneMergeTask['email'];
			$somethingToMerge = true;
			$thisResult[] = 'email merged to ' . $mergeData['Person']['email'];
		} else {
			$thisResult[] = 'no email to merge';
		}
		if (($oneMergeTask['mobile'] <> null) and (($mergeMainPerson['mobile'] == null) or ($mergeMainPerson['mobile'] == ''))) {
			$mergeData['Person']['mobile'] = $oneMergeTask['mobile'];
			$somethingToMerge = true;
			$thisResult[] = 'mobile merged to ' . $mergeData['Person']['mobile'];
		} else {
			$thisResult[] = 'no mobile to merge';
		}
		if (($oneMergeTask['gender'] <> null) and (($mergeMainPerson['gender'] == null) or ($mergeMainPerson['gender'] == ''))) {
			$mergeData['Person']['gender'] = $oneMergeTask['gender'];
			$somethingToMerge = true;
			$thisResult[] = 'gender merged to ' . $mergeData['Person']['gender'];
		} else {
			$thisResult[] = 'no gender to merge';
		}
		if ($somethingToMerge == true) {
			$this->loadModel('Person');
			if ($this->Person->save($mergeData)) {
				$thisResult[] = array('status' => '200', 'detail' => 'main person successfully merged');
				parent::logAction(__FUNCTION__, 'person', $this->Person->id);
			} else {
				$thisResult[] = array('status' => '404', 'detail' => 'Error: main person not successfully merged');
			}
		} else {
			$thisResult[] = 'NO MERGE - no data to merge';
		}
		return $thisResult;
	}

	private function mergeTaskRemoveMergePerson($oneMergeTask, $mergeMainPersonId) {
		/*
			"taskType": "removeMergePerson",
			"taskDescription": "Person: remove where id is "personId"",
			"personId": "13"
		*/
		if ($oneMergeTask['personId'] <> $mergeMainPersonId) {
			$this->loadModel('Person');
			$thisQuery = 'DELETE FROM cm_persons WHERE id = '.$oneMergeTask['personId'].';';
			$queryresult = $this->Personparent->query($thisQuery);
			parent::logAction(__FUNCTION__, 'person', $oneMergeTask['personId']);
			return $thisQuery;
		} else {
			return 'NO REMOVE - not removing main person';
		}
	}

	public function migrate_5_final() {
		/// the logoonly layout does not load jquery and vue and shit :-)
		//$this->layout = 'logoonly';

		/// No processing here - all processing through buttons and ajax
	}

	public function ajfetchallcontactaddresses() {
		// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$fetchResult = array();
		$allContactaddresses = array();

		$this->loadModel('Contactaddress');
		$this->Contactaddress->recursive = -1;
		$fields = array('id', 'address', 'street', 'streetnumber', 'postcode', 'metadata', 'remark');
		$conditions = array('id >' => 0);
		$allContactaddresses = $this->Contactaddress->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => array('Contactaddress.address', 'Contactaddress.id')));

		$resultMessage = count($allContactaddresses) . ' addresses fetched';
		$fetchResult = array('status' => '200', 'detail' => $resultMessage);

		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('allContactaddresses' => $allContactaddresses),
									'result' => $fetchResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajsavesplitaddress() {
		// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$saveResult = array();
		$contactaddress = array();
		$this->loadModel('Contactaddress');
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Contactaddress->save($this->request->data)) {
				$saveResult = array('status' => '200', 'detail' => 'contactaddress successfully saved');
				parent::logAction(__FUNCTION__, 'contactaddress', $this->Contactaddress->id);
			} else {
				$saveResult = array('status' => '404', 'detail' => 'Error: contactaddress not successfully saved');
			}
		}
		$contactaddress = $this->Contactaddress->read();
		$request = $this->request;
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => array('contactaddress' => $contactaddress),
			 						'result' => $saveResult,
								),
			//'error' => '',
		);
		return json_encode($response);
	}

	public function ajswitchtomembershipstable() {
		/// We don't render a view in this example
		$this->autoRender = false;
		// No direct access via browser URL
		$this->request->onlyAllow('ajax');

		$response = array();
		$queryResult = array();


		$dropMemberships = 'DROP TABLE IF EXISTS cm_memberships;';
		$createMemberships = 'CREATE TABLE cm_memberships LIKE cm_migratemembers;';
		$insertMemberships = 'INSERT cm_memberships SELECT * FROM cm_migratemembers;';
		$alterMemberships = <<<EODMEMBERSHIPS
ALTER TABLE cm_memberships
   DROP COLUMN picture_id,
   DROP COLUMN lastname,
   DROP COLUMN firstname,
   DROP COLUMN birthdate,
   DROP COLUMN birthday_public,
   DROP COLUMN email,
   DROP COLUMN tel,
   DROP COLUMN address,
   DROP COLUMN postcode,
   DROP COLUMN city,
   DROP COLUMN nationalnumber,
   DROP COLUMN mom_lastname,
   DROP COLUMN mom_firstname,
   DROP COLUMN mom_email,
   DROP COLUMN mom_tel,
   DROP COLUMN mom_address,
   DROP COLUMN mom_postcode,
   DROP COLUMN mom_city,
   DROP COLUMN dad_lastname,
   DROP COLUMN dad_firstname,
   DROP COLUMN dad_email,
   DROP COLUMN dad_tel,
   DROP COLUMN dad_address,
   DROP COLUMN dad_postcode,
   DROP COLUMN dad_city,
   DROP COLUMN nickname,
   DROP COLUMN bank_account;
EODMEMBERSHIPS;

		$queryResult['1-drop'] = $this->Migratemember->query($dropMemberships);
		$queryResult['2-create'] = $this->Migratemember->query($createMemberships);
		$queryResult['3-insert'] = $this->Migratemember->query($insertMemberships);
		$queryResult['4-alter'] = $this->Migratemember->query($alterMemberships);
		$this->loadModel('Membership');
		$queryResult['5-count'] = $this->Membership->find('count');
		$request = $this->request;
		parent::logAction(__FUNCTION__, 'membership', 0);
		$response = array(
			'meta' => array(
									'request' => $request,
									'cakedata' => $queryResult,
									'result' => array('status' => '200', 'detail' => 'migratemembers switched to memberships'),
								),
			//'error' => '',
		);
		return json_encode($response);
	}
}
