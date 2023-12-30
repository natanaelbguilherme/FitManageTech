# API TotalPower

O Projeto Total Power consiste em uma API para gestão de treinos, que permite o cadastro e gestão de usuários, alunos e exercícios, além do cadastro e listagem de seus respectivos treinos. O Total Power tem três opções de planos, BRONZE, PRATA, e OURO, cada plano dá ao usuario o número de estudantes que o mesmo pode cadastrar.

## 🔧 Tecnologias utilizadas

Projeto foi desenvolvido utilizando a linguagem PHP com frameword Laravel, e o banco de dados PostgreSQL.

### Vídeo de apresentação:

https://drive.google.com/file/d/1ETK4TztPOLecXj-YXtiqb3rqfoIhFFy8/view?usp=sharing

### Segue abaixo as bibliotecas externas utilizadas:

| Ferramenta | Uso                                           |
| ---------- | --------------------------------------------- |
| DomPdf     | Gerar os arquivos pdf enviados aos estudantes |

Outros softwares utilizados:

| Ferramenta | Uso                                              |
| ---------- | ------------------------------------------------ |
| Docker     | Criação de ambientes de desenvolvimento virtuais |
| DBeaver    | Conectar e manipular o banco de dados            |

### Organização de etapas e cronograma

| Ferramenta | Uso                                                           |
| ---------- | ------------------------------------------------------------- |
| Trello     | Quadro Kanban para organizar o desenvolvimento de cada tarefa |

## 🚀 Como executar o projeto

-Clonar o repositório https://github.com/natanaelbguilherme/FitManageTech.git

-Criar um container no docker

-Banco de dados postgres com o nome **api_academia**

-Criar um arquivo .env na raiz do projeto com os seguintes parametros:

```
DB_CONNECTION=''
DB_HOST=''
DB_PORT=''
DB_DATABASE=''
DB_USERNAME=''
DB_PASSWORD=''
```

### No prompt de comando executar :

```sh
composer install
```

-Criação das migrations:

```sh
php artisan migrate
```

-Criação das seeds (planos pré cadastrados, BRONZE, PRATA, e OUTRO):

```sh
php artisan db:seed PopulatePlans
```

-Instalar o DomPdf:

```sh
composer require barryvdh/laravel-dompdf
```

##  Documentação da API

##

### Endpoints - Rotas

##

#### Rota PÚBLICA para cadastro de usuário

```http
  POST /api/users
```

| Parâmetro            | Tipo     | Descrição                                                                    |
| :------------------- | :------- | :--------------------------------------------------------------------------- |
| `id`                 | `int`    | **Autoincremental**. Chave primaria                                          |
| `name`      | `string` | **Obrigatório**. Nome do usuário                                          |
| `email`             | `string` | **Obrigatório**. Email do usuário, único e válido          |
| `data_birth`    | `date`   | **Obrigatório** Data de nascimento do usuário                               |
| `cpf`                | `string` | **Obrigatório**. CPF do usuário, único e válido                             |
| `password`           | `string` | **Obrigatório** Senha de 8 a 32 caracteres               |
| `plan_id` | `unsignedBigInteger` | **Obrigatório**. Id do plano selecionado                               |

Response JSON (exemplo)

```http
{
  "name": "João Pedro",
  "email": "joaopedro@gmail.com",
  "date_birth": "1990-08-25",
  "cpf": "00000000005",
  "plan_id": "3",
  "updated_at": "2023-12-26T16:54:02.000000Z",
  "created_at": "2023-12-26T16:54:02.000000Z",
  "id": 7
}
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `201`           | sucesso (CREATED)  |
| `400`           | dados inválidos na requisição (BAD REQUEST)   |
| `409`           | CPF já cadastrado (CONFLICT)|


-Em caso de sucesso o usuário receberá um email de boas vindas.
##

#### Rota PÚBLICA para Login

```http
  POST /api/login
```

| Parâmetro            | Tipo     | Descrição                       |
| :------------------- | :------- | :------------------------------ |
| `email`      | `string` | **Obrigatório**. Email do usuário |
| `password`    | `string` | **Obrigatório**. Senha do usuário              |

Response JSON (exemplo)

```http
{
  "message": "Autorizado",
  "status": 200,
  "data": {
    "name": "nome do usuário",
    "token": "01|FBrdcVPE2BX0FoCxk3V91XMUdpXELR5pO4Nca8ssf1b4c85a"
  }
}
```
-Token de acesso válido por 24 hroas.

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `200`           | sucesso (ok)  |
| `400`           | dados inválidos na requisição (BAD REQUEST)   |
| `401`           | Login invalido (UNAUTHORIZED)|


##

#### Rota PRIVADA para logout

```http
  POST /api/logout
