<?php
# Navbar
$user = GWF_User::current();
$bar = GDO_Bar::make();
$bar->addFields(array(
    GDO_Link::make('link_newsletter')->href(href('News', 'Newsletter'))->icon('add_alert'),
    GDO_Link::make('link_newsfeed')->href(href('News', 'RSS'))->icon('add_alert'),
));
if ($user->hasPermission('staff'))
{
    $bar->addField(GDO_Link::make('link_write_news')->href(href('News', 'Write'))->icon('edit'));
}
echo $bar->renderCell();
