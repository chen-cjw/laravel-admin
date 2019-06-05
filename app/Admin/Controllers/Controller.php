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


    public function getDate($time, $is_convert_num = true)
    {
        $year = date('Y', $time);
        $month = date('m', $time);
        $day = date('d', $time);
        $yearString = '';
        if ($is_convert_num) {

            for ($i = 0; $i < strlen($year); $i++) {
                $yearString .= $this->getNumber($year[$i]);
            }

            $month = $this->getNumber($month);
            $day = $this->getNumber($day);
        } else {
            $yearString = $year;
        }

        return $yearString . '年' . $month . '月' . $day . '日';
    }

    protected function getNumber($number)
    {
        switch ($number) {
            case 0:
                return '〇';
            case 1:
                return '一';
            case 2:
                return '二';
            case 3:
                return '三';
            case 4:
                return '四';
            case 5:
                return '五';
            case 6:
                return '六';
            case 7:
                return '七';
            case 8:
                return '八';
            case 9:
                return '九';
            case 10:
                return '十';
            case 11:
                return '十一';
            case 12:
                return '十二';
            case 13:
                return '十三';
            case 14:
                return '十四';
            case 15:
                return '十五';
            case 16:
                return '十六';
            case 17:
                return '十七';
            case 18:
                return '十八';
            case 19:
                return '十九';
            case 20:
                return '二十';
            case 21:
                return '二十一';
            case 22:
                return '二十二';
            case 23:
                return '二十三';
            case 24:
                return '二十四';
            case 25:
                return '二十五';
            case 26:
                return '二十六';
            case 27:
                return '二十七';
            case 28:
                return '二十八';
            case 29:
                return '二十九';
            case 30:
                return '三十';
            case 31:
                return '三十一';
        }
    }

    /*
     * 过滤掉项目名中的【】 内容
     */
    public function filter_check_item_name($item_name)
    {
        $is_right = 0;
        $a = strpos($item_name, "[");
        $b = strpos($item_name, "]");

        if ($a >= 0 && $b > $a) {
            $is_right = 1;
        } else {
            $a = strpos($item_name, "【");
            $b = strpos($item_name, "】");
            if ($a >= 0 && $b > $a) {
                $is_right = 1;
            }
        }

        if ($is_right) {
            $length = $b - $a + 1;
            $str = substr($item_name, $a, $length);
            $item_name = str_replace($str, "", $item_name);
        }

        return $item_name;
    }

    /*
     *
     */
    public function filter_string($replace)
    {
        if ($replace && strlen($replace) > 0) {
            $replace = str_replace('&', '&amp;', $replace);
            $replace = str_replace('<', '&lt;', $replace);
            $replace = str_replace('>', '&gt;', $replace);
            $replace = str_replace('\'', '&quot;', $replace);
            $replace = str_replace('"', '&apos;', $replace);
        }
        return $replace;
    }
}
