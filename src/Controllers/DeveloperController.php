<?php

namespace Kizi\Admin\Controllers;

use Illuminate\Routing\Controller;
use Kizi\Admin\Facades\Admin;
use Kizi\Admin\Layout\Content;
use Kizi\Admin\Layout\Row;
use Kizi\Admin\Widgets\Form;

class DeveloperController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('Editors');

            $content->body(function ($row) {
                // $row->column(3, view('admin::developer.index'));
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
}
