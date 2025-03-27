@extends('admin.dashboard')
@section('admin')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">eCommerce</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Worker</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                        <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Worker">
                        <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('worker.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                            <i class="bx bxs-plus-square"></i>Add New Worker
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Serial Number</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Joining Date</th>
                                <th>Gender</th>
                                <th>State</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workers as $worker)
                                <tr onclick="window.location='{{ route('worker.edit', $worker->id) }}'" style="cursor: pointer;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img id="showImage"
                                             src="{{ (!empty($worker->profile_image)) ? url('upload/student_upload/'.$worker->profile_image) : url('upload/No_Image_Available.jpg') }}"
                                             alt="worker"
                                             style="height:30px; width:30px;">
                                    </td>
                                    <td>{{ $worker->name }}</td>
                                    <td>{{ $worker->surname }}</td>
                                    <td>{{ $worker->email }}</td>
                                    <td>{{ $worker->phone_number }}</td>
                                    <td>{{ $worker->joining_date }}</td>
                                    <td>{{ $worker->gender }}</td>
                                    <td>{{ $worker->state }}</td>
                                    <td>
                                        <div class="d-flex Worker-actions">
                                            <a href="{{ route('worker.edit', $worker->id) }}"><i class='bx bxs-edit'></i></a>
                                            <a href="{{ route('worker.delete', $worker->id) }}" class="ms-3"><i class='bx bxs-trash'></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
