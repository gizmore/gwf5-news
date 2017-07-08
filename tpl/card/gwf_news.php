<?php $gdo instanceof GWF_News; ?>
<?php
$user = GWF_User::current();
$comments = $gdo->gdoCommentTable();
?>
<md-card flex="100">
  <md-card-title>
    <md-card-title-text>
      <span class="md-headline">
        <div>“<?php html($gdo->getTitle()); ?>” - <?php echo $gdo->getCreator()->renderCell(); ?></div>
        <div class="gwf-card-date"><?php lt($gdo->getCreateDate()); ?></div>
      </span>
    </md-card-title-text>
  </md-card-title>
  <gwf-div></gwf-div>
  <md-card-content flex>
    <?php echo $gdo->displayMessage(); ?>
  </md-card-content>
  <gwf-div></gwf-div>
  <md-card-actions layout="row" layout-align="end center">
<?php if ($gdo->gdoCommentsEnabled()) : ?>
<?php $count = $gdo->gdoCommentCount(); ?>
<?php echo GDO_Link::make('link_comments')->label('link_comments', [$count])->icon('feedback')->href(href('News', 'Comments', '&id='.$gdo->getID()))->renderCell(); ?>
<?php endif; ?>
<?php
if ($gdo->canEdit($user))
{
	echo GDO_EditButton::make()->href(href('News', 'Write', '&id='.$gdo->getID()))->renderCell(); 
}
if ($gdo->gdoCanComment($user))
{
	echo GDO_Button::make('btn_write_comment')->href(href('News', 'WriteComment', '&id='.$gdo->getID()))->icon('reply')->renderCell();
	
}

?>
  </md-card-actions>

</md-card>
