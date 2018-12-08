$(document).ready(function() {
    $('#dataTable').dataTable({
        "ajax": {
            "url": "/get/registry_offices",
            "type": "POST"
        },
        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        },
        "columnDefs": [{
            targets: 1,
            render: function ( data, type, row ) {
                if(type=="display"){
                    if($(window).width() < 600){
                        if(data.length > 20){
                            return data.substr( 0, 20 ) +'…';
                        }
                        else{
                            return data;
                        }
                    }
                    return data.substr( 0, 30 ) +'…';
                }
                else{
                    return data;
                }
            }
        }],
        "deferRender": true
    });
});