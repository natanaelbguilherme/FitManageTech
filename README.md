# API TotalPower

O Projeto Total Power consiste em uma API para gestão de treinos, que permite o cadastro e gestão de usuários, alunos e exercícios, além do cadastro e listagem de seus respectivos treinos. O Total Power tem três opções de planos, BRONZE, PRATA, e OURO, cada plano dá ao usuario o número de estudantes que o mesmo pode cadastrar.

## 🔧 Tecnologias utilizadas

Projeto foi desenvolvido utilizando a linguagem PHP com frameword Laravel, e o banco de dados PostgreSQL.

### Vídeo de apresentação:

https://drive.google.com/file/d/1TgatvSkL_zVhRnYMggKyW_LDfgEGhQm4/view?usp=share_link

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

## 🚑📗 Documentação da API

##

### 🚥 Endpoints - Rotas

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
Não é necessario body

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
| `403`           | Exercício não foi dacastrado pelo usuário autenticado (CONFLICT)|
| `404`           | Exercício não encontrado (NOT FOUND)|

---

### 🚥 Endpoints - Rotas Medicos

#### S07 - Cadastro de Medico

```http
  POST /api/medicos
```

| Parâmetro                     | Tipo     | Descrição                                                                                                                     |
| :---------------------------- | :------- | :---------------------------------------------------------------------------------------------------------------------------- |
| `id`                          | `int`    | **Autoincremental**. Chave primaria                                                                                           |
| `nome_completo`               | `string` | **Obrigatório**. Nome do medico                                                                                               |
| `genero`                      | `string` | Genero do medico                                                                                                              |
| `data_nascimento`             | `date`   | **Obrigatório** Data de nascimento do medico                                                                                  |
| `cpf`                         | `string` | **Obrigatório**. CPF do medico, único e válido                                                                                |
| `telefone`                    | `string` | Telefone do medico                                                                                                            |
| `instituicao_ensino_formacao` | `string` | **Obrigatório**. Instituição de formação                                                                                      |
| `crm_uf`                      | `string` | **Obrigatório** Cadastro do CRM/UF                                                                                            |
| `especializacao_clinica`      | `string` | **Obrigatório** Valores: CLINICO_GERAL, ANESTESISTA, DERMATOLOGIA, GINECOLOGIA, NEUROLOGIA, PEDIATRIA, PSIQUIATRIA, ORTOPEDIA |
| `estado_no_sistema`           | `string` | Valores: 'ATIVO','INATIVO' , valor padrão 'ATIVO'                                                                             |

Request JSON exemplo

```http
  {
    "nome_completo":"Roberto Farias",
    "genero":"MASCULINO",
    "data_nascimento":"1982-03-01",
    "cpf":"22023336066",
	"telefone":"21 984569813",
	"instituicao_ensino_formacao":"FAEC Med",
	"crm_uf":"76870690",
	"especializacao_clinica":"ORTOPEDIA",
	"estado_no_sistema": "ATIVO"
}
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `201`           | sucesso           |
| `400`           | dados inválidos   |
| `409`           | CPF já cadastrado |
| `500`           | erro interno      |

##

#### S08 - Atualização dos dados de Medicos

```http
  PUT /api/medicos/:id
```

| Parâmetro                     | Tipo     | Descrição                                                                                                     |
| :---------------------------- | :------- | :------------------------------------------------------------------------------------------------------------ |
| `nome_completo`               | `string` | Nome do medico                                                                                                |
| `genero`                      | `string` | Genero do medico                                                                                              |
| `data_nascimento`             | `date`   | Data de nascimento do medico                                                                                  |
| `cpf`                         | `string` | CPF do medico, único e válido                                                                                 |
| `telefone`                    | `string` | Telefone do medico                                                                                            |
| `instituicao_ensino_formacao` | `string` | Instituição de formação                                                                                       |
| `crm_uf`                      | `string` | Cadastro do CRM/UF                                                                                            |
| `especializacao_clinica`      | `string` | Valores: CLINICO_GERAL, ANESTESISTA, DERMATOLOGIA, GINECOLOGIA, NEUROLOGIA, PEDIATRIA, PSIQUIATRIA, ORTOPEDIA |

Request JSON exemplo

```http
/api/medicos/1
```

```http
  {
	"telefone":"11 9245698345"
}
```

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `200`           | sucesso                                        |
| `400`           | dados inválidos                                |
| `404`           | não encontrado registro com o código informado |
| `500`           | erro interno                                   |

##

#### S09 - Atualização do estado no sistema

```http
  PUT /api/medicos/:id/status
