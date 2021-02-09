<?php
App::uses('CakeEmail', 'Network/Email');
class MailsController extends AppController {
	public $name = 'Mails';
	var $scaffold;

	public function beforeFilter() {
		parent::beforeFilter();
		/// During setup new mailing
		//$this->Auth->allow('index', 'add', 'view', 'edit', 'delete');
		$this->Auth->allow('index', 'view');
	}


	public function sendmanymails($mailingid = null, $target ='all', $do = 'test') {
		$enqueteSeason = $this->currentSeason;
		if ( ! isset($mailingid) ) {
			$this->Session->setFlash('Geen mailing meegegeven.', "flash-error");
			//$this->redirect('/');
		} else {
			$this->loadModel('Mailing');
			$this->Mailing->id = $mailingid;
			if ( ! $this->Mailing->exists()) {
				$this->Session->setFlash('Ongeldige mailing meegegeven ('.$mailingid.').', "flash-error");
				//$this->redirect('/');
			} else {
				$fields = ['Mailing.id', 'Mailing.season', 'Mailing.category', 'Mailing.name', 'Mailing.fromaddress'];
				$contain = array();
				$contain['all'] = array(
														'Mail' => array(
															'fields' => array('id', 'name', 'mailsent')
														)
													);
				$contain['unsent'] = array(
															'Mail' => array(
																'fields' => array('id', 'name', 'mailsent'),
																'conditions' => array('Mail.mailsent' => null)
															)
														);
				//$this->Mailing->contain(['Mail.id', 'Mail.name', 'Mail.mailsent']);
				$this->Mailing->contain($contain[$target]);
				$mailing = $this->Mailing->read($fields);
				$mailsok = 0;
				$mailingresult['mailsok'] = [];
				$mailsnotok = 0;
				$mailingresult['mailsnotok'] = [];
				foreach ($mailing['Mail'] as $mail) {
					/// next is for testing
					//$mailresult = ['id' => $mail['id'], 'rc' => 0, 'msg' => 'test-not-sending-mode'];
					/// next is for real
					$mailresult = $this->sendthismail($mail['id']);
					if ($mailresult['rc'] == 0) {
						$mailingresult['mailsok'][] = $mailresult;
						$mailsok +=1;
					} else{
						$mailingresult['mailsnotok'][] = $mailresult;
						$mailsnotok +=1;
					}
				}
				$flashmessage = '';
				if ($mailsnotok > 0) {
					$flashmessage .= 'Aantal mislukte mails: '.count($mailingresult['mailsnotok']).' - ';
				}
				$flashmessage .= 'Aantal gelukte mails: '.count($mailingresult['mailsok']);
				$this->Session->setFlash($flashmessage, "flash-info");
				$this->set('mailing', $mailing);
				$this->set('mailingresult', $mailingresult);
				$this->redirect(array('controller' => 'mailings', 'action' => 'view', $mailingid));
			}
		}
	}


	public function sendonemail($id = null, $do = 'test') {
		$enqueteSeason = $this->currentSeason;
		if ( ! isset($id) ) {
			$this->Session->setFlash('Geen mail meegegeven.', "flash-error");
			//$this->redirect('/');
		} else {
			$this->Mail->id = $id;
			if ( ! $this->Mail->exists()) {
				$this->Session->setFlash('Ongeldige mail meegegeven ('.$id.').', "flash-error");
				//$this->redirect('/');
			} else {
				$mailresult = $this->sendthismail($id);
				if ($mailresult['rc'] == 0) {
					$this->Session->setFlash($mailresult['msg'], "flash-info");
				} else {
					$this->Session->setFlash($mailresult['msg'], "flash-error");
				}
				$this->set('mailresult', $mailresult);
			}
		}
	}


	private function sendthismail($mailid = null) {
		if ($mailid) {
			$this->Mail->id = $mailid;
			$this->Mail->recursive = -1;
			$mail = $this->Mail->read();
			if (trim($mail['Mail']['mailto']) == '') {
				$mailrcmsg = 'Geen e-mail verzonden naar '.$mail['Mail']['name'].'. Geen email adres.';
				$mailrc = 1;
			} else {
				$email = new CakeEmail($this->cmclub['environment']['mail']);
				$email->sender(array($this->cmclub['clubmail']['webmailer']['email'] => $this->cmclub['clubmail']['webmailer']['name']));
				$email->template('mailing', 'clubmanplain')
				    	->emailFormat('html')
				    	->to($mail['Mail']['mailto'])
							->bcc($mail['Mail']['mailbcc'])
				    	->from($mail['Mail']['mailfrom']);
				if (trim($mail['Mail']['mailcc'])) {
					$mailcc = explode(",", $mail['Mail']['mailcc']);
					$email->cc($mailcc);
				}
				$email->subject($this->cmclub['shortname'] . ' -- Mailing -- ' . $mail['Mail']['mailsubject']);
				$email->viewVars(array('clubconfig' => $this->cmclub));
				try {
					if ($email->send($mail['Mail']['mailbody'])) {
						parent::logAction(__FUNCTION__, 'mail', $mail['Mail']['id']);
						$this->Mail->set( [ 'mailsent' => date('Y-m-d H:i:s') ] );
						$this->Mail->save();
						$mailrcmsg = 'De e-mail is verzonden naar '.$mail['Mail']['name'].'.';
						$mailrc = 0;
					} else {
						$mailrcmsg = 'De e-mail verzenden naar '.$mail['Mail']['name'].' is mislukt.';
						$mailrc = 8;
					}
				} catch ( Exception $e ) {
					$mailrcmsg = 'Mail exception naar '.$mail['Mail']['name'].'. Mogelijk mail server probleem.';
					$mailrc = 16;
				}
			}
		} else {
			$mailrcmsg = 'Er is geen e-mail verzonden. Geen mail.';
			$mailrc = 4;
		}
		return [ 'id' => $mailid, 'rc' => $mailrc, 'msg' => $mailrcmsg ];
	}


	public function delete($id = null) {
		if (isset($id)) {
			$this->Mail->id = $id;
			if (!$this->Mail->exists()) {
				$this->Session->setFlash(__('Deze mail bestaat niet. Er werd geen mail verwijderd.'), "flash-error");
			} else {
				$naam = $this->Mail->field('name');
				if ($this->Mail->field('season') == $this->currentSeason) {
					if ($this->Mail->delete($id, true)) {
						$this->Session->setFlash(__('De mail voor ' . $naam . ' werd verwijderd.'), "flash-info");
						parent::logAction(__FUNCTION__, 'mail', $id);
					} else {
						$this->Session->setFlash(__('De mail kon niet verwijderd worden.'), "flash-error");
					}
				} else {
					$this->Session->setFlash(__('De mail is niet van het huidige seizoen.'), "flash-error");
				}
			}
		} else {
			$this->Session->setFlash(__('Geen mail meegegeven om te verwijderen'), "flash-error");
		}
		//$this->redirect(array('controller' => 'mails', 'action' => 'index'));
	}


}
?>
