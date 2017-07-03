<?php
/**
 * News database.
 * @author gizmore
 * @version 5.0
 * @since 2.0
 * @see GWF_NewsText
 */
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
	public function getID() { return $this->getVar('news_id'); }
	public function isSent() { return $this->getSentDate() !== null; }
	/**
	 * @return GWF_Category
	 */
	public function getCategory() { return $this->getValue('news_category'); }
	public function getCategoryID() { return $this->getVar('news_category'); }
	public function getVisible() { return $this->getVar('news_visible') === '1'; }
	public function getSentDate() { return $this->getVar('news_sent'); }
	public function getCreateDate() { return $this->getVar('news_created'); }
	/**
	 * @return GWF_User
	 */
	public function getCreator() { return $this->getValue('news_creator'); }
	public function getCreatorID() { return $this->getVar('news_creator'); }
	
	#############
	### Texts ###
	#############
	public function getTitle() { return $this->getTextVar('newstext_title'); }
	public function getMessage() { return $this->getTextVar('newstext_message'); }
	
	public function getTextVar(string $key) { return $this->getText(GWF_Trans::$ISO)->getVar($key); }
	public function getTextValue(string $key) { return $this->getText(GWF_Trans::$ISO)->getValue($key); }
	
	public function displayMessage()
	{
		$text = $this->getTxt();
		return $text->gdoColumn('newstext_message')->value($text->getMessage())->renderCell();
	}

	###################
	### Translation ###
	###################
	/**
	 * @return GWF_NewsText
	 */
	public function getTxt()
	{
		return $this->getText(GWF_Trans::$ISO);
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
			return isset($texts[GWF_LANGUAGE]) ? $texts[GWF_LANGUAGE] : array_shift($texts);
		}
	}

	/**
	 * @return GWF_NewsText[]
	 */
	public function getTexts()
	{
		if (!($cache = $this->tempGet('newstexts')))
		{
			$query = GWF_NewsText::table()->select('newstext_lang, gwf_newstext.*');
			$query->where("newstext_news=".$this->getID());
			$cache = $query->exec()->fetchAllArray2dObject();
			$this->tempSet('newstexts', $cache);
		}
		return $cache;
	}
	
}
