<?php
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemIossa extends JPlugin {

	function onAfterInitialise() {

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
		// do nothing if not a mobile client
		if (!$jawc->mobile) {
			return;
		}

		// add needed items to head of page
		// add meta and link-rels to allow creation of standalone with provided app icons
		$doc->setMetaData('apple-mobile-web-app-capable', 'YES');
		$doc->addHeadLink('images/apple-touch-icon.png', 'apple-touch-icon');
		$doc->addHeadLink('images/apple-touch-icon-76x76.png', 'apple-touch-icon', 'rel', array('sizes'=>'76x76'));
		$doc->addHeadLink('images/apple-touch-icon-120x120.png', 'apple-touch-icon', 'rel', array('sizes'=>'120x120'));
		$doc->addHeadLink('images/apple-touch-icon-152x152.png', 'apple-touch-icon', 'rel', array('sizes'=>'152x152'));

		// modify every anchor link to keep from transferring to Safari when activated
		$so_script = 'var iossaWebkit;
if (!iossaWebkit) {
	iossaWebkit = jQuery(document).ready( function() {
			function fullscreen() {
				var a=document.getElementsByTagName("a");
				for (var i=0; i<a.length; i++) {
					var hrf = a[i].getAttribute("href");
					if ((hrf.substring(0, 1) == "#") || (hrf.substring(0, 11) == "javascript:") || a[i].className.match("noeffect")) {
					} else {
						a[i].onclick = function() {
								window.location = this.getAttribute("href");
								return false;
							}
					}
				}
			}
			iossaWebkit.init = function() {
					fullscreen();
				};
			iossaWebkit.init();
		});
}
';
		$doc->addScriptDeclaration($so_script);
	}

}