<?php
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemIossa extends JPlugin {

//	function __construct( &$subject, $params ){
//		parent::__construct( $subject, $params );
//		$this->_plugin = JPluginHelper::getPlugin( 'system', 'cmobile' );
//		$this->_params = new JRegistry( $this->_plugin->params );
//	}
	
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
		// if is a mobile client, add needed items to head of page
		if ($jawc->mobile) {

			// add meta and link-rels to allow creation of standalone with provided app icons
			$doc->setMetaData('apple-mobile-web-app-capable', 'YES');
			$doc->addHeadLink('images/apple-touch-icon.png', 'apple-touch-icon');
			$doc->addHeadLink('images/apple-touch-icon-76x76.png', 'apple-touch-icon', 'rel', array('sizes'=>'76x76'));
			$doc->addHeadLink('images/apple-touch-icon-120x120', 'apple-touch-icon', 'rel', array('sizes'=>'120x120'));
			$doc->addHeadLink('images/apple-touch-icon-152x152', 'apple-touch-icon', 'rel', array('sizes'=>'152x152'));

			// modify every anchor link to keep from transferring to Safari when activated
			$so_script = 'var iWebkit;
if (!iWebkit) {
	iWebkit = jQuery(document).ready( function() {
			function fullscreen() {
				var a=document.getElementsByTagName("a");
				for (var i=0; i<a.length; i++) {
					if (a[i].className.match("noeffect") || (a[i].getAttribute("href").substring(0, 11) == "javascript:")) {
					} else {
						a[i].onclick = function() {
								window.location = this.getAttribute("href");
								return false;
							}
					}
				}
			}
			iWebkit.init = function() {
					fullscreen();
				};
			iWebkit.init();
		});
}
';
			$doc->addScriptDeclaration($so_script);
		}
	}

}