# Simple PHP  

A lightweight **PHP boilerplate** for building web applications quickly.  

This project provides a **pre-built PHP base** that includes:  

- **MVC structure** for clean code organization.  
- **Integrated router** (for REST APIs and views).  
- **Authentication with Google OAuth**.  
- **JWT (JSON Web Token) management** for secure sessions.  
- **Ready-to-use PostgreSQL connection** with PDO.  
- **Frontend integration with Node.js tools**.  
- **TailwindCSS pre-installed** for rapid UI development.  

Perfect for small to medium-sized projects where you need speed and flexibility without heavy frameworks.  

---

## Requirements  

Make sure you have the following installed:  

- [XAMPP](https://www.apachefriends.org/) (to run locally with Apache & PHP).  
- **PHP** 8.0 or higher.  
- [Node.js](https://nodejs.org/) and **npm** (for frontend dependency management).  
- [Composer](https://getcomposer.org/) (for PHP dependency management).  
- [PostgreSQL](https://www.postgresql.org/) (database).  

---

## Installation  

### 1. Clone the Repository  
```bash
git clone https://github.com/davidleonstr/SimplePHP
cd SimplePHP
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
```

### 4. Run the Development Server
```bash
npm run dev
```

### 5. Change the URL name in './htaccess'.
```
# Priority 1: Handle API routes first
RewriteRule ^(api|SimplePHP/api|SimplePHP/api)/(.*)$ api/index.php [QSA,L]
```