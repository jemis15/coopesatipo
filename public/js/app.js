$('input[type="checkbox"]').on('change', function () {
    if ($(this).is(':checked')) {
        // Hacer algo si el checkbox ha sido seleccionado

        
        var objec = $(this);

        if ($('#db_tabla').val() == 'fundo') {
            $.ajax({
                method: "POST",
                url: "/ajax/checked.php",
                data: {
                    fundo_id: $('#fundo_id').val(),
                    clave: $(this).prop('name'),
                    valor: $(this).val() 
                }
            })
            .done(function (msg) {
                var json = JSON.parse(msg);
                objec.attr('id', json.item_id);
            })
    
        }else if ($('#db_tabla').val() == 'inspeccion') {
            $.ajax({
                method: "POST",
                url: "/ajax/checkedins.php",
                data: {
                    inspeccion_id: $('#inspeccion_id').val(),
                    clave: $(this).prop('name'),
                    valor: $(this).val() 
                }
            })
            .done(function (msg) {
                var json = JSON.parse(msg);
                objec.attr('id', json.valor_id);
            })
        }


        
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        
        if ($('#db_tabla').val() == 'fundo') {
            $.ajax({
                method: "POST",
                url: "/ajax/unchecked.php",
                data: {
                    id: $(this).prop('id')
                }
            })
            .done(function (msg) {
                console.log(msg);
            })
    
        }else if ($('#db_tabla').val() == 'inspeccion') {
            $.ajax({
                method: "POST",
                url: "/ajax/uncheckedins.php",
                data: {
                    id: $(this).prop('id')
                }
            })
            .done(function (msg) {
                console.log(msg);
            })
        }
    }
});


