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
                        <div id="kt_datatable_example_1_export">Duration({{$totalLineCount}})</div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @foreach($contents as $key=>$contentEnglish)
                        <div class="modal-body pt-0 pb-3">
                            <form action="{{route('update.duration.english')}}" method="POST" class="form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id[]" value="{{$contentEnglish->id}}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="d-flex align-items-center fs-6 fw-semibold required">Line</label>
                                        <textarea disabled class="form-control form-control-solid" rows="2" name="line[]" placeholder="Type Target Details">{{ $contentEnglish->line }}</textarea>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-6 fv-row">
                                                <label class="d-flex align-items-center fs-6 fw-semibold required">Start Time</label>
                                                <input type="text" name="start_time[]" id="timeInput1" class="form-control form-control-solid" value="{{ $contentEnglish->start_time }}"  placeholder="00:00:000"/>
                                            </div>
                                            <div class="col-md-6 fv-row">
                                                <label class="d-flex align-items-center fs-6 fw-semibold required">End Time</label>
                                                <input type="text" name="end_time[]" id="timeInput2" class="form-control form-control-solid" value="{{ $contentEnglish->end_time }}"  placeholder="00:00:000"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="d-flex align-items-center justify-content-center fs-6 fw-semibold">Status</label>
                                                <div class="d-flex align-items-center justify-content-center h-50">
                                                    @if( $contentEnglish->start_time !=null && $contentEnglish->end_time !=null)
                                                        <i class="fa-solid fa-check text-success"></i>
                                                    @else
                                                        <i class="fa-solid fa-xmark text-danger"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="text-end  d-block" style="margin-top: 20px;">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <span class="indicator-label">Update</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>




                        @endforeach

                        {{--                    <div class="text-end">--}}
                        {{--                        <button type="submit" class="btn btn-primary">--}}
                        {{--                            <span class="indicator-label">Update</span>--}}
                        {{--                        </button>--}}
                        {{--                    </div>--}}

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
            'You have successfully added Duration.',
            'success'
        )
        @endif

        // Add SweetAlert for update success here
        @if(session('success') && request()->routeIs('update.duration.english'))
        Swal.fire(
            'Success!',
            'Duration information updated successfully.',
            'success'
        )
        @endif
    </script>
    <script>
        const timeInput1 = document.getElementById("timeInput1");
        const timeInput2 = document.getElementById("timeInput2");

        timeInput1.addEventListener("input", function (e) {
            formatTime(e, timeInput1);
        });

        timeInput2.addEventListener("input", function (e) {
            formatTime(e, timeInput2);
        });

        timeInput1.addEventListener("keydown", function (e) {
            handleBackspace(e, timeInput1);
        });

        timeInput2.addEventListener("keydown", function (e) {
            handleBackspace(e, timeInput2);
        });

        function formatTime(e, inputField) {
            let inputValue = inputField.value;

            // Remove any non-numeric characters
            inputValue = inputValue.replace(/[^0-9]/g, "");

            // Limit each part to the desired number of digits
            inputValue = inputValue.slice(0, 2) + ":" + inputValue.slice(2, 4) + ":" + inputValue.slice(4, 7);

            // Update the input field with the formatted value
            inputField.value = inputValue;

        }

        function handleBackspace(e, inputField) {
            if (e.key === 'Backspace') {
                // Allow the user to delete characters using the Backspace key
                let inputValue = inputField.value;
                inputValue = inputValue.slice(0, -1);
                inputField.value = inputValue;
                e.preventDefault(); // Prevent the default Backspace behavior
            }
        }
    </script>

@endsection
