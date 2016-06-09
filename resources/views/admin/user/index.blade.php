@extends('admin.layout')

@section('title', 'Users')

@section('content_css')
    <link href="/{{ Config::get('path.css') }}/fresh-bootstrap-table.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">

        <div class="fresh-table" style="padding:25px">

            <div class="toolbar" style="padding-bottom: 25px;">
                <a class="btn btn-primary btn-fill" href="{{ action('Admin\UserController@create') }}">
                    <span class="glyphicon glyphicon-plus"></span>
                    <span class="hidden-xs"> New User</span>
                </a>
            </div>

            <table id="fresh-table" class="table">
                <thead>
                    <th data-field="number" data-sortable="true">#</th>
                    <th data-field="email" data-sortable="true">Email</th>
                    <th id="user-action" data-classes="user-action" data-field="actions" data-cell-style="width: 50%">Actions</th>
                </thead>
                <tbody>
                @foreach($users as $key => $user)

                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <span>{{ $user->email }}</span>
                            <form id="user-{{ $user->id }}" action="{{ action('Admin\UserController@update', ['user' => $user->id]) }}" method="post" style="display: none;">
                                <input class="form-control" type="email" name="email" value="{{ $user->email }}">
                                {!! csrf_field() !!}
                            </form>
                        </td>
                        <td>
                            <div data-target="user-{{ $user->id }}" class="edit-tools" style="display:none">
                                <button type="button" class="btn btn-primary btn-fill save"><span class="glyphicon glyphicon-floppy-disk"></span><span class="hidden-xs"> Save</span></button>
                                <button type="button" class="btn btn-danger btn-fill cancel"><span class="glyphicon glyphicon-remove"></span><span class="hidden-xs"> Cancel</span></button>
                            </div>
                            <div class="action" data-target="user-{{ $user->id }}">
                                <button type="button" class="btn btn-primary btn-fill edit action"><span class="glyphicon glyphicon-edit"></span><span class="hidden-xs"> Edit Email</span></button>
                                <a href="{{ action('Admin\UserController@getPassword', ['user' => $user->id]) }}" class="btn btn-primary btn-fill action"><span class="glyphicon glyphicon-lock"></span><span class="hidden-xs"> Change Password</span></a>

                                @if($user->id != Auth::user()->id)
                                    <a href="{{ action('Admin\UserController@destroy', ['user' => $user->id]) }}" class="btn btn-danger btn-fill delete action"><span class="glyphicon glyphicon-floppy-remove"></span><span class="hidden-xs action">  Delete</span></a>
                                @endif
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('content_js')
    <script type="text/javascript">
        $(function(){
            $('th[data-field=actions]').css('width', '50%');

            $('.delete').on('click', function(e){
                if(confirm("Are you sure want to delete this?") == false){
                    return false;
                }
            });

            $('.action .edit').on('click', function(){
                $('#'+$(this).parent().data('target')).prev().hide();
                $('#'+$(this).parent().data('target')).show();
                $(this).parent().hide();
                $(this).parent().prev().show();
            });

            $('.save').on('click', function(){
                $('form#'+$(this).parent().data('target')).submit();
            });
            $('.edit-tools .cancel').on('click', function(){
                $('#'+$(this).parent().data('target')).prev().show();
                $('#'+$(this).parent().data('target')).hide();
                $(this).parent().hide();
                $(this).parent().next().show();
            });
        });

    </script>

    @if(session('success') != null)
        <script src="/{{ Config::get('path.js') }}/bootstrap-notify.js"></script>

        <script>
            $.notify({
                icon: 'glyphicon glyphicon-ok',
                message: '\n{{ session('success') }}\n'

            },{
                type: 'success',
                timer: 4000
            });
            $(function(){
                $('th[data-field=actions]').css('width', '50%');
            })
        </script>
    @endif
@endsection