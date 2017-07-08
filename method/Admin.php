<?php
include 'List.php';
final class News_Admin extends GWF_MethodQueryTable
{
	use GWF_MethodAdmin;
	
	public function getPermission() { return 'staff'; }
	
	public function getHeaders()
	{
		return array_merge(array(
			GDO_EditButton::make(),
		), parent::getHeaders());
	}
	
	public function getQuery()
	{
		return GWF_News::table()->select();
	}
	
	public function execute()
	{
		return $this->renderNavBar('News')->add(Module_News::instance()->renderAdminTabs())->add(parent::execute());
	}
	
// 	public function filterNewsQuery(GDOQuery $query)
// 	{
// 		return $query;
// 	}
}