```

| Parâmetro           | Tipo     | Descrição                                     |
| :------------------ | :------- | :-------------------------------------------- |
| `id`                | `int`    | **Obrigatório** número inteiro chave primaria |
| `estado_no_sistema` | `string` | Valores: 'ATIVO','INATIVO'                    |

Request JSON exemplo

```http
/api/medicos/1/status
```

```http
  {
	"status_atendimento":"INATIVO"
  }
```

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `200`           | sucesso                                        |
| `400`           | dados inválidos                                |
| `404`           | não encontrado registro com o código informado |
| `500`           | erro interno                                   |

##

#### S10 - Listagem de Medicos

```http
  GET /api/medicos
```

Não é necessario resquest body

Opcionalmente pode ser utilizado no patch um query param informando: ATIVO, INATIVO

Exemplo:
`/api/medicos?status=INATIVO`
| Parâmetro | Tipo | Descrição |
| :---------- | :--------- | :---------------------------------- |
| `status_atendimento` | `string` | Valores: 'ATIVO', 'INATIVO'|

Exemplo de resposta:

```http
{
	"id": 1,
    "nome_completo":"Roberto Farias",
    "genero":"MASCULINO",
    "data_nascimento":"1982-03-01",
    "cpf":"22023336066",
	"telefone":"21 984569813",
	"instituicao_ensino_formacao":"FAEC Med",
	"crm_uf":"76870690",
	"especializacao_clinica":"ORTOPEDIA",
	"estado_no_sistema": "INATIVO"
	"total_atendimentos": 1,
	"createdAt": "2023-04-19T12:00:46.855Z",
	"updatedAt": "2023-04-21T00:02:47.509Z"
}
```

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

##

#### S11 - Listagem de Medico pelo identificador

```http
  GET /api/medicos/:id
```

Não é necessario resquest body

Request exemplo:
`/api/medicos/1`
| Parâmetro | Tipo | Descrição |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Exemplo de resposta:

```http
{
	"id": 1,
    "nome_completo":"Roberto Farias",
    "genero":"MASCULINO",
    "data_nascimento":"1982-03-01",
    "cpf":"22023336066",
	"telefone":"21 984569813",
	"instituicao_ensino_formacao":"FAEC Med",
	"crm_uf":"76870690",
	"especializacao_clinica":"ORTOPEDIA",
	"estado_no_sistema": "ATIVO"
	"total_atendimentos": 1,
	"createdAt": "2023-04-19T12:00:46.855Z",
	"updatedAt": "2023-04-21T00:02:47.509Z"
}
```

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `200`           | sucesso                                        |
| `404`           | não encontrado registro com o código informado |

##

#### S12 - Exclusão de Medico

```http
  DELETE /api/medicos/:id
```

Não é necessario resquest body

Request exemplo:
`/api/medicos/1`
| Parâmetro | Tipo | Descrição |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Não há response no body em caso de sucesso

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `204`           | sucesso                                        |
| `404`           | não encontrado registro com o código informado |

---

### 🚥 Endpoints - Rotas Enfermeiros

#### S13 - Cadastro de Enfermeiro

```http
  POST /api/enfermeiros
