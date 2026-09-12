# teste-tecnico-estagio-dev-livros

CRUD simples de catálogo de livros (criar, listar, editar e excluir registros com título, autor, categoria e status).

## Sobre a Aplicação

Esta aplicação é um sistema de gerenciamento de catálogo de livros desenvolvido em PHP nativo e banco de dados SQLite. Ela permite gerenciar uma biblioteca através de uma interface web simples e intuitiva.

### Funcionalidades

- Listagem de Livros: Exibição de todos os livros cadastrados com título, autor, categoria e status de leitura.
- Cadastro de Livros: Adição de novos livros ao catálogo informando título, autor, categoria e status.
- Edição de Livros: Atualização dos dados de livros existentes no catálogo.
- Exclusão de Livros: Remoção de registros com confirmação prévia de segurança.
- Validação de Dados: Validações tanto no cliente (JavaScript) quanto no servidor (PHP).
- Seeder de Dados: Script para popular o banco de dados com dados iniciais de exemplo.

## Tecnologias Utilizadas

- PHP 8 (utilizando PDO para banco de dados)
- SQLite3
- HTML5, CSS3 e JavaScript Vanilla

## Estrutura do Projeto

- `index.php`: Página principal com a listagem dos livros e ações.
- `save.php`: Formulário e processamento para criação e edição de livros.
- `delete.php`: Processamento de remoção de registros.
- `database/db.php`: Conexão PDO e criação automática da tabela no SQLite.
- `database/seeder.php`: Script opcional para inserção de dados de teste.
- `assets/styles.css`: Estilização visual da aplicação.
- `assets/scripts.js`: Validações de formulário no lado do cliente.

## Pré-requisitos

- PHP 8.0 ou superior instalado.
- Extensão `pdo_sqlite` habilitada no PHP.

## Como Executar a Aplicação

1. Abra o terminal na pasta raiz do projeto.

2. (Opcional) Popule o banco de dados com registros de exemplo executando:

   ```bash
   php database/seeder.php // Ou acessando a rota "/database/seeder.php na url da aplicação
   ```

3. Inicie o servidor embutido do PHP:

   ```bash
   php -S localhost:8000
   ```

4. Acesse a aplicação no seu navegador pelo endereço:
   ```
   http://localhost:8000
   ```

## Como Utilizar a Aplicação

1. **Visualizar o catálogo**: Na página inicial, visualize a tabela com os livros cadastrados e seus status (Nunca lido, Em andamento, Lido).
2. **Cadastrar um livro**:
   - Clique no botão **+ Novo Livro**.
   - Preencha os campos Título, Autor, Categoria e Status.
   - Clique em **Cadastrar Livro**.
3. **Editar um livro**:
   - Clique no botão **Editar** na linha do livro desejado.
   - Altere as informações necessárias e clique em **Salvar Alterações**.
4. **Excluir um livro**:
   - Clique no botão **Excluir** na linha do livro desejado.
   - Confirme a mensagem de aviso para concluir a remoção.
