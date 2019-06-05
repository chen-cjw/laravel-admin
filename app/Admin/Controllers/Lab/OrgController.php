<?php

namespace App\Admin\Controllers\Lab;

use App\Admin\Controllers\Controller;
use App\Models\ConsignmentSample;
use App\Models\Org;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrgController extends Controller
{
    use HasResourceActions;

    public function __construct()
    {
        $this->header = '部门';
    }
    public function index(Content $content)
    {
        return $content
            ->header($this->header)
            ->description('管理')
            ->body(Org::tree(function ($tree) {
                $tree->branch(function ($branch) {
                    return "{$branch['id']} - {$branch['parent_name']} ";
                });
            }));
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Org);

        $grid->id('ID')->sortable();
        $grid->org_name('Org name');
        $grid->parent_id('Parent id');
        $grid->lab_id('Lab id');
        $grid->remark('Remark');
        $grid->parent_name('Parent name');
        $grid->create_time('创建时间')->display(function ($create_time) {
            return date('Y-m-d H:i',$create_time);
        })->sortable();
        $grid->update_time('编辑时间')->display(function ($create_time) {
            return date('Y-m-d H:i',$create_time);
        })->sortable();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Org::findOrFail($id));

        $show->id('Id');
        $show->org_name('Org name');
        $show->parent_id('Parent id');
        $show->lab_id('Lab id');
        $show->remark('Remark');
        $show->create_time('Create time');
        $show->update_time('Update time');
        $show->parent_name('Parent name');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Org);

        $form->text('org_name', 'Org name');
        $form->number('parent_id', 'Parent id');
        $form->number('lab_id', 'Lab id');
        $form->text('remark', 'Remark');
        $form->number('create_time', 'Create time');
        $form->number('update_time', 'Update time');
        $form->text('parent_name', 'Parent name');

        return $form;
    }
}
