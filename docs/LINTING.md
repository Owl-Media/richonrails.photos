# ✨ Linting & Formatting Setup for Our-Space WordPress Project

This project uses a linting setup to ensure all PHP, JavaScript, and CSS code follows the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/).

Linting helps us:
- Keep the codebase clean and readable 🧼
- Avoid common bugs and formatting issues 🐛
- Make it easier for everyone to contribute consistently 🤝

---

## 📦 Tools We're Using

### ✅ PHP
- **[PHP_CodeSniffer (phpcs)](https://github.com/squizlabs/PHP_CodeSniffer)** — detects violations of coding standards
- **[phpcbf](https://github.com/squizlabs/PHP_CodeSniffer)** — auto-fixes fixable violations
- **[WordPress Coding Standards (WPCS)](https://github.com/WordPress/WordPress-Coding-Standards)** — set of sniffs for WordPress PHP code
- **[PHP Stubs for WordPress](https://github.com/php-stubs/wordpress-stubs)** — allows VS Code to autocomplete and understand WordPress functions

### ✅ JavaScript & CSS (coming soon)
We may expand linting to JS/CSS via ESLint and Stylelint. Stay tuned!

---

## 🖥️ Developer Requirements

To run linting locally, you’ll need:

- [PHP](https://www.php.net/downloads.php) installed and available in your terminal
- [Composer](https://getcomposer.org/) for managing dependencies
- [Node.js](https://nodejs.org/) (optional — only needed if/when JS/CSS linting is added)
- [Visual Studio Code](https://code.visualstudio.com/) with extensions (see below)

---

## 🔧 Setting It Up in VS Code

### 🧩 Required Extensions

1. **PHP Intelephense**
2. **PHP CodeSniffer** (by Ioannis Kappas)
3. *(optional)* **EditorConfig for VS Code**

### 📁 Project Folder Structure

```
.
├── vendor/
├── stubs/
│   └── wordpress.php   ← copy of `wordpress-stubs.php`
├── .vscode/
│   └── settings.json
├── .editorconfig
├── composer.json
├── functions.php
└── ...
```

### ⚙️ VS Code `.vscode/settings.json`

```json
{
  "editor.insertSpaces": false,
  "editor.tabSize": 4,
  "phpcs.enable": true,
  "phpcs.executablePath": "vendor/bin/phpcs.bat",
  "phpcs.standard": "WordPress-Extra",
  "intelephense.environment.includePaths": [
    "stubs"
  ],
  "[php]": {
    "editor.insertSpaces": false,
    "editor.tabSize": 4
  }
}
```

### 🧠 Important

> Copy the file `vendor/php-stubs/wordpress-stubs/wordpress-stubs.php` to a local folder called `stubs/` and name it `wordpress.php`  
> This enables Intelephense to provide autocomplete and stop marking WordPress functions as undefined.

---

## 🚀 Running Lint Checks

### ✅ From the Terminal

#### Lint the whole project:
```bash
vendor\bin\phpcs -d memory_limit=512M
```

#### Auto-fix fixable issues:
```bash
vendor\bin\phpcbf -d memory_limit=512M
```

#### Run just on a specific file:
```bash
vendor\bin\phpcs path/to/your/file.php
```

> You can also run `composer lint` or `composer fix` if those scripts are defined in `composer.json`.

---

### ✅ From VS Code

- Linting runs automatically on open/save via **PHP CodeSniffer**
- You can run a task to auto-fix:
  1. Press `Ctrl + Shift + B`
  2. Select `Fix PHP with phpcbf` (if configured in `tasks.json`)

---

## 🔐 Git Ignore

We do not commit `vendor/` or `stubs/` folders (they’re dev-time only):

```
/vendor/
/stubs/
```

---

## 🧹 Other Notes

- All PHP files must use **tabs** for indentation, not spaces
- An `.editorconfig` file is included to enforce this across different editors
- Final newline and LF line endings are required
- PHPCS follows the `WordPress-Extra` ruleset (stricter spacing, formatting rules)

---

## ❤️ Help & Troubleshooting

If Intelephense still reports “undefined function” for WordPress functions:

1. Make sure you've copied `wordpress-stubs.php` to `stubs/wordpress.php`
2. Run **Intelephense: Clear Cache** from the Command Palette
3. Restart VS Code

---

## 🧙‍♂️ Lint like a pro

Follow the linting rules, and your code will be clean, readable, and worthy of the WordPress gods.  
Need help? Ping Stanley, the semi-mythical lint goblin who lives in your terminal and snacks on rogue spaces.

Happy coding! 🚀
```