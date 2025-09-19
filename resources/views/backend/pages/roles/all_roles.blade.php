@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content mt-5">


        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div>
                            <div class="row">
                                <div class="col">
                                    <nav class="page-breadcrumb">
                                        <ol class="breadcrumb">
                                            <a href="{{ route('add.roles') }}" class="btn btn-sm btn-primary mx-1"><i class="feather-16"
                                                    data-feather="file-plus"></i> &nbsp;Add Roles</a>
                                        </ol>
                                    </nav>
                                </div>
    
                                <div class="col">
                                    <h6 class="card-title text-center">Roles All</h6>
    
                                </div>
                                <div class="col">
                                    <h6 class="card-title text-center"></h6>
                                </div>
                            </div>
                           
                        </div>


                     

                     

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Roles Name</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div class="d-flex align-items-center">

                                                        <div class="d-flex align-items-center">
                                                            <div class="actions dropdown">
                                                                <a href="#" data-bs-toggle="dropdown"> <i
                                                                        data-feather="more-horizontal"></i></a>
                                                                <div class="dropdown-menu" role="menu">


                                                                    <a href="{{ route('edit.roles', $item->id) }}"
                                                                        class="dropdown-item"><i class="feather-16"
                                                                            data-feather="edit-3"></i> &nbsp; Edit</a>


                                                                    <a href="{{ route('delete.roles', $item->id) }}"
                                                                        class="dropdown-item text-danger" id="delete"><i
                                                                            class="feather-16" data-feather="trash-2"></i>
                                                                        &nbsp; Delete</a>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>



                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
