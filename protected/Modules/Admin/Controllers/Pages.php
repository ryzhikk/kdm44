<?php
/**
 * Created by PhpStorm.
 * User: Степанцев Альберт
 * Date: 23.06.14
 * Time: 11:53
 */

namespace App\Modules\Admin\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

class Pages
    extends Controller
{

    protected  $access = [
        'Default' => ['role.name'=>'admin'],
        'Edit' => ['role.name'=>'admin'],
        'Save' => ['role.name'=>'admin'],
        'Delete' => ['role.name'=>'admin'],
    ];


    public function actionDefault()
    {
        $this->data->items = Page::findAllTree();
    }

    public function actionEdit($id=null, $parent=null)
    {
        $this->app->extensions->ckeditor->init();
        $this->app->extensions->ckfinder->init();

        if (null === $id || 'new' == $id) {
            $this->data->item = new Page();
            if (null !== $parent) {
                $this->data->item->parent = $parent;
            }
        } else {
            $this->data->item = Page::findByPK($id);
        }
    }

    public function actionSave()
    {
        if (!empty($_POST[Page::PK])) {
            $item = Page::findByPK($_POST[Page::PK]);
        } else {
            $item = new Page();
        }
        $item
            ->fill($_POST)
            ->save();
        $this->redirect('/admin/pages/');
    }

    public function actionDelete($id)
    {
        $item = Page::findByPK($id);
        if ($item)
            $item->delete();
        $this->redirect('/admin/pages/');
    }

}