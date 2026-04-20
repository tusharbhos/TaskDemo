# RBAC App — Role-Based Access Control System

A full-stack PHP web application built with **Laravel 12** implementing role-based access control (RBAC) following clean MVC architecture with Service and Repository pattern.

---

## Tech Stack

| Layer       | Technology                  |
|-------------|-----------------------------|
| Framework   | Laravel 12 (PHP 8.2+)       |
| Database    | SQLite (dev) / MySQL (prod) |
| Frontend    | Blade Templates + Vite      |
| Auth        | Manual (no Breeze/UI/Auth)  |
| Hashing     | Bcrypt (12 rounds)          |

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/       AuthController, DealerController, EmployeeController
│   ├── Middleware/        RoleMiddleware   (role:dealer | role:employee)
│   └── Requests/          RegisterRequest, LoginRequest, DealerProfileRequest
├── Models/                User, Role, DealerProfile
├── Repositories/          UserRepository, DealerRepository
└── Services/              AuthService
database/
└── migrations/            Single migration: roles → users → dealer_profiles
resources/views/
├── auth/                  login.blade.php, register.blade.php
├── dashboard/             dealer.blade.php, employee.blade.php
├── dealer/                profile.blade.php
├── employee/              dealer-detail.blade.php
└── layouts/               app.blade.php, guest.blade.php
```

---

## Database Design

```
roles
  id | name (unique) | label | timestamps

users
  id | first_name | last_name | email (indexed, unique)
   | password | role_id (FK→roles) | is_active | timestamps

dealer_profiles
  id | user_id (unique FK→users) | company_name | phone
   | city | state | zip (indexed) | timestamps
```

**Indexes:** `users.email`, `dealer_profiles.zip`
**Foreign Keys:** `users.role_id → roles.id`, `dealer_profiles.user_id → users.id` (cascade delete)

---

## ER Diagram

```
+----------+       +--------------------+       +------------------+
|  roles   |       |       users        |       | dealer_profiles  |
+----------+       +--------------------+       +------------------+
| PK id    |◄──────| PK id              |◄──────| PK id            |
| name     | 1   N | first_name         | 1   1 | user_id (FK, UQ) |
| label    |       | last_name          |       | company_name     |
+----------+       | email (UQ, IDX)    |       | phone            |
                   | password           |       | city             |
                   | role_id (FK)       |       | state            |
                   | is_active          |       | zip (IDX)        |
                   | timestamps         |       | timestamps       |
                   +--------------------+       +------------------+

Roles: employee | dealer
Relationship: User hasOne DealerProfile (dealers only)
```

---

## Setup & Running

### Requirements

- PHP 8.2+
- Composer
- Node.js & npm

### Step-by-Step Setup

```bash
# 1. Clone the project
git clone <repo-url>
cd rbac-app

# 2. Install PHP dependencies
composer install

# 3. Create environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Run migrations (creates all tables)
php artisan migrate

# 6. Seed demo data (roles + demo users)
php artisan db:seed

# 7. Install frontend dependencies
npm install

# 8. Build frontend assets
npm run build
# OR for development with hot-reload:
npm run dev

# 9. Start the development server
php artisan serve
```

Open your browser at: **http://localhost:8000**

---

## Demo Credentials

After running `php artisan db:seed`, use these accounts:

| Role     | Email             | Password   |
|----------|-------------------|------------|
| Employee | employee@demo.com | Password@1 |
| Dealer   | dealer@demo.com   | Password@1 |

---

## Website Flow

### Overview

```
http://localhost:8000
        │
        ▼
   /login  ◄── (default redirect)
        │
  ┌─────┴─────┐
  │           │
Register     Login
  │           │
  └─────┬─────┘
        │
   Role-based redirect
        │
   ┌────┴────┐
   ▼         ▼
Dealer    Employee
Dashboard  Dashboard
```

---

### Registration Flow

```
GET  /register
  └─► Show registration form
        Fields: first_name, last_name, email, password, role
        If role = dealer: also company_name, phone, city, state, zip

POST /register
  └─► Validate all fields (RegisterRequest)
        │
        ├─► Create User record (password bcrypt hashed)
        │
        ├─► role === 'dealer' ?
        │       YES ──► Create dealer_profile record
        │       NO  ──► Skip
        │
        └─► Auto-login + session regenerate
              │
              role === 'dealer'   ──► redirect /dealer/dashboard
              role === 'employee' ──► redirect /employee/dashboard
```

---

### Login Flow

```
GET  /login
  └─► Show login form (email + password)

POST /login
  └─► Validate (LoginRequest)
        │
        └─► Auth::attempt(email, password)
              │
              ├─ Success → Regenerate session → Redirect by role
              └─ Fail    → Back with error message
```

---

### Dealer Flow

```
Authenticated as 'dealer'

GET  /dealer/dashboard
  └─► View own profile summary (name, company, city, state)

GET  /dealer/profile
  └─► Show edit form: company_name, phone, city, state, zip

POST /dealer/profile
  └─► Validate (DealerProfileRequest)
        └─► Update dealer_profile record
              └─► Redirect /dealer/dashboard with success message
```

---

### Employee Flow

```
Authenticated as 'employee'

GET  /employee/dashboard
  └─► View list of all registered dealers

GET  /employee/dealer/{id}
  └─► View full profile detail of a specific dealer
```

---

### Logout Flow

```
POST /logout
  └─► Auth::logout()
        └─► session()->invalidate()
              └─► session()->regenerateToken()
                    └─► Redirect to /login
```

---

## Authentication Details

- **No Breeze / UI / Auth scaffolding** — implemented fully manually
- Passwords hashed with **bcrypt (12 rounds)**
- Session regenerated on login and logout (prevents session fixation)
- `RoleMiddleware` returns **HTTP 403** on unauthorized role access
- `guest` middleware prevents authenticated users from accessing `/login` and `/register`

### Password Requirements

| Rule              | Requirement                        |
|-------------------|------------------------------------|
| Minimum length    | 8 characters                       |
| Uppercase letter  | At least 1 (A–Z)                   |
| Lowercase letter  | At least 1 (a–z)                   |
| Number            | At least 1 digit (0–9)             |
| Special character | At least one of: `@ $ ! % * # ? &` |

---

## Route Summary

| Method | URL                      | Middleware           | Action                      |
|--------|--------------------------|----------------------|-----------------------------|
| GET    | `/`                      | —                    | Redirect → `/login`         |
| GET    | `/register`              | guest                | Show registration form      |
| POST   | `/register`              | guest                | Register new user           |
| GET    | `/login`                 | guest                | Show login form             |
| POST   | `/login`                 | guest                | Authenticate user           |
| POST   | `/logout`                | auth                 | Logout user                 |
| GET    | `/dealer/dashboard`      | auth, role:dealer    | Dealer dashboard            |
| GET    | `/dealer/profile`        | auth, role:dealer    | Edit dealer profile         |
| POST   | `/dealer/profile`        | auth, role:dealer    | Update dealer profile       |
| GET    | `/employee/dashboard`    | auth, role:employee  | Employee dashboard          |
| GET    | `/employee/dealer/{id}`  | auth, role:employee  | View specific dealer detail |

---

## Running Tests

```bash
php artisan test
```

---

## License

MIT
