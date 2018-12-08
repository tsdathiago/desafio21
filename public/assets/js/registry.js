let registryOfficesTable = null;

function updateTable(){
    if(registryOfficesTable == null){
        registryOfficesTable = $('#dataTable').DataTable({
            "ajax": {
                "url": "/get_registry_offices",
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
    }
    else{
        registryOfficesTable.ajax.reload();
    }
}

function importXml(file, element){
    let data = new FormData();
    data.append('file', file);
    $.ajax({
        "url" : "/import_registry_offices",
        "type": "POST",
        "processData": false,
        "contentType" : false,
        "dataType": 'text',
        "data": data,
        "success": function(data){
            console.log(data);
            if(data['result'] === "success"){
                console.log("success");
                updateTable();
            }
        }
    });
}

$(document).ready(function() {
    updateTable();
    $(document).on('change', '#file', function() {
        let input = $(this);
        let qtd = input.get(0).files ? input.get(0).files.length : 0;
        if(qtd === 1) importXml(input.get(0).files[0], input);
    });
});