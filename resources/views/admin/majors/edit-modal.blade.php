<!-- resources/views/majors/edit-modal.blade.php -->
<div class="modal fade" id="editMajorsModal" tabindex="-1" role="dialog" aria-labelledby="editMajorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editMajorLabel">Edit Major</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="edit-major-form" action="">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="edit-major-code">Major Code</label>
              <input type="text" class="form-control" id="edit-major-code" name="code" required>
            </div>
            <div class="form-group">
              <label for="edit-major-name">Major Name</label>
              <input type="text" class="form-control" id="edit-major-name" name="name" required>
            </div>
            <div class="form-group">
              <label for="edit-koordinator">Coordinator</label>
              <select name="koordinator_id" class="form-control" id="edit-koordinator">
                  <option value="">-- Select Coordinator (Optional) --</option>
                  @foreach($koordinators as $koordinator)
                      <option value="{{ $koordinator->id }}">{{ $koordinator->name }}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="edit-classroom">Classroom</label>
              <select name="classroom_id" class="form-control" id="edit-classroom">
                  <option value="">-- Select Classroom (Optional) --</option>
                  @foreach($classrooms as $classroom)
                      <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                  @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
</div>

<script>
function editMajor(id) {
    $.ajax({
        url: '/majors/' + id + '/edit',
        type: 'GET',
        success: function(response) {
            // Fill the form with the existing major data
            $('#edit-major-code').val(response.major.code);
            $('#edit-major-name').val(response.major.name);
            $('#edit-koordinator').val(response.major.koordinator_id);
            $('#edit-classroom').val(response.major.classroom_id);

            // Set the action attribute for the form
            $('#edit-major-form').attr('action', '/majors/' + id);

            // Show the modal
            $('#editMajorsModal').modal('show');
        }
    });
}
</script>
