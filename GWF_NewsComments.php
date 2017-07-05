<?php
final class GWF_NewsComments extends GWF_CommentTable
{
	public function gdoCommentedObjectTable() { return GWF_News::table(); }
	public function gdoAllowFiles() { return false; }
	public function gdoEnabled() { return Module_News::instance()->cfgComments(); }
	
	
}