<?
defined('C5_EXECUTE') or die("Access Denied.");
?>
<h2><?=t('Search Documentation')?></h2>
<form method="get" action="http://www.concrete5.org/search/">
<input type="text" name="query" style="width: 130px" />
<input type="hidden" name="do" value="search" />
<input type="submit" value="<?=t('Search')?>" />
</form>
<br/>

<h2><?=t('Full Documentation')?></h2>
<div><?=t('Full documentation is available <a href="%s">at Concrete5.org</a>', 'http://www.concrete5-japan.org/help/')?>.</div><br/>
