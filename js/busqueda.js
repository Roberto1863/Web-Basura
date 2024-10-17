$(document).on('pageinit', '#search-XD', function() {
    var products = [
        { name: 'Pantalones', category: 'Ropa', url: 'http://localhost/App%20Basura/Busqueda/Pantalones.html' },
        { name: 'Vestidos', category: 'Ropa', url: 'http://localhost/App%20Basura/Busqueda/Vestidos.html' },
        { name: 'Camisas y Tops', category: 'Ropa', url: 'http://localhost/App%20Basura/Busqueda/Camisas%20y%20Tops.html' },
        { name: 'Faldas', category: 'Ropa', url: 'http://localhost/App%20Basura/Busqueda/Faldas.html' },
        { name: 'Shorts', category: 'Ropa', url: 'http://localhost/App%20Basura/Busqueda/Shorts.html' },
        { name: 'Calcetines', category: 'Accesorios', url: 'http://localhost/App%20Basura/Busqueda/Calcetines.html' }
    ];

    $('#search').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        var results = $.grep(products, function(product) {
            return product.name.toLowerCase().indexOf(searchTerm) !== -1 || 
                   product.category.toLowerCase().indexOf(searchTerm) !== -1;
        });

        var $searchResults = $('#searchResults');
        $searchResults.empty();

        if (searchTerm.length > 0 && results.length > 0) {
            $.each(results, function(i, product) {
                $searchResults.append('<li><a href="' + product.url + '">' + product.name + ' - ' + product.category + '</a></li>');
            });
            $searchResults.listview('refresh').show();
        } else {
            $searchResults.hide();
        }
    });

    $(document).on('tap', function(e) {
        if (!$(e.target).closest('.search-container').length) {
            $('#searchResults').hide();
        }
    });
});