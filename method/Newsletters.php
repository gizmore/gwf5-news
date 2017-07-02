<?php
final class News_Newsletters extends GWF_MethodQueryTable
{
	use GWF_MethodAdmin;
	
	public function getPermission() { return 'staff'; }
	
	public function getQuery()
	{
		return GWF_Newsletter::table()->select();
	}
	
}
