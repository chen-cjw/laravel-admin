{{--17739739392--}}
<form action="/admin/consignment_sample/update_report_is_send" method="post" class="" >
    {{csrf_field()}}
    {{--这里就是想要提交的值--}}
    <input hidden name="report_id" value="{{ $report_id }}">
    <input hidden name="sample_id" value="{{ $id }}">
    <button type="submit" class="btn btn-primary btn-xs" >消息提醒</button>
</form>
