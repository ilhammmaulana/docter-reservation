@extends('layouts.app')
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Docter'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Docters</h6>
                    <button type="button" class="btn bg-gradient-primary mt-1 mb-4" data-bs-toggle="modal"
                        data-bs-target="#createUser">
                        Create Docter
                    </button>
                    <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createModelProduct"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createModelProduct">Craete Docter</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form enctype="multipart/form-data"
                                        action="{{ route('docters.store') }}"method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <img id="imagePreview" src="#" alt="Image Preview"
                                                style="display: none; max-width: 100%; max-height: 300px;">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="name" class="h6">Name</label>
                                                <div class="form-group">
                                                    <input required type="text" name="name" class="form-control"
                                                        id="name" placeholder="User name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="description" class="h6">Email</label>
                                                <div class="form-group">
                                                    <input required type="email" name="email" class="form-control"
                                                        id="email" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="password" class="h6">Password</label>
                                                <div class="form-group">
                                                    <input required placeholder="Password" name="password"
                                                        class="form-control" id="password" />
                                                    <span id="passwordError" class="text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="photo" class="h6">Photo</label>
                                                <div class="form-group">
                                                    <input type="file" id="imageInput"
                                                        onchange="previewImage(event)"class="form-control" name="photo">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="phone" class="h6">Phone</label>
                                                <div class="form-group">
                                                    <input required type="phone" name="phone" class="form-control"
                                                        id="phone" placeholder="Phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="subdistrict_id" class="h6">Kecamatan</label>
                                                    <select required name="subdistrict_id" class="form-control"
                                                        id="subdistrict_id">
                                                        <option value="Kecamatan" disabled selected>Pilih Kecamatan</option>
                                                        @foreach ($subdistricts as $subdistrict)
                                                            <option value="{{ $subdistrict->id }}">{{ $subdistrict->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="subdistrict_id" class="h6">Kategori Docter</label>
                                                    <select required name="category_docter_id" class="form-control"
                                                        id="category_docter_id">
                                                        <option value="category" disabled selected>Pilih Kategori</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="description" class="h6">Description</label>
                                                <div class="form-group">
                                                    <textarea name="description" id="description" class="form-control" cols="20" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="address" class="h6">Address</label>
                                                <div class="form-group">
                                                    <textarea name="address" id="address" class="form-control" cols="20" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn bg-gradient-primary">Create</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editModalUser"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalUser">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form enctype="multipart/form-data" action="{{ route('docters.store') }}"
                                        id="editForm" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <div class="form-group">
                                            <img id="editImagePreview" src="#" alt="Image Preview"
                                                style="display: none; max-width: 100%; max-height: 300px;">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="name" class="h6">Name</label>
                                                <div class="form-group">
                                                    <input required type="text" name="name" class="form-control"
                                                        id="update-name" placeholder="User name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="description" class="h6">Email</label>
                                                <div class="form-group">
                                                    <input required type="email" name="email" class="form-control"
                                                        id="update-email" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="update-password" class="h6">Password</label>
                                                <div class="form-group">
                                                    <input  placeholder="Password" name="password"
                                                        class="form-control" id="update-password" />
                                                    <span id="passwordError" class="text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="photo" class="h6">Product photo</label>
                                                <div class="form-group">
                                                    <input 
                                                        type="file" 
                                                        id="imageInput"
                                                        onchange="previewImageForEdit(event)"class="form-control"
                                                        name="photo">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="phone" class="h6">Phone</label>
                                                <div class="form-group">
                                                    <input required type="phone" name="phone" class="form-control"
                                                        id="update-phone" placeholder="Phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="subdistrict_id" class="h6">Kecamatan</label>
                                                    <select id="update_subdistricts" required name="subdistrict_id" class="form-control">
                                                        @foreach ($subdistricts as $subdistrict)
                                                            <option value='{{ $subdistrict->id }}'>{{ $subdistrict->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn bg-gradient-primary">Create</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Email
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Phone
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kecamatan
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Address
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Category Docter
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Created at</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($docters as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    <img src="{{ $user->photo !== null ? url($user->photo) : asset('assets/img/default.png') }}"
                                                        class="avatar me-3" alt="photo">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $user->phone === null ? 'N/A' : $user->phone }}</p>
                                        </td> 
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $user->subdistrict->name === null ? 'N/A' : $user->subdistrict->name }}
                                            </p>
                                        </td>
                                        
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $user->address === null ? 'N/A' : $user->address }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $user->category->name === null ? 'N/A' : $user->category->name }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->created_at }}</p>
                                        </td>
                                        <td class="align-middle text-end d-flex gap-2">
                                            <a href="{{ route('docters.edit', $user->id) }}">
                                            <button type="button" class="btn btn-primary edit-button">
                                                Edit
                                            </button>
                                        </a>
                                            <form action="{{ route('docters.destroy', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button TYPE="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <ul class="pagination pagination-primary ms-3 mt-4">
                            @if ($docters->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $docters->previousPageUrl() }}"
                                        rel="prev">&laquo;</a></li>
                            @endif

                            @if ($docters->lastPage() == 1)
                                <li class="page-item active"><span class="page-link">1</span></li>
                            @else
                                @foreach ($docters->getUrlRange(1, $docters->lastPage()) as $page => $url)
                                    @if ($page == $docters->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif

                            @if ($docters->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $docters->nextPageUrl() }}"
                                        rel="next">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        function previewImageForEdit(event) {
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
                    editImagePreview.src = e.target.result;
                    editImagePreview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                editImagePreview.src = '#';
                editImagePreview.style.display = 'none';
            }
        }

        const editButtons = document.querySelectorAll('.edit-button');
        const editForm = document.getElementById('editForm');
        const editNameInput = document.getElementById('update-name');
        const editEmailInput = document.getElementById('update-email');
        const editPhoneInput = document.getElementById('update-phone');
        const editSubdistricts = document.getElementById('update_subdistricts');

        function setSelectedOption(dropdown, value) {
            const options = dropdown.options;
            console.log(value)
            for (let i = 0; i < options.length; i++) {
                console.log(options[i].value == value)
                if (options[i].value == value) {
                    options[i].selected = true;
                    break;
                }
            }
        }

        editButtons.forEach(button => { 
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const phone = button.getAttribute('data-phone');
                const email = button.getAttribute('data-email');
                const subdistrict_id = button.getAttribute('data-subdistrict_id');
                console.log(subdistrict_id)
                const image = button.getAttribute('data-image');

                const url = "{{ url('admins/user-managements') }}" + '/' + id;
                editForm.setAttribute('action', url);
                editNameInput.value = name;
                editEmailInput.value = email;
                editPhoneInput.value = phone;
                editImagePreview.src = image;
                editImagePreview.style.display = 'block';
                setSelectedOption(editSubdistricts, subdistrict_id)

            });

        });

        const randomPassword = (length) => {
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }

                return result;
            }
            const passwordField  = document.getElementById('password');
            passwordField.value = randomPassword(9)
    </script>
@endsection
