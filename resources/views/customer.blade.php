<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(!empty(session('message')))
                    　　<div class="alert alert-success" role="alert">
                        　　　　{{session('message')}}
                        　　</div>
                @endif
                <!-- /.box-header -->
                <!-- form start -->
                {{--customer_name ,tel,car_no,openid--}}
                <form role="form" action="/admin/customer/add_customer" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">送检的客户名称</label>
                            <input required type="text" name="customer_name" class="form-control" id="exampleInputEmail1" placeholder="送检的客户名称">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">车次号</label>
                            <input required type="text" name="car_no" class="form-control" id="exampleInputEmail1" placeholder="车次号">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">客户openid</label>
                            <input required type="text" name="openid" class="form-control" id="exampleInputEmail1" placeholder="客户openid">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">联系电话</label>
                            <input required type="text" name="tel" class="form-control" id="exampleInputEmail1" placeholder="联系电话">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
    </div>
    <!-- /.row -->
</section>