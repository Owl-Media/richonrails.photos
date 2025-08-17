# Rich On Rails Photos WordPress Theme

[![Build Status](https://github.com/rich-howell/wordpress-theme-boilerplate/actions/workflows/phpcs-reviewdog.yml/badge.svg)](https://github.com/rich-howell/wordpress-theme-boilerplate/actions)
[![Latest Release](https://img.shields.io/github/v/release/rich-howell/wordpress-theme-boilerplate?label=release)](https://github.com/rich-howell/wordpress-theme-boilerplate/releases)
![PHP Version](https://img.shields.io/badge/php-8.2-blue.svg)
![WordPress](https://img.shields.io/badge/wordpress-6.8.1-blueviolet.svg)

This repository contains the custom WordPress theme for **Rich On Rails Photos**

---

## 🧠 About the Project

A bit about Rich On Rails Photos can go here.

The theme is built for WordPress 6.8.1 and follows the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/).

---

## 🧭 Developer Guide

For full documentation including setup, contributing, release workflow, and plugins:

👉 Head to the [`docs/`](./docs) folder for everything you need.

---

## 🛠️ Quick Start

- Clone the repo
- Use [Local](https://localwp.com/) to spin up a dev environment
- Run `composer install` and `npm install`
- Develop inside the `src/` folder
- Build the theme with:

```bash
npm run build
```

---

## 🩺 Code Quality

This project uses PHPCS with WordPress-Extra rules, enforced via:

- Local linting (`npm run lint`)
- Auto-fix (`npm run fix`)
- GitHub Actions (with inline comments for errors/warnings)
