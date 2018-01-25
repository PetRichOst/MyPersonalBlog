@extends('admin.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Blank page
                <small>it all starts here</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Листинг сущности</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{route('users.create')}}" class="btn btn-success">Добавить</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Имя</th>
                            <th>E-mail</th>
                            <th class="text-center">Аватар</th>
                            <th class="text-center">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                       @foreach($users as $user)
                            <tr>
                                <td class="text-center">{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    <img src="{{$user->getAvatar()}}" alt="" class="img-responsive img-circle" width="100" height="100">
                                </td>
                                <td class="text-center">
                                    <a href="{{route('users.edit', $user->id)}}" class="fa fa-pencil"></a>
                                    {{Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete'])}}
                                    <button type="submit" class="delete">
                                        <a href="" class="fa fa-remove"></a>
                                    </button>
                                    {{Form::close()}}
                                </td>
                            </tr>
                        @endforeach
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection