@extends('backend.layouts.master')

@section('title')
    @include('backend.pages.roles.partials.title')
@endsection

@section('admin-content')
    @include('backend.pages.roles.partials.header-breadcrumbs')
    <div class="container-fluid">
        @include('backend.layouts.partials.messages')
        <div class="create-page">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('put')
                
                <div class="form-body">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Role Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" placeholder="Enter Role Name" required=""/>
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label" for="allManagement">Assign Permissions 
                                    <span class="optional">(optional)</span>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="allManagement" {{ App\Models\Admin::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="allManagement">
                                        <strong>All</strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>

                        @php $i = 1;  @endphp
                        @foreach ($permissions_group as $group)
                            <!-- Single Menu Roles -->
                            <div class="row role-{{ $i }}-managements">
                                @php
                                    $permissions = App\Models\Admin::getPermissionsByGroupName($group->name);
                                    $j = 1;
                                @endphp

                                <div class="col-md-3">
                                    <label class="control-label" for="{{ $i }}Management">{{ $group->title }}</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="{{ $i }}Management" onclick="checkPrmissions('role-{{ $i }}-managements', this)" {{ App\Models\Admin::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="{{ $i }}Management">
                                            <strong>All</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-9 role-{{ $i }}-managements-checkbox">
                                    @foreach ($permissions as $permission)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="{{ $i }}-{{ $j }}" name="permissions[]"  value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} onclick="checkSinglePrmission('role-{{ $i }}-managements', '{{ $i }}Management', <?php echo count($permissions); ?>)">
                                        <label class="custom-control-label" for="{{ $i }}-{{ $j }}">{{ $permission->title }}</label>
                                    </div>
                                    @php $j++; @endphp
                                    @endforeach

                                </div>
                                <hr>
                            </div>
                            <hr>
                            <!-- Single Menu Roles -->
                            @php $i++; @endphp
                        @endforeach

                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-actions">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                        <a href="{{ route('admin.roles.index') }}" class="btn btn-dark">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @include('backend.pages.roles.partials.scripts');
@endsection