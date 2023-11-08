@extends('admin.app')
@section('admin_content')
    @include('sweetalert::alert')
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center me-3 flex-wrap lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Book Content Reference Page no Input</h1>
                <span class="h-20px border-gray-200 border-start mx-4"></span>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="/" class="text-muted text-hover-primary">DASHBOARD</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Reference Page no Input</li>
                </ul>

            </div>
        </div>
    </div>
    <div class="post d-flex flex-column-fluid mb-5" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="card card-flush">
                <div class="card-body pt-5">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row pt-8">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Book Name</label>
                                    <input type="text" class="form-control form-control-solid" disabled value="{{$book}}"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-5">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Chapter Name</label>
                                    <input type="text" class="form-control form-control-solid" disabled value="{{$chapter}}"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-5">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Exist Page No</label>
                                    <input type="text" class="form-control form-control-solid" disabled value="{{$pageNo}}"/>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="text">
                            <div class="row">
                                <div class="col-12">
                                    <textarea name="kt_docs_ckeditor_classic" id="kt_docs_ckeditor_classic" disabled>{{$pageContents}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-8">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Reference Page No</label>
                                    <input type="text" name="reference_page_no" class="form-control form-control-solid" value="{{$referencePageNo? $referencePageNo: ''}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-7">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <script>
        @if(session('success'))
        Swal.fire(
            'Congratulations!',
            'You have successfully added book information.',
            'success'
        )
        @endif
        // Add SweetAlert for update success here
        @if(session('success') && request()->routeIs('book.update'))
        Swal.fire(
            'Success!',
            'Book information updated successfully.',
            'success'
        )
        @endif
        // Add SweetAlert for delete success here
        @if(session('success') && request()->routeIs('book.delete'))
        Swal.fire(
            'Success!',
            'Book deleted successfully.',
            'success'
        )
        @endif
    </script>
    <script>
        CKEDITOR.replace('kt_docs_ckeditor_classic');
    </script>
@endsection
