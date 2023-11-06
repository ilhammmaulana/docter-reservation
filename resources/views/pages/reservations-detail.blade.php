@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4 px-4">
                <div class="card-header pb-0">
                    <h4>Reservations</h4>
                </div>
                <div class="card-body px-0 pt-0 pb-2 row">
                  <div class="col-md-6">
                    <h6>Detail User</h6>
                    <p>Name : {{ $reservation->user->name }}</p>
                    <p>Keluhan : {{ $reservation->remarks }}</p>
                    <p>Jam reservasi : {{ $reservation->time_reservation }}</p>
                  </div>
                  <div class="col-md-6">
                    <h6>Detail Reservation</h6>
                    <p>Status reservation : {{ $reservation->status }}</p>
                    <p>Nomer antrian : {{ $reservation->queue_number !== null ? $reservation->queue_number : "Belum mendapatkan" }}</p>
                    @if($reservation->status === 'cancel')
                    <p>Remark cancel : {{ $reservation->remark_cancel }}</p>
                    @endif
                    @if($reservation->status === 'done')
                    <p>Done at : {{ $reservation->done_at }}</p>
                    @endif
                    @if($reservation->status === 'done')
                    <p>Done at : {{ $reservation->done_at }}</p>
                    @endif
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
