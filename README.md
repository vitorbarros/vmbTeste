# Vitor Barros Test

## Requisitos do sistema
  php5
  
  mysql
  
  composer
  
  gulp
  
  sass
  
  nodejs
  
  npm
  
## Instalação

  1 - Clone o repositório em sua máquina ou baixe os arquivos
  
  2 - Abra o terminal, navegue até a pasta do projeto e execute o seguinte comando: `composer install`.
  
  3 - Acesse os arquivos .env, config/database.php e faça as configurações do banco de dados de acordo com suas credenciais de acesso
  
  4 - acesse o terminal e execute o seguinte comando: `php artisan migrate --seed`, para zerer a base e criar os registros necessários para o funcionamento do sistema.
  
  5 - acesse a tabela `oauth_clients` no banco de dados e faça um insert com os seguintes dados 'appid01', 'secret', 'API', nos respectivos campoos 'id', 'secret', 'name'. (necessário para acessos dos serviços fornecidos pela API).
  
  6 - Abra o terminal e exefute o seguinte comando na raiz do projeto `php artisan serve`.
  
  7 - Caso seja necessário fazer alterações nos arquivos de CSS e JS será necessário ter instalado em sua máquina os seguintes
  pacotes 'nodejs', 'npm', 'sass', 'gulp'. Na raiz do projeto exeute o seguinte comando `npm install`. Após a instalação execute o seguinte comando `gulp watch`. Após a execução desse comando acesse os arquivos em resources/assets/sass/src e edite os arquivos desejados.
  
## Acesso ao sistema

  1 - após a execução dos procedimentos acima, acesse em seu navegador 'localhost:8000'.
  
  2 - Faça o acesso com o nome de usuário 'admin', e senha 'admin'.
  
## API
  1 - Autenticação
    Faça uma requisição do tipo POST para a seguinte rota localhost:8000/oauth/access_token com os seguintes parâmetros.
    
      grant_type = password
      
      client_id = appid01
      
      client_secret = secret
      
      username = admin
      
      password = admin
      
  O retorno deverá ser:
  
  {
    "access_token": "9z9cFIp2DtK8g8kKmeoYRIX4yxkxbSA5t8SGk1eI",
    "token_type": "Bearer",
    "expires_in": 3600
  }
  
  2 - Consulta no sintegra
  
  Faça uma requisição do tipo POST para localhost:8000/api/sintegra com os seguintes parâmetros:
  
  cnpj = cnpj para consulta
  
  Authorization = Bearer access_token
  
  2 - Retornar todas as consultas
  
  Faça uma requisição do tipo GET para localhost:8000/api/sintegra com os seguintes parâmetros:
  
  Authorization = Bearer access_token
  
  3 - Retornar consulta por ID
  
  Faça uma requisição do tipo GET para localhost:8000/api/sintegra/{id} com os seguintes parâmetros:
  
  Authorization = Bearer access_token
  
  
  
  
  
  
  
  
