<?php $field instanceof GDO_NewsletterStatus; ?>
<?php $user = $field->getUser(); ?>
<?php
if ($user->isMember())
{
	$linkSettings = GWF_HTML::anchor(href('Account', 'Form'), t('link_mail_settings'));
	if (GWF_Newsletter::hasSubscribed($user))
	{
		$field->icon('check');
		$field->label('newsletter_info_subscribed', [$linkSettings]);
	}
	else
	{
		$field->icon('block');
		$field->label('newsletter_info_not_subscribed', [$linkSettings]);
	}
}
else
{
	$field->icon('priority_high');
	$field->label('newsletter_sub_guest_unknown');
}
?>
<div class="gwf-label"><?php echo $field->htmlIcon() . ' ' . $field->displayLabel(); ?></div>
