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
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    <img src="{{ $reservation->user->photo !== null ? url($reservation->user->photo) : asset('assets/img/default.png') }}"
                                                        class="avatar me-3" alt="photo">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $reservation->user->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
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
                                                    @if($reservation->status === 'hold')
                                                    <form action="{{ route('reservations.verify', $reservation->id) }}" method="POST" >
                                                        @csrf
                                                        @method('POST')
                                                        <button class="btn btn-info">Verify</button>
                                                    </form>
                                                    <button class="btn btn-warning"    data-bs-toggle="modal" data-bs-target="#reservation-cancel-{{ $reservation->id}}" >Cancel</button>
        <div class="modal fade" id="reservation-cancel-{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalUser"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalUser">Remark cancel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST">                                    
                                    @csrf
                                    @method('POST')
                                    <div class="form-group">
                                        <textarea name="remark-cancel" class="form-control" placeholder="Min 5 max 1000" id="remarks-cancel" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn bg-gradient-primary">Cancel</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>                                                               
                                                    @endif
                                                    @if($reservation->status === 'verify')
                                                    <form action="{{ route('reservations.arrived', $reservation->id) }}" method="POST" >
                                                        @csrf
                                                        @method('POST')
                                                        <button class="btn btn-info">Arrived</button>
                                                    </form>
                                                    @endif
                                                    @if($reservation->status === 'arrived')
                                                    <form action="{{ route('reservations.done' , $reservation->id) }}" method="POST" >
                                                        @csrf
                                                        @method('POST')
                                                        <button class="btn btn-success">Done this reservation</button>
                                                    </form>
                                                    @endif
                                                  
                                                    
                                                    <a href="{{ route('reservations.show', $reservation->id) }}">
                                                        <button class="btn btn-secondary">Detail</button>
                                                    </a>
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
