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
        '/packages/admin/codemirror/mode/javascript/javascript.js',
        '/packages/admin/codemirror/mode/css/css.js',
        '/packages/admin/codemirror/mode/clike/clike.js',
        '/packages/admin/codemirror/mode/php/php.js',
    ];

    protected static $css = [
        '/packages/codemirror/lib/codemirror.css',
    ];

    public function render()
    {
        $this->script = <<<EOT

CodeMirror.fromTextArea(document.getElementById("{$this->id}"), {
    lineNumbers: true,
    mode: "text/x-php",
    extraKeys: {
        "Tab": function(cm){
            cm.replaceSelection("    " , "end");
        }
     }
});

EOT;
        return parent::render();
    }
}
