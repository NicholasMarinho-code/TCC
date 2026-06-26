# TCC - Sistema de Monitoramento de Temperatura

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php)
![Supabase](https://img.shields.io/badge/Supabase-3ECF8E?style=for-the-badge&logo=supabase&logoColor=white)
![Firebase](https://img.shields.io/badge/Firebase-FFCA28?style=for-the-badge&logo=firebase&logoColor=black)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

Sistema desenvolvido para monitoramento de temperatura em tempo real, gerenciamento de dispositivos, usuários e emissão de alertas.

</div>

---

## Objetivo

O sistema foi desenvolvido como Trabalho de Conclusão de Curso (TCC) com o objetivo de:

- Monitorar temperaturas em tempo real;
- Gerenciar dispositivos IoT;
- Controlar permissões de usuários;
- Emitir alertas automáticos;
- Registrar leituras históricas;
- Permitir vinculação entre funcionários e dispositivos.

---

## Tecnologias Utilizadas

| Tecnologia | Função |
|-----------|--------|
| PHP | Backend |
| JavaScript | Interatividade |
| HTML5 | Interface |
| CSS3 | Estilização |
| Supabase | Banco de Dados |
| Firebase | Notificações e Integrações |
| SQL | Estrutura do banco |
| MVC | Organização do projeto |

---

## Arquitetura do Projeto

```text
TCC
│
├── controller/
│   ├── dispositivos-create.php
│   ├── dispositivos-read.php
│   ├── dispositivos-update.php
│   ├── dispositivos-delete.php
│   ├── usuario-create.php
│   ├── usuario-read.php
│   └── ...
│
├── model/
│
├── view/
│   ├── login.php
│   ├── menu.php
│   ├── api_temperatura.php
│   ├── leitura.php
│   ├── usuarios.php
│   └── ...
│
├── includes/
├── css/
├── img/
│
├── app.js
├── script.js
├── config.php
├── database.sql
└── index.php
```

---

## Funcionalidades

### Usuários

- Cadastro
- Edição
- Exclusão
- Controle de permissões
- Login

### Dispositivos

- Cadastro
- Atualização
- Exclusão
- Associação com funcionários

### Temperatura

- Coleta de leituras
- Histórico de medições
- Consulta em tempo real
- API dedicada

### Alertas

- Geração automática
- Registro de ocorrências
- Notificações utilizando Firebase

---

## Banco de Dados

O projeto utiliza o **Supabase** como solução de banco de dados em nuvem.

Principais vantagens:

- PostgreSQL gerenciado;
- Alta disponibilidade;
- API automática;
- Segurança integrada;
- Facilidade de escalabilidade.

As tabelas podem ser encontradas em:

```sql
database.sql
```

---

## Firebase

O Firebase é utilizado para:

- Notificações em tempo real;
- Serviços complementares de integração;
- Possível expansão para autenticação e mensageria.

---

## Instalação

### 1. Clonar o projeto

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
```

---

### 2. Configurar o Supabase

No arquivo:

```php
config.php
```

Adicionar:

```php
$url_supabase = '';
$key_supabase = '';
```

---

### 3. Configurar Firebase

Inserir as credenciais do Firebase conforme a necessidade do projeto.

---

### 4. Iniciar servidor local

Exemplo:

```bash
php -S localhost:8000
```

ou utilizar:

- XAMPP
- Laragon
- Apache

---

## Segurança

O sistema possui mecanismos para:

- Controle de acesso;
- Verificação de permissões;
- Restrição de páginas administrativas;
- Gerenciamento de sessões.

---

## Possíveis Melhorias

- Dashboard analítico;
- Gráficos históricos;
- Exportação em PDF;
- Integração com Telegram;
- Aplicativo mobile;
- IA para previsão de anomalias térmicas.

---

## Autores

Desenvolvido como projeto de **Trabalho de Conclusão de Curso (TCC)**.

Equipe responsável pelo desenvolvimento.

---

<div align="center">

**Sistema de Monitoramento de Temperatura**

Desenvolvido utilizando **PHP • Supabase • Firebase**

</div>
