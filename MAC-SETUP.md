# 🍎 Chạy HiChina trên Mac (Port 5400)

## ⚡ Quick Start (Mac có sẵn PHP)

```bash
# 1. Clone code
git clone <repo-url>
cd GioiThieuDoanhNghiep_HICHINA

# 2. Chạy với port 5400
php start.php 5400

# 3. Mở browser
open http://localhost:5400
```

✅ **Done!** Mac đã có PHP built-in sẵn!

---

## 🎯 **3 Cách chạy trên Mac:**

### **Cách 1: start.php với custom port**

```bash
# Default port 8000
php start.php

# Custom port 5400
php start.php 5400

# Bất kỳ port nào
php start.php 3000
php start.php 9999
```

### **Cách 2: PHP server trực tiếp**

```bash
# Port 5400
php -S localhost:5400

# Port khác
php -S localhost:3000
```

### **Cách 3: Docker với port 5400**

Tạo file `docker-compose.override.yml`:

```yaml
version: '3.8'

services:
  web:
    ports:
      - "5400:80"  # Đổi từ 8080 sang 5400

  phpmyadmin:
    ports:
      - "5401:80"  # phpMyAdmin
```

Sau đó chạy:

```bash
docker-compose up -d

# Truy cập
open http://localhost:5400
```

---

## 🔧 **Mac-specific Tips:**

### Kiểm tra PHP version (Mac có sẵn)
```bash
php -v

# Output mẫu:
# PHP 8.1.2 (cli)
```

### Nếu port bị chiếm
```bash
# Kiểm tra port nào đang dùng
lsof -i :5400

# Kill process
kill -9 <PID>

# Hoặc dùng port khác
php start.php 5401
```

### Enable SQLite (thường đã enable sẵn)
```bash
# Check
php -m | grep sqlite

# Nếu chưa có, cài Homebrew PHP
brew install php
```

### Homebrew (nếu muốn PHP mới nhất)
```bash
# Cài Homebrew (nếu chưa có)
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Cài PHP
brew install php

# Check version
php -v
```

---

## 🚀 **Commands cho Mac:**

### Start server
```bash
# Default port 8000
php start.php

# Port 5400
php start.php 5400

# Background mode (không block terminal)
php start.php 5400 &

# Hoặc dùng nohup
nohup php start.php 5400 > server.log 2>&1 &
```

### Stop server
```bash
# Ctrl+C trong terminal

# Hoặc kill process
ps aux | grep php
kill <PID>

# Hoặc killall
killall php
```

### Check status
```bash
# Check PHP đang chạy
ps aux | grep php

# Check port đang dùng
lsof -i :5400

# Check database
ls -lh hichina.db
```

---

## 🎨 **Mac Terminal Tips:**

### Mở browser tự động
```bash
# Tạo alias trong ~/.zshrc hoặc ~/.bash_profile
alias hichina="php start.php 5400 && open http://localhost:5400"

# Reload shell
source ~/.zshrc

# Chạy
hichina
```

### Tạo app shortcut (optional)
```bash
# Tạo file run.command
echo '#!/bin/bash
cd "$(dirname "$0")"
php start.php 5400' > run.command

# Cho phép execute
chmod +x run.command

# Double-click run.command để chạy!
```

---

## 🐳 **Docker trên Mac:**

### Install Docker Desktop for Mac
1. Download: https://www.docker.com/products/docker-desktop/
2. Install .dmg file
3. Start Docker Desktop

### Run với Docker (port 5400)
```bash
# Tạo override file
cat > docker-compose.override.yml << EOF
version: '3.8'
services:
  web:
    ports:
      - "5400:80"
  phpmyadmin:
    ports:
      - "5401:80"
EOF

# Start
docker-compose up -d

# Check
docker-compose ps

# Truy cập
open http://localhost:5400
open http://localhost:5401  # phpMyAdmin
```

---

## 📊 **Performance trên Mac:**

Mac (M1/M2) chạy cực nhanh với SQLite:

| Device | SQLite Speed | MySQL Speed |
|--------|-------------|-------------|
| Mac M1 | ⚡⚡⚡⚡⚡ | ⚡⚡⚡⚡ |
| Mac Intel | ⚡⚡⚡⚡ | ⚡⚡⚡ |
| Windows | ⚡⚡⚡ | ⚡⚡ |

---

## 🔍 **Troubleshooting Mac:**

### "Address already in use"
```bash
# Port 5400 đã bị dùng
lsof -i :5400
kill -9 <PID>

# Hoặc dùng port khác
php start.php 5401
```

### "Permission denied"
```bash
# Give permission
chmod +x start.php
chmod 666 hichina.db
```

### SQLite extension not found (hiếm gặp)
```bash
# Cài PHP qua Homebrew
brew install php

# Check
php -m | grep sqlite
```

### Port < 1024 cần sudo
```bash
# Port 80 cần sudo
sudo php start.php 80

# Nên dùng port > 1024
php start.php 5400  # OK!
```

---

## 🎯 **Recommended Setup cho Mac:**

```bash
# 1. Clone
git clone <repo>
cd GioiThieuDoanhNghiep_HICHINA

# 2. Switch to SQLite (if needed)
php switch-db.php sqlite

# 3. Run on port 5400
php start.php 5400

# 4. Open browser
open http://localhost:5400
```

---

## 💡 **Pro Tips:**

### VS Code terminal
```bash
# Mở terminal trong VS Code (Cmd+`)
php start.php 5400

# Split terminal (Cmd+\)
# Terminal 1: Server
# Terminal 2: Git commands
```

### iTerm2 hotkey
```bash
# Setup hotkey trong iTerm2
# Preferences > Keys > Hotkey Window
# Set: Cmd+Shift+T

# Quick access terminal!
```

### Auto-open browser
```bash
# Update start.php thêm dòng này
echo "Opening browser...\n";
exec("open http://localhost:$port");
```

---

## 📁 **Files structure trên Mac:**

```
~/Projects/GioiThieuDoanhNghiep_HICHINA/
├── hichina.db           # SQLite database
├── start.php            # Start script
├── config-sqlite.php    # SQLite config
└── ...
```

---

## 🆚 **Mac vs Windows:**

| Feature | Mac | Windows |
|---------|-----|---------|
| PHP built-in | ✅ Yes | ❌ No |
| Setup time | ⚡ 0 min | 🐢 10 min |
| Commands | Unix-style | CMD/PowerShell |
| Performance | ⚡⚡⚡⚡⚡ | ⚡⚡⚡ |

Mac = Best for development! 🍎

---

## 🎉 **Quick Commands Cheatsheet:**

```bash
# Start
php start.php 5400

# Check status
lsof -i :5400

# Stop
Ctrl+C

# Reset DB
rm hichina.db && php start.php 5400

# Switch DB
php switch-db.php sqlite
php switch-db.php mysql

# Docker
docker-compose up -d

# Open browser
open http://localhost:5400
```

---

**Happy Coding on Mac! 🍎**

*Mac + PHP + SQLite = Perfect combo!*
