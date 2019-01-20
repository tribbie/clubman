<?php
App::uses('CakeEmail', 'Network/Email');
class SubscriptionsController extends AppController {

	/// Include the RequestHandler, it makes sure the proper layout and views files are used (for csv and pdf)
	/// Also check your routes.php for Router::parseExtensions('pdf', 'csv');
	var $components = array('RequestHandler');

	var $scaffold;

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('subscribe', 'confirm', 'testmail', 'mailSubscription');
		//$this->Auth->deny('index');
	}


	public function listevent($eventid = null) {
		if (!$eventid) {
			$this->Session->setFlash('Je inschrijving kon niet worden bewaard.', "flash-error");
		} else {
			$this->loadModel('Event');
			$this->Event->id = $eventid;
			//$this->Event->recursive = -1;
			if (!$this->Event->exists()) {
				throw new NotFoundException(__('Dit evenement bestaat niet!'));
			} else {
				$fields = ['Event.id', 'Event.season', 'Event.name', 'Event.event_date_start', 'Event.event_date_end', 'Event.category', 'Event.status', 'Event.title', 'Event.subtitle', 'Event.subscribe_extra'];
				$event = $this->Event->read($fields);
			}
		}
		$this->set('event', $event);
	}


	public function subscribe($eventid = null) {
		$extra = null;
		$subsdates = array();
		$subscriptionmsg = array();
		$subscriptionmsg['text'] = 'initial error message';
		$subscriptionmsg['class'] = 'default';
		$subscriptionmsg['form'] = false;
		if (!empty($this->request->data)) {
			$epoch = time();
			$hashprep = 'subscription-'.$this->currentSeason.'-'.$epoch.'-'.trim($this->request->data['Subscription']['subsemail']);
			$this->request->data['Subscription']['subshashprep'] = $hashprep;
			$this->request->data['Subscription']['subshash'] = md5($hashprep);
			$this->request->data['Subscription']['epoch'] = $epoch;
			$oneSubscription = array();
			$oneSubscription['Subscription']['event_id']	= $this->request->data['Subscription']['event_id'];
			$oneSubscription['Subscription']['season']		= $this->request->data['Subscription']['season'];
			$oneSubscription['Subscription']['substitle']	= $this->request->data['Subscription']['substitle'];
			$oneSubscription['Subscription']['subshash']	= $this->request->data['Subscription']['subshash'];
			$oneSubscription['Subscription']['subsname']	= $this->request->data['Subscription']['subsname'];
			$oneSubscription['Subscription']['subsemail']	= $this->request->data['Subscription']['subsemail'];
			$oneSubscription['Subscription']['remark']		= '';
			if ($this->request->data['Subscription']['extra']) {
				$oneSubscription['Subscription']['extra'] = json_encode($this->request->data['Subscription']['extra']);
			}
			if ($this->Subscription->save($oneSubscription)) {
				$mailmessage = $this->mailSubscription($oneSubscription);
				$this->Session->setFlash('Je inschrijving werd bewaard. ' . $mailmessage, "flash-info");
				parent::logAction(__FUNCTION__, "subscription", $this->Subscription->id);
				$this->redirect(array('controller' => 'events', 'action' => 'view', 'id' => $eventid));
			} else {
				$this->Session->setFlash('Je inschrijving kon niet worden bewaard.', "flash-error");
			}
			$this->set('subscriptiondata', $this->request->data);
			/// debug
			$this->set('subscription', $oneSubscription);
		}
		$this->loadModel('Event');
		$this->Event->id = $eventid;
		if (!$this->Event->exists()) {
			//throw new NotFoundException(__('Dit evenement bestaat niet!'));
			$this->Session->setFlash('Dit evenement bestaat niet!', "flash-error");
			$this->redirect('/');
		}
		$this->Event->recursive = -1;
		$event = $this->Event->read();
		if ($event['Event']['subscribe_able'] == false) {
			$subscriptionmsg['text'] = 'Voor dit evenement kan je je niet inschrijven!';
			$subscriptionmsg['class'] = 'warning';
			$subscriptionmsg['form'] = false;
			//throw new NotFoundException(__('Voor dit evenement kan je je niet inschrijven!'));
		} else {
			$subsdates['now'] = strtotime('today midnight');
			$subsdates['begin'] = strtotime($event['Event']['subscribe_date_start']);
			$subsdates['end'] = strtotime($event['Event']['subscribe_date_end']);
			if (($subsdates['now'] < $subsdates['begin']) or ($subsdates['now'] > $subsdates['end'])) {
				$subscriptionmsg['text'] = 'De inschrijvingen voor dit evenement zijn vandaag (' . date('d-m-Y', $subsdates['now']) . ') niet mogelijk!<br/>';
				$subscriptionmsg['text'] .= 'Inschrijvingen mogelijk van ' . date('d-m-Y', $subsdates['begin']) . ' tot en met ' . date('d-m-Y', $subsdates['end']);
				$subscriptionmsg['class'] = 'warning';
				$subscriptionmsg['form'] = false;
				//throw new NotFoundException(__('De inschrijvingen voor dit evenement zijn momenteel niet (meer) mogelijk! --' . date('d-m-Y', $subsdates['begin']) . '-' . date('d-m-Y', $subsdates['now']) . '-' . date('d-m-Y', $subsdates['end'])));
			} else {
				$subscriptionmsg['text'] = 'Inschrijven kan nog tot en met ' . date('d-m-Y', $subsdates['end']) . '.';
				$subscriptionmsg['class'] = 'info';
				$subscriptionmsg['form'] = true;
			}
			/// We always prepare the "extra", because root can always subscribe, even outside the subscription window
			if ($event['Event']['subscribe_extra'] == false) {
			} else {
				$extra = json_decode($event['Event']['subscribe_extra'], true);
			}
		}
		$this->set('subsdates', $subsdates);
		$this->set('event', $event);
		$this->set('extra', $extra);
		$this->set('subscriptionmsg', $subscriptionmsg);
	}


	public function mailSubscription($subscription = null) {
		/// Be sure to enable (allow) this in the beforefilter
		if ($subscription) {
			$email = new CakeEmail($this->cmclub['environment']['mail']);
			$email->template('subscription', 'clubmanplain')
			    	->emailFormat('html')
			    	->to($subscription['Subscription']['subsemail'])
						->bcc($this->cmclub['clubmail']['subscriptions']['email'])
			    	->from($this->cmclub['clubmail']['webmailer']['email']);
			$email->subject($this->cmclub['shortname'] . ' -- Inschrijving evenement -- ' . $subscription['Subscription']['substitle']);
			if ($subscription['Subscription']['extra']) {
				$subscription['Subscription']['extrafields'] = json_decode($subscription['Subscription']['extra']);
			}
			$email->viewVars(array('subscription' => $subscription, 'clubconfig' => $this->cmclub));
			if ($email->send()) {
				$mailrcmsg = 'De e-mail is verzonden.';
			} else {
				$mailrcmsg = 'De e-mail verzenden is mislukt.';
			}
		} else {
			$mailrcmsg = 'De e-mail is niet verzonden. Geen inschrijving.';
		}
		return $mailrcmsg;
	}


	public function confirm($hash = null) {
		if (!$hash) {
			$this->Session->setFlash(__('Ongeldige inschrijving.', true), "flash-error");
			$this->redirect('/');
		} else {
			$subscription = $this->Subscription->findBySubshash($hash);
			if (!$subscription) {
				$this->Session->setFlash(__('Ongeldige inschrijving.', true), "flash-error");
				$this->redirect('/');
			} else {
				$update_subscription = array();
				$update_subscription['Subscription']['id'] = $subscription['Subscription']['id'];
				$update_subscription['Subscription']['confirmed'] = true;
				$update_subscription['Subscription']['confirmed_stamp'] = date('Y-m-d H:i:s');
				if ($this->Subscription->save($update_subscription)) {
					$mailmessage = $this->mailConfirmation($subscription);
					$this->Session->setFlash('Je inschrijving is bevestigd. ' . $mailmessage, "flash-info");
					parent::logAction(__FUNCTION__, 'subscription', $subscription['Subscription']['id']);
					$this->redirect(array('controller' => 'events', 'action' => 'view', 'id' => $subscription['Subscription']['event_id']));
				} else {
					$this->Session->setFlash(__('Je inschrijving kon niet worden bevestigd.'), "flash-error");
				}
			}
		}
	}


	public function mailConfirmation($subscription = null) {
		/// Be sure to enable (allow) this in the beforefilter
		if ($subscription) {
			$email = new CakeEmail($this->cmclub['environment']['mail']);
			$email->template('confirmation', 'clubmanplain')
			    	->emailFormat('html')
			    	->to($subscription['Subscription']['subsemail'])
						->bcc($this->cmclub['clubmail']['subscriptions']['email'])
			    	->from($this->cmclub['clubmail']['webmailer']['email']);
			$email->subject($this->cmclub['shortname'] . ' -- Bevestiging inschrijving evenement -- ' . $subscription['Subscription']['substitle']);
			if ($subscription['Subscription']['extra']) {
				$subscription['Subscription']['extrafields'] = json_decode($subscription['Subscription']['extra']);
			}
			$email->viewVars(array('subscription' => $subscription, 'clubconfig' => $this->cmclub));
			if ($email->send()) {
				$mailrcmsg = 'Een e-mail is verzonden.';
			} else {
				$mailrcmsg = 'De e-mail verzenden is mislukt.';
			}
		} else {
			$mailrcmsg = 'De e-mail is niet verzonden. Geen inschrijving.';
		}
		return $mailrcmsg;
	}


	public function cancelSubscription($id = null, $hash = null) {
		if ((!$hash) or (!$id)) {
			$this->Session->setFlash(__('Ongeldige schrappingspoging. Je moet id en hash meegeven.', true), "flash-error");
			$this->redirect('/');
		} else {
			$subscription = $this->Subscription->findBySubshash($hash);
			if (!$subscription) {
				$this->Session->setFlash(__('Ongeldige inschrijving.', true), "flash-error");
				$this->redirect('/');
			} elseif ($id <> $subscription['Subscription']['id']) {
				$this->Session->setFlash(__('Ongeldige schrappingspoging. De id en hash horen niet bij elkaar.', true), "flash-error");
				$this->redirect('/');
			} else {
				$cancel_subscription = array();
				$cancel_subscription['Subscription']['id'] = $subscription['Subscription']['id'];
				$cancel_subscription['Subscription']['confirmed'] = false;
				$cancel_subscription['Subscription']['remark'] = $subscription['Subscription']['remark'] . ($subscription['Subscription']['remark'] == "" ? "" : " " ) . "geannuleerd.";
				//$cancel_subscription['Subscription']['confirmed_stamp'] = date('Y-m-d H:i:s');
				if ($this->Subscription->save($cancel_subscription)) {
					//$mailmessage = $this->mailConfirmation($subscription);
					$this->Session->setFlash('De inschrijving is geschrapt.', "flash-info");
					parent::logAction(__FUNCTION__, 'subscription', $subscription['Subscription']['id']);
					$this->redirect(array('controller' => 'subscriptions', 'action' => 'listevent', $subscription['Subscription']['event_id']));
					//$this->redirect(array('controller' => 'events', 'action' => 'view', 'id' => $subscription['Subscription']['event_id']));
				} else {
					$this->Session->setFlash(__('De inschrijving kon niet worden geschrapt.'), "flash-error");
					$this->redirect('/');
				}
			}
		}
	}


	public function reconfirmSubscription($id = null, $hash = null) {
		if ((!$hash) or (!$id)) {
			$this->Session->setFlash(__('Ongeldige bevestigingspoging. Je moet id en hash meegeven.', true), "flash-error");
			$this->redirect('/');
		} else {
			$subscription = $this->Subscription->findBySubshash($hash);
			if (!$subscription) {
				$this->Session->setFlash(__('Ongeldige inschrijving.', true), "flash-error");
				$this->redirect('/');
			} elseif ($id <> $subscription['Subscription']['id']) {
				$this->Session->setFlash(__('Ongeldige bevestigingspoging. De id en hash horen niet bij elkaar.', true), "flash-error");
				$this->redirect('/');
			} else {
				$reconfirm_subscription = array();
				$reconfirm_subscription['Subscription']['id'] = $subscription['Subscription']['id'];
				$reconfirm_subscription['Subscription']['confirmed'] = true;
				$reconfirm_subscription['Subscription']['confirmed_stamp'] = date('Y-m-d H:i:s');
				if ($subscription['Subscription']['confirmed_stamp'] == false) {
					$reconfirm_subscription['Subscription']['remark'] = $subscription['Subscription']['remark'] . ($subscription['Subscription']['remark'] == "" ? "" : " " ) . "bevestigd.";
				} else {
					$reconfirm_subscription['Subscription']['remark'] = $subscription['Subscription']['remark'] . ($subscription['Subscription']['remark'] == "" ? "" : " " ) . "(her)bevestigd.";
				}
				if ($this->Subscription->save($reconfirm_subscription)) {
					$this->Session->setFlash('De inschrijving is geherconfirmeerd.', "flash-info");
					parent::logAction(__FUNCTION__, 'subscription', $subscription['Subscription']['id']);
					$this->redirect(array('controller' => 'subscriptions', 'action' => 'listevent', $subscription['Subscription']['event_id']));
					//$this->redirect(array('controller' => 'events', 'action' => 'view', 'id' => $subscription['Subscription']['event_id']));
				} else {
					$this->Session->setFlash(__('De inschrijving kon niet worden (her)bevestigd.'), "flash-error");
					$this->redirect('/');
				}
			}
		}
	}


	public function testmail($type = 'simple') {
		/// Be sure to enable (allow) this in the beforefilter
		$messagebody = 'Iemand heeft een testmail gestuurd.';
		$email = new CakeEmail($this->cmclub['environment']['mail']);
		switch ($type) {
			case 'simple':
					$email->sender(array($this->cmclub['clubmail']['webmailer']['email'] => $this->cmclub['clubmail']['webmailer']['name']));
					//$email->cc(array('bart@oblivio.be'));
			    break;
			case 'text':
					$email->template('default', 'default')
					    	->emailFormat('text');
					$email->viewVars(array('value' => 12345));
			    break;
			case 'html':
					$email->template('default', 'default')
					    	->emailFormat('html');
			    break;
			case 'both':
					$email->template('default', 'default')
					    	->emailFormat('both');
					break;
			default:
				$this->Session->setFlash('De test e-mail ('.$type.') verzenden is mislukt.', "flash-error");
				$this->redirect('/');
		}
		$email->from(array($this->cmclub['clubmail']['webmailer']['email'] => $this->cmclub['clubmail']['webmailer']['name']));
		$email->to('seghersb@gmail.com');
		$email->subject($this->cmclub['shortname'] . ' -- testmail (' . $type . ') van de website');
		if ($email->send($messagebody)) {
			$this->Session->setFlash('De test e-mail ('.$type.') is verzonden.', "flash-info");
		} else {
			$this->Session->setFlash('De test e-mail ('.$type.') verzenden is mislukt.', "flash-error");
		}
		//$this->redirect('/');
	}

}
