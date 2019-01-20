<?php
class User extends AppModel {
	public $name = 'User';
	public $actsAs = array('Containable');

	public $displayField = 'username';

	var $validate = array(
		'username' => array(
			'content' => array('rule' => '/^.{2,40}$/', 'required' => true, 'message' => 'De gebruikersnaam moet tussen 2 and 40 characters lang zijn.'),
			'unique'  => array('rule' => 'isUnique', 'message' => 'Deze naam is al gebruikt. Gelieve een andere te nemen.')
		),
		'password' => array(
			'required' => array('rule' => array('notBlank'),      'message' => 'Wachtwoord is verplicht'),
			'pwmatch' => array('rule' => array('matchPasswords'), 'message' => 'Wachtwoorden niet hetzelfde')
		),
		'password_confirmation' => array(
			'required' => array('rule' => array('notBlank'), 'message' => 'Wachtwoord confirmatie is verplicht')
		),
		'role' => array(
			'valid' => array(
				'rule'       => array('allInList'),
				'message'    => 'Gelieve een geldige functie in te geven',
				'allowEmpty' => false
			)
		)
	);

	public $belongsTo = 'Member';

	public function matchPasswords( $data ) {
		if ($data['password'] == $this->data['User']['password_confirmation']) {
			return true;
		}
		$this->invalidate('password_confirmation', 'Wachtwoorden niet hetzelfde');
		return false;
	}

	public function allInList( $data ) {
		$roleArray = explode(',', $data['role']);
		$validRoles = ['root', 'admin', 'teamadmin', 'gameadmin', 'memberadmin', 'trainerfinance', 'memberfinance', 'memberview', 'memberedit', 'trainer', 'member'];
		foreach ($roleArray as $oneRole) {
			if (! in_array($oneRole, $validRoles)) {
				$this->invalidate('role', 'Ongeldige functie: '. $oneRole);
				return false;
			}
		}
		return true;
	}

	public function beforeSave( $options = array() ) {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}

}
