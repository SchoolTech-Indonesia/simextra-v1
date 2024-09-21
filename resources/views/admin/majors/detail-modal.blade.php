<!-- resources/views/majors/detail-modal.blade.php -->
<div class="modal fade" id="detailMajorsModal" tabindex="-1" role="dialog" aria-labelledby="detailMajorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailMajorLabel">Major Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="detail-major-code">Major Code</label>
              <p id="detail-major-code"></p>
          </div>
          <div class="form-group">
              <label for="detail-major-name">Major Name</label>
              <p id="detail-major-name"></p>
          </div>
          <div class="form-group">
              <label for="detail-major-koordinator">Coordinator</label>
              <p id="detail-major-koordinator"></p>
          </div>
          <div class="form-group">
              <label for="detail-major-classes">Class List</label>
              <p id="detail-major-classes"></p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
