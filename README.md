# desafio21
A solução proposta para o desafio é deixar de utilizar as planilhas, e fazer todo o processo utilizando este sistema.

# Instalação
- Foram utilizados no sistema: Composer, Zend Framework e Doctrine ORM. 
- Para instalar basta clonar o repositório, extrair em uma pasta do servidor desejado, executar o comando "php composer.phar install", e direcionar o tráfego para a pasta "public".

# Informações
- Os dados dos cartórios serão guardados em um banco de dados, na tabela "registry".
- O XML enviado pelo CNJ pode ser importado utilizado o botão "Importar XML".
- Os registros podem ser editados clicando uma vez na linha do registro na tabela exibida no sistema.
- Para criar um registro de um cartório manualmente, basta clica no botão "Adicionar Cartório".
- Para enviar um mesmo e-mail para todos os registros ativos, basta clicar no botão "Enviar E-mail".
- O serviço MailSender, que é responsável por enviar os e-mails, utiliza uma forma primitiva de envio de e-mail, o ideal é substituir a forma de envio por outra que utilize portas, servidores SMTP, etc. de forma correta.