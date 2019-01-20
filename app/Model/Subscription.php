<?php
class Subscription extends AppModel {
	public $name = 'Subscription';

	public $virtualFields = array(
			'created_nice' => 'date_format(Subscription.created, "%d/%m/%Y")',
			'confirmed_stamp_epoch' => 'unix_timestamp(Subscription.confirmed_stamp)',
			'confirmed_stamp_nice' => 'date_format(Subscription.confirmed_stamp, "%d/%m/%Y")',
		);

	public $order = 'Subscription.created';

	public $belongsTo = 'Event';

}
?>
