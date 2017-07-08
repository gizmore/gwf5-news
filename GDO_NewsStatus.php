<?php
final class GDO_NewsStatus extends GDO_Label
{
	public function renderCell()
	{
		return GWF_Template::modulePHP('News', 'cell/news_status.php', ['field'=>$this]);
	}
	
	public function render()
	{
		return GWF_Template::modulePHP('News', 'form/news_status.php', ['field'=>$this]);
	}
	
	/**
	 * @return GWF_News
	 */
	public function getNews()
	{
		return $this->gdo;
	}
}