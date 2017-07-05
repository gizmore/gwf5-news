<?php
final class News_WriteComment extends Comments_Write
{
	public function gdoCommentsTable() { return GWF_NewsComments::table(); }
	
	public function hrefList() { return href('News', 'Comments', '&id='.$this->object->getID()); }
	
}
