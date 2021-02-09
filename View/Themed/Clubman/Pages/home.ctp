<h2>Welkom op <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : '')?> Clubman</h2>

<!--
<h3><?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : '')?> Clubman homepagina</h3>
-->
<br/>
Vragen over deze website?<br/>
Stel ze aan <a class="boldlink" href="mailto:<?=(isset($cmclub['clubmail']['clubman']['email']) ? $cmclub['clubmail']['clubman']['email'] : 'webmaster@'.(isset($cmclub['domain']) ? $cmclub['domain'] : 'oblivio.be'))?>">het <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : '')?> Clubman team</a>!<br/>
<br/>


<?php
if (isset($currentUser)) {
//	echo '<hr/>';
//	pr($therequest);
//	echo '<hr/>';
//	pr($currentUser);
}
?>
