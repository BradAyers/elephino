console.log("Help me.  I'm stuck in this cursed javascript!");

jQuery(document).ready(function($) {          //wrapper
    $("#upload").change(function() {                      //use in callback
        $.post(my_ajax_obj.ajax_url, {         //POST request
            _ajax_nonce: my_ajax_obj.nonce,     //nonce
            action: "elph_upload",            //action
            title: this.value                  //data
        }, function(data) {                    //callback
            $("#preview").html(data).fadeIn();              //insert server response
        });
    });
});


/*
("#upload").click(function() {

  var data = {
     'action'   : 'elph_upload_handler.php', // the name of your PHP function!
     'function' : 'pdf_upload',    // a random value we'd like to pass
     'fileid'   : '88'              // another random value we'd like to pass
     };

  jQuery.post(ajaxurl, data, function(response) {
     jQuery("#preview").html(response);
  });
});*/
