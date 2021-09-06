var url = 'http://127.0.0.1:8000';
window.addEventListener("load", function () {

    $(".btn-like").css("cursor", "pointer");
    $(".btn-dislike").css("cursor", "pointer");

    // Dislike
    $(document).on("click", ".btn-like", function (e) {
        $(this).addClass("btn-dislike").removeClass("btn-like");
        $(this).attr("src", url+"/icons/hearts-gray.png"); // Concatenar url para que las imagenes las saque de la raiz del servidor

        $.ajax({
            url: url+'/dislike/'+$(this).data('id'), // This para acceder al elemento al cual le he dado click, data('id') me extrae el id que está guardado en ese atributo
            type: 'GET',
            success: function (response) {
                if(response.like) {
                    console.log('has dado dislike a la publicacion');

                }else {
                    console.log('Error al dar like')
                }
            }
        });
    });

    // Like
    $(document).on("click", ".btn-dislike", function (e) {
        $(this).addClass("btn-like").removeClass("btn-dislike");
        $(this).attr("src",  url+"/icons/hearts-red.png");

        $.ajax({
            url: url+'/like/'+$(this).data('id'), // This para acceder al elemento al cual le he dado click, data('id') me extrae el id que está guardado en ese atributo
            type: 'GET',
            success: function (response) {
                if(response.like) { // Si existe el objeto like muestro por consola el siguiente mensaje.
                    console.log('has dado like a la publicacion');

                }else {
                    console.log('Error al dar like')
                }
            }
        });
    });
});
