<?php
$config['Menuman'] = [

			'items' => [
							'root' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
									'members' => [
										'main' => ['label' => 'Leden', 'linkarray' => ['controller' => 'members', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',                 'linkarray' => ['controller' => 'members', 'action' => 'reports']],
											2 => ['label' => 'Nieuw lid',                 'linkarray' => ['controller' => 'members', 'action' => 'add']],
											3 => ['label' => 'Alle leden',                'linkarray' => ['controller' => 'members', 'action' => 'index', 'all']],
											4 => ['label' => 'Actieve leden',             'linkarray' => ['controller' => 'members', 'action' => 'index', 'active']],
											5 => ['label' => 'Inactieve leden',           'linkarray' => ['controller' => 'members', 'action' => 'index', 'inactive']],
											6 => ['label' => 'Importeer leden vanaf CSV', 'linkarray' => ['controller' => 'members', 'action' => 'import']]
										]
									],
									'teams' => [
										'main' => ['label' => 'Teams', 'linkarray' => ['controller' => 'teams', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',  'linkarray' => ['controller' => 'teams', 'action' => 'reports']],
											2 => ['label' => 'Lijst', 'linkarray' => ['controller' => 'teams', 'action' => 'listing']],
											3 => ['label' => 'Nieuw team', 'linkarray' => ['controller' => 'teams', 'action' => 'add']],
											4 => ['label' => 'Teamleden',  'linkarray' => ['controller' => 'teammembers', 'action' => 'index']],
											5 => ['label' => 'Trainingsmomenten',  'linkarray' => ['controller' => 'trainingmoments', 'action' => 'index']],
											6 => ['label' => 'Team Trainingsmomenten',  'linkarray' => ['controller' => 'trainingmomentsteams', 'action' => 'index']]
										]
									],
									'games' => [
										'main' => ['label' => 'Wedstrijden', 'linkarray' => ['controller' => 'games', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten', 'linkarray' => ['controller' => 'games', 'action' => 'reports']],
											2 => ['label' => 'Weekendoverzicht (kort)', 'linkarray' => ['controller' => 'games', 'action' => 'shortoverview', 'week']],
											3 => ['label' => 'Weekendoverzicht (lang)', 'linkarray' => ['controller' => 'games', 'action' => 'overview', 'week']],
											4 => ['label' => 'Wijzigingen', 'linkarray' => ['controller' => 'games', 'action' => 'changes']],
											5 => ['label' => 'Nieuwe wedstrijd', 'linkarray' => ['controller' => 'games', 'action' => 'add']]
										]
									],
									'efforts' => [
										'main' => ['label' => 'Prestaties', 'linkarray' => ['controller' => 'efforts', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',        'linkarray' => ['controller' => 'efforts', 'action' => 'reports']],
											2 => ['label' => 'Alle prestatie',   'linkarray' => ['controller' => 'efforts', 'action' => 'listmember', 'all']],
											3 => ['label' => 'Nieuwe prestatie', 'linkarray' => ['controller' => 'efforts', 'action' => 'add']]
										]
									],
									'news' => [
										'main' => ['label' => 'Nieuws', 'linkarray' => ['controller' => 'newsitems', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Nieuw artikel', 'linkarray' => ['controller' => 'newsitems', 'action' => 'add']],
											//2 => ['label' => 'Redactie', 'linkarray' => ['controller' => 'newsitems', 'action' => 'redactie']],
											//3 => ['label' => 'Rolkrant', 'linkarray' => ['controller' => 'newsitems', 'action' => 'rolkrant']],
											//4 => ['label' => 'Volley Likes', 'linkarray' => ['controller' => 'newsitems', 'action' => 'listsocial']],
											//5 => ['label' => 'Volley Likes krant', 'linkarray' => ['controller' => 'newsitems', 'action' => 'socialkrant']]
										]
									],
									//'enquetes' => [
									//	'main' => ['label' => 'Enquetes', 'linkarray' => ['controller' => 'enquetes', 'action' => 'index']],
									//	'sub'  => [
									//		1 => ['label' => 'Genereer',    'linkarray' => ['controller' => 'enquetes', 'action' => 'generate']],
									//	]
									//],
									'pictures' => [
										'main' => ['label' => 'Foto\'s', 'linkarray' => ['controller' => 'pictures', 'action' => 'index']],
										'sub'  => [
											2 => ['label' => 'Vergunningen', 'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'memberid']],
											3 => ['label' => 'Leden',        'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'member']],
											4 => ['label' => 'Teams',        'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'team']]
										]
									],
									'uploads' => [
										'main' => ['label' => 'Uploads', 'linkarray' => ['controller' => 'uploads', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',     'linkarray' => ['controller' => 'uploads', 'action' => 'reports']],
											2 => ['label' => 'Nieuwe upload', 'linkarray' => ['controller' => 'uploads', 'action' => 'add']]
										]
									],
									'users' => [
										'main' => ['label' => 'Gebruikers', 'linkarray' => ['controller' => 'users', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',        'linkarray' => ['controller' => 'users', 'action' => 'reports']],
											2 => ['label' => 'Nieuwe gebruiker', 'linkarray' => ['controller' => 'users', 'action' => 'add']]
										]
									],
									'extra' => [
										'main' => ['label' => 'Extra', 'linkarray' => ['controller' => 'reports', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'trainingen',     'linkarray' => ['controller' => 'trainings', 'action' => 'index']],
											2 => ['label' => 'evenementen',    'linkarray' => ['controller' => 'events', 'action' => 'index']],
											3 => ['label' => 'verjaardagen',   'linkarray' => ['controller' => 'members', 'action' => 'birthdays']],
											4 => ['label' => 'kalender4tasks', 'linkarray' => ['controller' => 'games', 'action' => 'fortasks']],
											5 => ['label' => 'importtasks',    'linkarray' => ['controller' => 'games', 'action' => 'importtasks']],
											6 => ['label' => 'enquetes',       'linkarray' => ['controller' => 'enquetes', 'action' => 'index']],
											7 => ['label' => 'mailings',       'linkarray' => ['controller' => 'mailings', 'action' => 'index']],
											8 => ['label' => 'metingen',       'linkarray' => ['controller' => 'meterings', 'action' => 'index']],
											9 => ['label' => 'instellingen',   'linkarray' => ['controller' => 'clubmansettings', 'action' => 'view']],
										]
									]
								],
							'admin' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
									'members' => [
										'main' => ['label' => 'Leden', 'linkarray' => ['controller' => 'members', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',       'linkarray' => ['controller' => 'members', 'action' => 'reports']],
											2 => ['label' => 'Nieuw lid',       'linkarray' => ['controller' => 'members', 'action' => 'add']],
											3 => ['label' => 'Alle leden',      'linkarray' => ['controller' => 'members', 'action' => 'index', 'all']],
											4 => ['label' => 'Inactieve leden', 'linkarray' => ['controller' => 'members', 'action' => 'index', 'inactive']]
										]
									],
									'teams' => [
										'main' => ['label' => 'Teams', 'linkarray' => ['controller' => 'teams', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',  'linkarray' => ['controller' => 'teams', 'action' => 'reports']],
											2 => ['label' => 'Lijst', 'linkarray' => ['controller' => 'teams', 'action' => 'listing']],
											3 => ['label' => 'Nieuw team', 'linkarray' => ['controller' => 'teams', 'action' => 'add']],
											4 => ['label' => 'Teamleden',  'linkarray' => ['controller' => 'teammembers', 'action' => 'index']]
										]
									],
									'games' => [
										'main' => ['label' => 'Wedstrijden', 'linkarray' => ['controller' => 'games', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten', 'linkarray' => ['controller' => 'games', 'action' => 'reports']],
											2 => ['label' => 'Weekendoverzicht (kort)', 'linkarray' => ['controller' => 'games', 'action' => 'shortoverview', 'week']],
											3 => ['label' => 'Weekendoverzicht (lang)', 'linkarray' => ['controller' => 'games', 'action' => 'overview', 'week']],
											4 => ['label' => 'Wijzigingen', 'linkarray' => ['controller' => 'games', 'action' => 'changes']],
											5 => ['label' => 'Nieuwe wedstrijd', 'linkarray' => ['controller' => 'games', 'action' => 'add']]
										]
									],
									'efforts' => [
										'main' => ['label' => 'Prestaties', 'linkarray' => ['controller' => 'efforts', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',        'linkarray' => ['controller' => 'efforts', 'action' => 'reports']],
											2 => ['label' => 'Nieuwe prestatie', 'linkarray' => ['controller' => 'efforts', 'action' => 'add']]
										]
									],
									//'enquetes' => [
									//	'main' => ['label' => 'Enquetes', 'linkarray' => ['controller' => 'enquetes', 'action' => 'index']],
									//	'sub'  => [
									//		1 => ['label' => 'Genereer',    'linkarray' => ['controller' => 'enquetes', 'action' => 'generate']],
									//	]
									//],
									'pictures' => [
										'main' => ['label' => 'Foto\'s', 'linkarray' => ['controller' => 'pictures', 'action' => 'index']],
										'sub'  => [
											2 => ['label' => 'Vergunningen', 'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'memberid']],
											3 => ['label' => 'Leden',        'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'member']],
											4 => ['label' => 'Teams',        'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'team']]
										]
									],
									'uploads' => [
										'main' => ['label' => 'Uploads', 'linkarray' => ['controller' => 'uploads', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',     'linkarray' => ['controller' => 'uploads', 'action' => 'reports']],
											2 => ['label' => 'Nieuwe upload', 'linkarray' => ['controller' => 'uploads', 'action' => 'add']],
											3 => ['label' => 'De kampkrantjes', 'linkarray' => ['controller' => 'uploads', 'action' => 'category', 'kamp']],
											4 => ['label' => 'Nieuw kampkrantje', 'linkarray' => ['controller' => 'uploads', 'action' => 'add', 'kamp']]
										]
									],
									'users' => [
										'main' => ['label' => 'Gebruikers', 'linkarray' => ['controller' => 'users', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',        'linkarray' => ['controller' => 'users', 'action' => 'reports']],
											2 => ['label' => 'Nieuwe gebruiker', 'linkarray' => ['controller' => 'users', 'action' => 'add']]
										]
									]
								],
							'teamadmin' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
									'members' => [
										'main' => ['label' => 'Leden', 'linkarray' => ['controller' => 'members', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',       'linkarray' => ['controller' => 'members', 'action' => 'reports']],
											2 => ['label' => 'Nieuw lid',       'linkarray' => ['controller' => 'members', 'action' => 'quickadd']],
											4 => ['label' => 'Inactieve leden', 'linkarray' => ['controller' => 'members', 'action' => 'index', 'inactive']]
										]
									],
									'teams' => [
										'main' => ['label' => 'Teams', 'linkarray' => ['controller' => 'teams', 'action' => 'index']],
										'sub'  => [
											2 => ['label' => 'Nieuw team', 'linkarray' => ['controller' => 'teams', 'action' => 'add']],
											3 => ['label' => 'Teamleden',  'linkarray' => ['controller' => 'teammembers', 'action' => 'index']],
											5 => ['label' => 'Trainingsmomenten',  'linkarray' => ['controller' => 'trainingmoments', 'action' => 'index']]
										]
									],
									'games' => [
										'main' => ['label' => 'Wedstrijden', 'linkarray' => ['controller' => 'games', 'action' => 'index']],
										'sub'  => [
											//1 => ['label' => 'Rapporten', 'linkarray' => ['controller' => 'games', 'action' => 'reports']],
											2 => ['label' => 'Weekendoverzicht (kort)', 'linkarray' => ['controller' => 'games', 'action' => 'shortoverview', 'week']],
											3 => ['label' => 'Weekendoverzicht (lang)', 'linkarray' => ['controller' => 'games', 'action' => 'overview', 'week']],
											4 => ['label' => 'Wijzigingen', 'linkarray' => ['controller' => 'games', 'action' => 'changes']],
											5 => ['label' => 'Nieuwe wedstrijd', 'linkarray' => ['controller' => 'games', 'action' => 'add']]
										]
									],
									'efforts' => [
										'main' => ['label' => 'Prestaties', 'linkarray' => ['controller' => 'efforts', 'action' => 'index']],
										'sub'  => [
											2 => ['label' => 'Nieuwe prestatie', 'linkarray' => ['controller' => 'efforts', 'action' => 'add']]
										]
									],
									'pictures' => [
										'main' => ['label' => 'Foto\'s', 'linkarray' => ['controller' => 'pictures', 'action' => 'index']],
										'sub'  => [
											2 => ['label' => 'Vergunningen', 'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'memberid']],
											3 => ['label' => 'Leden',        'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'member']],
											4 => ['label' => 'Teams',        'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'team']]
										]
									],
									'uploads' => [
										'main' => ['label' => 'Uploads', 'linkarray' => ['controller' => 'uploads', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',       'linkarray' => ['controller' => 'uploads', 'action' => 'reports']],
											2 => ['label' => 'Upload training', 'linkarray' => ['controller' => 'uploads', 'action' => 'add', 'training']],
											3 => ['label' => 'Upload coaching', 'linkarray' => ['controller' => 'uploads', 'action' => 'add', 'coaching']],
											4 => ['label' => 'Upload clip',     'linkarray' => ['controller' => 'uploads', 'action' => 'add', 'clip']],
											5 => ['label' => 'Andere upload',   'linkarray' => ['controller' => 'uploads', 'action' => 'add']]
										]
									]
								],
							'gameadmin' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
									'members' => [
										'main' => ['label' => 'Leden', 'linkarray' => ['controller' => 'members', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten', 'linkarray' => ['controller' => 'members', 'action' => 'reports']]
										]
									],
									'teams'   => ['main'=> ['label' => 'Teams',   'linkarray' => ['controller' => 'teams', 'action' => 'index']]],
									'games' => [
										'main' => ['label' => 'Wedstrijden', 'linkarray' => ['controller' => 'games', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten', 'linkarray' => ['controller' => 'games', 'action' => 'reports']],
											2 => ['label' => 'Weekendoverzicht (kort)', 'linkarray' => ['controller' => 'games', 'action' => 'shortoverview', 'week']],
											3 => ['label' => 'Weekendoverzicht (lang)', 'linkarray' => ['controller' => 'games', 'action' => 'overview', 'week']],
											4 => ['label' => 'Wijzigingen', 'linkarray' => ['controller' => 'games', 'action' => 'changes']],
											5 => ['label' => 'Nieuwe wedstrijd', 'linkarray' => ['controller' => 'games', 'action' => 'add']]
										]
									]
								],
							'memberadmin' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
									'members' => [
										'main' => ['label' => 'Leden', 'linkarray' => ['controller' => 'members', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',       'linkarray' => ['controller' => 'members', 'action' => 'reports']],
											2 => ['label' => 'Nieuw lid',       'linkarray' => ['controller' => 'members', 'action' => 'add']],
											4 => ['label' => 'Inactieve leden', 'linkarray' => ['controller' => 'members', 'action' => 'index', 'inactive']]
										]
									],
									'pictures' => [
										'main' => ['label' => 'Foto\'s', 'linkarray' => ['controller' => 'pictures', 'action' => 'index']],
										'sub'  => [
											2 => ['label' => 'Vergunningen', 'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'memberid']],
											3 => ['label' => 'Leden',        'linkarray' => ['controller' => 'pictures', 'action' => 'category', 'member']]
										]
									],
									'uploads' => [
										'main' => ['label' => 'Uploads', 'linkarray' => ['controller' => 'uploads', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten',     'linkarray' => ['controller' => 'uploads', 'action' => 'reports']],
											2 => ['label' => 'Nieuwe upload', 'linkarray' => ['controller' => 'uploads', 'action' => 'add']]
										]
									]
								],
							'trainerfinance' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
									'members' => [
										'main' => ['label' => 'Leden', 'linkarray' => ['controller' => 'members', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten', 'linkarray' => ['controller' => 'members', 'action' => 'reports']]
										]
									],
									'efforts' => [
										'main' => ['label' => 'Prestaties', 'linkarray' => ['controller' => 'efforts', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten', 'linkarray' => ['controller' => 'efforts', 'action' => 'reports']]
										]
									]
								],
							'memberfinance' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
									'members' => [
										'main' => ['label' => 'Leden', 'linkarray' => ['controller' => 'members', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten', 'linkarray' => ['controller' => 'members', 'action' => 'reports']]
										]
									],
									'teams' => [
										'main' => ['label' => 'Teams', 'linkarray' => ['controller' => 'teams', 'action' => 'index']],
										'sub'  => [
											2 => ['label' => 'Teamleden', 'linkarray' => ['controller' => 'teammembers', 'action' => 'index']]
										]
									]
								],
							'memberedit' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
									'members' => [
										'main' => ['label' => 'Leden', 'linkarray' => ['controller' => 'members', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten', 'linkarray' => ['controller' => 'members', 'action' => 'reports']]
										]
									]
								],
							'memberview' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
									'members' => [
										'main' => ['label' => 'Leden', 'linkarray' => ['controller' => 'members', 'action' => 'index']],
										'sub'  => [
											1 => ['label' => 'Rapporten', 'linkarray' => ['controller' => 'members', 'action' => 'reports']]
										]
									],
									'teams'   => ['main'=> ['label' => 'Teams',   'linkarray' => ['controller' => 'teams', 'action' => 'index']]],
									'events' => ['main' => ['label' => 'Evenementen', 'linkarray' => ['controller' => 'events', 'action' => 'index']]],
								],
							'trainer' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
									'members' => ['main' => ['label' => 'Leden',   'linkarray' => ['controller' => 'members', 'action' => 'index']]],
									'teams'   => ['main' => ['label' => 'Teams',   'linkarray' => ['controller' => 'teams', 'action' => 'index']]],
									'efforts' => [
										'main' => ['label' => 'Prestaties', 'linkarray' => ['controller' => 'efforts', 'action' => 'index']],
										'sub'  => [
											2 => ['label' => 'Nieuwe prestatie', 'linkarray' => ['controller' => 'efforts', 'action' => 'add']]
										]
									],
									'uploads' => [
										'main' => ['label' => 'Uploads', 'linkarray' => ['controller' => 'uploads', 'action' => 'index']],
										'sub'  => [
											//1 => ['label' => 'Rapporten',       'linkarray' => ['controller' => 'uploads', 'action' => 'reports']],
											2 => ['label' => 'Upload training', 'linkarray' => ['controller' => 'uploads', 'action' => 'add', 'training']],
											3 => ['label' => 'Upload coaching', 'linkarray' => ['controller' => 'uploads', 'action' => 'add', 'coaching']],
											4 => ['label' => 'Upload clip',     'linkarray' => ['controller' => 'uploads', 'action' => 'add', 'clip']],
											//5 => ['label' => 'Andere upload',   'linkarray' => ['controller' => 'uploads', 'action' => 'add']]
										]
									]
								],
							'member' => [
									'profile' => ['main' => ['label' => 'Profiel', 'linkarray' => ['controller' => 'users', 'action' => 'profile']]],
								]
							]
						];
