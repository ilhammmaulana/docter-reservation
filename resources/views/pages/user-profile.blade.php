@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img id="imagePreview" src="{{ $user->photo === null ? asset('assets/img/default.png') : url($user->photo) }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ $user->name }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Profile</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="photo" class="form-control-label">Photo</label>
                                            <input class="form-control" id="photo" type="file"
                                            onchange="previewImage(event)"
                                            name="photo" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Name</label>
                                            <input  class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-control-label">Phone</label>
                                        <input class="form-control" id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-control-label">Password</label>
                                        <input class="form-control" type="text" name="password" >
                                        <span style="font-size: .8rem">*update password optional</span>
                                    </div>
                            </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Address</p>
                            <div class="row">
                                @docter
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Address</label>
                                        <input class="form-control" type="text" name="address"
                                            value="{{ old('address', $user->address) }}">
                                    </div>
                                </div>
                                @endDocter
                                <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="subdistrict_id" class="h6">Kecamatan</label>
                                            <select required name="subdistrict_id" class="form-control"
                                                id="subdistrict_id">
                                                <option value="Kecamatan" disabled selected>Pilih Kecamatan</option>
                                                @foreach ($subdistricts as $subdistrict)
                                                <option value="{{ $subdistrict->id }}" {{ $user->subdistrict_id === $subdistrict->id ? 'selected': '' }}>
                                                    {{ $subdistrict->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                              
                            </div>
                            <hr class="horizontal dark">
                            @docter
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Your Docter Description</label>
                                        <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ $user->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endDocter
                        </div>
                    </form>
                </div>
            </div>
            @docter
            <div class="col-md-4">
                <div class="card px-4 py-2">
                    <form action="{{ route('docter-images.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $user->id }}" name="docter_id">
                        <div class="form-group">
                            <label for="multiple-images">Upload Images</label>
                            <input class="form-control" type="file" id="multiple-images" placeholder="Max 3 Images" multiple name="images" onchange="previewImages()">
                            <p class="ms-1">*max 3 images</p>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Images</button>
                    </form>
                    <table id="image-preview-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Preview</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
              
            @endDocter
            <script>
                  const imagePreview = document.getElementById('imagePreview');
                const editImagePreview = document.getElementById('editImagePreview');

        function previewImage(event) {
            const imageInput = event.target;

            if (imageInput.files && imageInput.files[0]) {
                const file = imageInput.files[0];
                const reader = new FileReader();

                const fileType = file.type;
                const validImageTypes = ['image/jpeg', 'image/jpg'];
                if (!validImageTypes.includes(fileType)) {
                    alert('Please select a valid JPG/JPEG image.');
                    imageInput.value = '';
                    return;
                }

                const fileSizeMB = file.size / (1024 * 1024);
                const maxSizeMB = 2;
                if (fileSizeMB > maxSizeMB) {
                    alert('Image size must be less than 2MB.');
                    imageInput.value = '';
                    return;
                }

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            }
        }
        function previewImages() {
            const previewTable = document.getElementById('image-preview-table');
            const previewBody = previewTable.getElementsByTagName('tbody')[0];
            previewBody.innerHTML = ''; // Clear previous previews

            const input = document.getElementById('multiple-images');
            const files = input.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (i >= 3) {
                    break; // Only preview the first 3 images (as per your requirement)
                }

                const newRow = previewBody.insertRow();
                const cell1 = newRow.insertCell(0);
                const cell2 = newRow.insertCell(1);

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = file.name;
                img.style.maxWidth = '100px';
                cell1.appendChild(img);

                const fileName = document.createElement('span');
                fileName.textContent = file.name;
                cell2.appendChild(fileName);
            }
        }

            </script>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
