# Laravel Task Management API

## 📌 Description
This is a RESTful API built using Laravel for managing tasks. It includes authentication, CRUD operations, search, and pagination.

---

## 🚀 Features
- User Authentication (Register & Login)
- CRUD Task
- Search Task
- Pagination
- User-based Authorization

---

## ⚙️ Tech Stack
- Laravel
- MySQL
- Laravel Sanctum

---

## 🔐 Authentication

### Register
POST /api/register

```json
{
  "name": "Kevin",
  "email": "kevin@test.com",
  "password": "123456"
}
