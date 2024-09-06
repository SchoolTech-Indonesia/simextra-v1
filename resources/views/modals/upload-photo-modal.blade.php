<!-- resources/views/modals/upload-photo-modal.blade.php -->

@csrf_field
<div class="modal fade" id="uploadPhotoModal" tabindex="-1" role="dialog" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPhotoModalLabel">Upload Foto Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#uploadPhotoForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            type: 'POST', // Ensure POST is used here
            url: '{{ route("profile.photo.upload") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#uploadPhotoModal').modal('hide');
                alert('Foto profil berhasil diupload.');
                $('#profile-photo-display').attr('src', response.photo_url);
            },
            error: function(response) {
                alert('Terjadi kesalahan saat mengupload foto.');
            }
        });
    });
});
    
</script>
