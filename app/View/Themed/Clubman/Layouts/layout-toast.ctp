
<!DOCTYPE html>
<html>
  <head lang="en">
    <meta charset="UTF-8" />
    <title>Editor With WYSIWYG Mode</title>
    <!--<link rel="stylesheet" href="./css/tuidoc-example-style.css" />-->
    <!-- Editor's Dependecy Style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.css"/>
    <!-- Editor's Style -->
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
    <script>var errorLogs=[];window.onerror=function(o,r,e,n){errorLogs.push({message:o,source:r,lineno:e,colno:n})};</script>
  </head>
  <body>
    <div class="tui-doc-description">
      <strong>
        The example code can be slower than your environment because the code is transpiled by babel-standalone in runtime.
      </strong>
    </div>
    <div class="code-html tui-doc-contents">
      <div id="editor"></div>
    </div>
    <!-- Added to check demo page in Internet Explorer -->
    <script src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>
    <script src="https://uicdn.toast.com/editor/latest/data/md-default.js"></script>
    <!-- Editor -->
    <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
    <script type="text/babel" class="code-js">
      const editor = new toastui.Editor({
        el: document.querySelector('#editor'),
        height: '500px',
        initialValue: content,
        initialEditType: 'wysiwyg'
      });
    </script>
  </body>
</html>