```

| Parâmetro                     | Tipo     | Descrição                                          |
| :---------------------------- | :------- | :------------------------------------------------- |
| `id`                          | `int`    | **Autoincremental**. Chave primaria                |
| `nome_completo`               | `string` | **Obrigatório**. Nome do enfermeiro                |
| `genero`                      | `string` | Genero do enfermeiro                               |
| `data_nascimento`             | `date`   | **Obrigatório** Data de nascimento do enfermeiro   |
| `cpf`                         | `string` | **Obrigatório**. CPF do enfermeiro, único e válido |
| `telefone`                    | `string` | Telefone do enfermeiro                             |
| `instituicao_ensino_formacao` | `string` | **Obrigatório**. Instituição de formação           |
| `cofen_uf`                    | `string` | **Obrigatório** Cadastro do COFEN/UF               |

Request JSON exemplo

```http
  {
    "nome_completo":"Ana Leme",
    "genero":"FEMININO",
    "data_nascimento":"1987-02-01",
    "cpf":"99686191089",
    "telefone":"21 984569813",
    "instituicao_ensino_formacao":"Fac Enf MG",
    "cofen_uf":"8619108"
}
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `201`           | sucesso           |
| `400`           | dados inválidos   |
| `409`           | CPF já cadastrado |
| `500`           | erro interno      |

##

#### S14 - Atualização dos dados de Enfermeiros

```http
  PUT /api/enfermeiros/:id
```

| Parâmetro                     | Tipo     | Descrição                         |
| :---------------------------- | :------- | :-------------------------------- |
| `nome_completo`               | `string` | Nome do enfermeiro                |
| `genero`                      | `string` | Genero do enfermeiro              |
| `data_nascimento`             | `date`   | Data de nascimento do enfermeiro  |
| `cpf`                         | `string` | CPF do enfermeiro, único e válido |
| `telefone`                    | `string` | Telefone do enfermeiro            |
| `instituicao_ensino_formacao` | `string` | Instituição de formação           |
| `cofen_uf`                    | `string` | Cadastro do COFEN/UF              |

Request JSON exemplo

```http
/api/enfermeiros/1
```

```http
  {
	"telefone":"11 845698345",
	"instituicao_ensino_formacao": "Faculdade Pan",
}
```

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `200`           | sucesso                                        |
| `400`           | dados inválidos                                |
| `404`           | não encontrado registro com o código informado |
| `500`           | erro interno                                   |

##

#### S15 - Listagem de Enfermeiros

```http
  GET /api/enfermeiros
```

Não é necessario resquest body

Exemplo de resposta:

```http
{
	"id": 1,
	"nome_completo":"Ana Leme",
   	"genero":"FEMININO",
   	"data_nascimento":"1987-02-01",
   	"cpf":"99686191089",
   	"telefone":"21 984569813",
   	"instituicao_ensino_formacao":"Fac Enf MG",
   	"cofen_uf":"8619108"
	"updatedAt": "2023-04-20T00:57:43.465Z",
	"createdAt": "2023-04-20T00:57:43.465Z"
}
```

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

##

#### S16 - Listagem de Enfermeiro pelo identificador

```http
  GET /api/enfermeiros/:id
```

Não é necessario resquest body

Request exemplo:
`/api/enfermeiros/1`
| Parâmetro | Tipo | Descrição |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Exemplo de resposta:

```http
{
	"id": 1,
	"nome_completo":"Ana Leme",
   	"genero":"FEMININO",
   	"data_nascimento":"1987-02-01",
   	"cpf":"99686191089",
   	"telefone":"21 984569813",
   	"instituicao_ensino_formacao":"Fac Enf MG",
   	"cofen_uf":"8619108"
	"updatedAt": "2023-04-20T00:57:43.465Z",
	"createdAt": "2023-04-20T00:57:43.465Z"
}
```

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `200`           | sucesso                                        |
| `404`           | não encontrado registro com o código informado |

##

#### S17 - Exclusão de Enfermeiro

```http
  DELETE /api/enfermeiros/:id
```

Não é necessario resquest body

