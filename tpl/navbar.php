<?php $navbar instanceof GWF_Navbar;
if ($navbar->isLeft())
{
	$navbar->addFields(array(
		GDO_Link::make('link_news')->href(href('News', 'List'))->label('link_news'),
	));
}
