let registryOfficesTable = null;
let registryEditMode = 0;
let currentRegistry = -1;
let currentRow = null;

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
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "phone" },
                { "data": "mail" },
                { "data": "right" },
                { "data": "document" },
                { "data": "zipcode" },
                { "data": "address" },
                { "data": "district" },
                { "data": "city" },
                { "data": "state" },
                { "data": "notary" }
            ],
            responsive: {
                details: false
            },
            "columnDefs": [{
                targets: [1,4],
                render: function ( data, type, row ) {
                    if(type === "display"){
                        if($(window).width() < 500){
                            return data.length > 20 ? data.substr( 0, 20 ) +'…' : data;
                        }
                        return data.length > 40 ? data.substr( 0, 40 ) +'…' : data;
                    }
                    else
                        return data;
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
                $('#registry-modal').modal('hide');
            }
        }
    });
}

function saveCurrentRegistry(data){
    data += "&registry-id=" + currentRegistry;
    $.ajax({
        type: "POST",
        url: "/save_registry_office",
        data: data,
        success: function(data){
            if(data['result'] === "success"){
                updateTable();
                $('#registry-modal').modal('hide');
            }
        }
    });
}

function openAddRegistryModal(){
    $('#modal-label').html("Adicionar Cartório");
    $('#name').val("");
    $('#right').val("");
    $('#document').val("");
    $('#zipcode').val("");
    $('#address').val("");
    $('#district').val("");
    $('#city').val("");
    $('#state').val("");
    $('#phone').val("");
    $('#mail').val("");
    $('#notary').val("");
    $('#document-type').val("1");
    $('#active').attr('checked', false);
    registryEditMode = 0;
    $('#registry-modal').modal();
}

function editRegistryModal(data){
    $('#modal-label').html("Editar Cartório");
    $('#name').val(data["name"]);
    $('#right').val(data["right"]);
    $('#document').val(data["document"]);
    $('#zipcode').val(data["zipcode"]);
    $('#address').val(data["address"]);
    $('#district').val(data["district"]);
    $('#city').val(data["city"]);
    $('#state').val(data["state"]);
    $('#phone').val(data["phone"]);
    $('#mail').val(data["mail"]);
    $('#notary').val(data["notary"]);
    $('#document-type').val(data["document-type"]);
    $('#active').attr('checked', data["active"] === "1");
    currentRegistry = data["id"];
    registryEditMode = 1;
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
    $('#data-table tbody').on('click', 'tr', function () {
        if(registryOfficesTable != null){
            let row = registryOfficesTable.row($(this));
            if(row != null) {
                editRegistryModal(row.data());
                currentRow = row;
            }
        }
    });
});