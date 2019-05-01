
<div class="bc-container col-md-10 py-4 upload-section upload-section-upload">
  <p class="title h2 weight-700 text-center text-secondary mb-0">Let's get started. First let's upload a photo.</p>
  <p class="text-center h5">Find the perfect photo. If the print doesn't come out the way you like then we'll reprint it for you.</p>



  <!-- MAIN DROP ZONE -->
  <form action="" enctype="multipart/form-data" id="uploadForm">
    <input type="hidden" name="action" value="upload_preview" />
    <input type="hidden" name="nonce" value="<?= wp_create_nonce('preview_image') ?>" />
      <div class="row mt-5">

          <!-- FIRST COL -->
          <div class="col-md-12">
              <div id="mainDropZone" class="flex-center-center">
                  <div class="info flex-center-center flex-column">
                      <i class="fa fa-cloud-download fa-4x mb-0 text-primary"></i>
                      <p class="m-0 text-gray">Choose a file or drag it here</p>
                  </div>

                  <!-- INPUT -->
                  <input type="file" name="image" id="mainImage" accept="image/*">

                  <!-- PREVIEW -->
                  <img id="previewImg">
              </div>
          </div>

          <!-- SECOND COL -->
          <div class="col-md-12">
              <div id="mainDropZoneButton" class="flex fj-center fa-start flex-column">
                  <label for="mainImage" class="btn-primary btn-lg">Upload From Folder</label>
                  <button type="button" class="btn-light h5 mt-1 modal-open" data-modal="faqModal">I need
                                help Uploading...</button>
              </div>
          </div>


          <!-- ON DRAG OVERLAY -->
          <div id="dragOverlay" class="flex-center-center flex-column">

              <i class="fa fa-image fa-4x text-muted mb-2"></i>
              <h1 class="uppercase text-muted">Drop Here</h1>

          </div>
  </form>
</div>
</div>

<div id="uploader-loader">
    <div class="img text-center">
        <img alt="">
        <p class="text-white mt-2 weight-600 h4">Uploading...</p>
    </div>
</div>

<div class="modal" id="faqModal">
    <div class="modal-container modal-md b-none">
        <!-- HEADER -->
        <div class="modal-header">
            <div class="modal-title weight-600">Why won't my photo upload?</div>
            <div class="modal-close" data-modal="faqModal">
                <i class="fa fa-close"></i>
            </div>
        </div>

        <!-- CONTENT -->
        <article id="fullArticle" class=" px-4">
            <h3 class="title"></h3>
            <h5>Here are some things to check if you're having trouble uploading a photo:&nbsp;</h5>

            <ol>
                <li class="pb-1">We accept the following file types:&nbsp;<strong>.jpg </strong>or&nbsp;<strong>.png</strong>.&nbsp;If
                    your file is not in one of these formats, you'll want to convert it using a photo-editing
                    software or free file conversion website.</li>

                <li class="pb-1">Our site can process photo files between <b style="background-color: initial;">1-35
                        MB</b>. If your image is any larger than 35 MB, you’ll need to re-save it at a smaller size prior to
                    uploading.</li>

                <li class="pb-1">If your file type and size match the requirements above, try refreshing your page
                    or trying the upload from another web browser.</li>

                <li class="pb-1">Some adblockers can interfere with uploads; try temporarily disabling or switching
                    off your adblockers and then uploading again.</li>

                <li class="pb-1">When uploading from a mobile device or tablet, make sure&nbsp;<strong>Private
                        Browsing</strong>&nbsp;mode is turned off on your device. Private Browsing will sometimes
                    prevent a photo from uploading correctly.</li>
            </ol>

            <p> When your photo has been successfully uploaded, you'll be redirected to the size selection page.</p>


            <p> If you need help placing your order after your photo is uploaded, contact us and we will be happy to assist you.</p>

            <p class="text-center mb-3"><img width="380" src="https://apggraphics.com/wp-content/uploads/2018/01/logo.png" /></p>
            <p>&nbsp;</p>

        </article>
    </div>
</div>
