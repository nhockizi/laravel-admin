<?php

namespace Kizi\Admin\Extensions;

use Kizi\Admin\Form\Field;

class PHPEditor extends Field
{
    protected $view = 'admin::form.editor';

    protected static $js = [
        '/packages/admin/codemirror/lib/codemirror.js',
        '/packages/admin/codemirror/addon/edit/matchbrackets.js',
        '/packages/admin/codemirror/mode/htmlmixed/htmlmixed.js',
        '/packages/admin/codemirror/mode/xml/xml.js',
        '/packages/admin/codemirror/mode/markdown/markdown.js',
        '/packages/admin/codemirror/mode/javascript/javascript.js',
        '/packages/admin/codemirror/mode/css/css.js',
        '/packages/admin/codemirror/mode/clike/clike.js',
        '/packages/admin/codemirror/mode/php/php.js',
        '/packages/admin/codemirror/addon/hint/show-hint.js',
        '/packages/admin/codemirror/addon/hint/css-hint.js',
        '/packages/admin/codemirror/addon/hint/html-hint.js',
        '/packages/admin/codemirror/addon/hint/javascript-hint.js',
        '/packages/admin/codemirror/mode/clike/clike.js',
        '/packages/admin/codemirror/addon/display/fullscreen.js',
    ];

    protected static $css = [
        '/packages/admin/codemirror/lib/codemirror.css',
        '/packages/admin/codemirror/addon/hint/show-hint.css',
        '/packages/admin/codemirror/addon/display/fullscreen.css',
    ];

    public function render()
    {
        $this->script = <<<EOT

CodeMirror.fromTextArea(document.getElementById("{$this->id}"), {
    lineNumbers: true,
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

EOT;
        return parent::render();
    }
}
