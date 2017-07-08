<?php $field instanceof GDO_NewsStatus; ?>
<?php $news = $field->getNews(); ?>
<?php
$icon = 'pause';
$lbl = 'newsletter_status_waiting';
if ($news->isSent())
{
	$icon = 'done_all';
	$lbl = 'newsletter_status_sent';
}
elseif ($news->isSending())
{
	$icon = 'done';
	$lbl = 'newsletter_status_in_queue';
}
$field->icon($icon);
$field->label($lbl);
?>
<div class="gwf-label"><?php echo $field->htmlIcon() . ' ' . $field->displayLabel(); ?></div>
