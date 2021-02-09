<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-Type: text/csv; charset=windows-1252");
header ("Content-Disposition: attachment; filename=clubman_export.csv");
header ("Content-Description: Clubman Generated Report" );
?>
<?php echo $content_for_layout; ?>
