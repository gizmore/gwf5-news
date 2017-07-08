<?php
final class GDO_NewsletterStatus extends GDO_Label
{
	public function renderCell()
	{
		return GWF_Template::modulePHP('News', 'cell/newsletter_status.php', ['field'=>$this]);
	}
	
	public function render()
	{
		return GWF_Template::modulePHP('News', 'form/newsletter_status.php', ['field'=>$this]);
	}
	
	/**
	 * @return GWF_User
	 */
	public function getUser()
	{
		return $this->gdo;
	}
}