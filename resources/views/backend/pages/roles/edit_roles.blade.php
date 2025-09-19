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

                        <h6 class="card-title">Edit role</h6>

                        <form method="POST" action="{{ route('update.roles') }}" class="forms-sample">
                            @csrf


                            <input type="hidden" name="id" value="{{ $roles->id }}">
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ $roles->name }}" autocomplete="off">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
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