let registryOfficesTable = null; // Tabela DataTable contendo os registros dos cartórios
let registryEditMode = 0; // Modo de edição: 0 - Novo Cartório, 1 - Cartório Existente
let currentRegistry = -1; // Cartório atualmente exibido na modal
let currentRow = null; // Linha sendo atualmente editada na modal

// Atualiza a tabela de cartórios inteira
function updateTable(){
    if(registryOfficesTable == null){ // Caso a tabela ainda não tenha sido inicializada...
        registryOfficesTable = $('#data-table').DataTable({
            "ajax": {
                "url": "/get_registry_offices", // Indica de onde a tabela irá obter os dados
                "type": "POST" // Método que será utilizado no ajax
            },
            // Opções do menu de resultados por página
            "lengthMenu": [[10,25, 50, 100], ["10","25","50","100"]],

            // Tradução
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
            // Fim da Tradução

            // Especifica-se abaixo as colunas da tabela
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

            // Opções de responsividade da tabela
            "responsive": {
                details: false // Não deve mostrar o "+" para visualizar os dados não visíveis
            },

            // Definições das colunas
            "columnDefs": [{
                targets: [1,4], // A definição se aplica as colunas de índice 1 e 4
                render: function ( data, type, row ) {
                    if(type === "display"){
                        // Se a largura da janela é menor que 500, adiciona reticências no nome
                        if($(window).width() < 500){
                            return data.length > 20 ? data.substr( 0, 20 ) +'…' : data;
                        }
                        // Se a largura da janela é maior que 500, mostra mais caracteres do nome
                        return data.length > 40 ? data.substr( 0, 40 ) +'…' : data;
                    }
                    else
                        return data;
                }
            }],

            // Indica-se abaixo que a tabela só deve criar as linhas quando elas precisarem ser exibidas
            "deferRender": true
        });
    }
    else{ // Caso a tabela já tenha sido criada, apenas recarrega
        registryOfficesTable.ajax.reload();
    }
}

// Função executada quando o usuário clica no botão de importar Xml
function importXml(file, element){
    // Cria-se o objeto FormData para poder fazer upload do arquivo
    let data = new FormData();
    data.append('file', file);

    // Inicia o ajax que faz a comunicação com o back-end
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

// Função executada quando o usuário clica no botão de criar novo cartório
function createNewRegistry(data){
    // Inicia o ajax que faz a comunicação com o back-end
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

// Função que é executada quando o usuário salva um cartório que foi editado
function saveCurrentRegistry(data){
    // Adicionamos o ID do cartório na string do form
    data += "&registry-id=" + currentRegistry;

    // Inicia o ajax que faz a comunicação com o back-end
    $.ajax({
        type: "POST",
        url: "/save_registry_office",
        data: data,
        success: function(data){
            if(data['result'] === "success"){
                // Atualizamos abaixo a linha da tabela com os novos dados
                currentRow.data(data['data']);
                currentRow.invalidate();
                registryOfficesTable.draw(false);

                $('#registry-modal').modal('hide');
            }
        }
    });
}

// Função que é executada após o usuário decidir enviar o e-mail
function sendMail(data){
    // Inicia o ajax que faz a comunicação com o back-end
    $.ajax({
        type: "POST",
        url: "/send_mail",
        data: data,
        success: function(data){
            if(data['result'] === "success"){
                $('#mail-modal').modal('hide');
            }
        }
    });
}

// Abre a modal de enviar e-mail
function openSendMailModal(){
    $('#subject').val("");
    $('#mail-body').val("");
    $('#mail-modal').modal();
}

// Abre a modal de criar novo cartório
function openAddRegistryModal(){
    // Muda o título da modal
    $('#modal-label').html("Adicionar Cartório");

    // Esvazia os input no caso de usos anteriores
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

    // Indica que o modo de edição é novo cartório
    registryEditMode = 0;

    // Abre a modal
    $('#registry-modal').modal();
}

// Abre a modal de editar cartório existente
function editRegistryModal(data){
    // Muda o título da modal
    $('#modal-label').html("Editar Cartório");

    // Popula os input com os valores do cartório
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

    // Indica que o modo de edição é editar cartório
    registryEditMode = 1;

    // Abre a modal
    $('#registry-modal').modal();
}

// Assim que a página terminar de ser carregada, executamos as inicializações
$(document).ready(function() {
    updateTable(); // Atualiza a tabela de cartórios

    // Caso algum arquivo tenha sido selecionado através do botão "importar XML"...
    $(document).on('change', '#file', function() {
        let input = $(this);
        let qtd = input.get(0).files ? input.get(0).files.length : 0; // Verifica a quantidade de arquivos
        if(qtd === 1) importXml(input.get(0).files[0], input); // Importa o XML
    });

    // Adiciona o listener do botão de adicionar cartório
    $("#add-registry-button").click(function(){
        openAddRegistryModal();
    });

    // Adiciona o listener do botão de enviar e-mail
    $("#send-mail-button").click(function(){
        openSendMailModal();
    });

    // Desabilita-se abaixo o submit padrão do form do cartório, para utilizar apenas ajax
    $('#registry-form').submit(function(){
        let data = $(this).serialize();
        if(registryEditMode === 0) createNewRegistry(data);
        else saveCurrentRegistry(data);
        return false;
    });

    // Desabilita-se abaixo o submit padrão do form de enviar e-mail, para utilizar apenas ajax
    $('#mail-form').submit(function(){
        let data = $(this).serialize();
        sendMail(data);
        return false;
    });

    // Adiciona o listener para abrir a modal de edição quando o usuário clicar em alguma linha da tabela de cartórios
    $('#data-table tbody').on('click', 'tr', function () {
        if(registryOfficesTable != null){ // Verifica se a tabela foi iniciada
            let row = registryOfficesTable.row($(this));
            if(row != null) { // Verifica se a linha existe
                editRegistryModal(row.data());
                currentRow = row;
            }
        }
    });
});