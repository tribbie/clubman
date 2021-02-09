<?php
class Game extends AppModel {
	public $name = 'Game';

	public $validate = array(
		'game_date' => array('rule' => 'notBlank'),
		'game_time' => array('rule' => 'notBlank'),
	);

	public $virtualFields = array(
		'day_of_month'   => 'DAY(game_date)',
		'day_of_week'    => 'WEEKDAY(game_date)',
		'week_of_year'   => 'WEEK(game_date)',
		'month_of_year'  => 'MONTH(game_date)',
		'yyyy'           => 'YEAR(game_date)',
		'game_date_nice' => 'date_format(Game.game_date, "%e/%m/%Y")',
		'game_time_nice' => 'date_format(Game.game_time, "%H:%i")',
		'game_time_end'  => 'ADDTIME(Game.game_time, "02:00:00")',
		'full_name'      => 'CONCAT(Game.team_code, ":", Game.game_home, "-", Game.game_away)'
	);

	public $displayField = 'full_name';

//	public $belongsTo = array('Team');

	public $belongsTo = array(
		'Team' => array(
			'classname'  => 'Team',
			'foreignKey' => 'team_id'
		),
		'Coach' => array(
			'classname'  => 'Coach',
			'foreignKey' => 'game_coach_id',
			'fields'     => array('Coach.id, member_id, copy_member_name, copy_member_license')
		)
	);

	public $hasMany = array('Gamesteammember');


/**
 * Initializes the filter to only get info for the "current season"
 *	The "current season" is set in the globally defined configuration (in core.php)
 *	The "current season" is also implemented in the AppController (as property currentSeason)
 *
 */
	public function beforeFind($queryData) {
		parent::beforeFind($queryData);
		$defaultConditions = array('Game.season' => Configure::read('Clubman.currentseason'));
		$queryData['conditions'] = is_array($queryData['conditions']) ? array_merge($queryData['conditions'], $defaultConditions) : $defaultConditions;
		return $queryData;
	}

}
?>
