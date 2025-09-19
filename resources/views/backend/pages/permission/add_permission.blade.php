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

                            <h6 class="card-title">Add Permission</h6>

                            <form id="myForm" method="POST" action="{{ route('store.permission') }}" class="forms-sample">
                                @csrf



                                <div class="mb-3">
                                    <label for="name" class="form-label">Permission Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" autocomplete="off" required autofocus>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="type_icon" class="form-label">Group Name</label>
                                    <input type="text" class="form-control @error('group_name') is-invalid @enderror"
                                        id="group_name" name="group_name" autocomplete="off" required>
                                    @error('group_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    {{-- <select name="group_name" class="form-select" id="group_name">
                                    <option selected="" disabled>Select Group</option>
                                    <option value="type">Property Type</option>
                                    <option value="employee">employee</option>
                                    <option value="tool">tool</option>
                                </select> --}}
                                </div>



                                <button type="submit" class="btn btn-primary me-2">Save</button>

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
