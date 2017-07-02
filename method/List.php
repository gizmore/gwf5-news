<?php
class News_List extends GWF_MethodQueryList
{
	public function gdoTable() { return GWF_News::table(); }
	
	public function gdoQuery()
	{
		$query = parent::gdoQuery();
		return $this->filterNewsQuery($query);
	}
	
	public function filterNewsQuery(GDOQuery $query)
	{
		return $query->where('news_deleted IS NULL AND news_visible');
	}
	
}
