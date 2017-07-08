<?php
$user = GWF_User::current();
if (GWF_Newsletter::table()->getBy('newsletter_email', $user->getMail()))
{
	$key = 'box_content_newsletter_subscribed';
}
else
{
	$key = 'box_content_newsletter_subscribe';
}
echo GDO_Box::make()->content(t($key))->renderCell();

echo $response->getHTML();
