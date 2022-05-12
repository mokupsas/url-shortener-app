# PHP Url Shortener Project
Small PHP url shortener website that use MVC pattern. The aim of the work is to learn and create a project that meets requirements of a normal functioning website.

## Features
- General
  - [ ] Url shortening. Base62 encode/decode
- Auth
  - Registration
    - [x] Password hash with BCRYPT
    - [x] One email per website (prevent email collision)
    - [x] Three accounts per IP address- 
  - Login
    - [x] Raw with BCRYPT password verification
    - [ ] Limit attempts to prevent brute-force
  - Logout

## PHP Libraries
- [nikic/fast-route](https://github.com/nikic/FastRoute)
- [patricklouys/http](https://github.com/PatrickLouys/http)
- [mustache/mustache](https://github.com/bobthecow/mustache.php)
- [rdlowrey/auryn](https://github.com/rdlowrey/auryn)

## UI Libraries
- [Bootstrap](https://getbootstrap.com/)
- [Font Awesome](https://fontawesome.com/)
