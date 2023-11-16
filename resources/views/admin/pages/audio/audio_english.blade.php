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
                    <li class="breadcrumb-item text-muted">Unfinished Memory</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="post d-flex flex-column-fluid mb-5" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalFormDataSave" class="btn btn-primary">Add New</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="">

                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>S/N</th>
                            <th>Chapter</th>
                            <th>File</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        @foreach($englishAudio as $key=>$data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$data->chapter? $data->chapter->chapter_name:'Not Found'}}</td>
                                <td>
                                    @if($data->file)
                                        <audio controls>
                                            <source src="{{asset('storage/audio/audioBanglaFile/'.$data->file)}}" type="audio/mpeg">
                                        </audio>
                                    @else
                                        <span class="badge badge-danger">No File Found</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('audio.english.delete',$data->id)}}" class="btn btn-danger btn-sm delete-division" data-bs-toggle="modal" data-bs-target="#deleteModal{{$data->id}}" data-category-id="{{$data->id}}">Delete</a>
                                </td>
                            </tr>


                            <div class="modal fade" id="deleteModal{{$data->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$data->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{$data->id}}">Delete Audio</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this Audio?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('audio.english.delete', $data->id) }}" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{--Book Add Modal--}}
    <div class="modal fade" id="modalFormDataSave" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form action="{{route('audio.english.store')}}" method="post" class="form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Add Audio</h1>
                        </div>

                        <div class="col-md-12 mb-8 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Book</label>
                            <select name="chapter_id" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select Chapter" >
                                <option selected>Select Chapter</option>
                                @foreach($chapters as $chaptersData)
                                    <option value="{{$chaptersData->id}}">{{$chaptersData->chapter_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-9 mb-8">
                            <div class="col-md-12 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2 required">Audio File</label>
                                <input type="file" name="file" class="form-control form-control-solid" placeholder="Enter File"/>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
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
            'You have successfully added book information.',
            'success'
        )
        @endif

        // Add SweetAlert for update success here
        @if(session('success') && request()->routeIs('archive.update'))
        Swal.fire(
            'Success!',
            'Book information updated successfully.',
            'success'
        )
        @endif

        // Add SweetAlert for delete success here
        @if(session('success') && request()->routeIs('archive.delete'))
        Swal.fire(
            'Success!',
            'Book deleted successfully.',
            'success'
        )
        @endif
    </script>
@endsection
