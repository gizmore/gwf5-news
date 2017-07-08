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
			GDO_Int::make('newsletter_news')->unsigned(), # Last received newsletter for cronjob via web state :P
			GDO_User::make('newsletter_user')->unique(),
			GDO_Email::make('newsletter_email')->unique(),
			GDO_Language::make('newsletter_lang'),
			GDO_EmailFormat::make('newsletter_fmt'),
		);
	}
	
	public function gdoHashcode()
	{
		return self::gdoHashcodeS($this->getVars(['newsletter_id', 'newsletter_user', 'newsletter_email']));
	}
	
	public static function getByEmail(string $email) { return self::getBy('newsletter_email', $email); }
	
	public static function getByUser(GWF_User $user) { return self::getBy('newsletter_user', $user->getID()); }
	
	public static function hasSubscribed(GWF_User $user) { return !!self::getByUser($user); }
	
	public static function hasSubscribedMail(string $email) { return !!self::getByEmail($email); }
	
	/**
	 * @return GWF_User
	 */
	public function getUser() { return $this->getValue('newsletter_user'); }
	public function getUserID() { return $this->getVar('newsletter_user'); }
	public function hasUser() { return $this->getUserID() !== null; }
	
}
