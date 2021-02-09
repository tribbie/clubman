<div class='crlf'>
<?php

$aa = array('root' => array('main' => 'mainstuff', 'sub' => array('1' => 'sub1-stuff')));
$ab = array('admin' => array('main' => 'mainstuff', 'sub' => array('1' => 'sub1-stuff')));

pr($aa);
pr($ab);

$ma = array_merge($aa, $ab);
pr($ma);


