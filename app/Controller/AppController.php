<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('ClubmanUtilityLib', 'Lib'); ### my own Clubman Utility Library - file is in /APP/Lib/ named ClubmanUtilityLib.php
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	/// Enable themes
	public $theme;
	/// Enable the helpers for the views
	public $helpers = array('Markdown.Markdown', 'Permission');
	/// Enable authorization component, and configure it
	public $components = array(
		'Session',
		'Auth' => array(
			'authenticate'   => array('Form' => array('scope' => array('User.active' => true))),
			'authorize'      => array('Controller'),
			'loginRedirect'  => array('controller' => 'users', 'action' => 'profile'),
			'logoutRedirect' => array('controller' => 'pages', 'action' => 'home'),
			'authError'      => 'Verboden toegang!',
			'loginError'     => 'Oei. Niet juist.'
		),
		'Calendar',
		'Magazine'
	);
	//public $cmUtil = new ClubmanUtilityLib();

	/// Here we will put the "current season" from the globally defined configuration (in bootstrap.php) -- see below
	var $currentSeason = '';
	var $currentYears = array();
	var $weekdays = array(0 => 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag', 'zondag');
	var $shortweekdays = array(0 => 'ma', 'di', 'wo', 'do', 'vr', 'za', 'zo');
	var $cmCurrentRoles = array();

	var $cmmenuMerged = array();
	var $cmmenu = array();

	var $cmaclMerged = array();
	var $cmacl = array();
	var $cmuserrolehome = array(
							'root'           => array('controller' => 'pages',       'action' => 'home'),
							'admin'          => array('controller' => 'pages',       'action' => 'home'),
							'teamadmin'      => array('controller' => 'teams',       'action' => 'index'),
							'gameadmin'      => array('controller' => 'teams',       'action' => 'index'),
							'memberadmin'    => array('controller' => 'members',     'action' => 'index'),
							'trainerfinance' => array('controller' => 'efforts',     'action' => 'reports'),
							'memberfinance'  => array('controller' => 'members',     'action' => 'index'),
							'memberview'     => array('controller' => 'members',     'action' => 'index'),
							'memberedit'     => array('controller' => 'members',     'action' => 'index'),
							'trainer'        => array('controller' => 'teams',       'action' => 'index'),
							'enqueteur'      => array('controller' => 'enquetes',    'action' => 'index'),
							'member'         => array('controller' => 'users',       'action' => 'profile')
						);
	var $loggedIn = false;
	var $currentUser = false;
	var $teampriorities = array(
							1  => 'Hoofdteam',
							2  => 'Dubbelteam',
							3  => 'Derde team',
							4  => 'Vierde team',
							5  => 'Vijfde team',
							9  => 'Extra team',
							0  => 'Begeleiding',
							10 => 'Niet spelend lid',
							99 => 'Gestopt (bij het team of bij de club)'
						);


	public function isAuthorized($user) {
		/// For testing only ... default allow ... all doors are wide open!
		//return true;
		/// special user 'root' can access every action, he is not subject to the acl array
		if (isset($user['role']) && ($user['role'] === 'root')) {
			return true;
		} else {
			//$this->cmCurrentRoles = explode(',', $this->cmaclrequest['cmrole']);
			$this->cmaclMerged = $this->mergeAcl($this->cmCurrentRoles, $this->cmacl);
			if (isset($this->cmaclMerged[$this->cmaclrequest['cmcontroller']][$this->cmaclrequest['cmaction']]) and ($this->cmaclMerged[$this->cmaclrequest['cmcontroller']][$this->cmaclrequest['cmaction']] > 0)) {
				return true;
			} else {
				$this->Session->setFlash('Nonono. Verboden toegang.', "flash-error");
				return false;
			}
		}
		/// Default = deny
		return false;
	}

	public function mergeAcl($theroles, $theacl) {
		/// This function will merge the acl array
		/// First, create an empty array
		$mergedarray = array();
		/// Then, merge each role into the new acl
		foreach (array_keys($theacl['dummy']) as $controller) {
			$mergedarray[$controller] = array();
			foreach ($theroles as $onerole) {
				$mergedarray[$controller] = array_merge($mergedarray[$controller], $theacl[$onerole][$controller]);
			}
		}
		return $mergedarray;
	}

	public function mergeMenu($theroles, $themenu) {
		/// This function will merge the menu array
		/// First, create an empty array
		$mergedarray = array();
		/// Then, merge each role into the menu acl
		foreach ($theroles as $onerole) {
			$mergedarray = array_merge($mergedarray, $themenu[$onerole]);
		}
		return $mergedarray;
	}

	public function beforeFilter() {
		/// First things first!
		$this->cakeversion = Configure::version();
		/// Load the Clubman specific config file - general Clubman information
		$this->currentClubman = Configure::read('Clubman');
		/// Load the Clubman specific config file - Club information
		$this->cmclub = Configure::read('Club');
		/// Set important season config!
		$this->currentSeason = Configure::read('Clubman.currentseason');
		$this->currentYears = explode('-', $this->currentSeason);
		$this->allowLogin = Configure::read('Clubman.allowlogin');
		/// Set logged in state
		$this->loggedIn = $this->Auth->loggedIn();
		$this->currentUser = $this->Auth->user();
		if (! isset($this->currentUser['role'])) {
			$this->currentUser['role'] = 'visitor';
		}
		/// Determines what non-logged-in users have access to
		/// This will allow display WITHOUT ANY authentication -- maybe a nice way to put most pages of the "normal website" in the Pages views
		$this->Auth->allow('display');
		/// Prepare acl request
		$this->cmaclrequest = array('cmrole' => $this->currentUser['role'], 'cmcontroller' => $this->name, 'cmaction' => $this->action);
		if ($this->loggedIn) {
			/// Load the Clubman specific config file - Clubman navigation menu
			$this->cmmenu = Configure::read('Menuman');
			/// Load the Clubman specific config file - Clubman permissions
			$this->cmacl = Configure::read('Permissions');
			//// TEST SHIZZLE -- $this->cmCurrentRoles = array($this->cmaclrequest['cmrole'], 'trainer', 'member');
			$this->cmCurrentRoles = explode(',', $this->currentUser['role']);
			$this->cmmenuMerged = $this->mergeMenu($this->cmCurrentRoles, $this->cmmenu['items']);
			/// Set the Clubman theme (from the clubman config)
		 	$this->theme = $this->cmclub['clubman']['theme'];
		} else {
			/// Load the Clubweb specific config file - Clubweb navigation menu
			$this->cmmenu = Configure::read('Menuweb');
			$this->cmmenuMerged = $this->cmmenu;
			/// Set the Clubweb theme (from the clubman config)
			$this->theme = $this->cmclub['clubweb']['theme'];
		}
	}

	public function beforeRender() {
		$this->set('cakeversion', $this->cakeversion);
		$this->set('currentClubman', $this->currentClubman);
		$this->set('currentClub', $this->cmclub);
		$this->set('loggedIn', $this->loggedIn);
		$this->set('currentUser', $this->currentUser);
		$this->set('cmaclMerged', $this->cmaclMerged);
		$this->set('cmmenuMerged', $this->cmmenuMerged);
		$this->set('currentSeason', $this->currentSeason);
		$this->set('weekdays', $this->weekdays);
		$this->set('shortweekdays', $this->shortweekdays);
		/// Fetch teams for the menu
		$this->loadModel('Team');
		$this->Team->recursive = -1;
		$clubmanteamsfields = array('Team.id', 'Team.name', 'Team.shortname');
		$clubmanteams['jeugd'] = $this->Team->find('all', array('fields' => $clubmanteamsfields, 'conditions' => array('Team.category' => array('U19', 'U17', 'U15', 'U13', 'U11', 'U9', 'Bengels'))));
		$clubmanteams['jeugdcompetitie'] = $this->Team->find('all', array('fields' => $clubmanteamsfields, 'conditions' => array('Team.category' => array('U19', 'U17', 'U15', 'U13', 'U11', 'U9', 'Bengels'), 'Team.series <>' => 'beker')));
		$clubmanteams['seniors'] = $this->Team->find('all', array('fields' => $clubmanteamsfields, 'conditions' => array('Team.category' => array('Seniors')), 'order' => array('Team.name')));
		$clubmanteams['beach'] = $this->Team->find('all', array('fields' => $clubmanteamsfields, 'conditions' => array('Team.teamtype' => array('beachvolley')), 'order' => array('Team.name')));
		$clubmanteams['bestuur'] = $this->Team->find('all', array('fields' => $clubmanteamsfields, 'conditions' => array('Team.category' => array('Bestuur'))));
		$this->set('clubmanteams', $clubmanteams);
		/// Fetch calendar items for this week
		$weekkalender = $this->Calendar->fetchWeek();
		$this->set('weekkalender', $weekkalender);
		/// Fetch magazines for this season
		$shortmagazines = $this->Magazine->fetchLastMagazine($this->currentSeason);
		$this->set('shortmagazines', $shortmagazines);
		/// Fetch published events for this season
		$this->loadModel('Event');
		$this->Event->recursive = -1;
		$shorteventsfields = array('Event.id', 'Event.name', 'Event.title', 'Event.year');
		#$yesterdaymidnight = strtotime('yesterday midnight');
		$todaymidnight = strtotime('today midnight');
		$shorteventsconditions = array(
				//'Event.season >=' => $this->currentSeason,
				'Event.publish_date_start_epoch <=' => $todaymidnight,
				'Event.publish_date_end_epoch >=' => $todaymidnight,
				'Event.status' => 'public'
			);
		$shorteventsorder = array('Event.event_date_start DESC');
		$shortevents = $this->Event->find('all', array('fields' => $shorteventsfields, 'conditions' => $shorteventsconditions, 'order' => $shorteventsorder));
		$this->set('shortevents', $shortevents);
		/// Fetch published newsitems
		$this->loadModel('Newsitem');
		$this->Newsitem->recursive = -1;
		$shortnewsitemsfields = array('Newsitem.id', 'Newsitem.name', 'Newsitem.title', 'Newsitem.subtitle', 'Newsitem.season', 'Newsitem.image_url', 'Newsitem.content', 'Newsitem.activate', 'Newsitem.activate_epoch', 'Newsitem.expire', 'Newsitem.expire_epoch');
		$shortnewsitemsconditions = array(
				//'Newsitem.season >=' => $this->currentSeason,
				'Newsitem.activate_epoch <=' => $todaymidnight,
				'Newsitem.expire_epoch >=' => $todaymidnight,
				'Newsitem.status' => 'public'
			);
		$shortnewsitemsorder = array('Newsitem.season DESC', 'Newsitem.itemdate DESC', 'Newsitem.created DESC');
		$shortnewsitems = $this->Newsitem->find('all', array('fields' => $shortnewsitemsfields, 'conditions' => $shortnewsitemsconditions, 'order' => $shortnewsitemsorder));
		$this->set('shortnewsitems', $shortnewsitems);
		/// Fetch campmagazines for this season
		$campmagazines = $this->Magazine->fetchCampMagazines($this->currentSeason);
		$this->set('campmagazines', $campmagazines);
		/// diagnostics
		$this->set('cmclub', $this->cmclub);
		//$this->set('cmmenu', $this->cmmenu);
		//$this->set('cmacl', $this->cmacl);
		$this->set('cmaclrequest', $this->cmaclrequest);
		$this->set('therequest', $this->Auth->request);
		$this->set('cmCurrentRoles', $this->cmCurrentRoles);
		//$this->set('cmuserrolehome', $this->cmuserrolehome);
		//$this->set('cmcompleteConfig', Configure::read());
	}

	/**
	 * This function is used for audit logging
	 *
	 * In your controller, whenever an action was successful, you can add an audit record
	 * by calling this method with the 3 parameters: the action, the model and the model id.
	 */
	public function logAction($theaction, $themodel = '', $themodelid = 0) {
		if ($themodelid == null) {
			$themodelid = 0;
		}
		$this->loadModel('Auditrecord');
		$this->Auditrecord->create();
		$thisrecord = array('Auditrecord' =>  array(
										"userid"    => $this->Auth->user('id'),
										"username"  => $this->Auth->user('username'),
										"userrole"  => $this->Auth->user('role'),
										"userip"    => $_SERVER['REMOTE_ADDR'],
										"useragent" => substr($_SERVER['HTTP_USER_AGENT'], 0, 256),
										"action"    => $theaction,
										"model"     => $themodel,
										"modelid"   => $themodelid,
										"remark"    => "")
									);
		$this->Auditrecord->save($thisrecord);
	}

}
