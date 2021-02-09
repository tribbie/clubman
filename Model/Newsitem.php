<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class Newsitem extends AppModel {
	public $name = 'Newsitem';

	public $virtualFields = array(
		'itemdate_nice'  => 'DATE_FORMAT(Newsitem.itemdate, "%e/%m/%Y")',
		'activate_nice'  => 'DATE_FORMAT(Newsitem.activate, "%e/%m/%Y")',
		'expire_nice'    => 'DATE_FORMAT(Newsitem.expire, "%e/%m/%Y")',
		'activate_epoch' => 'UNIX_TIMESTAMP(Newsitem.activate)',
		'expire_epoch'   => 'UNIX_TIMESTAMP(Newsitem.expire)',
		'item_order'     => 'UNIX_TIMESTAMP(Newsitem.modified)'
	);

	public function findFileByName($name = null) {
		if ($name) {
			$newsitem = array();
			$newsitem['Newsitem'] = array('category' => 'page', 'name' => 'Webpagina', 'file' => "$name.txt");
			$newsitemfilename = WWW_ROOT . "files/news/$name.md";
			$newsitemfile = new File($newsitemfilename);
			if ($newsitemfile->exists()) {
				// $newsitemfilecontent = '';
				$newsitemfilecontent = $newsitemfile->read(true, 'r');
				$newsitem['Newsitem']['title'] = ucwords(str_replace('-', ' ', $name));
				$newsitem['Newsitem']['subtitle'] = 'filed article';
				$newsitem['Newsitem']['image_url'] = '';
				$newsitem['Newsitem']['filepath'] = $newsitemfilename;
				$newsitem['Newsitem']['content'] = $newsitemfilecontent;
				return $newsitem;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	public function beforeSave( $options = array() ) {
			if (isset($this->data[$this->alias]['expire'])) {
				$expiredate = date('Y-m-d', strtotime($this->data[$this->alias]['expire']));
				$this->data[$this->alias]['expire'] = date('Y-m-d H:i:s', strtotime($expiredate . ' 23:59:59'));
			}
			return true;
	}

}
