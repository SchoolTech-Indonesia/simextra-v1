<!-- resources/views/modals/upload-photo-modal.blade.php -->

<div class="modal fade" id="uploadPhotoModal" tabindex="-1" role="dialog" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPhotoModalLabel">Upload Foto Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <div class="modal-body">
                <form id="uploadPhotoForm" method="POST" action="{{ route('profile.photo.upload') }}" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('POST') }} <!-- Ensure this is POST -->
                    <div class="form-group">
                        <label for="profile_photo">Pilih Foto</label>
                        <input type="file" id="profile_photo" name="profile_photo" class="form-control">
                    </div>
                </form>
                
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" form="uploadPhotoForm" class="btn btn-primary">Upload</button>
            </div> --}}
            <form id="uploadPhotoForm" method="POST" action="{{ route('profile.photo.upload') }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('POST') }}
                <div class="form-group">
                    <input type="file" id="profile_photo" name="profile_photo" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
            
        </div>
    </div>
</div>

<script>
// $(document).ready(function() {
//     $('#uploadPhotoForm').on('submit', function(e) {
//         e.preventDefault();

//         let formData = new FormData(this);

//         $.ajax({
//             type: 'POST', // Ensure POST is used here
//             url: '{{ route("profile.photo.upload") }}',
//             data: formData,
//             contentType: false,
//             processData: false,
//             success: function(response) {
//                 $('#uploadPhotoModal').modal('hide');
               
//                 // Refresh the current page
//                 location.reload();
//             },
//             error: function(response) {
//                 alert('Terjadi kesalahan saat mengupload foto.');
//             }
//         });
//     });
// });
// $('#upload-photo-form').submit(function(event) {
//     event.preventDefault(); // Prevent the default form submission

//     var formData = new FormData(this);

//     $.ajax({
//         url: '/profile/photo/upload',
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function(response) {
//             if (response.success) {
//                 // Optionally show success message
//                 alert(response.success);

//                 // Redirect to the specified URL
//                 window.location.href = response.redirect_url;
//             }
//         },
//         error: function(xhr) {
//             // Handle errors here
//             alert('An error occurred: ' + xhr.responseText);
//         }
//     });
// });

window.addEventListener('toaster', event => {
    Toastify({
      text: event.detail.message,
      duration: 3000,
      close: true,
      gravity: "top",
      position: "right",
    }).showToast();
  });
// </script>
