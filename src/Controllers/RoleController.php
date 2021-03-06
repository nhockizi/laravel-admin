<?php

namespace Kizi\Admin\Controllers;

use Illuminate\Routing\Controller;
use Kizi\Admin\Auth\Database\Permission;
use Kizi\Admin\Auth\Database\Role;
use Kizi\Admin\Facades\Admin;
use Kizi\Admin\Form;
use Kizi\Admin\Grid;
use Kizi\Admin\Layout\Content;

class RoleController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header(trans('admin::lang.roles'));
            $content->description(trans('admin::lang.list'));
            $content->body($this->grid()->render());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header(trans('admin::lang.roles'));
            $content->description(trans('admin::lang.edit'));
            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header(trans('admin::lang.roles'));
            $content->description(trans('admin::lang.create'));
            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Role::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->slug(trans('admin::lang.slug'));
            $grid->name(trans('admin::lang.name'));

            $grid->created_at(trans('admin::lang.created_at'));
            $grid->updated_at(trans('admin::lang.updated_at'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->row->slug == 'administrator') {
                    $actions->disableDelete();
                }
            });

            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return Admin::form(Role::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('slug', trans('admin::lang.slug'))->rules('required');
            $form->text('name', trans('admin::lang.name'))->rules('required');
            $form->checkbox('permissions', trans('admin::lang.permissions'))->options(Permission::all()->pluck('name', 'id'));
            $latitude  = '10.823099';
            $longitude = '106.629664';
            $label     = 'google map';
            $form->map($latitude, $longitude, $label);
        });
    }
}