```

-Passar token na requisição.

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `204`           |  (Not Content)  |

##

#### Rota PRIVADA para dashboard

```http
  GET /api/dashboard
```

Response JSON (exemplo)

```http
{
  "registered_students": 3,
  "registered_exercices": 3,
  "current_user_plan": "Plano BRONZE",
  "remaining_students": 7
}
```
-Retorna quantidade de estudantes, exercícios, e plano escolhido do usuário logado, e também estudantes o usuário ainda pode cadastrar.
| Response Status | Descrição         |
| :-------------- | :---------------- |
| `200`           | sucesso (ok)  |

##

#### Rota PÚBLICA para cadastro de exercícios

```http
  POST /api/exercises
```

| Parâmetro            | Tipo     | Descrição                                                                    |
| :------------------- | :------- | :--------------------------------------------------------------------------- |
| `id`                 | `int`    | **Autoincremental**. Chave primaria                                          |
| `description`      | `string` | **Obrigatório**. Nome do exercício                                          |
| `user_id`      | `unsignedBigInteger` |  id do usuario que cadastrou o exercício                                         |

Response JSON (exemplo)

```http
 {
  "user_id": 4,
  "description": "agachamento",
  "updated_at": "2023-12-26T17:28:14.000000Z",
  "created_at": "2023-12-26T17:28:14.000000Z",
  "id": 4
}

```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `201`           | sucesso (CREATED)  |
| `400`           | dados inválidos na requisição (BAD REQUEST)   |
| `409`           | Exercício já cadastrado (CONFLICT)|


##

#### Rota PRIVADA para listagem de exercicios

```http
  GET /api/exercises
```

Response JSON (exemplo)

```http
  [
  {
    "id": 1,
    "description": "remada"
  },
  {
    "id": 2,
    "description": "leg"
  },
  {
    "id": 3,
    "description": "supino"
  },
  {
    "id": 4,
    "description": "agachamento"
  }
]
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `200`           | sucesso (ok)  |

##

#### Rota PRIVADA para deletar um exercicio

```http
  DELETE /api/exercises/:id
```

Request exemplo:
`/api/exercises/1`
| Parâmetro | Tipo | Descrição |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Não há response no body em caso de sucesso

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `204`           |  (Not Content)  |
| `409`           | Exercício sendo usado em um treino (CONFLICT)|
| `403`           | Exercício não foi dacastrado pelo usuário autenticado (FORBIDDEN)|
| `404`           | Exercício não encontrado (NOT FOUND)|

##

#### Rota PRIVADA para cadastro de estudantes

```http
  POST /api/students
```

| Parâmetro            | Tipo     | Descrição                                                                    |
| :------------------- | :------- | :--------------------------------------------------------------------------- |
| `id`                 | `int`    | **Autoincremental**. Chave primaria                                          |
| `name`      | `string` | **Obrigatório**. Nome do usuário                                          |
| `email`             | `string` | **Obrigatório**. Email do usuário, único e válido          |
| `data_birth`    | `date`   | **Obrigatório** Data de nascimento do usuário                               |
| `cpf`                | `string` | **Obrigatório**. CPF do usuário, único e válido                             |
| `contact`                | `string` | **Obrigatório**. Contato do usuário, com no máximo 20 caracteres  |
| `user_id` | `unsignedBigInteger` | **Obrigatório**. Id do usuario que cadastrou o estudante |
| `city`                | `string` | Cidade  |
| `neighborhood`      | `string` | Bairro  |
| `number`                | `string` |Número da residencia |
| `street`                | `string` | Nome da rua  |
| `state`                | `string` | estado, com no máximo 2 caracteres |
| `cep`                | `string` | Cep, com no máximo 20 caracteres  |

Response JSON (exemplo)

```http
{
  "name": "joao",
  "email": "joao@gmail.com",
  "date_birth": "1990-08-25",
  "cpf": "12234413325",
  "contact": "00000000001",
  "cep": "12345-678",
  "street": "rua a",
  "state": "CE",
  "neighborhood": "centro",
  "city": "pacajus",
  "number": "001",
  "id": 5
}
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `201`           | sucesso (CREATED)  |
| `400`           | dados inválidos na requisição (BAD REQUEST)   |
| `403`           | Limite de cadastros excedidos (FORBIDDEN)|
| `409`           | CPF ou email já cadastrados (CONFLICT)|

##


#### Rota PRIVADA para listagem de estudantes
-Busca os estudantes de forma geral.
-Também é possivel pesquisar por nome, cpf ou email, enviado QUERY PARAMS.
    EX: enviar no parametro a palavra `filter` e no value a opção para pesquisar, por ex: `joao`
```http
  GET /api/students
