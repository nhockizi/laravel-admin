<textarea id="{{$nameFile}}" class="form-control">{{file_get_contents($file)}}</textarea>
<script data-exec-on-popstate>
CodeMirror.fromTextArea(document.getElementById("{{$nameFile}}"), {
    lineNumbers: true,
    scrollbarStyle:"overlay",
    mode: "text/x-php",
    extraKeys: {
        "Tab": function(cm){
            cm.replaceSelection("   " , "end");
        },
        "F11": function(cm) {
          cm.setOption("fullScreen", !cm.getOption("fullScreen"));
        },
        "Esc": function(cm) {
          if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
        },
        "Ctrl-Space": "autocomplete",
     },
      commandsOptions: {
                        edit: {
                          mimes: [],
                          editors: [{
                            mimes: ['text/plain', 'text/x-php', 'application/x-httpd-php', 'text/html', 'text/javascript'],
                            load: function(textarea) {
                              var mimeType = this.file.mime;
                              return CodeMirror.fromTextArea(textarea, {
                                mode: mimeType,
                                lineNumbers: true,
                                indentUnit: 4
                              });
                            },
                            save: function(textarea, editor) {
                              $(textarea).val(editor.getValue());
                            }
                          }]
                        }
                      }
});
</script>
