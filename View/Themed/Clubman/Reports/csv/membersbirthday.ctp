#voornaam;naam;geboren;bouwmaand;bouwdag;bouwjaar;actief;
<?php
	foreach($members as $member) {
		echo mb_convert_encoding($member['Member']['firstname'], "Windows-1252", "UTF-8") . ";";
		echo mb_convert_encoding($member['Member']['lastname'], "Windows-1252", "UTF-8") . ";";
		echo $member['Member']['birthdate_nice'] . ";";
		echo $member['Member']['birthmonth'] . ";";
		echo $member['Member']['birthday'] . ";";
		echo $member['Member']['birthyear'] . ";";
		echo $member['Member']['active'] . ";";
		echo "\n";
	}
?>
