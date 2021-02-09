<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class Photobook extends AppModel {
	public $name = 'Photobook';
	public $useTable = false;

	public function findalbums($group = 'all', $amount = 0) {
		$albumcoversimgdir = 'andere/albumcovers/';
		$albumcoversdir = 'img/' . $albumcoversimgdir;
		$albumcoverspath = WWW_ROOT . $albumcoversdir;
		$dir = new Folder($albumcoverspath);
		$files = $dir->find('.*\.jpg');
		rsort($files);
		//$this->set('files', $files);
		if (($group <> 'first') and ($group <> 'last')) {
			$group = 'all';
			$xfirst = 0;
			$xlast = count($files) - 1;
		}
		if ($group == 'first') {
			$xfirst = 0;
			$xlast = $amount - 1;
		} elseif ($group == 'last') {
			$xlast = count($files) - 1;
			$xfirst = $xlast - $amount + 1;
		}
		$photobooks = array();
		for ($i = $xfirst; $i <= $xlast; $i++) {
			$file = $files[$i];
			$basename = str_replace(".jpg", "", $file);
			$albumdata = explode('_', $basename, 2);
			$albumid = $albumdata[0];
			$albumrest = explode('__', $albumdata[1], 2);
			$albumtitle = str_replace("_", " ", $albumrest[0]);
			$albumname = $albumrest[1];
			//$albumurl = 'http://picasaweb.google.com/vcwolvertem/' . $albumname;
			$albumurl = Configure::read('Club.photoalbums.baseurl') . $albumname;
			$albumcover = $albumcoversimgdir . $file;
			$photobooks[]['Photobook'] = array('id' => $albumid,  'name' => $albumname, 'title' => $albumtitle, 'url' => $albumurl, 'cover' => $albumcover);
		}
		return array('files' => $files, 'data' => $photobooks);
	}

}
