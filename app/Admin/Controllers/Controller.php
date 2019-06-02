<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Model\Symbol;
use Encore\Admin\Layout\Content;

class Controller extends BaseController
{
    public function symbol($symbol,$amount)
    {
        switch ($symbol) {
            case "BTC":
                return $this->realBtc($symbol,$amount);
            case "ETH":
                return $this->realEth($symbol,$amount);
            case "USD":
                return $this->realUsd($symbol,$amount);
            default:
                return '未知币种';
        }

    }

    public function time($grid)
    {
        $grid->created_at('创建时间')->display(function ($created_at) {
            return date('Y-m-d H:i:s',$created_at);
        })->sortable();
        $grid->updated_at('编辑时间')->display(function ($created_at) {
            return date('Y-m-d H:i:s',$created_at);
        })->sortable();
    }
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header($this->header)
            ->description('管理')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id,Content $content)
    {
        return $content
            ->header($this->header)
            ->description('详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id,Content $content)
    {
        return $content
            ->header($this->header)
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header($this->header)
            ->description('创建')
            ->body($this->form());
    }

    public function moreZero($amount)
    {
        return rtrim(rtrim($amount, '0'), '.');

    }

    public function realUsd($amount)
    {
        return $this->moreZero(bcdiv($amount, Symbol::USD_RATE, 4));
    }

    public function realBtc($amount)
    {
        return $this->moreZero(bcdiv($amount, Symbol::BTC_RATE, 9));

    }

    public function realEth($amount)
    {
        return $this->moreZero(bcdiv($amount, Symbol::ETH_RATE, 18));
    }
    public function realTP($amount)
    {
        return $this->moreZero(bcdiv($amount, Symbol::TP_RATE, 18));
    }
}
