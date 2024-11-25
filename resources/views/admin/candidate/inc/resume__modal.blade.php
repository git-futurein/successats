<div class="modal fade" id="showResume" tabindex="-1" aria-labelledby="showResumeLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showResumeLabel">Candidate Resume</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="resumeFilePath">
          <iframe id="pdfViewer" style="width:100%;height:600px;"></iframe>
          <div id="noCVMessage" style="display: none; height: 600px;">
              <h4 class="text-danger text-center">No CV attached</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
