{{--17739739392--}}
<form action="/admin/consignment_report/download" method="post" class="" >
    {{csrf_field()}}
    {{--这里就是想要提交的值--}}
    <input hidden name="report_id" value="{{ $report_id }}">
    <button type="submit" class="btn btn-primary btn-xs" >报告下载</button>
</form>
