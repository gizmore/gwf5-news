<?php
final class Module_News extends GWF_Module
{
	public $module_version = "5.01";
	
	##############
	### Module ###
	##############
	public function getClasses() { return ['GWF_News', 'GWF_NewsText', 'GWF_NewsComments', 'GWF_Newsletter', 'GDO_NewsStatus', 'GDO_NewsletterStatus']; }
	public function onLoadLanguage() { $this->loadLanguage('lang/news'); }
	public function href_administrate_module() { return href('News', 'Admin'); }

	##############
	### Config ###
	##############
	public function getConfig()
	{
		return array(
			GDO_Checkbox::make('news_comments')->initial('1'),
			GDO_Checkbox::make('news_guests')->initial('1'),
			GDO_Checkbox::make('newsletter_guests')->initial('1'),
			GDO_Checkbox::make('news_guest_comments')->initial('1'),
		);
	}
	public function cfgComments() { return $this->getConfigValue('news_comments'); }
	public function cfgGuestNews() { return $this->getConfigValue('news_guests'); }
	public function cfgGuestNewsletter() { return $this->getConfigValue('newsletter_guests'); }
	public function cfgGuestComments() { return $this->getConfigValue('news_guest_comments'); }
	
	############
	### Navs ###
	############
	public function renderTabs()
	{
	    return $this->templatePHP('tabs.php');
	}
	
	public function renderAdminTabs()
	{
	    return $this->templatePHP('admin_tabs.php');
	}
	
	public function onRenderFor(GWF_Navbar $navbar)
	{
		$this->templatePHP('navbar.php', ['navbar' => $navbar]);
	}
}
