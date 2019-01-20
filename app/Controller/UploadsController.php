<?php
class UploadsController extends AppController {

	//var $scaffold;

	public $helpers = array('Markdown.Markdown');

	var $categories = array(
						'training'  => 'training',
						'coaching'  => 'coaching',
						'game'      => 'game',
						'magazine'  => 'magazine',
						'nieuws' 		=> 'nieuws',
						'evenement' => 'evenement',
						'kamp'      => 'kamp',
						'pers'      => 'in de pers',
						'picture'   => 'foto',
						'clip'      => 'clip',
						'csv'       => 'csv',
						'andere'    => 'andere'
						);

	var $statuses = array(
						'public'  => 'publiek',
						'private' => 'privé',
						'hidden'  => 'verstopt',
						'test'    => 'test'
						);


	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('presentation', 'view');
		// $this->Auth->deny('index');
	}


	public function index() {
		$this->Upload->recursive = -1;
		$this->set('uploads', $this->Upload->find('all', array('fields' => array('id', 'name', 'category', 'season', 'stamp_nice', 'location', 'description', 'tags', 'type', 'size', 'uploader', 'status'), 'order' => array('season DESC', 'category', 'stamp DESC', 'created DESC'))));
	}


	public function category($category = 'all') {
		$this->Upload->recursive = -1;
		if ($category == 'all') {
			$uploads = $this->Upload->find('all', array('fields' => array('id', 'name', 'category', 'season', 'stamp_nice', 'location', 'description', 'tags', 'type', 'size', 'uploader', 'status'), 'order' => array('season DESC', 'category','stamp DESC', 'created DESC')));
			$category = 'alles';
		} else {
			$uploads = $this->Upload->find('all', array('conditions' => array('Upload.category' => $category), 'fields' => array('id', 'name', 'category', 'season', 'stamp_nice', 'location', 'description', 'tags', 'type', 'size', 'uploader', 'status'), 'order' => array('season DESC', 'stamp DESC', 'created DESC')));
			$category = $this->categories[$category];
		}
		$this->set('category', $category);
		$this->set('uploads', $uploads);
	}


	public function presentation($category = 'kamp', $year = null) {
		// $this->layout = 'uploadspresentation';
		$this->set('title_for_layout', $category);
		if ($year == null) {
			$year = $this->currentYears[0];
			$season = $this->currentSeason;
		} else {
			$season = $year . '-' . ($year+1);
		}
		if ($category == "kamp") {
			$title = "De kampboekjes van " . $year;
			$yearpart = '_'.$year;
		} else {
			$title = ucfirst($category) . ' - ' . $season;
			$yearpart = '';
		}
		$this->set('title', $title);
		$this->Upload->recursive = -1;
		$uploadsconditions = array('Upload.category' => $category, 'Upload.season' => $season, 'Upload.status' => 'public');
		$uploadsfields = array('id', 'name', 'category', 'season', 'location', 'description', 'tags', 'type', 'size', 'uploader');
		$uploadsorder = array('stamp', 'name DESC');
		$uploads = $this->Upload->find('all', array('conditions' => $uploadsconditions, 'fields' => $uploadsfields, 'order' => $uploadsorder));
		$this->set('category', $category);
		$this->set('uploads', $uploads);
		$this->set('images', array('clublogo' => 'club_logo.png', 'logo' => 'cmstyle/logo_'.$category.$yearpart.'.png', 'thumbnail' => 'cmstyle/logo_'.$category.$yearpart.'_thumb.png'));
		$thumbnails = array(
			'kamp' => 'cmstyle/download_pdf.png',
			'passeurke' => 'cmstyle/download_pdf.png',
			'magazine' => 'cmstyle/press_128.png',
			'pers' => 'cmstyle/press_128.png',
			);
		$this->set('thumbnails', $thumbnails);
	}


	public function old_view_without_category($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Ongeldige upload', true), "flash-error");
			$this->redirect(array('action' => 'index'));
		}
		$this->Upload->id = $id;
		$upload = $this->Upload->read();
		$uploadtype = explode('/', $upload['Upload']['type']);
		$fullLocation = $this->base . '/files/uploads/'.$upload['Upload']['location'];
		if ($uploadtype[0] == 'image') {
			$isPicture = true;
			$thumbnail = array('location'=>$fullLocation, 'title'=>'Bekijk '.$upload['Upload']['name']);
		} else {
			if ($uploadtype[1] == 'pdf') {
				$subtype = 'pdf';
			} else {
				$subtype = 'document';
			}
			$isPicture = false;
			$thumbnail = array('location'=>$this->base . '/img/cmstyle/download_'.$subtype.'.png', 'title'=>'Download '.$upload['Upload']['name']);
		}
		$this->set('category', $this->categories[$upload['Upload']['category']]);
		$this->set('upload', $upload);
		$this->set('isPicture', $isPicture);
		$this->set('fullLocation', $fullLocation);
		$this->set('thumbnail', $thumbnail);
	}


	public function view($category = null, $id = null) {
		if ((!$category) or (!$id)) {
			$this->Session->setFlash(__('Ongeldige upload', true), "flash-error");
			$this->redirect(array('action' => 'index'));
		}
		$this->Upload->id = $id;
		if (!$this->Upload->exists()) {
			//throw new NotFoundException(__('Upload bestaat niet.'));
			$this->Session->setFlash(__('Upload bestaat niet', true), "flash-error");
			$this->redirect(array('action' => 'index'));
		}
		$upload = $this->Upload->read();
		if ($upload['Upload']['category'] <> $category) {
			//throw new NotFoundException(__('Upload bestaat niet in deze categorie.'));
			$this->Session->setFlash(__('Upload bestaat niet in deze categorie', true), "flash-error");
			$this->redirect(array('action' => 'index'));
		}
		$uploadtype = explode('/', $upload['Upload']['type']);
		$fullLocation = $this->base . '/files/uploads/'.$upload['Upload']['location'];
		if ($uploadtype[0] == 'image') {
			$isPicture = true;
			$thumbnail = array('location'=>$fullLocation, 'title'=>'Bekijk '.$upload['Upload']['name']);
		} else {
			if ($uploadtype[1] == 'pdf') {
				$subtype = 'pdf';
			} else {
				$subtype = 'document';
			}
			$isPicture = false;
			$thumbnail = array('location'=>$this->base . '/img/cmstyle/download_'.$subtype.'.png', 'title'=>'Download '.$upload['Upload']['name']);
		}
		$this->set('category', $this->categories[$upload['Upload']['category']]);
		$this->set('upload', $upload);
		$this->set('isPicture', $isPicture);
		$this->set('fullLocation', $fullLocation);
		$this->set('thumbnail', $thumbnail);
	}


	public function add($category = null) {
		if ($this->request->is('post')) {
			$formdata = $this->request->data;
			if ((isset($formdata['Upload']['Files'])) and (is_array($formdata['Upload']['Files']))) {
				if (isset($formdata['Upload']['category'])) {
					// upload (move uploaded files) to the correct position and return array with urls (and/or errors)
					$uploads = $this->uploadFiles($formdata['Upload']['category'], $formdata['Upload']['Files']);
					// process the successfully uploaded files
					for ($i = 0; $i < count($uploads); ++$i) {
						$onefile = $formdata['Upload']['Files'][$i];
						$oneresult = $uploads[$i];
						// if earlier on, the uploaded file was successfully moved to the url location, we add a record for the table
						if ($oneresult['upload_url'] <> '') {
							$newrecords[] = array(
										'season'         => $formdata['Upload']['season'],
										'name'           => $formdata['Upload']['name'],
										'category'       => $formdata['Upload']['category'],
										'stamp'          => $formdata['Upload']['stamp'],
										'tags'           => $formdata['Upload']['tags'],
										'description'    => $formdata['Upload']['description'],
										'location'       => $oneresult['upload_url'],
										'type'           => $onefile['type'],
										'size'           => $onefile['size'],
										'status'         => 'public',
										'uploader'       => $this->Auth->user('username')
									);
						} else {
							$badrecords[] = $oneresult['upload_error'];
						}
					}
				}
				// validate and save the records for the files that were valid
				if (isset($newrecords)) {
					$saveresults    = $this->Upload->saveAll($newrecords, array('validate' => 'first', 'atomic' => false));
					$selectioncount = count($formdata['Upload']['Files']);
					$uploadcount    = count($newrecords);
					$savedcount = 0;
					for ($j = 0; $j < count($saveresults); ++$j) {
						if ($saveresults[$j]) {
							$savedcount++;
							// $badrecords[] = $newrecords[$j]['location'] . " kon WEL bewaard worden in de databank";
						} else {
							$badrecords[] = $newrecords[$j]['location'] . " kon niet bewaard worden in de databank";
						}
					}
					if (isset($badrecords)) {
						$flashdetails = '<br/><font size="-1">' . implode('<br/>', $badrecords) . '</font>';
					} else {
						$flashdetails = '';
					}
					parent::logAction(__FUNCTION__, 'upload', $this->Upload->id);
					$this->Session->setFlash("Het bestand werd bewaard." . $flashdetails, "flash-info");
					$this->redirect(array('action' => 'index'));
					$this->set('saveresults', $saveresults);
					$this->set('newrecords', $newrecords);
				} else {
					$flashdetails = implode('<br/>', $badrecords);
					$this->Session->setFlash('Er werd geen geldig bestand geselecteerd.<br/><font size="-1">' . $flashdetails . '</font>', "flash-error");
					// $this->redirect(array('action' => 'index'));
				}
				$this->set('uploads', $uploads);
			} else {
				$this->Session->setFlash('Er werd geen bestand opgeladen.<br/><font size="-1">De totale grootte is groter dan toegelaten. Er werd een te groot bestand geselecteerd.</font>', "flash-error");
			}
		} else {
			if ($category != null) {
				$this->request->data['Upload']['category'] = $category;
				// $this->set('category', $category);
			}
		}
		$this->set('categories', $this->categories);
	}


	public function edit($id = null) {
		$this->Upload->id = $id;
		$upload = $this->Upload->read(null, $id);
		if (!$this->Upload->exists()) {
			throw new NotFoundException(__('Upload bestaat niet.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Upload->save($this->request->data)) {
				$this->Session->setFlash(__('De upload werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'upload', $this->Upload->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('De upload kon niet worden bewaard.'), "flash-error");
			}
		} else {
			$this->request->data = $upload;
		}
		$this->set('upload', $upload);
		$this->set('categories', $this->categories);
		$this->set('statuses', $this->statuses);
	}


/**
 * upload files
 * params:
 *      $location   = the folder to upload the files e.g. 'files', in this case the location starting AFTER "files/uploads/"
 *      $filedata   = the array containing the form files
 *      $subdir     = will put the image in the subdir (optional)
 * @return:
 *      will return an array with the success of each file upload
 */
	private function uploadFiles($location, $filedata, $subdir = null) {
		// initialize stuff
		$permittedtypes = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'video/mp4',
								'application/pdf',
								'application/vnd.oasis.opendocument.text', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
								'application/vnd.oasis.opendocument.spreadsheet', 'application/excel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
								'application/vnd.oasis.opendocument.presentation', 'application/mspowerpoint', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
								'text/csv'
		                       );
		$returncodes = array(
						0 => array('code' => 'UPLOAD_ERR_OK',         'text' => 'There is no error, the file uploaded with success.'),
						1 => array('code' => 'UPLOAD_ERR_INI_SIZE',   'text' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.'),
						2 => array('code' => 'UPLOAD_ERR_FORM_SIZE',  'text' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.'),
						3 => array('code' => 'UPLOAD_ERR_PARTIAL',    'text' => 'The uploaded file was only partially uploaded.'),
						4 => array('code' => 'UPLOAD_ERR_NO_FILE',    'text' => 'No file was uploaded.'),
						6 => array('code' => 'UPLOAD_ERR_NO_TMP_DIR', 'text' => 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.'),
						7 => array('code' => 'UPLOAD_ERR_CANT_WRITE', 'text' => 'Failed to write file to disk. Introduced in PHP 5.1.0.'),
						8 => array('code' => 'UPLOAD_ERR_EXTENSION',  'text' => 'File upload stopped by extension. Introduced in PHP 5.2.0.')
					);
		// setup dir names absolute and relative
		$upload_dir = WWW_ROOT . 'files/uploads/' . $location;
		$rel_url    = $location;
		if (!is_dir($upload_dir)) mkdir($upload_dir);
		if (($subdir) && (trim($subdir) !== '')) {
			$upload_dir .= '/' . $subdir;
			$rel_url .= '/' . $subdir;
			if (!is_dir($upload_dir)) mkdir($upload_dir);
		}
		// loop through and deal with the files
		for ($i = 0; $i < count($filedata); ++$i) {
			$file = $filedata[$i];
			$result[$i]['returncode'] = $returncodes[$file['error']]['code'];
			$result[$i]['returntext'] = $returncodes[$file['error']]['text'];
			$result[$i]['upload_url'] = '';
			$result[$i]['upload_error'] = '';
			$typeOK = false;
			foreach ($permittedtypes as $filetype) {
				if ($file['type'] == $filetype) {
					$typeOK = true;
					break;
				}
			}
			$filename = $file['name'];
			switch ($file['error']) {
				case 0:		// if file type and upload ok, then move the file
					if ($typeOK) {
						$newfilename = str_replace(array(" ", ":", "!", "(", ")", ",", ";", "=", "+", "<", ">"), '_', $filename);
						if (file_exists($upload_dir . '/' . $newfilename)) $newfilename = date('Ymd-His') . '_' . $newfilename;
						$url = $rel_url . '/' . $newfilename;
						$success = move_uploaded_file($file['tmp_name'], 'files/uploads/' . $url);
						if ($success) {
							$result[$i]['upload_url'] = $url;
						} else {
							$result[$i]['upload_error'] = "Fout bij het plaatsen van $filename naar $url.";
						}
					} else {
						// unacceptable file type
						$result[$i]['upload_error'] = "$filename van het type " . $file['type'] . " kan niet opgeladen worden. Toegelaten types: beelden en documenten.";
					}
					break;
				case 1:		// an error occured
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Bestand is te groot (php.ini).";
					break;
				case 2:		// an error occured
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Bestand is te groot.";
					break;
				case 3:		// an error occured
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Bestand gedeeltelijk opgeladen.";
					break;
				case 4:		// no file was selected for upload
					$result[$i]['upload_error'] = "Er werd geen bestand geselecteerd.";
					break;
				case 6:		// missing a temporary folder (introduced in PHP 4.3.10 and PHP 5.0.3)
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Een folder ontbreekt.";
					break;
				case 7:		// failed to write file to disk (introduced in PHP 5.1.0)
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Bestand kon niet weggeschreven worden.";
					break;
				case 8:		// file upload stopped by extension (introduced in PHP 5.2.0)
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Opladen werd onderbroken.";
					break;
				default:	// another error occured
					$result[$i]['upload_error'] = "Systeemfout bij het opladen van $filename -- Contacteer de webmaster.";
					break;
			}
		}
		return $result;
	}


	public function reports() {
		$this->set('categories', $this->categories);
		$uploads = $this->Upload->find('all', array('fields' => array('category', 'COUNT(category) as aantal'), 'group' => 'category'));
		// $this->set('uploads', $uploads);
		$uploadcategories = array();
		foreach ($uploads as $upload) {
			$uploadcategories[$upload['Upload']['category']] = $upload[0]['aantal'];
		}
		$this->set('uploadcategories', $uploadcategories);
	}
}
