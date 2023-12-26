# API TotalPower

O Projeto Total Power consiste em uma API para gestão de treinos, que permite o cadastro e gestão de usuários, alunos e exercícios, além do cadastro e listagem de seus respectivos treinos.

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

-Criação das seeds:

```sh
php artisan db:seed PopulatePlans
```

-Instalar o DomPdf:

```sh
composer require barryvdh/laravel-dompdf
```

## 🚑📗 Documentação da API

### 🚥 Endpoints - Rotas Pacientes

#### S01 - Cadastro de Paciente

```http
  POST /api/pacientes
```

| Parâmetro            | Tipo     | Descrição                                                                    |
| :------------------- | :------- | :--------------------------------------------------------------------------- |
| `id`                 | `int`    | **Autoincremental**. Chave primaria                                          |
| `nome_completo`      | `string` | **Obrigatório**. Nome do paciente                                            |
| `genero`             | `string` | Genero do paciente                                                           |
| `data_nascimento`    | `date`   | **Obrigatório** Data de nascimento do paciente                               |
| `cpf`                | `string` | **Obrigatório**. CPF do paciente, único e válido                             |
| `telefone`           | `string` | Telefone do paciente                                                         |
| `contato_emergencia` | `string` | **Obrigatório**. Nome do contato de emergência                               |
| `lista_alergias`     | `string` | Alergias do paciente                                                         |
| `lista_cuidados`     | `string` | Cuidados especiais do paciente                                               |
| `convenio`           | `string` | Convênio do paciente                                                         |
| `status_atendimento` | `string` | Valores: 'AGUARDANDO_ATENDIMENTO','EM_ATENDIMENTO','ATENDIDO','NAO_ATENDIDO' |

Request JSON exemplo

```http
  {
    "nome_completo":"Paulo Nassi",
    "genero":"MASCULINO",
    "data_nascimento":"1984-03-01",
    "cpf":"47360294045",
	"telefone":"21 984569813",
    "contato_emergencia":"Marina Nassi",
	"lista_alergias":"Dipirona",
	"lista_cuidados":"nenhum",
	"convenio":"Amil",
	"status_atendimento":"AGUARDANDO_ATENDIMENTO"
}
```

| Response Status | Descrição         |
| :-------------- | :---------------- |
| `201`           | sucesso           |
| `400`           | dados inválidos   |
| `409`           | CPF já cadastrado |
| `500`           | erro interno      |

##

#### S02 - Atualização dos dados de Pacientes

```http
  PUT /api/pacientes/:id
```

| Parâmetro            | Tipo     | Descrição                       |
| :------------------- | :------- | :------------------------------ |
| `nome_completo`      | `string` | Nome do paciente                |
| `genero`             | `string` | Genero do paciente              |
| `data_nascimento`    | `date`   | Data de nascimento do paciente  |
| `cpf`                | `string` | CPF do paciente, único e válido |
| `telefone`           | `string` | Telefone do paciente            |
| `contato_emergencia` | `string` | Nome do contato de emergência   |
| `lista_alergias`     | `string` | Alergias do paciente            |
| `lista_cuidados`     | `string` | Cuidados especiais do paciente  |
| `convenio`           | `string` | Convênio do paciente            |

Request JSON exemplo

```http
/api/pacientes/1
```

```http
  {
	"telefone":"'1 9245698115",
	"convenio":"Unimed"
}
```

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `200`           | sucesso                                        |
| `400`           | dados inválidos                                |
| `404`           | não encontrado registro com o código informado |
| `500`           | erro interno                                   |

##

#### S03 - Atualização do status de atendimento

```http
  PUT /api/pacientes/:id/status
```

| Parâmetro            | Tipo     | Descrição                                                                    |
| :------------------- | :------- | :--------------------------------------------------------------------------- |
| `id`                 | `int`    | **Obrigatório** número inteiro chave primaria                                |
| `status_atendimento` | `string` | Valores: 'AGUARDANDO_ATENDIMENTO','EM_ATENDIMENTO','ATENDIDO','NAO_ATENDIDO' |

Request JSON exemplo

```http
/api/pacientes/1/status
```

```http
  {
	"status_atendimento":"EM_ATENDIMENTO"
  }
```

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `200`           | sucesso                                        |
| `400`           | dados inválidos                                |
| `404`           | não encontrado registro com o código informado |
| `500`           | erro interno                                   |

##

#### S04 - Listagem de Pacientes

```http
  GET /api/pacientes
```

Não é necessario resquest body

Opcionalmente pode ser utilizado no patch um query param informando: AGUARDANDO_ATENDIMENTO, EM_ATENDIMENTO, ATENDIDO e NAO_ATENDIDO

Exemplo:
`/api/pacientes?status=ATENDIDO`
| Parâmetro | Tipo | Descrição |
| :---------- | :--------- | :---------------------------------- |
| `status_atendimento` | `string` | Valores: 'AGUARDANDO_ATENDIMENTO','EM_ATENDIMENTO','ATENDIDO','NAO_ATENDIDO'|

Exemplo de resposta:

```http
{
	"id": 1,
	"nome_completo":"Paulo Nassi",
    "genero":"MASCULINO",
    "data_nascimento":"1984-03-01",
    "cpf":"47360294045",
	"telefone":"21 984569813",
    "contato_emergencia":"Marina Nassi",
	"lista_alergias":"Dipirona",
	"lista_cuidados":"nenhum",
	"convenio":"Amil",
	"status_atendimento": "ATENDIDO",
	"total_atendimentos": 1,
	"createdAt": "2023-04-19T10:32:32.796Z",
	"updatedAt": "2023-04-20T21:14:53.099Z"
}
```

| Response Status | Descrição |
| :-------------- | :-------- |
| `200`           | sucesso   |

##

#### S05 - Listagem de Paciente pelo identificador

```http
  GET /api/pacientes/:id
```

Não é necessario resquest body

Request exemplo:
`/api/pacientes/1`
| Parâmetro | Tipo | Descrição |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Exemplo de resposta:

```http
{
	"id": 1,
	"nome_completo":"Paulo Nassi",
    "genero":"MASCULINO",
    "data_nascimento":"1984-03-01",
    "cpf":"47360294045",
	"telefone":"21 984569813",
    "contato_emergencia":"Marina Nassi",
	"lista_alergias":"Dipirona",
	"lista_cuidados":"nenhum",
	"convenio":"Amil",
	"status_atendimento": "ATENDIDO",
	"total_atendimentos": 1,
	"createdAt": "2023-04-19T10:32:32.796Z",
	"updatedAt": "2023-04-20T21:14:53.099Z"
}
```

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `200`           | sucesso                                        |
| `404`           | não encontrado registro com o código informado |

##

#### S06 - Exclusão de Paciente

```http
  DELETE /api/pacientes/:id
```

Não é necessario resquest body

Request exemplo:
`/api/pacientes/1`
| Parâmetro | Tipo | Descrição |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Não há response no body em caso de sucesso

| Response Status | Descrição                                      |
| :-------------- | :--------------------------------------------- |
| `204`           | sucesso                                        |
| `404`           | não encontrado registro com o código informado |

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
