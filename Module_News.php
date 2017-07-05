<?php
final class Module_News extends GWF_Module
{
	##############
	### Module ###
	##############
	public function getClasses() { return ['GWF_News', 'GWF_NewsText', 'GWF_NewsComments', 'GWF_Newsletter']; }
	public function onLoadLanguage() { $this->loadLanguage('lang/news'); }
	public function href_administrate_module() { return href('News', 'Admin'); }

	##############
	### Config ###
	##############
	public function getConfig()
	{
		return array(
			GDO_Checkbox::make('news_comments')->initial('1'),
		);
	}
	public function cfgComments() { return $this->getConfigValue('news_comments'); }

	############
	### Navs ###
	############
	public function renderAdminTabs()
	{
		return $this->templatePHP('admin_tabs.php');
	}
	
	public function onRenderFor(GWF_Navbar $navbar)
	{
		$this->templatePHP('navbar.php', ['navbar' => $navbar]);
	}
}
