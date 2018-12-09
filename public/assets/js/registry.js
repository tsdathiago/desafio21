let registryOfficesTable = null;
let registryEditMode = 0;
let currentRegistry = -1;

function updateTable(){
    if(registryOfficesTable == null){
        registryOfficesTable = $('#data-table').DataTable({
            "ajax": {
                "url": "/get_registry_offices",
                "type": "POST"
            },
            "lengthMenu": [[10,25, 50, 100], ["10","25","50","100"]],
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
                        return data.substr( 0, 60 ) +'…';
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
            if(data['result'] === "success"){
                updateTable();
            }
        }
    });
}

function createNewRegistry(data){
    $.ajax({
        type: "POST",
        url: "/create_new_registry_office",
        data: data,
        success: function(data){
            if(data['result'] === "success"){
                updateTable();
            }
        }
    });
}

function saveCurrentRegistry(data){
    data += "&id=" + currentRegistry;
    $.ajax({
        type: "POST",
        url: "/save_registry_office",
        data: data,
        success: function(data){
            if(data['result'] === "success"){
                updateTable();
            }
        }
    });
}

function openAddRegistryModal(){
    $('#modal-label').html("Adicionar Cartório");
    $('#registry-modal').modal();
}

$(document).ready(function() {
    updateTable();
    $(document).on('change', '#file', function() {
        let input = $(this);
        let qtd = input.get(0).files ? input.get(0).files.length : 0;
        if(qtd === 1) importXml(input.get(0).files[0], input);
    });
    $("#add-registry-button").click(function(){
        openAddRegistryModal();
    });
    $('#registry-form').submit(function(){
        let data = $(this).serialize();
        if(registryEditMode === 0) createNewRegistry(data);
        else saveCurrentRegistry(data);
        return false;
    });
});