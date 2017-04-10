<script src="{{ asset ("/packages/admin/codemirror/lib/codemirror.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/edit/matchbrackets.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/htmlmixed/htmlmixed.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/xml/xml.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/markdown/markdown.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/javascript/javascript.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/css/css.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/clike/clike.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/php/php.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/hint/show-hint.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/hint/css-hint.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/hint/html-hint.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/hint/javascript-hint.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/mode/clike/clike.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/display/fullscreen.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/keymap/sublime.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/search/search.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/search/searchcursor.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/search/jump-to-line.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/dialog/dialog.js") }}"></script>
<script src="{{ asset ("/packages/admin/codemirror/addon/scroll/simplescrollbars.js") }}"></script>
<link rel="stylesheet" href="{{ asset("/packages/admin/codemirror/lib/codemirror.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/codemirror/addon/hint/show-hint.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/codemirror/addon/display/fullscreen.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/codemirror/addon/dialog/dialog.css") }}">
<link rel="stylesheet" href="{{ asset("/packages/admin/codemirror/addon/scroll/simplescrollbars.css") }}">
<textarea id="{{$nameFile}}" class="form-control">{{file_get_contents($file)}}</textarea>
<script data-exec-on-popstate>
	// The bindings defined specifically in the Sublime Text mode
var bindings = {
    "Ctrl-X Cmd-X":"cut",
    "Ctrl-S Cmd-S":"save",
    "Ctrl-C Cmd-C":"copy",
    "Ctrl-V Cmd-V":"paste",
    "Ctrl-F Cmd-F":"Start searching",
    "Ctrl-G Cmd-G":"Find next",
    "Shift-Ctrl-G Shift-Cmd-G":"Find previous",
    "Shift-Ctrl-F Shift-Cmd-F":"Replace",
    "Shift-Ctrl-R Shift-Cmd-R":"Replace all",
    "Alt-F":"Persistent search",
    "Alt-G":"Jump to line",
}

// The implementation of joinLines
function joinLines(cm) {
  var ranges = cm.listSelections(), joined = [];
  for (var i = 0; i < ranges.length; i++) {
    var range = ranges[i], from = range.from();
    var start = from.line, end = range.to().line;
    while (i < ranges.length - 1 && ranges[i + 1].from().line == end)
      end = ranges[++i].to().line;
    joined.push({start: start, end: end, anchor: !range.empty() && from});
  }
  cm.operation(function() {
    var offset = 0, ranges = [];
    for (var i = 0; i < joined.length; i++) {
      var obj = joined[i];
      var anchor = obj.anchor && Pos(obj.anchor.line - offset, obj.anchor.ch), head;
      for (var line = obj.start; line <= obj.end; line++) {
        var actual = line - offset;
        if (line == obj.end) head = Pos(actual, cm.getLine(actual).length + 1);
        if (actual < cm.lastLine()) {
          cm.replaceRange(" ", Pos(actual), Pos(actual + 1, /^\s*/.exec(cm.getLine(actual + 1))[0].length));
          ++offset;
        }
      }
      ranges.push({anchor: anchor || head, head: head});
    }
    cm.setSelections(ranges, 0);
  });
}
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
