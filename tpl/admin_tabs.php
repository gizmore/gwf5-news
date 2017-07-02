<?php
$bar = GDO_Bar::make('bar');
$bar->addFields(array(
	GDO_Link::make('link_overview')->href(href('News', 'Admin')),
	GDO_Link::make('link_write_news')->href(href('News', 'Write')),
	GDO_Link::make('link_newsletters')->href(href('News', 'Newsletters')),
));
echo $bar->renderCell();
