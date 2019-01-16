<?php
class MeteringsController extends AppController {

	//var $scaffold;

	var $meteringvalues = array(
					'score_presence' => array(
								'label' => 'Aanwezigheden',
								'options' => array(	0 => '0 - komt zeer zelden (< 10%)',
													1 => '1 - vaak afwezig (10% - 50%)',
													2 => '2 - regelmatig afwezig (50% - 70%)',
													3 => '3 - altijd aanwezig behalve voor school of reizen (> 70%)',
													4 => '4 - altijd aanwezig behalve voor examens of reizen (> 80%)',
													5 => '5 - komt quasi altijd (> 90%)'),
								'empty' => true
							),
					'score_effort' => array(
								'label' => 'Inzet',
								'options' => array(	0 => '0 - traint zonder inzet en stoort de training',
													1 => '1 - weinig inzet, geeft snel op als het niet lukt',
													2 => '2 - loopt er de kantjes af, doet de opdrachten alleen wanneer gemonitord',
													3 => '3 - traint correct, niet meer maar ook niet minder',
													4 => '4 - werkt hard op training, met inzet en motivatie',
													5 => '5 - kan niet genoeg krijgen van de trainingen, traint individueel nog bij of neemt deel aan extra trainingen'),
								'empty' => true
							),
					'score_ambition' => array(
								'label' => 'Ambitie',
								'options' => array(	0 => '0 - komt niet uit eigen keuze of overtuiging',
													1 => '1 - ziet volleybal als een hobby wanneer hij/zij zin heeft',
													2 => '2 - ziet volleybal als hobby maar met commitment',
													3 => '3 - wil het maximum uit zichzelf halen',
													4 => '4 - wil top van VCW bereiken',
													5 => '5 - wil absoluut hogerop'),
								'empty' => true
							),
					'score_overhand' => array(
								'label' => 'Bovenhands spelen',
								'options' => array(	0 => '0 - vangen en gooien',
													1 => '1 - vangen, opgooien, toets',
													2 => '2 - toets na bots',
													3 => '3 - controletoets en hoge toets',
													4 => '4 - onmiddellijke toets',
													5 => '5 - + frontaliteit'),
								'empty' => true
							),
					'score_underhand' => array(
								'label' => 'Onderhands spelen',
								'options' => array(	0 => '0 - vangen en gooien',
													1 => '1 - vangen, opgooien, spelen',
													2 => '2 - onderhands na bots',
													3 => '3 - onderhands controle voor zichzelf',
													4 => '4 - onmiddellijke receptie',
													5 => '5 - + frontaliteit'),
								'empty' => true
							),
					'score_stroke' => array(
								'label' => 'Slagbeweging',
								'options' => array(	0 => '0 - geen / stoot',
													1 => '1 - armslag',
													2 => '2 - + polsslag',
													3 => '3 - + uitzwaai',
													4 => '4 - + wapening',
													5 => '5 - + romprotatie'),
								'empty' => true
							),
					'score_feetwork' => array(
								'label' => 'Voetenplaatsing',
								'options' => array(	0 => '0 - geen',
													1 => '1 - lichte spreiding',
													2 => '2 - split',
													3 => '3 - split + buitenvoet voor',
													4 => '4 - + balans vooruit (op de bal van de voet)',
													5 => '5 - + armen los, klaar voor verdediging'),
								'empty' => true
							),
					'score_runup' => array(
								'label' => 'Aanloopbeweging',
								'options' => array(	0 => '0 - uit stand, geen correcte voetenplaatsing',
													1 => '1 - juiste voetenplaatsing',
													2 => '2 - juiste aanloop zonder sprong',
													3 => '3 - juiste aanloop met sprong',
													4 => '4 - idem, van buiten naar binnen',
													5 => '5 - idem inclusief armswing'),
								'empty' => true
							),
					'score_serve' => array(
								'label' => 'Opslag',
								'options' => array(	0  => '0 - gooien / toetsen',
													1  => '1 - onderhands',
													2  => '2 - topspin',
													3  => '3 - float',
													4  => '4 - float of topspin gericht',
													5  => '5 - zowel float als topspin gericht',
													6  => '6 - topspin jump',
													7  => '7 - jumpfloat',
													8  => '8 - zowel jumpfloat als topspin jump',
													9  => '9 - jumpfloat of topspin jump gericht',
													10 => '10 - zowel jumpfloat als topspin jump gericht'),
								'empty' => true
							),
					'score_pass' => array(
								'label' => 'Receptie',
								'options' => array(	0 =>  '0 - problemen om bal te vangen',
													1  => '1 - positionering achter de bal',
													2  => '2 - beweging met sides',
													3  => '3 - communicatie (ik/jij)',
													4  => '4 - vorming van correct plateau, zonder parasietbewegingen',
													5  => '5 - correcte voetenplaatsing',
													6  => '6 - frontaliteit naar setter',
													7  => '7 - inkanteling van de schouders',
													8  => '8 - differentiatie naargelang topspin of float',
													9  => '9 - receptie met 3',
													10 => '10 - coaching van de receptie'),
								'empty' => true
							),
					'score_set' => array(
								'label' => 'Pas',
								'options' => array(	0  => '0 - geen',
													1  => '1 - voorwaarts over korte afstand, hoge balcurve',
													2  => '2 - laterale positie tov net, netvoet voor',
													3  => '3 - voor- en achterwaardse pas over 4m',
													4  => '4 - inlopen met pivot',
													5  => '5 - gesprongen pas voor en achteruit over 4m',
													6  => '6 - pas voor en achteruit, en half snel midden',
													7  => '7 - spelverdeling over voorste aanvalsposities, meestal half snel',
													8  => '8 - spelverdeling over 5 aanvalsposities',
													9  => '9 - spelverdeling over 5 posities in 3 tempo\'s',
													10 => '10 - gesprongen spelverdeling, meestal in half snel tempo'),
								'empty' => true
							),
					'score_attack' => array(
								'label' => 'Aanval',
								'options' => array(	0 =>  '0 - geen',
													1  => '1 - correcte homepositie',
													2  => '2 - topspinslag zonder sprong',
													3  => '3 - topspinslag, bal hoog genomen',
													4  => '4 - topspinslag met sprong',
													5  => '5 - aanval op hoge aanspeelballen',
													6  => '6 - aanval met bewuste slagrichting',
													7  => '7 - aanval met bewuste afwisseling in "shots"',
													8  => '8 - 3-meter aanval',
													9  => '9 - aanval in verschillende tempo\'s',
													10 => '10 - aanval mét blok (blok-out scoring)'),
								'empty' => true
							),
					'score_block' => array(
								'label' => 'Blok',
								'options' => array(	0  => '0 - geen bewustzijn van blok',
													1  => '1 - uitgangspositie aan het net',
													2  => '2 - uitgangspositie aan het net',
													3  => '3 - verplaatsing met sides',
													4  => '4 - squatblok',
													5  => '5 - uitvoeren 2-mansblok',
													6  => '6 - crossbeweging',
													7  => '7 - bal / man blokken',
													8  => '8 - communicatie open / gesloten',
													9  => '9 - zoneblok (met doel specifieke zone van het veld af te schermen)',
													10 => '10 - assist'),
								'empty' => true
							),
					'score_defense' => array(
								'label' => 'Verdediging',
								'options' => array(	0  => '0 - geen',
													1  => '1 - durf, inzet, attitude om naar bal te gaan',
													2  => '2 - kort / ver bewustzijn',
													3  => '3 - correcte uitgangsposities',
													4  => '4 - correcte verplaatsingen / oriëntatie naargelang aanval',
													5  => '5 - verdedeging met controle, hoog, in centrum van veld',
													6  => '6 - besef 1st - 3 de tijd',
													7  => '7 - mogelijkheid tot verwerking van harde ballen',
													8  => '8 - correcte reactie op plaatsballen',
													9  => '9 - bewustzijn van, en leiding over, persoonlijke defense zone',
													10 => '10 - aanpassing aan tegenstander (strategie en individuele spelers)'),
								'empty' => true
							)
					);


	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
		//$this->Auth->deny('index');
	}


	public function index() {
		$fields = array('DISTINCT Metering.member_id', 'CONCAT(Member.firstname, " ", Member.lastname) as lid', 'count(Metering.member_id) as aantal', 'max(Metering.metering_date) as laatste');
		$conditions = array('Metering.id >' => '0');
		$group = 'member_id';
		$order = array('laatste DESC');
		$this->set('meterings', $this->Metering->find('all', array('fields' => $fields, 'conditions' => $conditions, 'group' => $group, 'order' => $order)));
	}


	public function viewmember($memberid = null) {
		/// Load other models
		$this->loadModel('Member');
		$this->Member->id = $memberid;
		$this->Member->unbindModel(array('belongsTo' => array('Picturelicense'), 'hasMany' => array('Teammember', 'Coach', 'User')));
		$this->set('member', $this->Member->read());
		$conditions = array('Metering.member_id' => $memberid);
		$order = array('metering_date DESC');
		$this->Metering->unbindModel(array('belongsTo' => array('Member')));
		$this->set('meterings', $this->Metering->find('all', array('conditions' => $conditions, 'recursive' => 0, 'order' => $order)));
	}


	public function view($id = null) {
		$this->Metering->id = $id;
		$this->Metering->recursive = 2;
		$this->set('metering', $this->Metering->read());
		$this->set('meteringvalues', $this->meteringvalues);
	}


	public function add($memberid = null) {
		if (!empty($this->request->data)) {
			if ($this->Metering->save($this->request->data)) {
				$this->Session->setFlash('De meting werd bewaard.', "flash-info");
				parent::logAction(__FUNCTION__, "metering", $this->Metering->id);
				if ($memberid <> null) {
					$this->redirect(array('action' => 'viewmember/' . $memberid));
				} else {
					$this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash('De meting kon niet worden bewaard.', "flash-error");
				if ($memberid <> null) {
					$this->request->data['Metering']['member_id'] = $memberid;
				}
				$this->set('members', $this->Metering->Member->find('list', array('conditions' => array('Member.firstname <>' => ''), 'recursive' => -1, 'order' => array('firstname', 'lastname'))));
			}
		} else {
			if ($memberid <> null) {
				$this->request->data['Metering']['member_id'] = $memberid;
			}
			$this->set('members', $this->Metering->Member->find('list', array('conditions' => array('Member.firstname <>' => ''), 'recursive' => -1, 'order' => array('firstname', 'lastname'))));
			$this->set('meteringvalues', $this->meteringvalues);
			$this->set('meteringdate', date("Y-m-d"));
		}
	}


}
