<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Summernote</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
</head>
<body>





  <div id="container">



    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-3">
        <div>
          <h2>Hello Summernote</h2>
          <p>
            Editor: Summernote
            <br/>
            GitHub: https://github.com/summernote/summernote
            <br/>
            Home page: https://summernote.org
            <br/>
            Found it here: https://medium.com/maatwebsite/lets-see-wyg-with-these-editors-e5720e91a626
          </p>
        </div>
      </div>
      <div class="col-md-7">
        <div class='text-center'>
          <h1>VC Wolvertem</h1>
        </div>
        <div>

          <form method="post">
            <textarea id="summernote" name="editordata"></textarea>
          </form>

        </div>
    	</div>
      <div class="col-md-1">
      </div>
    </div><!--row-->
  </div>

  <script>
    $(document).ready(function() {
        $('#summernote').summernote({
          placeholder: 'Je artikel hier...',
          spellCheck: false,
          toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview', 'help']],
          ],
          popover: {
            image: [
              ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
              ['float', ['floatLeft', 'floatRight', 'floatNone']],
              ['remove', ['removeMedia']]
            ],
            link: [
              ['link', ['linkDialogShow', 'unlink']]
            ],
            table: [
              ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
              ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
            ],
            air: [
              ['color', ['color']],
              ['font', ['bold', 'underline', 'clear']],
              ['para', ['ul', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link', 'picture']]
            ]
          }
        });
    });
  </script>
</body>
</html>
