<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?=$this->fetch('title')?></title>
		<style type="text/css">
	  	body { margin: 0; padding: 0; min-width: 100% !important; }
	  </style>
	</head>
	<body>
 		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
						<tr>
							<td>
								<img src="<?=FULL_BASE_URL?><?=$this->base?><?=(isset($clubconfig['logo']) ? "/img/".$clubconfig['logo'] : "/img/sports.png")?>" width="75">
							</td>
						</tr>
						<tr>
							<td>
								<div class="container">
									<?=$this->fetch('content')?>
								</div>
							</td>
						</tr>
						<?php if (isset($clubconfig['mailfooter'])) : ?>
							<tr>
								<td>
									<?=$clubconfig['mailfooter']?>
								</td>
							</tr>
						<?php endif; ?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
