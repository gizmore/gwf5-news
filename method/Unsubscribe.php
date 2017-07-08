<?php
final class News_Unsubscribe extends GWF_Method
{
	public function isAlwaysTransactional() { return true; }
	
	public function execute()
	{
		if ( (!($newsletter = GWF_Newsletter::getByEmail(Common::getRequestString('email')))) ||
			 ($newsletter->gdoHashcode() !== Common::getRequestString('token')) )
		{
			return $this->error('err_newsletter');
		}
	}
}