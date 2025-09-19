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

                            <h6 class="card-title">Import QR Code</h6>

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <h3> {{ $error }} </h3>
                                    @endforeach

                                </div>
                            @endif

                            <form id="myForm" method="POST" action="{{ route('import.qr_code') }}" class="forms-sample"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Excel File Improt</label>
                                    <input type="file" class="form-control" id="import_file" name="import_file" required>
                                    <x-input-error :messages="$errors->get('login')" class="mt-2" />

                                </div>

                                <button type="submit" class="btn btn-primary me-2">Upload</button>

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
