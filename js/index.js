$(function () {

      var img_id;
      var img_type;

      $(".size-previews").click(function(){
        var size = $(this).data("size");
        $(".variations_form.cart").find("[name='attribute_pa_size'][value='"+size.toLowerCase()+"']").click();
      });

      var img_url;
      $('#mainImage').bind('fileuploadprogress', function (e, data) {
        // Log the current bitrate for this upload:
        console.log(data.bitrate);
        var progress = parseInt(data.loaded / data.total * 100, 10);
        console.log(progress)
        $('#progress .bar').css(
            'width',
            progress + '%'
        );
    });



      $('#mainImage').fileupload({
        url: ajax_object.ajax_url,
        //dataType: 'json',
        dataType: 'text',
        processData: false,
        forceIframeTransport: true,
        formData: $('#uploadForm').serializeArray(),
        submit: function(e, input){
        //console.log(input)
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                $('#uploader-loader').addClass('uploading-show');
                //upload(input.files[0]);
                reader.readAsDataURL(input.files[0]);
                reader.onload = function (e) {
                    $('#uploader-loader img').attr('src', e.target.result);
                    // Set input hidden field images values
                    $('.imageWidth').val($('#uploader-loader img')[0].naturalWidth);
                    $('.imageHeight').val($('#uploader-loader img')[0].naturalHeight);
                }
            }
            var overallProgress = $('#mainImage').fileupload('progress');
            console.log(overallProgress)
      },
      progressall: function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        console.log(progress)
        $('#progress .bar').css(
            'width',
            progress + '%'
        );
    },
      //dropZone : $("#mainDropZone"),
      dragover: function(e){
        $('#dragOverlay').addClass('showUp');
      },
      done: function (e, data) {
        var formVal = data && data.result;
        formVal = formVal.replace('Array', '');
        formVal = JSON.parse(formVal);
        if (formVal.success) {
              var original = formVal.data.original;
              var thumbnail = formVal.data.thumbnail;
              img_id = formVal.data.id;
              img_type = formVal.data.type;
              $("[name=cart-uploaded-image]").val(original);
              if(img_type == "landscape"){
                $(".bc-main-container").removeClass("type-portrait");
                $(".bc-main-container").addClass("type-landscape");
              } else {
                $(".bc-main-container").removeClass("type-landscape");
                $(".bc-main-container").addClass("type-portrait");
              }
              $("#editImage, .upload-image-adjust-preview").attr("src", thumbnail);
              $(".img-crop-preview").attr("src", original);
              $("#crop-select").attr("data-src", original);
              $('#uploader-loader').removeClass('uploading-show');

              $(".size-previews").each(function(){
                var size = $(this).data("size").toLowerCase();
                $(this).find("img").attr("src", "/?uploadpreview&upid="+img_id+"&uptype="+size);
              });

              $(".upload-section-upload").stop().fadeOut(function () {
                $(".upload-section-size").stop().fadeIn();
                $(".upload-tabs").removeClass("active");
                $(".upload-tab-size").addClass("active");
              });
          }
          $('#uploader-loader').removeClass('uploading-show');
        }
      });



        // function loadEditor() {

        //     if ($('.crop-select-js').length === 0) {
        //         $('#crop-select').CropSelectJs({
        //             imageSrc: $('#crop-select').attr('data-src'),
        //             // Stub events
        //             selectionResize: function (e, a) {
        //                 $('#crop-w').val(e.widthScaledToImage);
        //                 $('#crop-h').val(e.heightScaledToImage);
        //             },
        //             selectionMove: function (e) {
        //                 $('#crop-x').val(e.xScaledToImage);
        //                 $('#crop-y').val(e.yScaledToImage);
        //             }
        //         });
        //     }

        //     //
        //     // Aspect Ratio Buttons
        //     //

        //    var caman = Caman('#editImage');

        //     var applyFilters = function () {
        //         caman.revert(false);
        //         $('#photoFilters .slider').each(function () {
        //             var op = $(this).attr('id');
        //             var value = $(this).attr('data-val');
        //             if (value === 0) {
        //                 return;
        //             }
        //             caman[op](value);
        //         });
        //     }

        //     var resetFilters = function() {
        //         $('#photoFilters .slider').each(function () {
        //             var op = $(this).attr('id');
        //             $('#' + op).slider('option', 'value', $(this).attr('data-val'));
        //         });
        //     }

        //     $('.preset').click(function () {
        //         // resetFilters();
        //         var preset = $(this).attr('data-preset');
        //         $('.preset').removeClass('active');
        //         $(this).addClass('active');
        //         caman.revert(true);
        //         caman[preset]();
        //         caman.render();
        //     });

        //     $('#reset').click(function () {
        //         caman.reset();
        //         caman.render();
        //         resetFilters();
        //         // $('#crop-select').removeClass('d-none');
        //     });

        //     $('#save').click( function () {
        //         caman.render(function () {
        //             var image = this.toBase64();
        //             // saveToServer(image); // your ajax function
        //             // save edited

        //             //$('.upload-image-adjust-preview').attr('src', image)

        //             /**
        //              * var image - thows out the image data blob - can save to database
        //              */
        //         });
        //     });


        //     // ENABLE CROP
        //     $('#enable-crop').click(function () {
        //         $('#crop-select').toggleClass('hidden-now');
        //     })


        //     $('#crop').click(function () {
        //             caman.reset();
        //             caman.revert();
        //             caman.render();
        //             caman.crop(
        //                 $('#crop-w').val(),
        //                 $('#crop-h').val(),
        //                 $('#crop-x').val(),
        //                 $('#crop-y').val()
        //             );
        //             applyFilters();
        //             caman.render();
        //             $('#crop-select').addClass('hidden-now')
        //     });



        //     $('#photoFilters .slider').each(function () {

        //         var op = $(this).attr('id');

        //         $('#' + op).slider({
        //             min: $(this).data('min'),
        //             max: $(this).data('max'),
        //             val: $(this).data('val'),
        //             change: function (e, ui) {
        //                 $('#v-' + op).html(ui.value);
        //                 $(this).attr('data-val', ui.value);

        //                 if (e.originalEvent === undefined) {
        //                     return;
        //                 }

        //                 applyFilters();
        //                 caman.render();
        //             }
        //         });
        //     });

        // }
        
       

        $('#fileupload').on('dragleave', function (e) {
          $('#dragOverlay').removeClass('showUp');
        });

        $("#ed_wc_pa_size .ed__variation__button__wrp").click(function () {
            var size = $(this).text();
            $(".size-previews").removeClass("active");
            $(".size-previews[data-size='" + size + "']").addClass("active");
        });

        $(".next-adjust").click(function () {
            $(".upload-section").stop().fadeOut(function () {
                $(".upload-section-size").stop().fadeIn();
                $(".upload-tabs").removeClass("active");
                $(".upload-tab-size").addClass("active");
            });
        });

        // $(".upload-edit-photo").click(function () {
        //     $(".upload-section").stop().fadeOut(function () {
        //         $(".upload-tabs").removeClass("active");
        //         $(".upload-tab-adjust").addClass("active");
        //         $(".upload-section-edit").stop().fadeIn();
        //         loadEditor();
        //     });
        // });

        // $(".upload-edit-save").click(function () {
        //     $(".upload-section").stop().fadeOut(function () {
        //         $(".upload-section-adjust").stop().fadeIn();
        //     });
        // });

        $(".upload-tab-upload").click(function () {
            $(".upload-section").stop().fadeOut(function () {
                $(".upload-tabs").removeClass("active");
                $(".upload-tab-upload").addClass("active");
                $(".upload-section-upload").stop().fadeIn();
            });
        });

        $(".upload-tab-adjust").click(function () {
            if ($(".upload-tab-size.active").length) {
                $(".upload-section").stop().fadeOut(function () {
                    $(".upload-tabs").removeClass("active");
                    $(".upload-tab-adjust").addClass("active");
                    $(".upload-section-adjust").stop().fadeIn();
                });
            }
        });

        // ON IMAGE CHOOSE
        /*
        $('#mainImage').on('change', function (e) {
            readURL(this);
        });



        var dropZone = $('body');

        dropZone.on('dragover', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('#dragOverlay').addClass('showUp')
            return false;
        });

        dropZone.on('dragend', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('#dragOverlay').removeClass('showUp');
        });

        dropZone.on('drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (e.originalEvent.dataTransfer.files && e.originalEvent.dataTransfer.files[0]) {
                readURL(e.originalEvent.dataTransfer);
            }
            $('#dragOverlay').removeClass('showUp');
        });
        */



        // SELECT SIZES
        $('.price-boxes .is-selectable').on('click', function () {
            var item = $(this).attr('data-target');
            $('.is-selectable').removeClass('active');
            $(this).addClass('active');
            $('.' + item).addClass('active');
            var price = $('.' + item).find('.price').text();
            var size = $('.' + item).find('.size').text();

            $('#price').val(price);
            $('#size').val(size);
        });

        // QUANTITY ADD
        $('.quantity .add').on('click', function () {
            var value = parseInt($('#quantity').val());
            $('#quantity').val(value + 1);
        });

        // QUANTITY MINUS
        $('.quantity .minus').on('click', function () {
            var value = parseInt($('#quantity').val());
            if (value > 1) {
                $('#quantity').val(value - 1);
            }
        })




    });
