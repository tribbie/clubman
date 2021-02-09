<?php
class PicturesController extends AppController {

	//var $scaffold;

	var $categories = array('memberid' => 'vergunningen', 'member' => 'leden', 'team' => 'teams');

	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('category');
		//$this->Auth->deny('index');
	}


	public function index() {
		$this->Picture->recursive = -1;
		$this->set('pictures', $this->Picture->find('all', array('fields' => array('id', 'location', 'type', 'size', 'uploader'))));
	}


	public function category($category = null) {
		$this->Picture->recursive = -1;
		$pictures = $this->Picture->find('all', array('conditions' => array('Picture.category' => $category), 'fields' => array('id', 'location', 'type', 'size', 'uploader')));
		$this->set('categorycode', $category);
		$this->set('category', $this->categories[$category]);
		$this->set('pictures', $pictures);
	}


	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid picture', true), 'flash-error');
			$this->redirect(array('action' => 'index'));
		}
		$this->Picture->id = $id;
		$picture = $this->Picture->read();
		$this->set('category', $this->categories[$picture['Picture']['category']]);
		$this->set('picture', $picture);
	}


	public function add($category = null) {
		if ($this->request->is('post')) {
			$formdata = $this->request->data;
			if ((isset($formdata['Picture']['Files'])) and (is_array($formdata['Picture']['Files']))) {
				if (isset($formdata['Picture']['category'])) {
					/// Upload (move uploaded files) to the correct position and return array with urls (and/or errors)
					$uploads = $this->uploadFiles($formdata['Picture']['category'], $formdata['Picture']['Files']);
					/// Process the successfully uploaded files
					for ($i = 0; $i < count($uploads); ++$i) {
						$onefile = $formdata['Picture']['Files'][$i];
						$oneresult = $uploads[$i];
						/// If earlier on, the uploaded file was successfully moved to the url location, we add a record for the table
						if ($oneresult['upload_url'] <> '') {
							$newrecords[] = array(
										'season'         => $formdata['Picture']['season'],
										'name'           => $formdata['Picture']['name'],
										'category'       => $formdata['Picture']['category'],
										'description'    => $formdata['Picture']['description'],
										'remark'         => $formdata['Picture']['remark'],
										'location'       => $oneresult['upload_url'],
										'type'           => $onefile['type'],
										'size'           => $onefile['size'],
										'uploader'       => $this->Auth->user('username')
									);
						} else {
							$badrecords[] = $oneresult['upload_error'];
						}
					}
				}
				/// Validate and save the records for the pictures that were valid
				if (isset($newrecords)) {
					$saveresults    = $this->Picture->saveAll($newrecords, array('validate' => 'first', 'atomic' => false));
					$selectioncount = count($formdata['Picture']['Files']);
					$uploadcount    = count($newrecords);
					$savedcount = 0;
					for ($j = 0; $j < count($saveresults); ++$j) {
						if ($saveresults[$j]) {
							$savedcount++;
							//$badrecords[] = $newrecords[$j]['location'] . " kon WEL bewaard worden in de databank";
						} else {
							$badrecords[] = $newrecords[$j]['location'] . " kon niet bewaard worden in de databank";
						}
					}
					if (isset($badrecords)) {
						$flashdetails = '<br/><font size="-1">' . implode('<br/>', $badrecords) . '</font>';
					} else {
						$flashdetails = '';
					}
					$this->Session->setFlash("$savedcount van de $selectioncount foto's werden bewaard." . $flashdetails, 'flash-info');
					parent::logAction(__FUNCTION__, 'picture', $this->Picture->id);
					$this->redirect(array('action' => 'index'));
					$this->set('saveresults', $saveresults);
					$this->set('newrecords', $newrecords);
				} else {
					$flashdetails = implode('<br/>', $badrecords);
					$this->Session->setFlash("Er werden geen geldige foto's geselecteerd." . '<br/><font size="-1">' . $flashdetails . '</font>', 'flash-error');
					//$this->redirect(array('action' => 'index'));
				}
				$this->set('uploads', $uploads);
			} else {
				$this->Session->setFlash('Er zijn geen foto\'s opgeladen.<br/><font size="-1">De totale grootte is groter dan toegelaten. Er werden te veel of te grote foto\'s geselecteerd.</font>', 'flash-error');
			}
		} else {
			if ($category) {
				$this->request->data['Picture']['category'] = $category;
				$this->set('addcategory', true);
			} else {
				$this->set('addcategory', false);
			}
		}
		$this->set('categories', $this->categories);
	}


	public function edit($id = null) {
		$this->Picture->id = $id;
		$picture = $this->Picture->read(null, $id);
		if (!$this->Picture->exists()) {
			throw new NotFoundException(__('Foto bestaat niet.'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Picture->save($this->request->data)) {
				$this->Session->setFlash(__('De foto werd bewaard.'), 'flash-info');
				parent::logAction(__FUNCTION__, 'picture', $this->Picture->id);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('De foto kon niet worden bewaard.'), 'flash-error');
			}
		} else {
			$this->request->data = $picture;
		}
		$this->set('picture', $picture);
		$this->set('categories', $this->categories);
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
	private function uploadFiles($location, $filedata, $subdir = null) {
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
		$img_dir = WWW_ROOT . 'img/' . $location;
		$rel_url = $location;
		if (!is_dir($img_dir)) mkdir($img_dir);
		if (($subdir) && (trim($subdir) !== '')) {
			$img_dir .= '/' . $subdir;
			$rel_url .= '/' . $subdir;
			if (!is_dir($img_dir)) mkdir($img_dir);
		}
		/// Create an "original" directory to store the original (non-resized) images
		$img_dir_original = $img_dir . '/original';
		$rel_url_original = $rel_url . '/original';
		if (!is_dir($img_dir_original)) mkdir($img_dir_original);
		/// Loop through and deal with the files
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
				case 0:		/// If file type and upload ok, then move the file
					if ($typeOK) {
						$newfilename = str_replace(array(" ", ":", "!", "(", ")", ",", ";", "=", "+", "<", ">"), '_', $filename);
						if (file_exists($img_dir . '/' . $newfilename)) $newfilename = date('Ymd-His') . '_' . $newfilename;
						$url          = $rel_url . '/' . $newfilename;
						$url_original = $rel_url . '/original/' . $newfilename;
						$success = move_uploaded_file($file['tmp_name'], 'img/' . $url_original);
						if ($success) {
							$resizerc = $this->resize_img('img/' . $url_original, 'img/' . $url);
							if ($resizerc == 0) {
								$result[$i]['upload_url'] = $url;
							} else {
								$result[$i]['upload_error'] = "Fout [$resizerc] bij het verkleinen/copiëren van $filename.";
							}
						} else {
							$result[$i]['upload_error'] = "Fout bij het plaatsen van $filename naar $url.";
						}

					} else {
						/// Unacceptable file type
						$result[$i]['upload_error'] = "$filename van het type " . $file['type'] . " kan niet opgeladen worden. Toegelaten types: jpg and png.";
					}
					break;
				case 1:		/// An error occured
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Foto is te groot (php.ini).";
					break;
				case 2:		/// An error occured
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Foto is te groot.";
					break;
				case 3:		/// An error occured
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Foto gedeeltelijk opgeladen.";
					break;
				case 4:		/// No file was selected for upload
					$result[$i]['upload_error'] = "Er werd geen foto geselecteerd.";
					break;
				case 6:		/// Missing a temporary folder (introduced in PHP 4.3.10 and PHP 5.0.3)
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Een folder ontbreekt.";
					break;
				case 7:		/// Failed to write file to disk (introduced in PHP 5.1.0)
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Foto kon niet weggeschreven worden.";
					break;
				case 8:		/// File upload stopped by extension (introduced in PHP 5.2.0)
					$result[$i]['upload_error'] = "Fout bij het opladen van $filename -- Opladen werd onderbroken.";
					break;
				default:	/// Another error occured
					$result[$i]['upload_error'] = "Systeemfout bij het opladen van $filename -- Contacteer de webmaster.";
					break;
			}
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
