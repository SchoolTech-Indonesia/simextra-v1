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