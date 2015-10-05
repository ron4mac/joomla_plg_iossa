<?php
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemIossa extends JPlugin {

	public function onAfterInitialise() {

		$app = JFactory::getApplication();
		// do nothing if in the admin
		if ($app->isAdmin()) {
			return;
		}

		$doc = JFactory::getDocument();
		// do nothing if not rendering the standard HTML document
		if (get_class($doc) != 'JDocumentHTML') {
			return;
		}

		$jawc = new JApplicationWebClient();
		// if is a mobile client, add needed items to head of page
		if ($jawc->mobile) {

			// add meta and link-rels to allow creation of standalone with provided app icons
			$doc->setMetaData('apple-mobile-web-app-capable', 'YES');
			$doc->addHeadLink('images/apple-touch-icon.png', 'apple-touch-icon');
			$doc->addHeadLink('images/apple-touch-icon-76x76.png', 'apple-touch-icon', 'rel', array('sizes'=>'76x76'));
			$doc->addHeadLink('images/apple-touch-icon-120x120.png', 'apple-touch-icon', 'rel', array('sizes'=>'120x120'));
			$doc->addHeadLink('images/apple-touch-icon-152x152.png', 'apple-touch-icon', 'rel', array('sizes'=>'152x152'));

			// add our javascript functions
			$doc->addScriptDeclaration(file_get_contents(JPATH_ROOT.'/plugins/system/iossa/iossa.js'));
		}
	}

}