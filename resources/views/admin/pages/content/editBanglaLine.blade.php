@extends('admin.app')
@section('admin_content')
    @include('sweetalert::alert')

    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center me-3 flex-wrap lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Unfinished Memory</h1>
                <span class="h-20px border-gray-200 border-start mx-4"></span>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="/" class="text-muted text-hover-primary">DASHBOARD</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Unfinished Memory - Show Bangla Contents</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Table View -->
    <div class="post d-flex flex-column-fluid mb-5" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <div id="kt_datatable_example_1_export">Line Update({{$totalLineCount}})</div>
                    </div>
                </div>

                <div class="card-body pt-0">
                     @foreach($contents as $key=>$contentBangla)
                         <div class="modal-body pt-0 pb-3">
                           <form action="{{route('update.content')}}" method="POST" class="form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id[]" value="{{$contentBangla->id}}">
                                <div class="col-md-12 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2 required">Line</label>
                                    <textarea class="form-control form-control-solid" rows="2" name="line[]" placeholder="Type Target Details">{{ $contentBangla->line }}</textarea>
                                </div>
                         </div>
                        @endforeach
                            <div class="text-end mt-5">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Update</span>
                                </button>
                            </div>
                       </form>
                </div>
            </div>
        </div>
     </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <script>
        @if(session('success'))
        Swal.fire(
            'Congratulations!',
            'You have successfully Update Line information.',
            'success'
        )
        @endif
        // Add SweetAlert for update success here
        @if(session('success') && request()->routeIs('update.content'))
        Swal.fire(
            'Success!',
            'Update Line information successfully.',
            'success'
        )
        @endif
    </script>
@endsection
