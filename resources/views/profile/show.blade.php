@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row ">
        <!-- Profile Title Card -->
        <div class="col-md-12 mb-4">
            <div class="card" style="position: relative; top: -50px; z-index: 1;">
                <div class="card-body text-center">
                    <h1 style="font-size: 40px;">{{ __('Profile') }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-1" style="position: relative; top: -100px; z-index: 1;">
            @if(Auth::user()->role->name == 'Super Admin')
                <div class="alert alert-info">
                    <strong>Hi, Superadmin!</strong> Change the information about yourself on this page.
                </div>
            @elseif(Auth::user()->role->name == 'Admin')
                <div class="alert alert-info">
                    <strong>Hi, Admin!</strong> Change the information about yourself on this page.
                </div>
            @elseif(Auth::user()->role->name == 'Coordinator')
                <div class="alert alert-info">
                    <strong>Hi, Coordinator!</strong> Change the information about yourself on this page.
                </div>
            @elseif(Auth::user()->role->name == 'Student')
                <div class="alert alert-info">
                    <strong>Hi, Student!</strong> Change the information about yourself on this page.
                </div>
            @endif
        </div>
        <!-- Informasi Pribadi Card -->
        <div class="col-12 mb-4" style="margin-top: -20px">
            <div class="card">
                <div class="card-header text-center"></div>
                <div class="card-body position-relative">
                    <!-- Display Profile Picture -->
                    <div class="text-center position-absolute" style="top: -150px; left: 50%; transform: translateX(-50%);">
                        <div id="profile-photo-container" class="position-relative" style="width: 150px; height: 150px;">
                            <!-- Profile Photo -->
                            <img id="profile-photo-display" 
                                 src="{{ Auth::user()->profile_photo_path ? asset(Auth::user()->profile_photo_path) : 'https://freesvg.org/img/abstract-user-flat-4.png' }}" 
                                 alt="Profile Picture"
                                 class="rounded-circle border border-white" 
                                 width="150" 
                                 height="150"
                                 style="cursor: {{ Auth::user()->profile_photo_path && Auth::user()->profile_photo_path !== 'https://freesvg.org/img/abstract-user-flat-4.png' ? 'pointer' : 'default' }}; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);"
                                 onclick="{{ Auth::user()->profile_photo_path && Auth::user()->profile_photo_path !== 'https://freesvg.org/img/abstract-user-flat-4.png' ? 'confirmRemoveProfilePhoto()' : '' }}">
                            <!-- Remove icon overlay (optional for better UX) -->
                            @if(Auth::user()->profile_photo_path !== 'https://freesvg.org/img/abstract-user-flat-4.png')
                                <div class="position-absolute" style="top: 0; right: 0; width: 30px; height: 30px; background: rgba(0, 0, 0, 0.5); border-radius: 50%;">
                                    <i class="fa fa-times text-white" style="line-height: 30px;"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Button to Open Modal for Photo Upload -->
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadPhotoModal">
                            Upload Foto Profil
                        </button>
                    </div>
                    <div class="text-center ml-1 mt-2 pt-5 mb-5">
                        <h5 style="font-size: 16px; color: #6777ef">{{ __('Informasi Pribadi') }}</h5>
                    </div>
                    <!-- Display Profile Information in 2x2 Grid -->
                    <div class="row ml-3 mt-2 pt-2">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <h5><strong>Nama</strong></h5>
                                <p>{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <h5><strong>Email</strong></h5>
                                <p>{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <h5><strong>Peran</strong></h5>
                                <p>{{ Auth::user()->role->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <div class="card">
                                <h5><strong>NISN/NIP</strong></h5>
                                <p>{{ Auth::user()->NISN_NIP }}</p>
                            </div>
                        </div>

                        <!-- Additional Information Based on Role -->
                        @if(Auth::user()->role->name == 'Super Admin')
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Sekolah yang Ditugaskan</strong></h5>
                                    <p>Semua Sekolah</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Hak Akses</strong></h5>
                                    <p>Akses penuh ke seluruh sistem</p>
                                </div>
                            </div>
                        @elseif(Auth::user()->role->name == 'Admin')
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Sekolah yang Ditugaskan</strong></h5>
                                    <p>Springfield Elementary</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Hak Akses</strong></h5>
                                    <p>Manajemen sekolah dan guru</p>
                                </div>
                            </div>
                        @elseif(Auth::user()->role->name == 'Coordinator')
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Ekstrakurikuler</strong></h5>
                                    <p>Basket</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Sekolah</strong></h5>
                                    <p>Springfield Elementary</p>
                                </div>
                            </div>
                        @elseif(Auth::user()->role->name == 'Student')
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Kelas</strong></h5>
                                    <p>10-A</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Jurusan</strong></h5>
                                    <p>IPA</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <h5><strong>Ekstrakurikuler</strong></h5>
                                    <p>Badminton</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <!-- Edit Profile Card -->
                <div class="col-md-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5>Edit Profile</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update', Auth::user()->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Nama:</label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password Baru:</label>
                                    <input type="password" class="form-control" name="new_password">
                                    <small class="form-text text-muted">*Kosongkan jika tidak ingin mengganti password.</small>
                                </div>
                                <button type="submit" class="btn btn-success" id="updateProfileBtn">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert Confirmation Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.getElementById('updateProfileBtn').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Show SweetAlert confirmation
        Swal.fire({
            title: 'Yakin ingin menyimpan perubahan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                e.target.closest('form').submit();
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Profile berhasil diperbarui.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    function confirmRemoveProfilePhoto() {
        Swal.fire({
            title: 'Hapus Foto Profil?',
            text: "Foto profil Anda akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call the delete photo function
                deleteProfilePhoto();
            }
        });
    }

    function deleteProfilePhoto() {
        // Perform the delete operation (e.g., AJAX request)
        // This is just a placeholder for your delete logic
        Swal.fire({
            title: 'Foto Profil Dihapus!',
            text: 'Foto profil Anda telah dihapus.',
            icon: 'success'
        });
        // Optionally, reload the page or update the UI to reflect the change
        location.reload();
    }
</script>

@endsection
