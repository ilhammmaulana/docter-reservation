@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit docter'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img id="imagePreview" src="{{ $docter->photo === null ? asset('assets/img/default.png') : url($docter->photo) }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ $docter->name }}
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
                    <form role="form" method="POST" action={{ route('docters.update', $docter->id) }} enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Profile</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Docter Information</p>
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
                                            <input  class="form-control" type="text" name="name" value="{{ $docter->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="{{ $docter->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-control-label">Phone</label>
                                        <input class="form-control" id="phone" value="{{ $docter->phone }}" type="text"  name="phone">
                                    </div>
                                </div>
                            </div>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_docter_id" class="h6">Category Docter</label>
                                    <select required name="category_docter_id" class="form-control"
                                        id="category_docter_id">
                                        <option value="Category Docter" disabled selected>Pilih Category Docter</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $docter->category_docter_id === $category->id ? 'selected': '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Address</label>
                                        <input class="form-control" value="{{ $docter->address }}" type="text" name="address"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="subdistrict_id" class="h6">Kecamatan</label>
                                            <select required name="subdistrict_id" class="form-control"
                                                id="subdistrict_id">
                                                <option value="Kecamatan" disabled selected>Pilih Kecamatan</option>
                                                @foreach ($subdistricts as $subdistrict)
                                                <option value="{{ $subdistrict->id }}" {{ $docter->subdistrict_id === $subdistrict->id ? 'selected': '' }}>
                                                    {{ $subdistrict->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="form-control-label">Your Docter Description</label>
                                        <textarea class="form-control" id="description" name="description" id="" cols="30" rows="10">{{ $docter->description }}</textarea>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card px-4 py-2">
                    @php
                    $totalCanUploud = (3 - count($docter->images)) < 0 ? 0 : 3 - count($docter->images)  ;   
                   @endphp
                   @if($totalCanUploud !== 0 && count($docter->images) < 3)
                   <form action="{{ route('docter-images.store') }}" id="form-input-images" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $docter->id }}" name="docter_id">
                    <div class="form-group">
                        <label for="multiple-images">Upload Images</label>
                        <input class="form-control" type="file" id="multiple-images" max="1"  placeholder="Max 3 Images" multiple name="images[]" onchange="previewImages()">
                      
                    </div>
                    <button type="submit" class="btn btn-primary">Save Images</button>
                </form>
                   <p class="ms-1">
                       * You can uploud <span class="text-success">{{ 3 - count($docter->images) }} more 
                   </span> 
                   </p>
                   @else
                       <p class="text-danger">Can't uploud photo maximal 3</p>
                   @endif
                    
                    <table id="image-preview-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Preview</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="card px-4 py-2 mt-5">
                    <h5 class="my-2 mb-4">Images docter</h5>
                    <table class="tablex">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($docter->images as $item)
                            <tr>
                                <td>
                                    <img style="max-width: 100px" src="{{ url($item['image']) }}" alt="{{ $item['id'] }}">
                                </td>
                                <td>
                                    <form action="{{ route('docter-images.destroy', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                const imagePreview = document.getElementById('imagePreview');
              const editImagePreview = document.getElementById('editImagePreview');
              const maxPreviewCount =  {{ $totalCanUploud }};

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
  const input = document.getElementById('multiple-images');

  const files = input.files;

  if (files.length > maxPreviewCount) {
      alert("You have selected more images than the allowed maximum of 3");
      input.value = ''; 
      return false; // Prevent the form submission
  }

  
  previewBody.innerHTML = '';

  for (let i = 0; i < files.length; i++) {
      const file = files[i];
      if (i >= maxPreviewCount) {
          break; // Only preview up to the allowed maximum
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
