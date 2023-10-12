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
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                            <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Chapter" />
                        </div>
                        <div id="kt_datatable_example_1_export" class="d-none"></div>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="{{ route('bangla.content') }}" class="btn btn-primary">Add New</a>
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
                            <th>Line</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Page No</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600 text-center">
                        @foreach($contents as $key=>$contentBangla)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $contentBangla->type }}</td>
                                <td>{{ $contentBangla->chapter->book->name_bn }}</td>
                                <td>{{ $contentBangla->chapter->chapter_name_bn }}</td>
                                <td>{{ $contentBangla->line? (Illuminate\Support\Str::limit($contentBangla->line, 10)):'N/A' }}</td>
                                <td>{{ $contentBangla->start_time ? $contentBangla->start_time:'N/A' }}</td>
                                <td>{{ $contentBangla->end_time ? $contentBangla->end_time:'N/A' }}</td>
                                <td>{{ $contentBangla->page_no }}</td>

                                <td>
                                    @if($contentBangla->image_file !=null)
                                    <img src="{{asset('storage/'.$contentBangla->image_file)}}" style="height: 100px; width: 100px;">
                                    @else
                                      <p>N/A</p>
                                    @endif
                                </td>

                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFormDataEdit{{$contentBangla->id}}">Edit</button>
                                </td>
                            </tr>

                            <!-- Content Edit Modal -->
                            <div class="modal fade" id="modalFormDataEdit{{$contentBangla->id}}" aria-labelledby="editModalLabel{{$contentBangla->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <div class="modal-content rounded">
                                        <div class="modal-header pb-0 border-0 justify-content-end">
                                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                <i class="ki-outline ki-cross fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                            <form action="{{route('bangla.content.update',$contentBangla->id)}}" method="POST" class="form">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-13 text-center">
                                                    <h1 id="editModalLabel{{$contentBangla->id}}" class="mb-3">Edit Bangla Content</h1>
                                                </div>

                                                <!-- Book -->
                                                <div class="form-group">
                                                    <label for="book_for_chapters" class="required fs-6 fw-semibold mb-2">Books</label>
                                                    <select name="book_id" id="book_for_chapters_edit" class="form-select form-select-solid" required>
                                                        <option selected value="{{ $contentBangla->chapter->book->id }}">{{ $contentBangla->chapter->book->name_bn }}</option>
                                                        @foreach ($books as $book)
                                                            <option value="{{ $book->id }}">{{ $book->name_bn }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Chapter -->
                                                <div class="form-group">
                                                    <label for="chapters_for_selected_book" class="required fs-6 fw-semibold mb-2">Chapters for Selected Book</label>
                                                    <select name="chapter_id" id="chapters_for_selected_book_edit" class="form-select form-select-solid">
                                                        <option selected value="{{ $contentBangla->chapter->id }}">{{ $contentBangla->chapter->chapter_name_bn }}</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-12 fv-row">
                                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2 required">Line</label>
                                                    <input type="text" name="line" class="form-control form-control-solid" value="{{ $contentBangla->line }}" placeholder="Enter Line "/>
                                                </div>

                                                <div class="col-md-12 fv-row">
                                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2 required">Start Time</label>
                                                    <input type="text" name="line" class="form-control form-control-solid" value="{{ $contentBangla->start_time }}" placeholder="Enter Start Time "/>
                                                </div>

                                                <div class="col-md-12 fv-row">
                                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2 required">End Time</label>
                                                    <input type="text" name="line" class="form-control form-control-solid" value="{{ $contentBangla->end_time }}" placeholder="Enter End Time "/>
                                                </div>

                                                <div class="">
                                                    <div class="col-md-12 fv-row">
                                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2 required">Image</label>
                                                        <input type="file" name="image_file" class="form-control form-control-solid" accept=""/>
                                                    </div>
                                                </div>

                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary">
                                                        <span class="indicator-label">Update</span>
                                                    </button>
                                                </div>
                                            </form>
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



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bookSelect = document.getElementById('book_for_chapters');
            const chapterSelect = document.getElementById('chapters_for_selected_book');

            bookSelect.addEventListener('change', function () {
                const selectedBookId = this.value;
                // Clear existing chapter options
                chapterSelect.innerHTML = '<option value="">Select Chapter</option>';
                // Filter chapters based on the selected book
                const chapters = @json($chapters);
                const filteredChapters = chapters.filter(chapter => chapter.book_id == selectedBookId);
                // Populate the chapters dropdown with filtered chapters
                filteredChapters.forEach(chapter => {
                    const option = document.createElement('option');
                    option.value = chapter.id;
                    option.textContent = chapter.chapter_name_bn;
                    chapterSelect.appendChild(option);
                });
                // Enable or disable the chapter dropdown
                chapterSelect.disabled = selectedBookId === '';
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bookSelect = document.getElementById('book_for_chapters_edit');
            const chapterSelect = document.getElementById('chapters_for_selected_book_edit');
            bookSelect.addEventListener('change', function () {
                const selectedBookId = this.value;
                // Clear existing chapter options
                chapterSelect.innerHTML = '<option value="">Select Chapter</option>';
                // Filter chapters based on the selected book
                const chapters = @json($chapters);
                const filteredChapters = chapters.filter(chapter => chapter.book_id == selectedBookId);
                // Populate the chapters dropdown with filtered chapters
                filteredChapters.forEach(chapter => {
                    const option = document.createElement('option');
                    option.value = chapter.id;
                    option.textContent = chapter.chapter_name_bn;
                    chapterSelect.appendChild(option);
                });
                // Enable or disable the chapter dropdown
                chapterSelect.disabled = selectedBookId === '';
            });
        });
    </script>

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
@endsection
