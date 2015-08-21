<?php

class plgSystemIossaInstallerScript {

	protected $touchImages = array('apple-touch-icon.png','apple-touch-icon-76x76.png','apple-touch-icon-120x120.png','apple-touch-icon-152x152.png');

	public function install ($parent) {

		// add apple-touch images if not already present
		$sPath = $parent->getParent()->getPath('source') . '/images/';
		foreach ($this->touchImages as $img) {
			if (!JFile::exists(JPATH_ROOT . '/images/' . $img)) {
				JFile::copy($sPath . $img, JPATH_ROOT . '/images/' . $img);
			}
		}

		return true;

	}

	public function uninstall ($parent) {

		// remove apple-touch images
		foreach ($this->touchImages as $img) {
			if (JFile::exists(JPATH_ROOT . '/images/' . $img)) {
				JFile::delete(JPATH_ROOT . '/images/' . $img);
			}
		}

	}

	public function update ($parent) {

	}

	public function preflight ($type, $parent) {

	}

	public function postflight ($type, $parent) {

		if ($type == 'install')
			echo '<p class="alert-info">You may want to change the "apple-touch-icon..." files in "&lt;joomla root&gt;/images" to something different. The image names and sizes (60,76,120,152) must remain the same.</p>';

	}

}