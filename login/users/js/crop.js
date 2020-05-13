
$(function(){

    var url     = $("#url").text();
    var url2    = $("#url2").text();
    var w       = $("#width").text();
    var h       = $("#height").text();
    var b       = $("#npacce").text();

    // var caminho = $("#caminho").text();

    function crop(){
        jQuery(".thumb-image").cropper('getCroppedCanvas').toBlob(function(blob){

            var image_holder = $("#img_save");
            image_holder.empty();
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onload = function (e) {
                 $('<img />', {
                    "src": e.target.result,
                    "class": "img_show",
                    "id": "img_show"
                }).appendTo(image_holder);
            }
            image_holder.show();
            $('#img_save').css('visible', '0');
            var formData = new FormData();
                formData.append('croppedImage', blob);
                formData.append('npacce', b);
            $('#window-crop').click();
            $("#preload").addClass('preload');
          // // Use `jQuery.ajax` method
          $.ajax(url+'ajax/carregar-imagem.php', {
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success(data) {
              if (data == 'success') {
                window.location=url2+'/meu-perfil';
              }else{
                if (alert('Ocorreu um erro! Entre em contato com o desenvolvedor do sistema.')) {

                }
              }
            },
            error() {
              console.log('Upload error');
            }
          });

        });

    }


    function openCrop(e){
        jQuery(e).cropper({
            aspectRatio: w / h,
            autoCropArea: 0,
            strict: false,
            guides: false,
            highlight: false,
            dragCrop: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            minCropBoxWidth: w,
            minCropBoxHeight: h
        });
    }

    $("#crop").click(function(event) {
        crop();
    });

    $('body').on('change', '#imagem', function(event) {
        if (typeof (FileReader) != "undefined") {
            var image_holder = $("#image-holder");
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                 $('<img />', {
                    "src": e.target.result,
                    "class": "thumb-image"
                }).appendTo(image_holder);
                image_holder.show();

                $('#callCrop').click();
                
                $('#window-crop').on('shown.bs.modal', function (e) {
                    openCrop('.thumb-image');
                     $('body .modal-backdrop').remove();
                });
            }
            reader.readAsDataURL($(this)[0].files[0]);
        }else{
            alert("Este navegador nao suporta FileReader.");
        }
    });

    $('#window-crop').on('hidden.bs.modal', function (e) {
        $('#imagem').val('');
        $("#image-holder").html('');
    });

});
