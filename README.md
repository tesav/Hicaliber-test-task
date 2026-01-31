# Hicaliber Test Task

Test task project based on Vue 3, Laravel 12, Docker, Nginx, and PostgreSQL.

**Original assignment:** <a href="https://drive.google.com/drive/folders/0ByqxhUNvccJxdTdROE5aX3VSOWc?resourcekey=0-Cf8K_Zu0DCnnhfFs3aokDQ" target="_blank">View here</a>

---

## 🚀 Getting Started

### Prerequisites
Make sure you have installed:
- Docker
- Docker Compose

### Clone the repository

```bash
git clone https://github.com/tesav/Hicaliber-test-task.git

cd Hicaliber-test-task
```

### Run the application

```bash
docker compose up -d
```

### Open the application in your browser:

http://localhost:8080

### Stop containers

```bash
docker compose down
```

### Optional: Rebuild containers from scratch

```bash
docker compose down -v
docker compose up --build -d
```

⚠️ This will remove all Docker volumes.  
All database data will be deleted.

---

## 🐳 Services

The project runs the following services via Docker:

- **frontend** — Vue 3
- **app** — PHP 8.4 (Laravel 12, PHP-FPM)
- **nginx** — web server
- **db** — PostgreSQL 16

---

## 📝 Notes

- Database migrations and seeders run automatically on container startup.
- Frontend assets are built using Vite.
- The project environment is configured for local development.
