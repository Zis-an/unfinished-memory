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
                    <li class="breadcrumb-item text-muted">Unfinished Memory - Show English Contents</li>
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

                        <div id="kt_datatable_example_1_export" class="d-none"></div>
                    </div>

                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="">

                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 text-center">
                            <th>S/N</th>
                            <th>Type</th>
                            <th>Book Name</th>
                            <th>Chapter Name</th>
                            <th style="width: 350px;">Line</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Page No</th>
                            <th>Image</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600 text-center">
                        @foreach($contents as $key=>$contentEnglish)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $contentEnglish->type }}</td>
                                <td>{{ $contentEnglish->book->name }}</td>
                                <td>{{ $contentEnglish->english_chapters->chapter_name }}</td>
                                <td>{{ $contentEnglish->line }}</td>
                                <td>{{ $contentEnglish->start_time ? $contentEnglish->start_time:'N/A' }}</td>
                                <td>{{ $contentEnglish->end_time ? $contentEnglish->end_time:'N/A' }}</td>
                                <td>{{ $contentEnglish->page_no }}</td>
                                <td>
                                    @if($contentEnglish->image_file !=null)
                                        <img src="{{asset('storage/'.$contentEnglish->image_file)}}" style="height: 100px; width: 100px;">
                                    @else
                                        <p>N/A</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
