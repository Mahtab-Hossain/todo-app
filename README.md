# To-Do Application with breaze-auth

A Laravel app for managing tasks using sessions, with authentication, theme switching via cookies, CSRF protection, and validation.

## Features
- Login/register with Laravel Breeze
- Add, edit, delete, view tasks (stored in sessions)
- Light/dark theme toggle (saved in cookies)
- CSRF-protected forms
- Validation: Title (required, min 3 chars), Description (optional, max 255 chars)
- Tailwind-styled, Google Form-like UI

## Prerequisites
- PHP 8.1+
- Composer
- Node.js/NPM
- SQLite (for user auth)

## Installation
1. `git clone <your-repo-url> todo-app`
2. `cd todo-app`
3. `composer install`
4. `npm install`
5. `cp .env.example .env`
6. `php artisan key:generate`
7. `php artisan migrate`
8. `npm run dev`
9. `php artisan serve`

## Usage
- Register/login at `/register` or `/login`
- Access tasks at `/tasks`
- Toggle theme via button on task page