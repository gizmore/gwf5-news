<?php
/**
 * Send newsletter via cronjob.
 * @author gizmore
 * @since 3.0
 * @version 5.0
 */
final class News_Send extends GWF_MethodCronjob
{
	public function run()
	{
		$table = GWF_News::table();
		$query = $table->select();
		$query->where("news_send IS NOT NULL AND news_sent IS NULL");
		$query->order('news_send');
		if ($news = $table->fetch($query->first()->exec()))
		{
			$this->sendNewsletter($news);
		}
	}
	
	private function sendNewsletter(GWF_News $news)
	{
		$this->logNotice("Sending newsletter for {$news->getTitle()}");
		$table = GWF_Newsletter::table();
		$query = $table->select('*')->where("newsletter_news IS NULL OR newsletter_news != {$news->getID()}");
		$result = $query->exec();
		$count = 0;
		while ($newsletter = $table->fetch($result))
		{
			$this->sendNewsletterTo($news, $newsletter);
			$count++;
		}
		$this->logNotice("Sent $count newsletter emails.");
		$news->saveVar('news_sent', GWF_Time::getDate());
	}
	
	private function sendNewsletterTo(GWF_News $news, GWF_Newsletter $newsletter)
	{
		$mail = $this->mailSkeleton($news, $newsletter);
		if ($user = $newsletter->getUser())
		{
			$mail->sendToUser($user);
		}
		else
		{
			$mail->setReceiver($newsletter->getMail());
			if ($mail->getMailFormat() === GDO_EmailFormat::TEXT)
			{
				$mail->sendAsText();
			}
			else
			{
				$mail->sendAsHTML();
			}
		}
		$newsletter->saveVar('newsletter_news', $news->getID());
	}
		
	private function mailSkeleton(GWF_News $news, GWF_Newsletter $newsletter)
	{
		$user = $newsletter->getUser();
		$iso = $user ? $user->getLangISO() : $newsletter->getLangISO();
		$sitename = $this->getSiteName();
		$username = $user ? $user->displayNameLabel() : tiso($iso, 'dear_member_of', [$sitename]);
		$date = tt($news->getCreateDate());
		$title = htmle($news->getTitleISO($iso));
		$author = $news->getCreator()->displayNameLabel();
		$message = htmle($news->getMessageISO($iso));
		$unsubscribeLink = GWF_HTML::anchor(
				url('News', 'Unsubscribe', '&id='.$newsletter->getID().'&token='.$newsletter->gdoHashcode()));
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setSenderName(GWF_BOT_NAME);
		$mail->setSubject(tiso($iso, 'mail_subj_newsletter', [$sitename, $title]));
		$args = [$username, $sitename, $unsubscribeLink, $date, $title, $author, $message];
		$mail->setBody(tiso($iso, 'mail_body_newsletter', $args));
		return $mail;
	}
	
}
