<?php
include 'List.php';
final class News_Admin extends News_List
{
	use GWF_MethodAdmin;
	
	public function execute()
	{
		return $this->renderNavBar('News')->add(Module_News::instance()->renderAdminTabs())->add(parent::execute());
	}
	
	public function filterNewsQuery(GDOQuery $query)
	{
		return $query;
	}
}
