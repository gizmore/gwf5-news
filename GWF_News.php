<?php
final class GWF_News extends GDO
{
	################
	### Comments ###
	################
	use GWF_CommentedObject;
	
	###########
	### GDO ###
	###########
	public function gdoColumns()
	{
		return array(
			GDO_AutoInc::make('news_id'),
			GDO_Category::make('news_category'),
			GDO_Checkbox::make('news_visible')->notNull()->initial('0'),
			GDO_DateTime::make('news_sent'),
			GDO_CreatedAt::make('news_created'),
			GDO_CreatedBy::make('news_creator'),
		);
	}
	
	##############
	### Getter ###
	##############
	public function isSent() { return $this->getSentDate() !== null; }
	public function getID() { return $this->getVar('news_id'); }
	public function getCategory() { return $this->getValue('news_category'); }
	public function getCategoryID() { return $this->getVar('news_category'); }
	public function getVisible() { return $this->getVar('news_visible') === '1'; }
	public function getSentDate() { return $this->getVar('news_sent'); }
	public function getCreateDate() { return $this->getVar('news_created'); }
	public function getCreator() { return $this->getValue('news_creator'); }
	public function getCreatorID() { return $this->getVar('news_creator'); }
	
	#############
	### Texts ###
	#############
	public function getTitle() { return $this->getTextVar('newstext_title'); }
	public function getMessage() { return $this->getTextVar('newstext_message'); }
	
	public function getTextVar(string $key) { return $this->getText(GWF_Trans::$ISO)->getVar($key); }
	public function getTextValue(string $key) { return $this->getText(GWF_Trans::$ISO)->getValue($key); }
	
	/**
	 * @return GWF_NewsText[]
	 */
	public function getTexts()
	{
		if (!($cache = $this->tempGet('newstexts')))
		{
			$query = GWF_NewsText::table()->select('newstext_lang, *');
			$query->where("newstext_news=".$this->getID());
			$cache = $query->exec()->fetchAllArray2dObject();
			$this->tempSet('newstexts', $cache);
		}
		return $cache;
	}
	
	/**
	 * @param string $iso
	 * @return GWF_NewsText
	 */
	public function getText(string $iso, bool $fallback=true)
	{
		$texts = $this->getTexts();
		if (isset($texts[$iso]))
		{
			return $texts[$iso];
		}
		if ($fallback)
		{
			if (isset($texts[GWF_LANGUAGE]))
			{
				return $texts[GWF_LANGUAGE];
			}
			else
			{
				return array_shift($texts);
			}
		}
	}
}
