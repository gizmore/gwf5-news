<?php
echo GDO_Link::make('link_newsletter')->href(href('News', 'Newsletter'))->icon('add_alert')->renderCell();

echo $response->getHTML();
