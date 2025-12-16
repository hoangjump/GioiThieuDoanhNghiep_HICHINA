# 🚀 HiChina - SQLite Version (No XAMPP needed!)

## ⚡ Quick Start (Giống React)

```bash
# 1. Clone
git clone <repo>
cd GioiThieuDoanhNghiep_HICHINA

# 2. Run (giống npm start)
php start.php

# 3. Open browser
http://localhost:8000
```

**DONE! ✅** No MySQL, no XAMPP, no config!

---

## 📋 Available Commands

### Start server (giống npm start)
```bash
php start.php
```

### Switch database type
```bash
# Use SQLite (default)
php switch-db.php sqlite

# Use MySQL
php switch-db.php mysql

# Check current DB
php switch-db.php status
```

### Reset database
```bash
rm hichina.db       # Delete SQLite file
php start.php       # Auto-create new DB
```

---

## 🎯 Features

✅ **Zero Configuration**
- No MySQL installation
- No config files to edit
- Auto-create database on first run
- Auto-create admin account

✅ **Full Functionality**
- Contact form → Save to DB
- Admin panel → Full CRUD
- Login/Logout → Session auth
- Search/Filter → All working

✅ **Development Friendly**
- Hot reload (just refresh browser)
- Single file database (hichina.db)
- Easy to reset/backup
- Works on any platform

---

## 📁 SQLite Files

```
config-sqlite.php    - SQLite configuration
start.php           - Start script (php start.php)
switch-db.php       - Switch between SQLite/MySQL
hichina.db          - Database file (auto-created)
QUICKSTART.md       - Quick start guide
README-SQLITE.md    - This file
```

---

## 🔄 Switch between MySQL & SQLite

### Currently using MySQL? Switch to SQLite:
```bash
php switch-db.php sqlite
php start.php
```

### Want to go back to MySQL?
```bash
php switch-db.php mysql
# Make sure MySQL is running!
```

---

## 💾 Database Location

**SQLite**: `hichina.db` (in project root)
**MySQL**: Server → hichina_db

---

## 🆚 When to use what?

### Use SQLite when:
✅ Local development
✅ Demo/Testing
✅ Small projects (<100k records)
✅ Don't want to install MySQL
✅ Want portable database

### Use MySQL when:
✅ Production deployment
✅ Large projects (>100k records)
✅ Multiple concurrent writers
✅ Need advanced features
✅ Already have MySQL setup

---

## 🎓 How it works

1. **start.php**:
   - Checks PHP version & extensions
   - Initializes SQLite database
   - Creates tables automatically
   - Starts PHP built-in server

2. **config-sqlite.php**:
   - Connects to SQLite using PDO
   - Auto-creates `hichina.db` file
   - Runs migrations (create tables)
   - Seeds default admin account

3. **SQLite Database**:
   - Single file: `hichina.db`
   - Same SQL syntax as MySQL
   - No server process needed
   - Portable & lightweight

---

## 🐛 Troubleshooting

### Error: "pdo_sqlite not found"

**Solution**: Enable extension in `php.ini`:
```ini
extension=pdo_sqlite
```

### Error: "Permission denied" on hichina.db

**Solution**: Give write permission:
```bash
chmod 666 hichina.db
```

### Want fresh start?

**Solution**: Delete database file:
```bash
rm hichina.db
php start.php  # Creates new DB
```

---

## 🔐 Default Admin

- **URL**: http://localhost:8000/admin/login.php
- **Username**: admin
- **Password**: admin123

---

## 📊 Performance

| Database | Size | Speed | Setup Time |
|----------|------|-------|------------|
| SQLite | 100KB | ⚡⚡⚡⚡⚡ | 0 seconds |
| MySQL | 10MB+ | ⚡⚡⚡⚡ | 10 minutes |

SQLite is **PERFECT** for development! 🎯

---

## 🌟 Bonus: No PHP? Use Docker!

```bash
# Dockerfile already includes PHP + SQLite
docker-compose up -d

# Access: http://localhost:8080
```

See [DOCKER.md](DOCKER.md) for details.

---

**Made with ❤️ by Claude**

*Inspired by the simplicity of React's "npm start"*