```

Response JSON (exemplo) - busca geral sem parametro de pesquisa

```http
 [
  {
    "id": 3,
    "name": "joao",
    "email": "joao@gmail.com",
    "date_birth": "1990-08-25",
    "cpf": "12234413321",
    "contact": "00000000001",
    "city": "pacajus",
    "neighborhood": "centro",
    "number": "001",
    "street": "rua a",
    "state": "CE",
    "cep": "12345-678"
  },
  {
    "id": 1,
    "name": "pedro",
    "email": "pedro@gmail.com",
    "date_birth": "1990-08-25",
    "cpf": "12339413321",
    "contact": "00000000000",
    "city": "pacajus",
    "neighborhood": "centro",
    "number": "001",
    "street": "rua a",
    "state": "CE",
    "cep": "12345-678"
  },
  {
    "id": 2,
    "name": "tiago",
    "email": "tiago@gmail.com",
    "date_birth": "1990-08-25",
    "cpf": "12334413321",
    "contact": "00000000001",
    "city": "pacajus",
    "neighborhood": "centro",
    "number": "001",
    "street": "rua a",
    "state": "CE",
    "cep": "12345-678"
  }
]
```

Response JSON (exemplo) - pesquisa com o value `joao`

```http
 [
  {
    "id": 3,
    "name": "joao",
    "email": "joao@gmail.com",
    "date_birth": "1990-08-25",
    "cpf": "12234413321",
    "contact": "00000000001",
    "city": "pacajus",
    "neighborhood": "centro",
    "number": "001",
    "street": "rua a",
    "state": "CE",
    "cep": "12345-678"
  }
]
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `200`           | sucesso (ok)  |

##

#### Rota PRIVADA para deletar um estudante - Soft Delete

```http
  DELETE /api/students/:id
```

Request exemplo:
`/api/students/1`
| Parâmetro | Tipo | Descrição |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Não há response no body em caso de sucesso

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `204`           |  (Not Content)  |
| `403`           | Estudante não foi dacastrado pelo usuário autenticado (FORBIDDEN)|
| `404`           | Estudante não encontrado (NOT FOUND)|

##

#### Rota PRIVADA para atualização de estudantes

```http
  PUT /api/students/:id
```

| Parâmetro            | Tipo     | Descrição                                                                    |
| :------------------- | :------- | :--------------------------------------------------------------------------- |
| `name`      | `string` | **Opicional** Nome do usuário                                          |
| `email`             | `string` | **Opicional** Email do usuário, único e válido          |
| `data_birth`    | `date`   | **Opicional** Data de nascimento do usuário                               |
| `cpf`                | `string` | **Opicional** CPF do usuário, único e válido                             |
| `contact`                | `string` |**Opicional** Contato do usuário  |
| `city`                | `string` |**Opicional** Cidade  |
| `neighborhood`      | `string` |**Opicional** Bairro  |
| `number`                | `string` |**Opicional** Número da residencia |
| `street`                | `string` |**Opicional** Nome da rua  |
| `state`                | `string` |**Opicional** estado |
| `cep`                | `string` |**Opicional** Cep  |

-Requisição para a rota
```http
  PUT /api/students/5
```
-Eviando no body
```http
{
  "name": "joao guilherme",
  "contact": "123457789"
 }
```

Response JSON (exemplo)

```http
{
  "id": 5,
  "name": "joao guilherme",
  "email": "joao3@gmail.com",
  "date_birth": "1990-08-25",
  "cpf": "12234413325",
  "contact": "123457789",
  "city": "pacajus",
  "neighborhood": "centro",
  "number": "001",
  "street": "rua a",
  "state": "CE",
  "cep": "12345-678"
}
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `200`           | sucesso (ok)  |

##

#### Rota PRIVADA para cadastro/montagem de treinos
```http
  POST /api/workouts
