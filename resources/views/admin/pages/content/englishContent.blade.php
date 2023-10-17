@extends('admin.app')
@section('admin_content')
    @include('sweetalert::alert')
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center me-3 flex-wrap lh-1">
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Book Content Text Input</h1>
                <span class="h-20px border-gray-200 border-start mx-4"></span>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="/" class="text-muted text-hover-primary">DASHBOARD</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Book Content Text Input</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="post d-flex flex-column-fluid mb-5" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <div class="card card-flush">
                <div class="card-body pt-5">
                    <form action="{{route('english.content.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-5">
                            <label for="type" class="required fs-6 fw-semibold mb-2">Type</label>
                            <select name="type" id="type" class="form-select form-select-solid" required>
                                <option value="">Select Type</option>
                                <option value="text">Text</option>
                                <option value="image">Image</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="book_for_chapters" class="required fs-6 fw-semibold mb-2">Books</label>
                            <select name="book_id" id="book_for_chapters" class="form-select form-select-solid" required>
                                <option value="">Select Book</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-5">
                            <label for="chapters_for_selected_book" class="required fs-6 fw-semibold mb-2">Chapters for Selected Book</label>
                            <select name="chapter_id" id="chapters_for_selected_book" class="form-select form-select-solid" disabled>
                                <option value="">Select Chapter</option>
                            </select>
                        </div>
                        <div id="text" style="display: none;">
                            <div class="row">
                                <div class="col-12">
                                    <textarea name="kt_docs_ckeditor_classic" id="kt_docs_ckeditor_classic"></textarea>
                                </div>
                            </div>
                            <br>
                            <br>
                            <!-- Add a preview section -->
                            <div class="d-flex row">
                                <div class="col-12 mt-3">
                                    <div class="">
                                        <div id="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="image" style="display: none;">
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <input type="file" name="image_file"/>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="page_no" value="{{$pageNo+1}}"/>

                        <!-- Bengali Text Hidden Input Field -->
                        <input type="hidden" name="lines_array" id="lines_array" value="">
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
    <!-- Chapter & Book -->
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
                    option.textContent = chapter.chapter_name;
                    chapterSelect.appendChild(option);
                });
                // Enable or disable the chapter dropdown
                chapterSelect.disabled = selectedBookId === '';
            });
        });
    </script>
    <!-- Select Type Image or Text -->
    <script>
        // Get references to the select element and input field containers
        const dropdown = document.getElementById("type");
        const option1Fields = document.getElementById("text");
        const option2Fields = document.getElementById("image");
        // Add an event listener to the dropdown
        dropdown.addEventListener("change", function() {
            if (dropdown.value === "text") {
                // Show Option 1 input fields and hide Option 2 input fields
                option1Fields.style.display = "block";
                option2Fields.style.display = "none";
            } else if (dropdown.value === "image") {
                // Show Option 2 input fields and hide Option 1 input fields
                option1Fields.style.display = "none";
                option2Fields.style.display = "block";
            } else {
                // Hide both input field containers if neither option is selected
                option1Fields.style.display = "none";
                option2Fields.style.display = "none";
            }
        });
    </script>

    {{--Generates Preview--}}
    <script>
        const linesArray = [];
        // Initialize CKEditor
        CKEDITOR.replace('kt_docs_ckeditor_classic');
        // Function to remove HTML tags from a string
        function removeHTMLTags(input) {
            return input.replace(/<\/?[^>]+(>|$)/g, "");
        }
        // Function to update the preview based on the CKEditor content

        function updatePreview() {
            // Clear the linesArray
            linesArray.length = 0;
            const editor = CKEDITOR.instances.kt_docs_ckeditor_classic;

            const separator = '.';
            const textareaValue = editor.getData();
            const lines = textareaValue.split(separator);
            // Remove the last empty line if it exists
            if (lines.length > 0 && lines[lines.length - 1].trim() === '') {
                lines.pop();
            }
            // Remove splitted text array last index
            if(lines.length > 0) {
                lines.pop();
            }
            // Create HTML to display the lines in the preview section
            const totalLineCount = lines.length;
            // Create HTML to display the lines in the preview section
            const previewHTML = `<div class="mb-3"><strong>Total Line:</strong> ${totalLineCount}</div>` + lines.map(line => {
                const trimmedLine = line.trim().concat('.');
                const lineWithoutTags = removeHTMLTags(trimmedLine);
                linesArray.push(lineWithoutTags);
                return `
                    <div class="row mt-7">
                        <div class="col-12 col-md-8">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Line Bn</label>
                            <input type="text" class="form-control form-control-solid" disabled value="${lineWithoutTags}" placeholder="Enter Line in Bangla"/>
                        </div>
                    </div>
                `;
            }).join('');
            document.getElementById('preview').innerHTML = previewHTML;
            document.getElementById('lines_array').value = JSON.stringify(linesArray);
        }
        // Attach an event listener to the CKEditor instance's 'change' event
        CKEDITOR.instances.kt_docs_ckeditor_classic.on('change', function() {
            // Check if the CKEditor content is not empty before updating the preview
            if (CKEDITOR.instances.kt_docs_ckeditor_classic.getData().trim() !== '') {
                updatePreview();
            } else {
                // Clear the preview if CKEditor content is empty
                document.getElementById('preview').innerHTML = '';
            }
        });
        // Initial update of the preview
        updatePreview();
    </script>
@endsection
