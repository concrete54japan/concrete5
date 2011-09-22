<?php
defined('C5_EXECUTE') or die("Access Denied.");
class NewsDashboardModuleController extends Controller {

	// simple pie is awesome and parses the HTML!
	const FEED = 'http://feeds2.feedburner.com/concrete5japan';
	const FEED_READ_MORE = "http://concrete5-japan.org/news/";
	
	public function __construct() {
		Loader::model('system_notification');
		$snl = new SystemNotificationList();
		$snl->setItemsPerPage(4);
		$notifications = $snl->getPage();
		$this->set('notifications', $notifications);
		$this->set('total', $snl->getTotal());
	}
}