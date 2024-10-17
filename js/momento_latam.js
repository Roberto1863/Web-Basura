$(document).on('pageinit', '[data-role="page"]', function() {
    var $page = $(this);
    var productId = $page.data('product-id');
    console.log('Product ID:', productId);

    function getCommentsFromDatabase(productId) {
        console.log('Requesting comments for product ID:', productId);
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '../Php/Obt_Comen.php',
                method: 'GET',
                data: { productId: productId },
                dataType: 'json',
                success: function(data) {
                    console.log('AJAX success:', data);
                    resolve(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                    reject(errorThrown);
                }
            });
        });
    }

    function loadComments() {
        console.log('LoadComments called with productId:', productId);
        
        getCommentsFromDatabase(productId)
            .then(function(comments) {
                console.log('Received comments:', comments);
                
                var $commentsList = $('#comments-list');
                if ($commentsList.length === 0) {
                    console.error('Could not find #comments-list element.');
                    return;
                }
                
                $commentsList.empty();
                
                if (comments.length === 0) {
                    $commentsList.append('<tr><td colspan="3">No hay comentarios aún.</td></tr>');
                } else {
                    $.each(comments, function(i, comment) {
                        var commentHtml = '<tr>' +
                            '<td class="comment-author">' + (comment.author || 'Anónimo') + '</td>' +
                            '<td class="comment-date">' + (comment.date || 'Fecha desconocida') + '</td>' +
                            '<td class="comment-text">' + (comment.text || 'Sin texto') + '</td>' +
                            '</tr>';
                        $commentsList.append(commentHtml);
                    });
                }
            })
            .catch(function(error) {
                console.error('Error loading comments:', error);
                $('#comments-list').html('<tr><td colspan="3">Error al cargar comentarios.</td></tr>');
            });
    }

    loadComments();

    $page.on('submit', '#comment-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        var commentText = $form.find('#comment-text').val().trim();
        if (commentText) {                
                $.ajax({
                    url: '../Php/Agreg_Comen.php',
                    method: 'POST',
                    data: {
                        productId: productId,
                        text: commentText
                    },
                    dataType: 'json'
                })
                .done(function(response) {
                    console.log("Respuesta del servidor:", response);
                    if (response.success) {
                        loadComments(); // Cargar los comentarios de nuevo
                        $form.find('#comment-text').val().trim(); // Limpiar el campo de texto
                    } else {
                        console.error("Error del servidor:", response.error);
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                });
            } else {
                console.error("No se ingresó ningún texto en el comentario.");
            }
            return false;
        });
    
    
       

    $('#like-button').on('click', function() {
        $(this).addClass('ui-btn-active');
        alert('¡Gracias por tu "Me gusta"!');
    });

    $('#buy-button').on('click', function() {
        alert('Redirigiendo al proceso de compra...');
    });
});