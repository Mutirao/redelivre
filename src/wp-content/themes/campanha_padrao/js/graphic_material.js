(function($){
    $(document).ready(function() {
        // update image preview whenever a value is changed
        $('#graphic_material_form :input:not(:hidden)').each(function() {
            $(this).change(function() {
                updatePreview();
            });
        });
        
        $('#graphic_material_form :input.mColorPicker').each(function() {
            $(this).bind('colorpicked', function () {
                updatePreview();
            });
        })
        
        $('#save-position').click(function() {
            updatePreview();
        });
    });
    
    function updatePreview() {
        $("body").css("cursor", "wait");
        $.ajax({
            url: ajaxurl,
            type: 'get',
            data: $('#graphic_material_form').serialize(),
            success: function(data) {
                $('#graphic_material_preview').html('<h3>Pré-visualização</h3>' + data);
                $("body").css("cursor", "auto");
            } 
        });
    }
})(jQuery);