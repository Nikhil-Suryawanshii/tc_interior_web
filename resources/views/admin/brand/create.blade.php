@extends('admin.dashboard')

@section('admin')
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <h6 class="mb-0 text-uppercase">Brand Form Details</h6>
                <hr />
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-primary"></i></div>
                            <h5 class="mb-0 text-primary">Brand Registration</h5>
                        </div>
                        <hr>
                        <form id="brandForm" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="inputFirstName" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#brandForm').on('submit', function (e) {
            alert("click button");
            e.preventDefault(); // Prevent default form submission
            console.log('Form submitted!'); // Debugging log

            let formData = new FormData(this); // Form data
            console.log([...formData]); // Log form data for debugging

            $.ajax({
                url: "{{ route('brand.store') }}", // Ensure route exists
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('button[type="submit"]').prop('disabled', true);
                    console.log('Sending request...');
                },
                success: function (response) {
                    console.log('Success:', response);
                    alert('Brand saved successfully!');
                    $('#brandForm')[0].reset();
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Unknown error'));
                },
                complete: function () {
                    $('button[type="submit"]').prop('disabled', false);
                    console.log('Request completed.');
                }
            });
        });
    });
</script>
@endpush
