<!-- app/View/Subscriptions/subscribe.ctp -->
<h2>Inschrijving <?=(isset($cmclub['shortname']) ? $cmclub['shortname'] : 'Clubman')?> evenement</h2>

<h3><?=ucfirst($event['Event']['title'])?> <?=$event['Event']['season']?></h3>

<?php if (isset($subscriptionmsg)) : ?>
	<div class="alert alert-<?=$subscriptionmsg['class']?>"><?=$subscriptionmsg['text']?></div>
<?php else : ?>
	<div class="alert alert-primary">Hmmm. Geen boodschap. Nevermind.</div>
<?php endif; ?>

<?php if (($subscriptionmsg['form']) or (($event['Event']['subscribe_able']) and ($loggedIn and (in_array($currentUser['role'], array('root')))))) : ?>

	<?php if ($subscriptionmsg['form'] == false) : ?>

		<div class="alert alert-warning">
			<p>
				<strong>Opgelet:</strong> This form should only be seen bij root. Only root is able to subscribe at this moment.
			</p>
		</div>

	<?php endif; ?>


	<div class="alert alert-info">
		<p>
			<strong>Opgelet:</strong> Bij inschrijving zal je een e-mail ontvangen, waarmee je je inschrijving nog moet bevestigen. Pas dan is je inschrijving compleet.
		</p>
	</div>

	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="cm-form-simple">
				<?= $this->Form->create('Subscription'); ?>
					<div class="form-group">
						<?= $this->Form->input('event_id', array('type' => 'hidden', 'default' => $event['Event']['id'])) ?>
						<?= $this->Form->input('season', array('type' => 'hidden', 'default' => $event['Event']['season'])) ?>
						<?= $this->Form->input('substitle', array('type' => 'hidden', 'default' => $event['Event']['title'])) ?>
					</div>

					<div class="form-group">
						<?= $this->Form->input('subsname', array('label' => 'Naam', 'placeholder' => 'Je naam', 'class' => 'form-control', 'required' => true, 'div' => false)) ?>
					</div>
					<div class="form-group">
						<?= $this->Form->input('subsemail', array('label' => 'E-mail adres (nodig voor de bevestiging)', 'placeholder' => 'Je e-mail adres', 'class' => 'form-control', 'required' => true, 'type' => 'email', 'div' => false)) ?>
					</div>

					<?php if ($extra) : ?>
						<hr/>
						Extra informatie<br/>
						<?php foreach ($extra as $item) : ?>
						<div class="form-group">
							<?php if (isset($item['values'])) : ?>
								<?= $this->Form->input('Subscription.extra.'.$item['code'], array('label' => $item['label'], 'options' => array_combine($item['values'], $item['values']), 'empty' => (isset($item['placeholder']) ? $item['placeholder'] : ''), 'required' => true, 'title' => 'extra veld', 'class' => 'form-control')) ?>
							<?php else : ?>
								<?= $this->Form->input('Subscription.extra.'.$item['code'], array('label' => $item['label'], 'placeholder' => (isset($item['placeholder']) ? $item['placeholder'] : ''), 'title' => 'extra veld', 'class' => 'form-control')) ?>
							<?php endif; ?>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>

		      <button type="submit" class="btn btn-primary">Schrijf in</button>
				<?= $this->Form->end(); ?>
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>
<?php endif; ?>

<hr/>
<?=$this->Html->link('Terug naar het evenement', array('controller' => 'events', 'action' => 'view', $event['Event']['name'], $event['Event']['year']), array('class' => 'boldlink'))?>

<?php
	//if (isset($subscription)) pr($subscription);
	//if (isset($extra)) pr($extra);
	//pr($subsdates);
	//pr($event);
?>