Request exemplo:
`/api/enfermeiros/1`
| Parâmetro | Tipo | Descrição |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Não há response no body em caso de sucesso

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `204`           | sucesso                                        |
| `404`           | não encontrado registro com o código informado |

---

### 🚥 Endpoints - Atendimentos

#### S18- Realização de Atendimento Médico

```http
  POST /api/atendimentos
```

| Parâmetro     | Tipo  | Descrição                                      |
| :------------ | :---- | :--------------------------------------------- |
| `id`          | `int` | **Autoincremental**. Chave primaria            |
| `paciente_id` | `int  | **Obrigatório**. Chave estrangeira do paciente |
| `medico_id`   | `int  | **Obrigatório**. Chave estrangeira do medico   |

Request JSON exemplo

```http
  {
    "paciente_id":"2",
    "medico_id":"1"
}
```

| Response Status | Descrição                                     |
| :-------------- | :-------------------------------------------- |
| `201`           | sucesso                                       |
| `400`           | dados inválidos                               |
| `404`           | medico ou paciente não encontrados no sistema |
| `500`           | erro interno                                  |

##

#### S19 - Listagem de Atendimentos ⭐(funcionalidade extra)

```http
  GET /api/atendimentos
```

Não é necessario resquest body

Opcionalmente podem ser utilizados no patch dois query params informando: medico_id ou paciente_id

Exemplo query params médico:
`/api/atendimentos?medico=1` retorna todos atendimentos do médico especificado

Exemplo query params paciente:
`/api/atendimentos?paciente=1` retorna todos atendimentos do paciente especificado

| Parâmetro     | Tipo  | Descrição                                                        |
| :------------ | :---- | :--------------------------------------------------------------- |
| `id`          | `int` | Chave primaria                                                   |
| `paciente_id` | `int` | **querie params não obrigatorio**. Chave estrangeira do paciente |
| `medico_id`   | `int` | **querie params não obrigatorio**. Chave estrangeira do medico   |

Exemplo de resposta:

```http
[
	{
		"id": 1,
		"paciente_id": 13,
		"medico_id": 1,
		"createdAt": "2023-04-20T23:56:33.120Z",
		"updatedAt": "2023-04-20T23:56:33.120Z",
		"pacienteId": 13,
		"medicoId": 1
	},
	{
		"id": 2,
		"paciente_id": 14,
		"medico_id": 1,
		"createdAt": "2023-04-20T23:57:25.088Z",
		"updatedAt": "2023-04-20T23:57:25.088Z",
		"pacienteId": 14,
		"medicoId": 1
	}
]
```

| Response Status | Descrição                                     |
| :-------------- | :-------------------------------------------- |
| `200`           | sucesso                                       |
| `404`           | medico ou paciente não encontrados no sistema |
| `500`           | erro interno                                  |

## Projeto Avaliativo do Módulo 1 :: LAB 365

#### Curso WEB FullStack 2023

|                                                                                                                                                                                                      |                                                                                           |
| :--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | :---------------------------------------------------------------------------------------- |
| <img src="https://media.licdn.com/dms/image/C4D0BAQGcs8aDa4BZOQ/company-logo_200_200/0/1668186440015?e=1690416000&v=beta&t=YhQTfa9VLbEVw1XnROd2OsJUwGu-7Ia8eUoy18a3ve0" width="100%" height="100%"/> | [LAB365 ](https://lab365.tech/) - Espaço do SENAI para desenvolver habilidades do futuro. |

## Autor

|                                                                                            |                                                                       |
| :----------------------------------------------------------------------------------------- | :-------------------------------------------------------------------- |
| <img src="https://avatars.githubusercontent.com/u/86934710?v=4" width="50%" height="50%"/> | Alexandre Mariano :: [@devmariano](https://www.github.com/devmariano) |

###

![Logo](https://raw.githubusercontent.com/devmariano/project_files_repo/main/labMedicine_logo6.jpg)
