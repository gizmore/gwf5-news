<?php
/**
 * Susbscribe to the newsletter.
 * @author gizmore
 */
final class News_Newsletter extends GWF_MethodForm
{
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
		$users = GWF_User::table();
		$form->addFields($users->getGDOColumns(['user_email_fmt', 'user_email']));
		$form->addFields(array(
			GDO_AntiCSRF::make(),
			GDO_Submit::make(),
		));
	}
}
