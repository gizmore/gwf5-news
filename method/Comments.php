<?php
final class News_Comments extends Comments_List
{
	public function gdoCommentsTable() { return GWF_NewsComments::table(); }
	public function hrefAdd() { return href('News', 'Comments', 'id='.$this->object->getID()); }
	
	public function isGuestAllowed() { return Module_News::instance()->cfgGuestNews(); }
	
}
