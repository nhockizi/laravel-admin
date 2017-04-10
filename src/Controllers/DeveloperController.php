<?php

namespace Kizi\Admin\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kizi\Admin\Facades\Admin;
use Kizi\Admin\Layout\Content;
use Kizi\Admin\Layout\Row;
use Kizi\Admin\Widgets\Form;

class DeveloperController extends Controller
{
    public function index()
    {
        return view('admin::developer.index');
        return Admin::content(function (Content $content) {
            $content->header('Editors');

            $content->body(function ($row) {
                $row->column(3, view('admin::developer.index'));
                $row->column(9, function ($column) {
                    $form = new Form();
                    $form->editor('content1', 'sss2');
                    $form->php('text3', 'PHP')->default(file_get_contents(public_path('index.php')));

                    $column->append($form);
                });
            });
        });
        return Admin::content(function (Content $content) {
            $content->header('Developer');
            $content->row(view('admin::developer.index'));
        });
    }
    public function loadContentFile(Request $request)
    {
        $dirApp = app()->basePath();
        $file   = explode('\\', $dirApp);
        array_pop($file);
        $file = implode('\\', $file);
        $file .= DIRECTORY_SEPARATOR . $request->id;
        if (File::isDirectory($file)) {
            return array('type' => 'folder', 'content' => $request->id);
        } else {
            $nameFile = explode('\\', $request->id);
            $nameFile = implode('-', $nameFile);
            $nameFile = explode('.', $nameFile);
            $nameFile = implode('-', $nameFile);

            $html = view('admin::developer.codemirror', compact('nameFile', 'file'))->render();
            $ext  = strpos($request->id, '.') !== false ? substr($request->id, strrpos($request->id, '.') + 1) : '';
            $name = explode('\\', $nameFile);
            $name = array_pop($name);
            return array('type' => $ext, 'name' => $name, 'id' => $nameFile, 'content' => $html);
        }
    }
}
