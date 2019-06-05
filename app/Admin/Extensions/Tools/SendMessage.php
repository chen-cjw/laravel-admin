<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class SendMessage extends BatchAction
{
    protected $action;

    public function script()
    {
        return <<<EOT

$('{$this->getElementClass()}').on('click', function() {

    $.ajax({
        method: 'post',
        url: '{$this->resource}/update_report_is_send_all',
        data: {
            _token:LA.token,
            ids: selectedRows(),
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('消息通知操作成功');
        }
    });
});

EOT;

    }
}