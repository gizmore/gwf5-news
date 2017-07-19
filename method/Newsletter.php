<?php
/**
 * Susbscribe to the newsletter.
 * @author gizmore
 * @see GWF_News
 * @see GWF_Newsletter
 * @see News_Send
 */
final class News_Newsletter extends GWF_MethodForm
{
	public function isGuestAllowed()
	{
		return Module_News::instance()->cfgGuestNewsletter();
	}
	
	public function isUserRequired()
	{
		return false;
	}
	
	public function execute()
	{
		$tVars = array(
			'form' => $this->getForm(),
			'response' => parent::execute(),
		);
		return $this->templatePHP('newsletter.php', $tVars);
	}
	
	public function createForm(GWF_Form $form)
	{
		$user = GWF_User::current();
		$mem = $user->isMember();
		$subscribed = $mem ? GWF_Newsletter::hasSubscribed($user) : true;
		
		$form->addFields(array(
			GDO_NewsletterStatus::make('status')->gdo($user),
			GDO_Enum::make('yn')->enumValues('yes', 'no')->initial($subscribed?'yes':'no')->label('newsletter_subscribed')->writable($mem),
			GDO_EmailFormat::make('newsletter_fmt')->value($mem?$user->getMailFormat():GDO_EmailFormat::HTML)->writable(!$mem),
			GDO_Language::make('newsletter_lang')->value($mem?$user->getLangISO():GWF_Trans::$ISO)->writable(!$mem),
			GDO_Email::make('newsletter_email')->value($user->getMail())->writable(!$mem),
			GDO_Submit::make(),
			GDO_AntiCSRF::make(),
		));
	}
	public function formValidated(GWF_Form $form)
	{
		return $this->formAction($form)->add($this->renderForm());
	}
	
	public function formAction(GWF_Form $form)
	{
		$user = GWF_User::current();
		$oldsub = $user->isMember() ? 
			GWF_Newsletter::hasSubscribed($user) : 
			false;
		
		if ($form->getVar('yn') === 'yes')
		{
			if ($user->isMember())
			{
				if ($oldsub)
				{
					return $this->error('err_newsletter_already_subscribed');
				}
				$initial = array('newsletter_user' => $user->getID());
			}
			elseif (GWF_Newsletter::hasSubscribedMail($form->getVar('newsletter_email')))
			{
				return $this->error('err_newsletter_already_subscribed');
			}
			else
			{
				$initial = $form->values();
			}
			GWF_Newsletter::blank($initial)->insert();
			return $this->message('msg_newsletter_subscribed');
		}
		elseif (!$oldsub)
		{
			return $this->error('err_newsletter_not_subscribed');
		}
		else
		{
			GWF_Newsletter::table()->deleteWhere('newsletter_user='.$user->getID())->exec();
			return $this->message('msg_newsletter_unsubscribed');
		}
	}
}
