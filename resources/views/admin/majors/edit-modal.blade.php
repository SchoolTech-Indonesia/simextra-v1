<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Edit Major</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form id="editMajorForm">
                  <div class="form-group">
                      <label for="edit-major-name">Major Name</label>
                      <input type="text" id="edit-major-name" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <form>
                        <label for="classrooms">Classrooms:</label>
                        <input type="text" id="classrooms" name="classrooms" list="classrooms-list">
                        <datalist id="classrooms-list">
                          @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->name }}">{{ $classroom->name }}</option>
                          @endforeach
                        </datalist>
                      </form>
                </div>
                  <button type="submit" class="btn btn-primary">Save Changes</button>
              </form>
          </div>
      </div>
  </div>
</div>
<script>
    $(document).ready(function() {
      $('#classrooms').select2();
    });
  </script>