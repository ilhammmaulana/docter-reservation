@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Reservations</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomer antrian</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time reservation</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keluhan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created at</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $reservation->queue_number}} </p></td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $reservation->user->name }}</td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0">{{ $reservation->time_reservation }} </p></td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $reservation->remarks }} </p></td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $reservation->status }} </p></td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $reservation->created_at }} 
                                                </p></td>
                                                <td class="align-middle text-end d-flex gap-2">
                                                    <form action="{{ route('reservations.verify', $reservation->id) }}" method="POST" >
                                                        @csrf
                                                        @method('POST')
                                                        <button class="btn btn-info">Verify</button>
                                                    </form>
                                                    <button class="btn btn-warning">Cancel</button>
                                                    <button class="btn btn-primary">Detail</button>
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

       
    </script>
@endsection