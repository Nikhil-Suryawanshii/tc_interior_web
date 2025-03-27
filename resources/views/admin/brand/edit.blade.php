@extends('admin.dashboard')
@section('admin')
<div class="page-wrapper">
    <div class="page-content">
    <div class="row">
        <div class="col-xl-8 mx-auto">
            <h6 class="mb-0 text-uppercase">Customer Form Details</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary">Customer Registration</h5>
                    </div>
                    <hr>
                    <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="inputFirstName" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="inputFirstName" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="inputBrandImage" class="form-label">Brand Image</label>
                            <input type="file" name="Brand_image" class="form-control" id="inputBrandImage" onchange="previewImage(event)">
                        </div>
                        <div class="col-md-6">
                            <img id="showImage" src="{{ (!empty($brand->Brand_image)) ? url('upload/brand_upload/',$brand->Brand_image) : url('upload/No_Image_Available.jpg') }}" alt="brand"  style="height:100px; width:100px;">
                        </div>
                        <div class="col-md-6">
                            <label for="inputExpiryDate" class="form-label">Expiry Date</label>
                            <input type="date" name="Expiry_date" class="form-control" id="inputExpiryDate" value="{{ old('joining_date') }}" required>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
<script>
function previewImage(event) {
var input = event.target;
var reader = new FileReader();

reader.onload = function () {
var dataURL = reader.result;
var output = document.getElementById('showImage');
output.src = dataURL;
};

reader.readAsDataURL(input.files[0]);
}
</script>


