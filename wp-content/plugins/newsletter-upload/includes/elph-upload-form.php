<?php

// Set file location for AJAX to send form data
//$elph_upload_form_handler = 	plugins_url( 'elph_upload_form_handler.php', __FILE__ );
?>
<div class="container">
  <div class="row">
      <div class="col-md-12">
          <h1 class="flex">
              <svg class="bi bi-folder-symlink" width="2em" height="1.25em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.828 4a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 6.173 2H2.5a1 1 0 0 0-1 .981L1.546 4h-1L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3v1z"/>
                  <path fill-rule="evenodd" d="M13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4zM2.19 3A2 2 0 0 0 .198 5.181l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3H2.19z"/>
                  <path d="M8.616 10.24l3.182-1.969a.443.443 0 0 0 0-.742l-3.182-1.97c-.27-.166-.616.036-.616.372V6.7c-.857 0-3.429 0-4 4.8 1.429-2.7 4-2.4 4-2.4v.769c0 .336.346.538.616.371z"/>
              </svg>
              Upload PDF Newsletter For Delivery
          </h1>
          <form id="form" action= "" method="post" enctype="multipart/form-data">
              <input type="hidden" name="MAX_FILE_SIZE" value="10485760" required/>
              <input type="text" id="email" name="email" />
              <div class="row">
                  <div class="form-group col-sm-4">
                      <label for="month">Newsletter Month</label>
                      <select type="month" class="form-control" id="month" name="month" required>
                          <option value="" selected disabled>Please select</option>
                          <option>January</option>
                          <option>February</option>
                          <option>March</option>
                          <option>April</option>
                          <option>May</option>
                          <option>June</option>
                          <option>July</option>
                          <option>August</option>
                          <option>September</option>
                          <option>October</option>
                          <option>November</option>
                          <option>December</option>
                      </select>
                  </div>
                  <div class="form-group col-sm-4">
                      <label for="year">Newsletter Year</label>
                      <select type="number" class="form-control" id="year" name="year" required>
                          <option value="" selected disabled>Please select</option>
                          <option>2010</option>
                          <option>2011</option>
                          <option>2012</option>
                          <option>2013</option>
                          <option>2014</option>
                          <option>2015</option>
                          <option>2016</option>
                          <option>2017</option>
                          <option>2018</option>
                          <option>2019</option>
                          <option>2020</option>
                          <option>2021</option>
                      </select>
                  </div>
                      <label for="senddate">Schedule Send Date (optional)</label>
                  <div id="datepicker" class="form-group input-group date col-sm-4" data-date-orientation="bottom left">
                      <input type="text" class="form-control" name="senddate" placeholder="mm/dd/yyyy" style="border: solid 1px #ccc;" />
                      <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                  </div>
              </div>
              <input id="uploadPDFnews" type="file" accept="application/pdf" name="pdfnews" required />
              <div id="preview"><img src="http://localhost/elephino/wp-content/uploads/2022/04/pdf_transparent.png" width="80px"/></div><br> <!--SRC IS TEMP. MUST FIX -->
              <button id="cancel" class="btn btn-primary form-group input-group col-sm-2" type="text" name="cancel" value="">Cancel</button>
              <button id="overwrite" class="btn btn-primary form-group input-group col-sm-2" type="text" name="overwrite" value="">Overwrite</button>
              <input class="btn btn-success" id="upload" type="submit" value="Upload">
          </form>
          <div id="err"></div>
      </div>
  </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
 jQuery('#datepicker').datepicker({
    "format": "mm/dd/yyyy",
    "todayBtn": "linked",
    "daysOfWeekHighlighted": "0,6",
    "todayHighlight": true,
    "autoclose": true,
    "startDate": new Date()
 });
});
</script>