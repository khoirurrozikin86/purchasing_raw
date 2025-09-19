@extends('admin.admin_dashboard')

@section('admin')


<div class="page-content">

    <div class="row profile-body">

        <!-- left wrapper end -->
        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Permission</h6>

                        <form method="POST" action="{{ route('update.permission') }}" class="forms-sample">
                            @csrf


                            <input type="hidden" name="id" value="{{ $permissions->id }}">
                            <div class="mb-3">
                                <label for="name" class="form-label">Type Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ $permissions->name }}" autocomplete="off">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type_icon" class="form-label">Group Name</label>
                                <select name="group_name" class="form-select" id="group_name">
                                    <option selected="" disabled>Select Group</option>
                                    <option value="type" {{ $permissions->group_name == 'type' ? 'selected':''
                                        }}>Property Type</option>
                                    <option value="employee" {{ $permissions->group_name == 'employee' ? 'selected':''
                                        }}>employee</option>
                                    <option value="tool" {{ $permissions->group_name == 'tool' ? 'selected':'' }}>tool
                                    </option>
                                </select>
                            </div>



                            <button type="submit" class="btn btn-primary me-2">Save Changes</button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
        <!-- middle wrapper end -->
        <!-- right wrapper start -->

        <!-- right wrapper end -->
    </div>

</div>









@endsection