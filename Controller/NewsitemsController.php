<?php
class NewsitemsController extends AppController {

	//var $scaffold;

	public $helpers = array('Markdown.Markdown');
	public $components = array('RequestHandler');


	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'list', 'view', 'viewtxt');
		//$this->Auth->deny('index');
	}


	public function index() {
		$this->Newsitem->recursive = -1;
		$fieldlist = array(
										'id',
										'name',
										'category',
										'season',
										'title',
										'subtitle',
										'status',
										'itemdate_nice',
										'activate_nice',
										'expire_nice',
										'author'
									);
		$conditions = array('Newsitem.id >' => 0);
		$itemorder = array('season DESC', 'itemdate DESC', 'activate DESC', 'expire DESC');
		$this->set('newsitems', $this->Newsitem->find('all', array('fields' => $fieldlist, 'conditions' => $conditions, 'order' => $itemorder)));
	}


	public function list() {
		$conditions = array('Newsitem.id >' => 0);
		if (isset($this->params['named']['category'])) {
			$conditions['Newsitem.category'] = $this->params['named']['category'];
		}
		if (isset($this->params['named']['season'])) {
			$conditions['Newsitem.season'] = $this->params['named']['season'];
		}
		if (isset($this->params['named']['status'])) {
			$conditions['Newsitem.status'] = $this->params['named']['status'];
		}
		if (isset($this->params['named']['author'])) {
			$conditions['Newsitem.author'] = $this->params['named']['author'];
		}
		$this->Newsitem->recursive = -1;
		$fieldlist = array(
										'id',
										'name',
										'category',
										'season',
										'title',
										'subtitle',
										'status',
										'itemdate_nice',
										'activate_nice',
										'expire_nice',
										'author'
									);
		$itemorder = array('season DESC', 'itemdate DESC', 'activate DESC', 'expire DESC');
		$this->set('newsitems', $this->Newsitem->find('all', array('fields' => $fieldlist, 'conditions' => $conditions, 'order' => $itemorder)));
		$this->layout = 'layout-bootstrap4';

	}


	public function view($itemname = null) {
		if (isset($this->params['named']['id'])) {
			$this->Newsitem->id = $this->params['named']['id'];
			if (!$this->Newsitem->exists()) {
				$this->Session->setFlash(__('Ongeldig nieuwsbericht.', true), "flash-error");
				$this->redirect('/');
			}
			$newsitem = $this->Newsitem->read();
			if (!$newsitem) {
				$this->Session->setFlash(__('Dit nieuwsbericht bestaat niet.', true), "flash-error");
				$this->redirect('/');
			}
		} else {
			if ($itemname) {
				$newsitem = $this->Newsitem->findByName($itemname);
				if (!$newsitem) {
					$newsitem = $this->Newsitem->findFileByName($itemname);
					if (!$newsitem) {
						$this->Session->setFlash(__(ucfirst($itemname) . ' is een ongeldig nieuwsbericht', true), "flash-error");
						$this->redirect('/');
					}
				} else {
				}
			} else {
				$this->Session->setFlash(__('Geen nieuwsbericht meegegeven.', true), "flash-error");
				$this->redirect('/');
			}
		}
		$newsitem['Newsitem']['content'] = str_replace('[wwwbase]', $this->base, $newsitem['Newsitem']['content']);
		$this->set('newsitem', $newsitem);
	}


	public function viewtxt($page = null) {
		// $this->layout = 'logoonly';
		$newsitem = $this->Newsitem->findFileByName($page);
		$this->set('newsitem', $newsitem);
	}


	public function add() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Newsitem->create();
			$itemname = $this->request->data['Newsitem']['title'];
			$itemname = str_replace(array(" ", ".", ":", "!", "(", ")", ",", ";", "=", "+", "<", ">", "'", '"'), '-', $itemname);
			$itemname = strtolower(trim(str_replace(array("--"), '-', $itemname), "-"));
			$this->request->data['Newsitem']['name'] = $itemname;
			if (trim($this->request->data['Newsitem']['author']) == '') {
				$this->request->data['Newsitem']['author'] = (($this->currentUser['Member']['name'] == '') ? 'unknown' : $this->currentUser['Member']['name']);
			}
			if ($this->Newsitem->save($this->request->data)) {
				$this->Session->setFlash(__('Het nieuwsbericht werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'newsitem', $this->Newsitem->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het nieuwsbericht kon niet worden bewaard.'), "flash-error");
			}
		}
		$newsitem_categories = array(
				'club' => 'Club nieuws',
				'jeugd' => 'Jeugd nieuws',
				'seniors' => 'Seniors nieuws',
				'evenement' => 'Evenement nieuws',
				'kamp' => 'Kamp nieuws',
				'andere' => 'Ander nieuws'
			);
		$newsitem_statuses = array(
				'public' => 'Publiek',
				'private' => 'Privé',
				'test' => 'Test'
			);
		$this->set('newsitem_statuses', $newsitem_statuses);
		$this->set('newsitem_categories', $newsitem_categories);
		//$this->layout = 'layout-summernote';

	}


	public function edit($id = null) {
		$this->Newsitem->id = $id;
		if (!$this->Newsitem->exists()) {
			throw new NotFoundException(__('Dit nieuwsbericht bestaat niet.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$itemname = $this->request->data['Newsitem']['title'];
			$itemname = str_replace(array(" ", ".", ":", "!", "(", ")", ",", ";", "=", "+", "<", ">", "'", '"'), '-', $itemname);
			$itemname = strtolower(trim(str_replace(array("--"), '-', $itemname), "-"));
			$this->request->data['Newsitem']['name'] = $itemname;
			if (trim($this->request->data['Newsitem']['author']) == '') {
				$this->request->data['Newsitem']['author'] = (($this->currentUser['Member']['name'] == '') ? 'unknown' : $this->currentUser['Member']['name']);
			}
			if ($this->Newsitem->save($this->request->data)) {
				$this->Session->setFlash(__('Het nieuwsbericht werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'newsitem', $this->Newsitem->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het nieuwsbericht kon niet worden bewaard.'), "flash-error");
			}
		} else {
			$newsitem = $this->Newsitem->read(null, $id);
			$this->request->data = $newsitem;
		}
		$newsitem_categories = array(
				'club' => 'Club nieuws',
				'jeugd' => 'Jeugd nieuws',
				'seniors' => 'Seniors nieuws',
				'evenement' => 'Evenement nieuws',
				'kamp' => 'Kamp nieuws',
				'andere' => 'Ander nieuws'
			);
		$newsitem_statuses = array(
				'public' => 'Publiek',
				'private' => 'Privé',
				'test' => 'Test'
			);
		$this->set('newsitem_statuses', $newsitem_statuses);
		$this->set('newsitem_categories', $newsitem_categories);
	}


	public function setstatus($id = null, $newstatus = null) {
		if (!empty($id) and !empty($newstatus)) {
			$this->Newsitem->read(null, $id);
			$this->Newsitem->set('status', $newstatus);
			if ($this->Newsitem->save()) {
				$this->Session->setFlash(__('Het item werd bewaard.'), "flash-info");
				parent::logAction(__FUNCTION__, 'newsitem', $this->Newsitem->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Het item kon niet worden bewaard.'), "flash-error");
				$this->redirect(array('action' => 'index'));
			}
		}
	}


	public function ajuploadimage() {

		$this->autoRender = false; // We don't render a view in this example
		//$this->request->onlyAllow('ajax'); // No direct access via browser URL

		$reqData = $this->request;
		$imageData = array();
		$uploadResult = array();
		$resultData = array();

		if ((isset($reqData->params['form']['imagedata'])) and (is_array($reqData->params['form']['imagedata']))) {
			$imageData = $reqData->params['form']['imagedata'];
			$category = "nieuws";
			/// Upload (move uploaded file) to the correct position and return url (or error)
			$uploadResult = $this->saveImage($category, $imageData);
			/// Process the successfully uploaded file
			if ($uploadResult['upload_url'] <> '') {
				$resultData['uploadrecord'] = array(
							'season'         => $this->currentSeason,
							'name'           => "upload - " . $imageData['name'],
							'category'       => $category,
							'stamp'          => date('Y-m-d H:i:s', strtotime('now')),
							'tags'           => "image automatic upload",
							'description'    => "Image uploaded through news editor (ajax) - " . $imageData['tmp_name'],
							'remark'         => "",
							'location'       => $uploadResult['upload_url'],
							'type'           => $imageData['type'],
							'size'           => $imageData['size'],
							'status'         => 'public',
							'uploader'       => $this->Auth->user('username')
						);
				$resultData['url'] = $this->cmclub['clubweb']['home'] . '/' . $uploadResult['upload_url_from_base'];
				$resultData['rc']['uploadimage'] = 0;
			} else {
				$resultData['error'] = 'Ooops! Your upload triggered the following error: ' . $imageData['error'] . ' -- ' . $uploadResult['upload_error'];
				$resultData['rc']['uploadimage'] = 1;
			}
		}
		/// Validate and save the records for the pictures that were valid
		$this->loadModel('Upload');
		if (isset($resultData['uploadrecord'])) {
			if ($this->Upload->save($resultData['uploadrecord'])) {
				$resultData['rc']['saverecord'] = 0;
			} else {
				$resultData['rc']['saverecord'] = 1;
				$resultData['error'] = $resultData['uploadrecord']['location'] . " kon niet bewaard worden in de databank";
			}
		}
		parent::logAction(__FUNCTION__, 'upload', $this->Upload->id);

		$response = array();
		$response['meta'] = array('requestdata' => $reqData, 'cakedata' => array('imagedata' => $imageData));
		$response['data'] = array('uploadresult' => $uploadResult, 'resultdata' => $resultData);
		return json_encode($response);

		// if ($_FILES['file']['name']) {
		//  	if (!$_FILES['file']['error']) {
		//     $name = md5(rand(100, 200));
		//     $ext = explode('.', $_FILES['file']['name']);
		//     $filename = $name . '.' . $ext[1];
		//     $destination = 'images/' . $filename; //change this directory
		//     $location = $_FILES["file"]["tmp_name"];
		//     move_uploaded_file($location, $destination);
		//     return 'images/' . $filename;//change this URL
		//  	}
		//  	else
		//  	{
		//   	return  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
		//  	}
		// }

	}

	/**
	 * upload images
	 * params:
	 *      $location   = the folder to upload the files e.g. 'files', in this case the location starting AFTER "img/", for html->image to work
	 *      $filedata   = the array containing the form files
	 *      $subdir     = will put the image in the subdir (optional)
	 * @return:
	 *      will return an array with the success of each file upload
	 */
	private function saveImage($location, $filedata, $subdir = null) {
		/// Initialize stuff
		$permittedtypes = array('image/jpeg', 'image/pjpeg', 'image/png');
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
		/// Setup dir names absolute and relative
		$base_location = 'files/uploads/';
		$upload_dir = WWW_ROOT . $base_location . $location;
		$rel_url = $location;
		if (!is_dir($upload_dir)) mkdir($upload_dir);
		if (($subdir) && (trim($subdir) !== '')) {
			$upload_dir .= '/' . $subdir;
			$rel_url .= '/' . $subdir;
			if (!is_dir($upload_dir)) mkdir($upload_dir);
		}
		/// Create an "original" directory to store the original (non-resized) image
		$upload_dir_original = $upload_dir . '/original';
		$rel_url_original = $rel_url . '/original';
		if (!is_dir($upload_dir_original)) mkdir($upload_dir_original);
		/// Put the file
		$file = $filedata;
		$result['returncode'] = $returncodes[$file['error']]['code'];
		$result['returntext'] = $returncodes[$file['error']]['text'];
		$result['upload_url'] = '';
		$result['upload_error'] = '';
		$typeOK = false;
		foreach ($permittedtypes as $filetype) {
			if ($file['type'] == $filetype) {
				$typeOK = true;
				break;
			}
		}
		$filename = $file['name'];
		switch ($file['error']) {
			case 0:		/// If file type and upload ok, then move the file
				if ($typeOK) {
					$newfilename = str_replace(array(" ", ":", "!", "(", ")", ",", ";", "=", "+", "<", ">"), '_', $filename);
					$newfilename = date('Ymd-His') . '_' . bin2hex(random_bytes(2)) . '_' . $newfilename;
					if (file_exists($upload_dir . '/' . $newfilename)) $newfilename = date('Ymd-His') . '_' . $newfilename;
					$url          = $rel_url . '/' . $newfilename;
					$url_original = $rel_url . '/original/' . $newfilename;
					$success = move_uploaded_file($file['tmp_name'], $base_location . $url_original);
					if ($success) {
						$resizerc = $this->resize_img($base_location . $url_original, $base_location . $url);
						if ($resizerc == 0) {
							$result['upload_url'] = $url;
							$result['upload_url_from_base'] = $base_location . $url;
						} else {
							$result['upload_error'] = "Fout [$resizerc] bij het verkleinen/copiëren van $filename.";
						}
					} else {
						$result['upload_error'] = "Fout bij het plaatsen van $filename naar $url.";
					}

				} else {
					/// Unacceptable file type
					$result['upload_error'] = "$filename van het type " . $file['type'] . " kan niet opgeladen worden. Toegelaten types: jpg and png.";
				}
				break;
			case 1:		/// An error occured
				$result['upload_error'] = "Fout bij het opladen van $filename -- Foto is te groot (php.ini).";
				break;
			case 2:		/// An error occured
				$result['upload_error'] = "Fout bij het opladen van $filename -- Foto is te groot.";
				break;
			case 3:		/// An error occured
				$result['upload_error'] = "Fout bij het opladen van $filename -- Foto gedeeltelijk opgeladen.";
				break;
			case 4:		/// No file was selected for upload
				$result['upload_error'] = "Er werd geen foto geselecteerd.";
				break;
			case 6:		/// Missing a temporary folder (introduced in PHP 4.3.10 and PHP 5.0.3)
				$result['upload_error'] = "Fout bij het opladen van $filename -- Een folder ontbreekt.";
				break;
			case 7:		/// Failed to write file to disk (introduced in PHP 5.1.0)
				$result['upload_error'] = "Fout bij het opladen van $filename -- Foto kon niet weggeschreven worden.";
				break;
			case 8:		/// File upload stopped by extension (introduced in PHP 5.2.0)
				$result['upload_error'] = "Fout bij het opladen van $filename -- Opladen werd onderbroken.";
				break;
			default:	/// Another error occured
				$result['upload_error'] = "Systeemfout bij het opladen van $filename -- Contacteer de webmaster.";
				break;
		}
		return $result;
	}

	private function resize_img($original_img, $new_img, $new_width = 640) {
		/// Get the image info from the image
		list($width, $height, $type) = getimagesize($original_img);
		if (($width > 640) or $height > 640) {
			/// Image is bigger than 640 pixels, so we resize
			/// Load the image
			switch ($type) {
				case IMAGETYPE_JPEG:
					$image = imagecreatefromjpeg($original_img);
					break;
				//case IMAGETYPE_GIF:
					//$image = imagecreatefromgif($original_img);
					//break;
				case IMAGETYPE_PNG:
					$image = imagecreatefrompng($original_img);
				default:
					//die("Error loading $photo - File type $type not supported");
					return 1;
			}
			/// Create a new, resized image
			$new_height = $height / ($width / $new_width);
			$new_image = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			/// Save the new image
			switch ($type) {
				case IMAGETYPE_JPEG:
					imagejpeg($new_image, $new_img, 100);
					break;
				//case IMAGETYPE_GIF:
					//imagegif($new_image, $new_img);
					//break;
				case IMAGETYPE_PNG:
					imagepng($new_image, $new_img);
					break;
				default:
					//die("Error saving image: $photo");
					return 2;
			}
		} else {
			/// Image is smaller than 640 pixels, so we don't resize, and just copy
			if (!copy($original_img, $new_img)) {
				//die "Error copying $original_img to $new_img\n";
				return 3;
			}
		}
		return 0;
	}


}
