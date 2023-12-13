@extends('admin.app')
@section('admin_content')
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
                <!-- Table View -->
                <div class="post d-flex flex-column-fluid mb-5" id="kt_post">
                    <div id="kt_content_container" class="container-fluid">
                        <div class="card card-flush">
                            <form action="{{ route('bangla.contents.show.all') }}" method="post">
                                @csrf
                                <div class="row pt-8">
                                    <div class="col-12 col-md-5">
                                        <div class="form-group">
                                            <label for="book_for_chapters" class="required fs-6 fw-semibold mb-2">Books</label>
                                            <select name="book_id" id="book_for_chapters" class="form-select form-select-solid" required>
                                                <option value="">Select Book</option>
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id }}">{{ $book->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <div class="form-group mb-5">
                                            <label for="chapters_for_selected_book" class="required fs-6 fw-semibold mb-2">Chapters for Selected Book</label>
                                            <select name="chapter_id" id="chapters_for_selected_book" class="form-select form-select-solid" disabled>
                                                <option value="">Select Chapter</option>
                                            </select>
                                        </div></div>
                                    <div class="col-12 col-md-2">
                                        <button type="submit" class="btn btn-primary mt-8" style="width: 100%;">Filter</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="">

                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0 text-center">
                            <th>S/N</th>
                            <th>Page No</th>
                            <th>Total Line</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600 text-center">
                        @foreach($contents as $key=>$contentBangla)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $contentBangla->page_no }}</td>
                                <td>{{ $contentBangla->total_line }}</td>
                                <td>{{ $contentBangla->type }}</td>
                                <td>
                                    @if($contentBangla->type=='text')
                                    <a href="{{ route('view.content', ['bookId' => $bookId, 'chapterId' => $chapterId, 'pageNo' => $contentBangla->page_no]) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('edit.content', ['bookId' => $bookId, 'chapterId' => $chapterId, 'pageNo' => $contentBangla->page_no]) }}" class="btn btn-info">Edit</a>
                                    <a href="{{ route('edit.duration', ['bookId' => $bookId, 'chapterId' => $chapterId, 'pageNo' => $contentBangla->page_no]) }}" class="btn btn-info">Duration</a>
                                    <a href="{{ route('create.reference.page.bangla', ['bookId' => $bookId, 'chapterId' => $chapterId, 'pageNo' => $contentBangla->page_no]) }}" class="btn btn-info">Reference Page</a>
                                    @else
                                        <a href="{{ route('view.content', ['bookId' => $bookId, 'chapterId' => $chapterId, 'pageNo' => $contentBangla->page_no]) }}" class="btn btn-info">View</a>
                                        <a href="{{ route('create.reference.page.bangla', ['bookId' => $bookId, 'chapterId' => $chapterId, 'pageNo' => $contentBangla->page_no]) }}" class="btn btn-info">Reference Page</a>
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
                    option.textContent = `${chapter.id} - ${chapter.chapter_name}`;
                    chapterSelect.appendChild(option);
                });
                // Enable or disable the chapter dropdown
                chapterSelect.disabled = selectedBookId === '';
            });
        });
    </script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('kt_docs_ckeditor_classic');
    </script>
@endsection
