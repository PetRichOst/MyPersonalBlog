@extends('admin.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Добавить пользователя
                <small>приятные слова..</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Добавляем пользователя</h3>
                    @include('admin.error')
                </div>
                {!! Form::open(['route' => 'users.store', 'files' => true]) !!}
                <div class="box-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Имя</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="name" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">E-mail</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="email" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Пароль</label>
                            <input type="password" class="form-control" id="exampleInputEmail1" placeholder="" name="password">
                        </div>
                        <div class="form-group">
                            <label for="subscribeNews">Админ </label>
                            <input type="checkbox" placeholder="" name="is_admin" value="{{old('is_admin')}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Забанен</label>
                            <input type="checkbox" placeholder="" name="status">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Аватар</label>
                            <input type="file" id="exampleInputFile" accept=".jpg, .jpeg, .png" name="avatar">

                            <p class="help-block">Поддерживаемие форматы: jpg, jpeg, png</p>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Описание</label>
                                <textarea id="" cols="30" rows="10" class="form-control" name="description">{{old('description')}}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{route('users.index')}}" class="btn btn-default">Назад</a>
                    <button class="btn btn-success pull-right">Добавить</button>
                </div>
                <!-- /.box-footer-->
                {!! Form::close() !!}
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection