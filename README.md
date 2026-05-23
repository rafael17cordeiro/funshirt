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

## 📋 Pré-requisitos

Antes de começarmos, verificar se temos as seguintes ferramentas instaladas no teu computador:
* [PHP](https://www.php.net/) (v8.2 ou superior)
* [Composer](https://getcomposer.org/)
* [Node.js e npm](https://nodejs.org/)
* [Git](https://git-scm.com/)

---

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
```bash
cp .env.example .env
php artisan key:generate
```


**4. Preparar a Base de Dados (SQLite):**
Criar o ficheiro vazio para a base de dados. Escolher o comando adequado ao sistema operativo:

* Mac / Linux:
```bash
touch database/database.sqlite
```
* Windows (PowerShell):
```bash
New-Item database/database.sqlite
```


**5. Migrações, Seeders e Storage:**
Criar as tabelas, popula a base de dados com os dados de teste e criar o atalho para as imagens públicas:
```bash
php artisan migrate --seed
php artisan storage:link
```

---

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

---

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

5. Revisão e Pull Request (PR): Ir ao GitHub, abrir um Pull Request da branch para a main e avisar o grupo para rever. O código só é fundido (merge) com a main após aprovação.

