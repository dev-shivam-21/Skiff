# Skiff – Simple, Fast & Secure Device-to-Device File Sharing

Skiff is a lightweight, browser-based peer-to-peer file transfer platform that lets you share files directly between two devices without installing any software or creating an account.

Using **WebRTC DataChannels**, Skiff establishes a direct connection between devices, allowing files to be transferred without routing the actual file data through a central server. A lightweight PHP signaling system helps devices discover and establish connections using unique pairing codes or QR codes.

### ✨ Features

- **Peer-to-Peer Transfers:** Direct device-to-device file sharing using WebRTC.
- **No Account Required:** Start sharing without registration or login.
- **QR Code Pairing:** Connect devices instantly by scanning a QR code.
- **5-Character Connection Code:** Easily pair devices manually.
- **Multiple File Support:** Send multiple files in one session.
- **Live Transfer Progress:** Monitor file transfer progress and speed.
- **Drag & Drop:** Simply drag files into the transfer area.
- **Automatic Downloads:** Received files are ready to save.
- **Responsive Interface:** Works across desktop and mobile browsers.
- **Light & Dark Themes:** Automatically adapts to system preferences.
- **Lightweight Backend:** PHP-based signaling, compatible with shared hosting environments such as InfinityFree.

### 🛠️ Technology Stack

- HTML5
- CSS3
- JavaScript
- WebRTC
- PHP
- QRCode.js

### 🔒 Privacy & Security

File contents are transferred directly between connected devices through WebRTC DataChannels. The PHP server handles connection signaling, not file storage or file transfer.

### 🚀 Deployment

Designed to run on PHP-supported web hosting, including InfinityFree. HTTPS is required for browser features such as WebRTC and camera-related functionality.

### 👨‍💻 Developer

Developed by **Shivam Dudhagara**

GitHub: https://github.com/dev-shivam-21

### 📄 License & Copyright

Copyright © 2026 Shivam Dudhagara. All rights reserved.
