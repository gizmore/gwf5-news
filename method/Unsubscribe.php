<?php
/**
 * Unsubscribe newsletter via token.
 * @author gizmore
 * @since 2.0
 */
final class News_Unsubscribe extends GWF_Method
{
	public function isAlwaysTransactional() { return true; }
	
	public function execute()
	{
		if ( (!($newsletter = GWF_Newsletter::getById(Common::getRequestString('id')))) ||
			 ($newsletter->gdoHashcode() !== Common::getRequestString('token')) )
		{
			return $this->error('err_newsletter_not_subscribed');
		}
		$newsletter->delete();
		return $this->message('msg_newsletter_unsubscribed');
	}
}
