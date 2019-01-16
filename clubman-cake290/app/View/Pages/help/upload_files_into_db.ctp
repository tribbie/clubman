<pre>

!!!!DOES NOT WORK!!!!


TABLE (mysql)
=============

CREATE TABLE vcw_files (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  type VARCHAR(255) NOT NULL,
  size INT(11) NOT NULL,
  data MEDIUMBLOB NOT NULL,
  created DATETIME,
  modified DATETIME,
  PRIMARY KEY (id)
);

data => BLOB (64KB) - MEDIUMBLOB (16MB) - LONGBLOB (4GB)

MODEL (app/models/file.php)
===========================

class File extends AppModel 
{
	var $name = 'File';
}

VIEW (app/views/files/add.ctp)
==============================

<form action="/files/add" enctype="multipart/form-data" method="post">
    <?php echo $html->file('File'); ?>
    <?php echo $html->submit('Upload'); ?>
</form>


CONTROLLER (app/controllers/files_controller.php)
=================================================

class FilesController extends AppController
{
//	store
    function add()
    {
        if (!empty($this->params['form']) &&
             is_uploaded_file($this->params[’form’][’File’][’tmp_name’]))
        {
            $fileData = fread(fopen($this->params['form']['File']['tmp_name'], "r"),
                                     $this->params['form']['File']['size']);
            $this->params['form']['File']['data'] = $fileData;

            $this->File->save($this->params['form']['File']);

            $this->redirect('somecontroller/someaction');
        }
    }
}

//	retrieve
function download($id)
{
    $file = $this->File->findById($id);

    header('Content-type: ' . $file['File']['type']);
    header('Content-length: ' . $file['File']['size']);
    header('Content-Disposition: attachment; filename='.$file['File']['name']);
    echo $file['File']['data'];

    exit();
}
Well, I know that this action is probably not very cake-like, the proper way would be to use a layout and a view, but this way I have less to write ;-)

So, that’s it. We have finished our very simple upload/download application.

Update (2006-08-05): Fixed a security hole in the code above, see also “Be careful with file uploads”. Thanks to Lamby.

</pre>
