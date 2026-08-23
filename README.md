# MetaLink 💬

A real-time chat web app built with PHP, MySQL, and WebSockets (Ratchet). MetaLink lets users register, add friends, chat instantly, share WhatsApp-style disappearing "status" updates, and manage their profile — all served over your local network with a QR code for easy mobile access.

## Features

- 🔐 **Auth** — Register/Login with live username availability check
- 💬 **Real-time 1-on-1 chat** — Instant messaging over WebSockets (Ratchet + ReactPHP)
- 🟢 **Presence** — Online/offline status and last-seen tracking
- 🔔 **Unread counts** — Per-friend and total unread message badges, pushed live over the socket
- 🤝 **Friend requests** — Send, accept, and delete requests; block/unblock users
- 📸 **Status updates** — Upload photo/video statuses with comments, seen tracking, and delete
- 👤 **Profiles** — Editable bio, profile picture, email, and password (with change flows)
- 📱 **LAN + QR access** — `start.bat` detects your WiFi IPv4, launches both servers, and opens a QR code so you can log in straight from your phone

## Tech Stack

- **Backend:** PHP, MySQLi
- **Real-time layer:** [Ratchet](http://socketo.me/) (WebSocket server) + ReactPHP, running as a standalone PHP process
- **Database:** MySQL (schema in `metalink_db.sql`)
- **Frontend:** HTML, CSS, vanilla JS, [SweetAlert2](https://sweetalert2.github.io/) for notifications
- **Dependency management:** Composer (`vendor/` included)

## Project Structure

```
metalink-chat-app/
├── index.html              # Login & Register page
├── home.php                # Main chat dashboard
├── chat.php                # Chat window
├── profile.php / edit.php  # Profile view & edit
├── settings.php            # Account settings (email/password change)
├── requests.php / request.php / accept.php / delete_request.php
│                            # Friend request flow
├── status_upload.php / upload_status.php / comments.php
│                            # Status (stories) feature
├── server.php               # Ratchet WebSocket server (real-time messaging)
├── config.php               # Database connection config
├── metalink_db.sql           # Database schema
├── start.bat                 # Windows script: starts both servers + QR code
└── vendor/                   # Composer dependencies (Ratchet, ReactPHP, etc.)
```

## Getting Started

### Prerequisites

- PHP 7.4+ with the `mysqli` extension
- MySQL / MariaDB
- [Composer](https://getcomposer.org/) (only needed if `vendor/` isn't already present)

### 1. Clone the repo

```bash
git clone https://github.com/Inayat-dev/metalink-chat-app.git
cd metalink-chat-app
```

### 2. Set up the database

Create a database named `metalink_db` and import the schema:

```bash
mysql -u root -p metalink_db < metalink_db.sql
```

### 3. Configure the connection

Update the credentials in `config.php` (and in `server.php`, which connects separately) if your MySQL setup differs from the defaults:

```php
$host = 'localhost';
$username = "root";
$password = "";
$DB = "metalink_db";
```

### 4. Install dependencies (if needed)

```bash
composer install
```

### 5. Run the app

**On Windows**, just double-click (or run) `start.bat` — it will detect your WiFi IP, start the PHP server and WebSocket server, and pop up a QR code you can scan on your phone.

**On macOS/Linux**, start both processes manually:

```bash
php server.php &          # WebSocket server on port 8000
php -S 0.0.0.0:9000        # App server on port 9000
```

Then open `http://localhost:9000` (or your machine's LAN IP on port 9000 from another device).

## How It Works

- The PHP built-in server serves the app pages and handles standard requests (auth, friend requests, status uploads, etc.) via MySQL.
- A separate long-running PHP process (`server.php`) runs a Ratchet WebSocket server on port 8000. When a user opens the app, the frontend connects to this socket to send/receive messages, unread-count updates, and online/offline presence instantly, without polling.

## Notes

- This is a local/LAN-oriented project (no built-in HTTPS or production hardening) — intended for development, demos, and learning real-time architecture with PHP.
- Sample demo recordings are in the `status/` folder.

## License

No license specified yet — add one (e.g. MIT) if you plan to share this publicly.
