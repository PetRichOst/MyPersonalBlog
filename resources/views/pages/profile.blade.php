@extends('layout')
@section('content')
    <!--main content start-->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="leave-comment mr0"><!--leave comment-->

                        <h3 class="text-uppercase">Мой профиль</h3>
                        @include('admin.error')
                        <br>
                        <img class="img-responsive img-circle" src="{{Auth::user()->getAvatar()}}" alt="" >
                        {!! Form::open(['route' => ['profile.update','user_id' => Auth::user()->id], 'method' => 'put', 'files' => true]) !!}
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Name" value="{{Auth::user()->name}}">
                                    <br/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="Email" value="{{Auth::user()->email}}">
                                    <br/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="password" name="password"
                                           placeholder="password">
                                    <br/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="file" class="form-control" id="avatar" name="avatar">
                                    <br/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <br/>
                                    <button type="submit" name="submit" class="btn send-btn">Обновить</button>
                                </div>
                            </div>

                        {!! Form::close() !!}
                    </div><!--end leave comment-->
                </div>
                @include('pages._sidebar')
            </div>
        </div>
    </div>
    <!-- end main content-->
@endsection