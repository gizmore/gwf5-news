<?php
final class GWF_Newsletter extends GDO
{
	###########
	### GDO ###
	###########
	public function gdoColumns()
	{
		return array(
			GDO_AutoInc::make('newsletter_id'),
			GDO_Email::make('newsletter_email')->notNull()->unique(),
			GDO_Int::make('newsletter_news_id')->unsigned(), # Last received newsletter for cronjob via web state :P
		);
	}
	
}
