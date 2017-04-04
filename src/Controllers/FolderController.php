<?php

namespace Kizi\Admin\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kizi\Admin\Support\JsTree;

class FolderController extends Controller
{
    public function data(Request $request)
    {
        $id = 'app';
        if ($request->has('id') and $request->id != '#') {
            $id = $request->id;
        }
        if (isset($request->operation)) {
            switch ($request->operation) {
                case 'get_node':
                    return 'get_node';
                    break;
                case "get_content":
                    return 'get_content';
                    break;
                case 'create_node':
                    if ($request->type === 'file') {
                        File::put(app()->basePath() . '/' . $id . '/' . $request->text, '');
                    } else {
                        File::makeDirectory(app()->basePath() . '/' . $id . '/' . $request->text, 0775, true, true);
                    }
                    return array('id' => $id . '/' . $request->text);
                case 'rename_node':
                    $old = $id;
                    if (preg_replace('~/~', '\\', $old)) {
                        $old = preg_replace('~/~', '\\', $old);
                    }
                    $new = explode('\\', $old);
                    array_pop($new);
                    array_push($new, $request->text);
                    $new = implode('/', $new);
                    rename(app()->basePath() . '/' . $old, app()->basePath() . '/' . $new);
                    return array('id' => $new);
                case 'delete_node':
                    if (File::isDirectory(app()->basePath() . '/' . $id)) {
                        File::deleteDirectory(app()->basePath() . '/' . $id);
                    } else {
                        File::delete(app()->basePath() . '/' . $id);
                    }
                    return array('status' => 'OK');
                case 'move_node':
                    $new  = explode('/', $id);
                    $name = array_pop($new);
                    if (File::isDirectory(app()->basePath() . '/' . $id)) {
                        File::moveDirectory(app()->basePath() . '/' . $id, app()->basePath() . '/' . $request->parent . '/' . $name);
                    } else {
                        File::move(app()->basePath() . '/' . $id, app()->basePath() . '/' . $request->parent . '/' . $name);
                    }

                    return array('id' => $request->parent . '/' . $name);
                case 'copy_node':
                    $old = $id;
                    $par = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
                    $dir = app()->basePath() . '/' . $id;
                    $par = app()->basePath() . '/' . $par;
                    if (preg_replace('~/~', '\\', $old)) {
                        $old = preg_replace('~/~', '\\', $old);
                    }
                    $new  = explode('\\', $old);
                    $name = array_pop($new);
                    if (File::isDirectory(app()->basePath() . '/' . $id)) {
                        File::copyDirectory(app()->basePath() . '/' . $id, app()->basePath() . '/' . $request->parent . '/' . $name);
                    } else {
                        File::copy(app()->basePath() . '/' . $id, app()->basePath() . '/' . $request->parent . '/' . $name);
                    }
                    return array('id' => $request->parent . '/' . $name);
                    break;
                default:
                    throw new Exception('Unsupported operation: ' . $_GET['operation']);
                    break;
            }
        }
        $nodes = array_merge(
            File::directories(app()->basePath() . '/' . $id),
            File::files(app()->basePath() . '/' . $id)
        );
        $nodes = str_replace(app()->basePath() . '/', '', $nodes);
        $tree  = new JsTree($nodes, 'app');

        $tree->setExcludedExtensions(['DS_Store', 'gitignore']);
        // $tree->setExcludedPaths(['Laravel-wallpapers/.git']);
        $tree->setDisabledExtensions(['md', 'png', '.git']);

        return response()->json($tree->build());
    }
}
