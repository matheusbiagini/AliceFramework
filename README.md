# Alice Framework

## Configurando ambiente de dev

``` bash
# Install docker CE(17.12+) & docker-compose(1.2+)
sudo apt-get install docker
sudo apt-get install docker-compose

# Adicionar permissões para o docker
sudo usermod -aG docker ${USER}
sudo su - $ {USER}

# Edite as configurações de banco de dados em:
Copie Docker/env/mysql.env.example para Docker/env/mysql.env
Copie Docker/env/mysql-test.env.example para Docker/env/mysql-test.env

#Adicionando as configurações do site escolhido: (*nota: copie a configuração e não apague os exemplos).
Copie Docker/env/app.env.example para Docker/env/app.env

# Adicionar permissão de usuário para o contéudo
sudo chown -R $USER: $USER .

# Rodar o docker-compose
docker-compose up -d

# Rodar o composer
docker-compose exec app composer install

# Rodar as migrations
docker-compose exec app php migrate migrate:run

# Acessando
http://localhost
```

```
## Extra
``` bash
# Criar uma migration
docker-compose exec app php migrate migrate:create

# Recriar e subir o dump novamente.
docker-compose down && docker volume rm aliceframework_database && docker-compose up -d

# Testando e-mail:
Se for testar no gmail, deve habilitar aplicativos de terceiros:
https://myaccount.google.com/u/1/lesssecureapps?pageId=none

#Permissão nas imagens:
sudo chown -R $USER:$USER ./web/Img/
chmod 777 -R web/Img/
```