```

| Parâmetro            | Tipo     | Descrição                                                                    |
| :------------------- | :------- | :--------------------------------------------------------------------------- |
| `id`                 | `int`    | **Autoincremental**. Chave primaria                     |
| `student_id` | `unsignedBigInteger` | **Obrigatório**. Id do estudante assosicado |
| `exercise_id` | `unsignedBigInteger` | **Obrigatório**. Id do exercício assossiado |
| `repetitions`      | `int` | **Obrigatório**. Número de repetições do exercício  |
| `weight`         | `decimal` | **Obrigatório**. Peso para realizar o exercício   |
| `break_time`    | `int`   | **Obrigatório** Tempo de descanso entre os exercícios  |
| `day`       | `enum` | **Obrigatório**. Contendo os valores: SEGUNDA,TERÇA, QUARTA, QUINTA, SEXTA, SÁBADO, DOMINGO. O dia do treino|
| `observations` | `string` | Observações  |
| `time` | `int` | **Obrigatório**. Tempo para realizar o exercício |


Response JSON (exemplo)

```http
{
  "student_id": 1,
  "exercise_id": 4,
  "repetitions": 15,
  "weight": 10.5,
  "break_time": 50,
  "day": "QUINTA",
  "time": 10,
  "updated_at": "2023-12-28T13:58:17.000000Z",
  "created_at": "2023-12-28T13:58:17.000000Z",
  "id": 17
}
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `201`           | sucesso (CREATED)  |
| `400`           | dados inválidos na requisição (BAD REQUEST)   |
| `409`           | exerccio ja cadastrado neste dia (CONFLICT)|

##

#### Rota PRIVADA para listagem de treinos do estudante

```http
  GET /api/:id/workouts
```

Response JSON (exemplo)
```http
 {
  "student_id": 1,
  "student_name": "pedro",
  "workouts": {
    "SEGUNDA": [
      {
        "exercise_id": 3,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 3,
          "description": "supino"
        }
      },
      {
        "exercise_id": 1,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 1,
          "description": "remada"
        }
      },
      {
        "exercise_id": 2,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 2,
          "description": "leg"
        }
      }
    ],
    "TERÇA": [
      {
        "exercise_id": 3,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 3,
          "description": "supino"
        }
      },
      {
        "exercise_id": 1,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 1,
          "description": "remada"
        }
      },
      {
        "exercise_id": 2,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 2,
          "description": "leg"
        }
      }
    ],
    "QUARTA": [
      {
        "exercise_id": 3,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 3,
          "description": "supino"
        }
      },
      {
        "exercise_id": 1,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 1,
          "description": "remada"
        }
      },
      {
        "exercise_id": 2,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 2,
          "description": "leg"
        }
      }
    ],
    "QUINTA": [
      {
        "exercise_id": 3,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 3,
          "description": "supino"
        }
      },
      {
        "exercise_id": 1,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 1,
          "description": "remada"
        }
      },
      {
        "exercise_id": 2,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 2,
          "description": "leg"
        }
      },
      {
        "exercise_id": 4,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 4,
          "description": "agachamento"
        }
      }
    ],
    "SEXTA": [
      {
        "exercise_id": 3,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 3,
          "description": "supino"
        }
      },
      {
        "exercise_id": 1,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 1,
          "description": "remada"
        }
      },
      {
        "exercise_id": 2,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 2,
          "description": "leg"
        }
      },
      {
        "exercise_id": 4,
        "repetitions": 15,
        "weight": "10.50",
        "break_time": 50,
        "observations": null,
        "time": 10,
        "exercise": {
          "id": 4,
          "description": "agachamento"
        }
      }
    ],
    "SÁBADO": [],
    "DOMINGO": []
  }
}
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `200`           | sucesso (ok)  |

##

#### Rota PRIVADA para listar um estudante por id
```http
  GET /api/students/:id
```
Response JSON (exemplo)

```http
{
  "id": 1,
  "name": "pedro",
  "email": "pedro@gmail.com",
  "date_birth": "1990-08-25",
  "cpf": "12339413321",
  "contact": "00000000000",
  "address": {
    "cep": "12345-678",
    "street": "rua a",
    "state": "CE",
    "neighborhood": "centro",
    "city": "pacajus",
    "number": "001"
  }
}
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `200`           | sucesso (ok)  |

##


#### Rota PRIVADA para gerar o PDF com o treino da semana de um estudante
```http
  GET /api/students/export?student_id=:id
```
-Enviar QUERY PARAMS.
    EX: no parametro a palavra `student_id` e no value a opção para pesquisar, por ex: `1`
    
-Link do arquivo pdf gerado     
        https://drive.google.com/file/d/1EGRGQ7E0KmuL0LPBW2MCEzThwzJHpiLK/view?usp=sharing
    

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `200`           | sucesso (ok)  |

##
## DevInHouse SENAI
### Projeto Avaliativo do Módulo 2



## Autor


| Natanael Batista Guilherme |  https://www.github.com/natanaelbguilherme |

###


