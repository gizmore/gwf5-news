<?php
/**
 * Write a news entry.
 * This is a bit more complex form with tabs for each edited language.
 * 
 * @see GDO_Tab
 * @see GDO_Tabs
 * @see GWF_News
 * @see GWF_Form
 * 
 * @author gizmore
 * @since 2.0
 * @version 5.0
 */
final class News_Write extends GWF_MethodForm
{
	use GWF_MethodAdmin;
	
	public function getPermission() { return 'staff'; }
	
	/**
	 * @var GWF_News
	 */
	private $news;
	
	public function init()
	{
		if ($id = Common::getRequestString('id'))
		{
			$this->news = GWF_News::table()->find($id);
		}
	}
	
	public function execute()
	{
		$response = parent::execute();
		$newstabs = Module_News::instance()->renderAdminTabs();
		return $this->renderNavBar('News')->add($newstabs)->add($response);
	}
	
	public function createForm(GWF_Form $form)
	{
		$news = GWF_News::table();
// 		$text = GWF_NewsText::table();
		
		# Category select
		$form->addFields(array(
			$news->gdoColumn('news_category'),
// 			$news->gdoColumn('news_created')->writable(false),
// 			$news->gdoColumn('news_creator')->writable(false),
// 			$news->gdoColumn('news_visible')->writable(false),
			GDO_Divider::make('div_texts'),
		));
		
		# Translation tabs
		$tabs = GDO_Tabs::make('tabs');
		foreach (Module_Language::instance()->cfgSupported() as $iso => $language)
		{
			# New tab
			$tab = GDO_Tab::make('tab_'.$iso)->rawlabel($language->displayName());

			# 2 Fields
			$primary = $iso === GWF_LANGUAGE;
			$title = GDO_String::make("iso][$iso][newstext_title")->label('title')->notNull($primary);
			$message = GDO_Message::make("iso][$iso][newstext_message")->label('message')->notNull($primary);
			if ($this->news)
			{ # Old values
				if ($text = $this->news->getText($iso, false))
				{
					$title->value($text->getTitle());
					$message->value($text->getMessage());
				}
			}
			# Add
			$tab->addField($title);
			$tab->addField($message);
			$tabs->tab($tab);
		}
		$form->addField($tabs);
		
		# Buttons
		$form->addFields(array(
			GDO_Submit::make(),
			GDO_AntiCSRF::make(),
		));
		
		# Dynamic buttons
		if ($this->news)
		{
			$form->addFields(array(
				GDO_Submit::make('preview'),
			));
			
			if (!$this->news->isVisible())
			{
				$form->addField(GDO_Submit::make('visible'));
			}
			else
			{
				$form->addField(GDO_Submit::make('invisible'));
				if (!$this->news->isSent())
				{
					$form->addField(GDO_Submit::make('send'));
				}
			}
			
			$form->addField(GDO_NewsStatus::make('status'));
			
			$form->withGDOValuesFrom($this->news);
		}
	}
	
	public function formValidated(GWF_Form $form)
	{
		# Update news
		$news = $this->news ? $this->news : GWF_News::blank();
		$news->setVar('news_category', $form->getVar('news_category'));
		$news->replace();

		# Update texts
		foreach ($_POST['form']['iso'] as $iso => $data)
		{
			$title = trim($data['newstext_title']);
			$message = trim($data['newstext_message']);
			if ($title || $message)
			{
				$text = GWF_NewsText::blank(array(
					'newstext_news' => $news->getID(),
					'newstext_lang' => $iso,
					'newstext_title' => $title,
					'newstext_message' => $message,
				))->replace();
			}
		}
		
		if ($this->news)
		{
			$this->news->tempUnset('newstexts');
			$this->news->recache();
			return $this->message('msg_news_edited')->add($this->renderForm());
		}
		
		$hrefEdit = href('News', 'Write', '&id='.$news->getID());
		return $this->message('msg_news_created')->add(GWF_Website::redirectMessage($hrefEdit));
	}
	
	public function onSubmit_visible(GWF_Form $form)
	{
		$this->news->saveVar('news_visible', '1');
		$this->form = null;
		return $this->message('msg_news_visible')->add($this->renderForm());
	}
	
	public function onSubmit_invisible(GWF_Form $form)
	{
		$this->news->saveVar('news_visible', '0');
		$this->form = null;
		return $this->message('msg_news_invisible')->add($this->renderForm());
	}
	
	############
	### Mail ###
	############
	public function onSubmit_preview(GWF_Form $form)
	{
	}
	
	public function onSubmit_send(GWF_Form $form)
	{
		$this->news->saveVar('news_send', GWF_Time::getDate());
		
	}
	
}
