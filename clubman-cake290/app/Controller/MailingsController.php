<?php
class MailingsController extends AppController {
	public $name = 'Mailings';
	//var $helpers = array('Html', 'Form');
	var $scaffold;


	public function beforeFilter() {
		parent::beforeFilter();
		/// Normal
		$this->Auth->deny('index', 'view');
		/// During setup new mailing
		//$this->Auth->allow('index', 'view', 'add', 'edit');
		/// During new mailing
		//$this->Auth->allow('index', 'view');
	}


	public function index() {
		$enqueteSeason = $this->currentSeason;
		$options =	[
	    'fields' => [
	        'Mailing.id',
					'Mailing.season',
					'Mailing.category',
					'Mailing.name'
	    ],
			'order' => 'Mailing.season DESC'
		];
		$this->Mailing->contain('Mail.mailsent');
		$mailings = $this->Mailing->find('all', $options);
		$this->set('mailings', $mailings);
		$this->set('enqueteSeason', $enqueteSeason);
	}


	public function view($id = null) {
		$enqueteSeason = $this->currentSeason;
		$this->Mailing->id = $id;
		$mailing = $this->Mailing->read();
		if (count($mailing['Mail']) == 0) {
			$mailexample = [];
			$mailexample['id'] = 'no-info-yet';
			$mailexample['name'] = 'no-info-yet';
			$mailexample['mailing_id'] = 'no-info-yet';
			$mailexample['mailsubject'] = 'no-info-yet';
			$mailexample['mailfrom'] = 'no-info-yet';
			$mailexample['mailto'] = 'no-info-yet';
			$mailexample['mailcc'] = 'no-info-yet';
			$mailexample['mailbcc'] = 'no-info-yet';
			$mailexample['mailbody'] = 'no-info-yet';
			$mailexample['maillinkurl'] = 'no-info-yet';
			$mailexample['maillinkuid'] = 'no-info-yet';
			$mailexample['mailsent'] = 'no-info-yet';
			$mailing['Mail'][] = $mailexample;
		}
		$this->set('mailing', $mailing);
		$this->set('enqueteSeason', $enqueteSeason);
	}


	public function preparemails($mailingid = null, $target = 'all', $do = 'test') {
		$enqueteSeason = $this->currentSeason;
		if ( ! isset($mailingid) ) {
			$this->Session->setFlash('Geen mailing meegegeven.', "flash-error");
			//$this->redirect('/');
		} else {
			$this->Mailing->id = $mailingid;
			if ( ! $this->Mailing->exists()) {
				$this->Session->setFlash('Ongeldige mailing meegegeven ('.$mailingid.').', "flash-error");
				//$this->redirect('/');
			} else {
				$contain = array(
						'Mail' => array(
								'fields' => array('id', 'season', 'name', 'mailing_id', 'mailsubject', 'mailfrom', 'mailto', 'mailcc', 'mailbcc', 'maillinkurl', 'maillinkuid', 'mailsent', 'created', 'modified')
						)
				);
				$this->Mailing->contain($contain);
				$fields = array('id', 'season', 'category', 'name', 'fromaddress', 'body', 'created', 'modified');
				$mailing = $this->Mailing->read($fields);
				if ($mailing['Mailing']['category'] == 'ledenbevraging') {
					/// Haal de lijst van de voorbereide enquetes op
					$this->loadModel('Enquete');
					$this->Enquete->recursive = -1;
					if ($target == 'all') {
						$conditions = [
							'Enquete.season' => $enqueteSeason
						];
					} elseif ($target == 'empty') {
						$conditions = [
							'Enquete.season' => $enqueteSeason,
							'Enquete.modified = Enquete.created'
						];
					} elseif ($target == 'test') {
						$conditions = [
							'Enquete.season' => $enqueteSeason,
							'Enquete.algemeen_naam LIKE' => 'AAA - % - test'
						];
					} else {
						$conditions = [
							'Enquete.season' => $enqueteSeason
						];
					}
					$fields = ['Enquete.algemeen_naam', 'Enquete.id', 'Enquete.created', 'Enquete.modified', 'Enquete.mail_ik', 'Enquete.mail_mama', 'Enquete.mail_papa'];
					$enquetes = $this->Enquete->find('all', array('conditions' => $conditions, 'fields' => $fields, 'order' => array('Enquete.modified' => 'ASC')));
					if (($do == 'generate') and (count($enquetes) > 0)) {
						$generatemails = [];
						foreach ($enquetes as $enquete) {
							$onemailto = trim($enquete['Enquete']['mail_ik']);
							$onemailcc = '';
							$mailmama = trim($enquete['Enquete']['mail_mama']);
							$mailpapa = trim($enquete['Enquete']['mail_papa']);
							$cc = [];
							if (($mailmama <> '') and ($mailmama <> $onemailto)) {
								 $cc[] = $mailmama;
							}
							if (($mailpapa <> '') and ($mailpapa <> $onemailto) and ($mailpapa <> $mailmama)) {
								$cc[] = $mailpapa;
							}
							$onemailcc = implode(',', $cc);
							if (trim($mailing['Mailing']['fromaddress']) == '') {
								$onemailfrom = $this->cmclub['clubmail']['webmaster']['email'];
							} else {
								$onemailfrom = trim($mailing['Mailing']['fromaddress']);
							}
							$name = $enquete['Enquete']['algemeen_naam'];
							//$linkurl = 'http://clubman.oblivio.be/enquetes/vulin';
							//$linkurl = $this->webroot.'/enquetes/vulin';
							$linkurl = FULL_BASE_URL . $this->base.'/enquetes/vulin';
							$linkuid = $enquete['Enquete']['id'];
							$body = $mailing['Mailing']['body'];
							$body = str_replace("%%name%%", $name, $body);
							$body = str_replace("%%maillinkurl%%", $linkurl, $body);
							$body = str_replace("%%maillinkuid%%", $linkuid, $body);
							$generatemails[] = array(
								'season' => $enqueteSeason,
								'name' => $enquete['Enquete']['algemeen_naam'],
								'mailing_id' => $mailingid,
								'mailsubject' => $mailing['Mailing']['name'],
								'mailfrom' => $onemailfrom,
								'mailto' => $onemailto,
								'mailcc' => $onemailcc,
								'mailbcc' => $this->cmclub['clubmail']['mailings']['email'],
								'mailbody' => $body,
								'maillinkurl' => $linkurl,
								'maillinkuid' => $linkuid,
								'mailsent' => null,
								'modified' => null
							);
						}
						$this->set('mails', $generatemails);
						$this->loadModel('Mail');
						if ($this->Mail->saveMany($generatemails)) {
							$this->Session->setFlash(count($generatemails) . ' mails werden voorbereid.', "flash-info");
							$this->redirect(array('action' => 'preparemails', $mailingid, $target));
						} else {
							$this->Session->setFlash('De mails konden niet worden voorbereid.', "flash-error");
						}
					}
					$this->set('enquetes', $enquetes);
				} else {
					/// als het niet over een ledenbevraging gaat
					/// aka de "normale" mailing shizzle ...
					/// ... dat moet hier nog komen
				}
				$this->set('mailing', $mailing);
			}
		}
		$this->set('enqueteSeason', $enqueteSeason);
	}

}
?>
