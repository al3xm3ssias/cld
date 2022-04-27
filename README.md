
O CLD foi desenvolvido para atender as necessidades do Departamento de Informatica([DEINFO](https://deinfo.uepg.br/)) da Universidade Estadual de Ponta Grossa ([UEPG](https://www.uepg.br/)).

O sistema conta com gerenciamento de usuários, um controle de reservas de espaços de laboratórios, para acadêmicos e professores do departamento. 


Para instalar o CLD realize as seguintes etapas:

Clone o repositorio

Execute o seguinte comando

``composer install``

Após isso execute este comando

``cp .env-example .env``

``php artisan key:generate``

Altere as variais de banco de dados no arquivo .env

e execute este comendo

``php artisan migrate:fresh --seed`` 

Para que o banco de dados seja resetado e populado, por padrão o CLD cria 1000 usuários ficticios e um usuário Admin, caso queira alterar a quantidade entre no arquivo [DatabaseSeeder.php](https://github.com/al3xm3ssias/cld/blob/master/database/seeders/DatabaseSeeder.php). 

A usuário e senha de acesso ao sistema é admin@admin.com



## Autor

[<img src="https://avatars.githubusercontent.com/u/93291578?s=40&v=4" width=115><br><sub>Cladio Alex Messias da Rosa</sub>](https://github.com/al3xm3ssias)]

