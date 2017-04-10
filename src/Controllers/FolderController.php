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
        $dirApp   = app()->basePath();
        $arrayDir = explode('\\', $dirApp);
        $nameDir  = $id  = array_pop($arrayDir);
        if ($request->has('id') and $request->id != '#') {
            $id = $request->id;
        } else {
            $nodes = array_merge(
                File::directories($dirApp),
                File::files($dirApp)
            );
            if (preg_replace('~/~', '\\', $nodes)) {
                $nodes = preg_replace('~/~', '\\', $nodes);
            }
            $nodes = str_replace($dirApp, $nameDir, $nodes);
            $tree  = new JsTree($nodes, $nameDir);

            $tree->setExcludedExtensions(['DS_Store', 'gitignore']);
            $tree->setDisabledExtensions(['md', 'png', '.git']);

            return response()->json($tree->build());
        }

        if (isset($request->operation)) {
            $arrayDir = implode('/', $arrayDir);
            if (preg_replace('~/~', '\\', $arrayDir)) {
                $arrayDir = preg_replace('~/~', '\\', $arrayDir);
            }
            switch ($request->operation) {
                case 'create_node':
                    if ($request->type === 'file') {
                        File::put($arrayDir . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $request->text, '');
                    } else {
                        File::makeDirectory($arrayDir . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $request->text, 0775, true, true);
                    }
                    return array('id' => $id . DIRECTORY_SEPARATOR . $request->text);
                case 'rename_node':
                    $old = $id;
                    if (preg_replace('~/~', '\\', $old)) {
                        $old = preg_replace('~/~', '\\', $old);
                    }
                    $new = explode('\\', $old);
                    array_pop($new);
                    array_push($new, $request->text);
                    $new = implode(DIRECTORY_SEPARATOR, $new);
                    rename($arrayDir . DIRECTORY_SEPARATOR . $old, $arrayDir . DIRECTORY_SEPARATOR . $new);
                    return array('id' => $new);
                case 'delete_node':
                    if (File::isDirectory($arrayDir . DIRECTORY_SEPARATOR . $id)) {
                        File::deleteDirectory($arrayDir . DIRECTORY_SEPARATOR . $id);
                    } else {
                        File::delete($arrayDir . DIRECTORY_SEPARATOR . $id);
                    }
                    return array('status' => 'OK');
                case 'move_node':
                    $new  = explode(DIRECTORY_SEPARATOR, $id);
                    $name = array_pop($new);
                    if (File::isDirectory($arrayDir . DIRECTORY_SEPARATOR . $id)) {
                        File::moveDirectory($arrayDir . DIRECTORY_SEPARATOR . $id, $arrayDir . DIRECTORY_SEPARATOR . $request->parent . DIRECTORY_SEPARATOR . $name);
                    } else {
                        File::move($arrayDir . DIRECTORY_SEPARATOR . $id, $arrayDir . DIRECTORY_SEPARATOR . $request->parent . DIRECTORY_SEPARATOR . $name);
                    }

                    return array('id' => $request->parent . DIRECTORY_SEPARATOR . $name);
                case 'copy_node':
                    $old = $id;
                    $par = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : DIRECTORY_SEPARATOR;
                    $dir = $arrayDir . DIRECTORY_SEPARATOR . $id;
                    $par = $arrayDir . DIRECTORY_SEPARATOR . $par;
                    if (preg_replace('~/~', '\\', $old)) {
                        $old = preg_replace('~/~', '\\', $old);
                    }
                    $new  = explode('\\', $old);
                    $name = array_pop($new);
                    if (File::isDirectory($arrayDir . DIRECTORY_SEPARATOR . $id)) {
                        File::copyDirectory($arrayDir . DIRECTORY_SEPARATOR . $id, $arrayDir . DIRECTORY_SEPARATOR . $request->parent . DIRECTORY_SEPARATOR . $name);
                    } else {
                        File::copy($arrayDir . DIRECTORY_SEPARATOR . $id, $arrayDir . DIRECTORY_SEPARATOR . $request->parent . DIRECTORY_SEPARATOR . $name);
                    }
                    return array('id' => $request->parent . DIRECTORY_SEPARATOR . $name);
                    break;
                default:
                    throw new Exception('Unsupported operation: ' . $_GET['operation']);
                    break;
            }
        } else {
            array_push($arrayDir, $id);
            $arrayDir = implode('/', $arrayDir);
            if (preg_replace('~/~', '\\', $arrayDir)) {
                $arrayDir = preg_replace('~/~', '\\', $arrayDir);
            }
        }

        $nodes = array_merge(
            File::directories($arrayDir),
            File::files($arrayDir)
        );
        if (preg_replace('~/~', '\\', $nodes)) {
            $nodes = preg_replace('~/~', '\\', $nodes);
        }
        $nodes = str_replace($dirApp, $nameDir, $nodes);
        $tree  = new JsTree($nodes, $nameDir);

        $tree->setExcludedExtensions(['DS_Store', 'gitignore']);
        $tree->setDisabledExtensions(['md', 'png', '.git']);

        return response()->json($tree->build());
    }
}
