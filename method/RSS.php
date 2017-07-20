<?php
final class News_RSS extends GWF_Method
{
	public function execute()
	{
	    $query = GWF_News::table()->select()->limit(10);
	    $query->where("news_visible")->order('news_created', false);
	    $items = $query->exec()->fetchAllObjects();
	    
	    $sitename = $this->getSiteName();
	    $feed = new GWF_RSS(
	        t('newsfeed_title', [$sitename]),
	        t('newsfeed_descr', [$sitename]),
	        $items,
	        url('News', 'List'),
	        url('News', 'RSS'));
	    die($feed->render());
	}
}
