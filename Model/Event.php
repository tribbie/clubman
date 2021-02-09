<?php
App::uses('File', 'Utility');

class Event extends AppModel {
	public $name = 'Event';

	public $virtualFields = array(
			'year' => 'date_format(Event.event_date_start, "%Y")',
			'event_date_start_nice' => 'date_format(Event.event_date_start, "%d/%m/%Y")',
			'event_date_end_nice' => 'date_format(Event.event_date_end, "%d/%m/%Y")',
			'publish_date_start_nice' => 'date_format(Event.publish_date_start, "%d/%m/%Y")',
			'publish_date_end_nice' => 'date_format(Event.publish_date_end, "%d/%m/%Y")',
			'publish_date_start_epoch' => 'unix_timestamp(Event.publish_date_start)',
			'publish_date_end_epoch' => 'unix_timestamp(Event.publish_date_end)',
			'subscribe_date_start_epoch' => 'unix_timestamp(Event.subscribe_date_start)',
			'subscribe_date_end_epoch' => 'unix_timestamp(Event.subscribe_date_end)',
			'subscribe_date_start_nice' => 'date_format(Event.subscribe_date_start, "%d/%m/%Y")',
			'subscribe_date_end_nice' => 'date_format(Event.subscribe_date_end, "%d/%m/%Y")',
		);

	public $hasMany = 'Subscription';


	public function findeventfile($eventname = null, $year = null) {
		$event = array();
		$event['Event'] = array('name' => $eventname, 'year' => $year, 'title' => 'VCW Zomerkamp');
		$eventInfoFilename = WWW_ROOT . 'files/events/'.$eventname.'_'.$year.'/event_info.htm';
		$eventInfofile = new File($eventInfoFilename);
		if ($eventInfofile->exists() == false) {
			return null;
		}
		$eventInfo = file_get_contents($eventInfoFilename);
		$event['Event']['Information'] = $eventInfo;
		$event['Event']['subscribe_able'] = true;
		$event['Event']['subscribe_date_start'] = $year.'-01-01';
		$event['Event']['subscribe_date_end'] = $year.'-01-01';
		$event['Event']['subscribe_date_start_epoch'] = strtotime($event['Event']['subscribe_date_start']);
		$event['Event']['subscribe_date_end_epoch'] = strtotime($event['Event']['subscribe_date_end']);
		// this next part is no longer needed, if the subscriptions are put in the database
		$inscsvfilename = WWW_ROOT . 'files/events/'.$eventname.'_'.$year.'/event_confirmatie.csv';
		$inscsvfile = new File($inscsvfilename);
		$event['Event']['csv'] = $inscsvfilename;
		$inschrijvingen = array();
		if ($inscsvfile->exists()) {
			$inscsv = $inscsvfile->read(true, 'r');
			$lijst = explode("\n", $inscsv); //create array separate by new line
			for ($i=0; $i < count($lijst); $i++) {
				$lijn = trim($lijst[$i]);
				if (($lijn != "") and ($lijn != 'code;stamp;email;naam;shirt;hash;confirmation;dubbel;')) {
					$inschrijving = explode(';', $lijn);
					$inschrijvingen[] = array(
						'subshash'             => $inschrijving[5],
						'subsname'             => $inschrijving[3],
						'subsemail'            => $inschrijving[2],
						'created_nice'         => $inschrijving[1],
						'confirmed'            => true,
						'confirmed_stamp_nice' => $inschrijving[6]
					);
				}
			}
		}
		$event['Subscription'] = $inschrijvingen;
		return $event;
	}

}
