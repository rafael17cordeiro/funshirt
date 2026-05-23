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

Antes de começares, certifica-te que tens as seguintes ferramentas instaladas no teu computador:
* [PHP](https://www.php.net/) (v8.2 ou superior)
* [Composer](https://getcomposer.org/)
* [Node.js e npm](https://nodejs.org/)
* [Git](https://git-scm.com/)

---

## 🚀 Instalação do Projeto

Segue os passos abaixo para configurares o ambiente de desenvolvimento na tua máquina local.

**1. Clonar o repositório:**
```bash
git clone https://github.com/rafael17cordeiro/funshirt.git
cd funshirt
```


**2. Instalar dependências:**
Instala as dependências do backend (PHP) e do frontend (Node.js):
```bash
composer install
npm install
```


**3. Configurar variáveis de ambiente:**
Cria o ficheiro .env a partir do exemplo e gera a chave de encriptação do Laravel:
```bash
cp .env.example .env
php artisan key:generate
```


**4. Preparar a Base de Dados (SQLite):**
Cria o ficheiro vazio para a base de dados. Escolhe o comando adequado ao teu sistema operativo:
* Mac / Linux:
```bash
touch database/database.sqlite
```
* Windows (PowerShell):
```bash
New-Item database/database.sqlite
```


**5. Migrações, Seeders e Storage:**
```bash
php artisan migrate --seed
php artisan storage:link
```
Cria as tabelas, popula a base de dados com os dados de teste e cria o atalho para as imagens públicas:
```bash
php artisan migrate --seed
php artisan storage:link
```

---

## 💻 Executar o Projeto no dia a dia

Para correres o projeto localmente, precisas de manter dois terminais abertos em simultâneo na pasta raiz do projeto (/funshirt):

** Terminal 1 (Servidor PHP): **
```bash
php artisan serve
```

**Terminal 2 (Compilador de Assets - CSS/JS):**
```bash
npm run dev
```

---

## 🌿 Gestão de Git e Fluxo de Trabalho (Workflow)
Para evitarmos conflitos e garantirmos a qualidade do projeto, a equipa deve seguir rigorosamente estas regras:

1. NUNCA programes ou faças commits diretamente na branch main
2. Sincroniza antes de começar: Antes de iniciares uma nova funcionalidade, garante que tens a versão mais recente do projeto localmente:
```bash
git checkout main
git pull
```
3. Cria uma nova branch para a tua tarefa: Usa um nome descritivo para o que vais desenvolver.
```bash
git checkout -b feature/nome-da-tua-tarefa
```
4. Quando terminares a tua funcionalidade (ou no fim do dia de trabalho), faz o commit e envia a branch para o repositório:
```bash
git add .
git commit -m "feat: descrição clara do que foi feito"
git push -u origin feature/nome-da-tua-tarefa
```

5. Revisão e Pull Request (PR): Vai ao GitHub, abre um Pull Request da tua branch para a main e avisa o grupo para rever. O código só é fundido (merge) com a main após aprovação.

