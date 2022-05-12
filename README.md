# PHP Url Shortener Project
Small PHP url shortener website that use MVC pattern. The aim of the work is to learn and create a project that meets requirements of a normal functioning website.

## Features
- General
  - [ ] Url shortening. Base62 encode/decode
  - [ ] Create short url without registration
    - [ ] Assign a url to the user when registering
- Account
  - Management
    - User shortened links 
      - [ ] Edit
      - [ ] Activate/pause
      - [ ] Delete
    - [ ] Change email
    - [ ] Change password
  - Registration
    - [x] One email per website (prevent email collision)
  - [x] Login
  - [x] Logout
- Security
  - [x] Password BCRYPT hash/verification
  - [x] Three accounts per IP address 
  - [ ] Limit attempts to prevent brute-force
  - [x] SQL injection protection. Prepared statements
  - [ ] CSRF protection
  - [ ] XSS protection

## PHP Libraries
- [nikic/fast-route](https://github.com/nikic/FastRoute)
- [patricklouys/http](https://github.com/PatrickLouys/http)
- [mustache/mustache](https://github.com/bobthecow/mustache.php)
- [rdlowrey/auryn](https://github.com/rdlowrey/auryn)

## UI Libraries
- [Bootstrap](https://getbootstrap.com/)
- [Font Awesome](https://fontawesome.com/)
