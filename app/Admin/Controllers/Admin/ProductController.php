<?php

namespace App\Admin\Controllers\Admin;

use App\Models\Products;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductController extends Controller
{
    use HasResourceActions;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Products);

        $grid->id('Id');
        $grid->title('Title');
        $grid->description('Description');
        $grid->image('Image');
        $grid->on_sale('On sale');
        $grid->sold_count('Sold count');
        $grid->price('Price');
        $grid->stock('Stock');
        $grid->sort('Sort');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(Products::findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->description('Description');
        $show->image('Image');
        $show->on_sale('On sale');
        $show->sold_count('Sold count');
        $show->price('Price');
        $show->stock('Stock');
        $show->sort('Sort');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Products);

        $form->text('title', 'Title');
        $form->textarea('description', 'Description');
        $form->image('image', 'Image');
        $form->switch('on_sale', 'On sale')->default(1);
        $form->number('sold_count', 'Sold count');
        $form->decimal('price', 'Price');
        $form->text('stock', 'Stock');
        $form->text('sort', 'Sort');

        return $form;
    }
}
