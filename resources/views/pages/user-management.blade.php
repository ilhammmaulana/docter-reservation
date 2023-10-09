@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Users</h6>
                    <button type="button" class="btn bg-gradient-primary mt-1 mb-4" data-bs-toggle="modal"
                        data-bs-target="#createUser">
                        Create user
                    </button>
                    <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createModelProduct"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createModelProduct">Craete User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form enctype="multipart/form-data"
                                        action="{{ route('admins.store') }}"method="POST">
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
                                                <label for="photo" class="h6">Product photo</label>
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
                                    <form enctype="multipart/form-data" action="{{ route('admins.store') }}"
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
                                                <label for="password" class="h6">Password</label>
                                                <div class="form-group">
                                                    <input  placeholder="Password" name="password"
                                                        class="form-control" id="password" />
                                                    <span id="passwordError" class="text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="photo" class="h6">Product photo</label>
                                                <div class="form-group">
                                                    <input type="file" id="imageInput"
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
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Created at</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
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
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->created_at }}</p>
                                        </td>
                                        <td class="align-middle text-end d-flex gap-2">
                                            <button type="button" class="btn btn-primary edit-button"
                                                data-bs-toggle="modal" data-bs-target="#editUser"
                                                data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}" data-phone="{{ $user->phone }}"
                                                data-image="{{ $user->photo === null ? null : url($user->photo) }}">
                                                Edit

                                            </button>
                                            <form action="{{ url('admins') . '/' . $user->id }}"
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
                            @if ($users->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}"
                                        rel="prev">&laquo;</a></li>
                            @endif

                            @if ($users->lastPage() == 1)
                                <li class="page-item active"><span class="page-link">1</span></li>
                            @else
                                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    @if ($page == $users->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif

                            @if ($users->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}"
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

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                console.log(id)
                const name = button.getAttribute('data-name');
                const phone = button.getAttribute('data-phone');
                const email = button.getAttribute('data-email');
                const image = button.getAttribute('data-image');

                const url = "{{ url('admins') }}" + '/' + id;
                editForm.setAttribute('action', url);
                editNameInput.value = name;
                editEmailInput.value = email;
                editPhoneInput.value = phone;
                editImagePreview.src = image;
                editImagePreview.style.display = 'block';


            });

        });
    </script>
@endsection
