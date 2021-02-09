<?php
$config['Menuweb'] = [
	'home' => [
		'main' => ['label' => 'Home', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'home']]
	],
	'jeugd' => [
		'main' => ['label' => 'Jeugd', 'linkarray' => []],
		'sub'  => [
			['label' => 'teamlist', 'category' => 'jeugdcompetitie', 'linkarray' => []],
			//['label' => 'separator', 'linkarray' => []],
			//['label' => 'bekerwedstrijden', 'linkarray' => ['controller' => 'games', 'action' => 'overview', 'jeugdbeker']],
			//['label' => 'separator', 'linkarray' => []],
			//['label' => 'VIS project', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'jeugd-vis']],
			//['label' => 'gedragscode', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'jeugd-gedragscode']],
			//['label' => 'kamp', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'jeugd-kamp']],
			//['label' => 'stages', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'jeugd-stages']],
			//['label' => 'clinic', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'jeugd-clinic']],
			//['label' => 'scheidsrechters', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'jeugd-scheidsrechters']],
			//['label' => 'volgend seizoen', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'jeugd-volgendseizoen']]
		]
	],
	'seniors' => [
		'main' => ['label' => 'Seniors', 'linkarray' => []],
		'sub'  => [
			['label' => 'teamlist', 'category' => 'seniors', 'linkarray' => []],
			//			['label' => 'separator', 'linkarray' => []],
		]
	],
	'club' => [
		'main' => ['label' => 'Club', 'linkarray' => []],
		'sub'  => [
			['label' => 'teamlist', 'category' => 'bestuur', 'linkarray' => []],
			['label' => 'Trainers', 'linkarray' => ['controller' => 'teammembers', 'action' => 'category', 'trainers']],
			['label' => 'Leden', 'linkarray' => ['controller' => 'teammembers', 'action' => 'category', 'players']]
			//['label' => 'separator', 'linkarray' => []],
			//['label' => 'trainers', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'wiezijnwij-trainers']],
			//['label' => 'ledenoverzicht', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'wiezijnwij-ledenoverzicht']],
			//['label' => 'beleid', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'wiezijnwij-beleid']],
			//['label' => 'geschiedenis', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'wiezijnwij-geschiedenis']],
			//['label' => 'knipselmap', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'wiezijnwij-knipselmap']],
			//['label' => 'promofilmpje', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'wiezijnwij-promofilm']],
			//['label' => 'clublied', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'wiezijnwij-clublied']]
		]
	],
	'info' => [
		'main' => ['label' => 'Info', 'linkarray' => []],
		'sub'  => [
			//['label' => 'algemeen', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'info-algemeen']],
			//['label' => 'wegbeschrijving', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'info-wegbeschrijving']],
			//['label' => 'sporthallen', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'info-sporthallen']],
			//['label' => 'ongeval', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'info-ongeval']],
			//['label' => 'separator', 'linkarray' => []],
			['label' => 'Website', 'linkarray' => ['controller' => 'pages', 'action' => 'display', 'info-website']]
		]
	]
];
