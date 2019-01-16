<?php
foreach ($members[0]['Member'] as $memberkey => $membervalue) {
	echo mb_convert_encoding($memberkey, "Windows-1252", "UTF-8") . ";";
}
echo "\n"; 
foreach ($members as $member) {
	foreach ($member['Member'] as $memberkey => $membervalue) {
		echo mb_convert_encoding($membervalue, "Windows-1252", "UTF-8") . ";";
	}
	echo "\n"; 
}
?>
