<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 👕 FunShirt - Projeto de Aplicações para a Internet

Projeto desenvolvido para a UC de Aplicações para a Internet (2025/2026) - Engenharia Informática.
Uma loja online de t-shirts estampadas desenvolvida em Laravel 12+ com TailwindCSS e Alpine.js.

---

## 🚀 Como instalar o projeto na tua máquina

Para começares a trabalhar, abre o teu terminal e segue estes passos um a um:

**1. Clonar o repositório para o teu computador:**
```bash
git clone https://github.com/rafael17cordeiro/funshirt
cd funshirt 
```

**2. Instalar as dependências de PHP e Node.js:**
```bash
composer install
npm install
```

**3. Configurar as variáveis de ambiente:**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Preparar a Base de Dados SQLite:**
Cria o ficheiro da base de dados manualmente correndo:
```bash
Mac/Linux: touch database/database.sqlite
Windows: New-Item database/database.sqlite
```


**5. Criar as tabelas, carregar os dados de teste e ativar as imagens:**
```bash
php artisan migrate --seed
php artisan storage:link
```





## 💻 Como correr o projeto no dia a dia
Vais precisar sempre de ter dois terminais abertos a correr em simultâneo na pasta do projeto:
*** Terminal 1 (Servidor PHP): ***
```bash
php artisan serve
```

*** Terminal 2 (Compilador de CSS/JS): ***
```bash
npm run dev
```


