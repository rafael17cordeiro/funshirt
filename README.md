<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">👕 FunShirt - Loja Online</h1>

<p align="center">
  <strong>Projeto de Aplicações para a Internet (2025/2026) - Engenharia Informática</strong><br>
  Uma loja online de t-shirts estampadas desenvolvida em Laravel 12+ com Tailwind CSS e Alpine.js.
</p>


---

<div align="center">
  <img src="https://img.shields.io/github/repo-size/rafael17cordeiro/funshirt?style=flat-square" alt="Repo Size">
  <img src="https://img.shields.io/github/last-commit/rafael17cordeiro/funshirt?style=flat-square" alt="Last Commit">
  <img src="https://img.shields.io/github/languages/top/rafael17cordeiro/funshirt?style=flat-square" alt="Top Language">
  <img src="https://img.shields.io/badge/Status-In_Development-yellow?style=flat-square" alt="Status">
  <br>
  <img src="https://komarev.com/ghpvc/?username=rafael17cordeiro-funshirt&label=Profile%20Views&color=blue&style=flat-square" alt="Views">
</div>
<br><br>

## 📋 Pré-requisitos

Antes de começarmos, verifica se tens as ferramentas necessárias instaladas no teu computador.

🚀 **Recomendação para Windows e macOS:** Para evitar erros de configuração manuais, é recomendado a instalação do **[Laravel Herd](https://herd.laravel.com/)**. O Herd instala e configura automaticamente o PHP, o Composer e o Node.js num único clique.

Caso opte pela instalação manual (ou se usar **Linux**), garante que tem instalado:
* [PHP](https://www.php.net/) (v8.2 ou superior)
* [Composer](https://getcomposer.org/)
* [Node.js e npm](https://nodejs.org/)
* [Git](https://git-scm.com/)

<br><br>

---

<br><br>

## 🚀 Instalação do Projeto

Seguir os passos abaixo para configurar o ambiente de desenvolvimento na tua máquina local.

**1. Clonar o repositório:**
```bash
git clone https://github.com/rafael17cordeiro/funshirt.git
cd funshirt
```


**2. Instalar dependências:**
Instalar as dependências do backend (PHP) e do frontend (Node.js):
```bash
composer install
npm install
```


**3. Configurar variáveis de ambiente:**
Criar o ficheiro .env a partir do exemplo e gerar a chave de encriptação do Laravel:

* Linux / Mac / Git Bash / PowerShell:
```bash
cp .env.example .env
php artisan key:generate
```

* Windows (CMD Tradicional):
```bash
copy .env.example .env
php artisan key:generate
```


**4. Preparar a Base de Dados (SQLite):**
Criar o ficheiro vazio para a base de dados. Escolher o comando adequado ao sistema operativo:

* Mac / Linux / Git Bash:
```bash
touch database/database.sqlite
```
* Windows (PowerShell):
```bash
New-Item database/database.sqlite
```
* Windows (CMD):
```bash
type nul > database\database.sqlite
```


**5. Migrações, Seeders e Storage:**
Criar as tabelas, popula a base de dados com os dados de teste e criar o atalho para as imagens públicas:
```bash
php artisan migrate --seed
php artisan storage:link
```

<br><br>

---

<br><br>

## 💻 Executar o Projeto no dia a dia

Para correr o projeto localmente é preciso de manter dois terminais abertos em simultâneo na pasta raiz do projeto (/funshirt):

**Terminal 1 (Servidor PHP):**
```bash
php artisan serve
```

**Terminal 2 (Compilador de Assets - CSS/JS):**
```bash
npm run dev
```
<br><br>

---

<br><br>

## 🌿 Gestão de Git e Fluxo de Trabalho (Workflow)
Para evitar conflitos e garantir a qualidade do projeto, é necessario seguir rigorosamente regras:

1. NUNCA programar ou fazer commits diretamente na branch main
2. **Sincronizar antes de começar:** Antes de iniciar uma nova tarefa, garantir que se tem a versão mais recente do projeto localmente:
```bash
git checkout main
git pull
```
3. **Criar uma nova branch para a nova tarefa:** Usar um nome descritivo para o que que se vai desenvolver.
```bash
git checkout -b feature/nome-da-tua-tarefa
```
4. Quando termina a funcionalidade fazer o commit e enviar a branch para o repositório:
```bash
git add .
git commit -m "feat: descrição clara do que foi feito"
git push -u origin feature/nome-da-tua-tarefa
```

5. **Revisão e Pull Request (PR):** Ir ao GitHub, abrir um Pull Request da branch para a main e avisar o grupo para rever. O código só é fundido (merge) com a main após aprovação.

6. **Limpar e Voltar à base:** Depois da PR ser aprovada e fundida no GitHub, voltar à branch principal no terminal, atualizar o projeto e apagar a branch antiga:

```bash
git checkout main
git pull
git branch -d feature/nome-da-tua-tarefa
```
<br><br>

---
<br><br>

## 📊 Ponto de Situação do Projeto

Abaixo encontra-se o mapeamento das funcionalidades implementadas e dos requisitos do enunciado que ainda precisam de ser desenvolvidos pela equipa.

### ✅ O que já está implementado
- [x] **Autenticação Base:** Sistema de Login e Registo configurado (Laravel Breeze).
- [x] **Interface e Design:** UI minimalista, tipografia Montserrat aplicada e Navbar dinâmica e unificada em todas as páginas.
- [x] **Catálogo (Lado Público):** Grelha de t-shirts, filtragem por categorias com barra de navegação horizontal (scroll invisível com setas de navegação) e pesquisa funcional.
- [x] **Detalhe do Produto:** Visualização individual, escolha de cor, tamanho e quantidade com feedback visual instantâneo (Toast animado de sucesso).
- [x] **Carrinho de Compras (Sessão):** Persistência dos dados na sessão do servidor, listagem de itens, cálculo automático de subtotais/totais, contador dinâmico na Navbar, remoção de itens com ícone de lixo e Toast de feedback.

<br><br>

---

<br><br>

### 🛠️ O que falta implementar (Grupos do Enunciado)

#### G1. Autenticação, Perfil e Gestão de Utilizadores
- [ ] Verificação/confirmação de e-mail obrigatória para novos clientes (via Mailtrap).
- [ ] Recuperação de senha ("reset") com envio de link por e-mail (via Mailtrap).
- [ ] **Área do Cliente:** Edição de dados pessoais e upload de fotografia/avatar.
- [ ] **Backoffice do Admin:** CRUD completo para gestão de colaboradores (criar, bloquear ou remover funcionários e outros administradores).
- [ ] **Backoffice do Admin:** Listagem, filtragem e bloqueio de clientes (usar *soft delete* obrigatoriamente se o cliente tiver histórico).

#### G2. Catálogo (Gestão de Backoffice)
- [ ] **Backoffice do Admin:** CRUD completo de Imagens de T-shirts do catálogo público (com upload de ficheiros).
- [ ] **Backoffice do Admin:** CRUD completo de Categorias e Cores disponíveis para venda (com upload das respetivas t-shirts base).
- [ ] **Backoffice do Admin:** Painel de configuração de preços da loja (preço catálogo, preço personalizada, descontos e limiar de quantidade na tabela `prices`).

#### G3. Carrinho de Compras (Ajustes Finais)
- [ ] Funcionalidade de alterar características (cor, tamanho e quantidade) diretamente na página do carrinho.
- [ ] Botão de limpeza total do carrinho numa única operação.
- [ ] Mecanismo para remover automaticamente o item caso a quantidade seja reduzida para zero (0).

#### G4. Encomendas e Checkout
- [ ] **Processo de Checkout:** Exclusivo para clientes autenticados (redirecionar anónimos mantendo o carrinho).
- [ ] **Formulário de Checkout:** Campos de NIF (9 dígitos), endereço, método e referência de pagamento pré-preenchidos com os dados do perfil, mas editáveis.
- [ ] **Integração de Pagamento:** Consumir a API externa simulada (`https://ainet-payments-api.vercel.app`) usando o *Laravel HTTP Client* para validar Visa, PayPal ou MB WAY.
- [ ] **Registo na BD:** Gravação das tabelas `orders` e `order_items` replicando os preços exatos do momento da compra (imutabilidade do histórico).
- [ ] **Histórico do Cliente:** Página para o cliente consultar as suas encomendas anteriores e detalhes.
- [ ] **Logística dos Funcionários:** Tela para funcionários consultarem encomendas `pending` e transitá-las para `closed` pós-envio.
- [ ] **Controlo do Admin:** Permissão para o Admin filtrar qualquer encomenda, alterá-la para `closed` ou `canceled` (com registo opcional do motivo de cancelamento).

#### G5. Imagens Personalizadas
- [ ] **Área Exclusiva do Cliente:** Espaço privado para o cliente fazer upload, consultar, atualizar e remover as suas próprias imagens (armazenadas em `storage/app/private/tshirt_images_private`).
- [ ] Aplicar a lógica de preço diferenciado (`unit_price_own`) para t-shirts que utilizem estas imagens privadas.

#### G6. Recibos e E-mails
- [ ] **Geração de PDF:** Criar automaticamente o recibo em PDF estruturado (armazenado na pasta privada) assim que o estado passa para `closed`.
- [ ] **Notificações por E-mail (Mailtrap):**
- [ ] Envio de e-mail ao criar encomenda (`pending`).
- [ ] Envio de e-mail ao anular encomenda (`canceled`).
- [ ] Envio de e-mail ao expedir encomenda (`closed`) com o recibo PDF em anexo.

#### G7. Preview de T-shirts (Opcional/Extra)
- [ ] Implementar a sobreposição visual (via CSS ou biblioteca PHP) da imagem da estampagem por cima da t-shirt base da cor selecionada no carrinho, detalhes ou PDF.

#### G8. Estatísticas
- [ ] **Painel do Admin:** Desenvolver um dashboard gráfico/métrico com os indicadores de desempenho do negócio (volume de vendas, médias temporais, produtos mais vendidos, etc.).

<br><br>

---

<br><br>

## ⚖️​ Divisão de Tarefas

<br>

#### 🧑‍💻 Membro 1: Carrinho, Checkout e Faturação
#### G3. Carrinho de Compras:
- Alterar características (cor, tamanho, quantidade) no carrinho.
- Limpeza total do carrinho.
- Remover item automaticamente se a quantidade for 0.
#### G4. Encomendas e Checkout (Lado do Cliente):
- Proteger o checkout (só para autenticados).
- Formulário com dados pré-preenchidos e editáveis.
- Integração da API de Pagamentos (Visa, PayPal, MB WAY).
- Gravação na BD (`orders` e `order_items`) congelando os preços.
- Página do Histórico de Encomendas do Cliente.
#### G6. Recibos e E-mails (Ligado ao Checkout):
- Gerar o recibo PDF.
- Enviar os e-mails (via Mailtrap) na criação, anulação e expedição (com PDF).


<br><br>

#### 🧑‍💻 Membro 2: Utilizadores, Logística e Estatísticas
#### G1. Autenticação, Perfil e Utilizadores:
- Verificação/confirmação de e-mail e recuperação de senha.
- Área do Cliente (edição de dados e upload de avatar).
- CRUD do Admin para gerir colaboradores.
- Listagem e bloqueio de clientes (com *soft delete*).
#### G4. Encomendas e Checkout (Lado do Staff):
- Ecrã para Funcionários passarem encomendas de `pending` para `closed`.
- Ecrã para Admins filtrarem e anularem (`canceled`) com motivo.
#### G8. Estatísticas:
- Dashboard do Admin com métricas e gráficos de desempenho do negócio.

<br><br>


#### 🧑‍💻 Membro 3: O "Gestor de Produto" (Catálogo, Uploads e Efeitos Visuais)
#### G2. Catálogo (Backoffice):
- CRUD das Imagens do catálogo público.
- CRUD de Categorias e Cores (com as t-shirts base).
- Painel de configuração de preços (tabela `prices`).
#### G5. Imagens Personalizadas::
- Área privada do cliente para gerir (upload/atualizar/remover) as suas próprias estampagens (`storage/app/private...`).
- Lógica de preço diferenciado (`unit_price_own`) ao usar estas imagens.
#### G7. Preview de T-shirts:
- Criar a sobreposição visual da estampa em cima da t-shirt base (no carrinho, detalhe e PDF)

