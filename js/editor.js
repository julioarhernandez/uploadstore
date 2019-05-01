$(function () {

    $('#crop-select').CropSelectJs({
        imageSrc: $('#crop-select').attr('data-src'),
        // Stub events
        selectionResize: function (e, a) {
            $('#crop-w').val(e.widthScaledToImage);
            $('#crop-h').val(e.heightScaledToImage);
        },
        selectionMove: function (e) {
            $('#crop-x').val(e.xScaledToImage);
            $('#crop-y').val(e.yScaledToImage);
        }
    });

    //
      // Aspect Ratio Buttons
      //

    var caman = Caman('#editImage');

    var rotation = 0;

    function applyFilters() {
        caman.revert(false);

        $('.slider').each(function () {
            var op = $(this).attr('id');
            var value = $(this).data('val');

            if (value === 0) {
                return;
            }

            caman[op](value);
        });
    }

    function resetFilters() {
        $('.slider').each(function () {
            var op = $(this).attr('id');
            $('#' + op).slider('option', 'value', $(this).attr('data-val'));
        });
    }

    $('.slider').each(function () {
        var op = $(this).attr('id');

        $('#' + op).slider({
            min: $(this).data('min'),
            max: $(this).data('max'),
            val: $(this).data('val'),
            change: function (e, ui) {
                $('#v-' + op).html(ui.value);
                $(this).data('val', ui.value);

                if (e.originalEvent === undefined) {
                    return;
                }

                applyFilters();
                caman.render();
            }
        });
    });

    $('.preset').click(function () {
        // resetFilters();
        var preset = $(this).data('preset');
        $('.preset').removeClass('active');
        $(this).addClass('active');
        caman.revert(true);
        caman[preset]();
        caman.render();
    });

    $('#reset').click(function () {
        caman.reset();
        caman.render();
        resetFilters();
        // $('#crop-select').removeClass('d-none');
    });

    $('#save').click(function () {
        caman.render(function () {
            var image = this.toBase64();
            // saveToServer(image); // your ajax function

            /**
             * var image - thows out the image data blob - can save to database
             */
        });
    });


    // ENABLE CROP
    $('#enable-crop').on('click', function () {
        $('#crop-select').toggleClass('hidden-now');
     })


    $('#crop').click(function () {
        caman.reset();
        caman.crop(
            $('#crop-w').val(),
            $('#crop-h').val(),
            $('#crop-x').val(),
            $('#crop-y').val()
        );
        applyFilters();
        caman.render();
        $('#crop-select').addClass('hidden-now')
    });


});
