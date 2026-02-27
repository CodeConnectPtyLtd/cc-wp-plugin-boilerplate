# Code Connect WP Plugin Boilerplate

A modern, OOP-based WordPress plugin boilerplate with PSR-4 autoloading and CI/CD ready workflows.

## 🚀 Getting Started

1. **Clone/Copy** this repo into a new project folder.
2. **Search and Replace** the following tokens:
   - `{{PLUGIN_NAME}}`: Your Human-friendly Plugin Name.
   - `{{DESCRIPTION}}`: A brief description of the plugin.
   - `{{TEXT_DOMAIN}}`: Slug used for translations and folder name (e.g., `my-cool-plugin`).
   - `{{PREFIX}}`: Uppercase short prefix for constants (e.g., `MCP`).
   - `{{NAMESPACE}}`: PHP Namespace (e.g., `CC\MyCoolPlugin`).
3. **Rename** the main file `cc-wp-plugin-boilerplate.php` to match your plugin slug.

## 📁 Structure
- `admin/`: Admin-specific logic, CSS, and JS.
- `frontend/`: Public-facing logic, CSS, and JS.
- `includes/`: Core classes (Mapped to PSR-4 `{{NAMESPACE}}`).
- `templates/`: Overridable template files.

## 🚢 Deployment
GitHub Actions are pre-configured in `.github/workflows/deploy.yml`. 
Ensure you have the following secrets in your GitHub Repo:
- `DEV_SFTP_HOST`, `DEV_SFTP_USER`, `DEV_SFTP_PASS`, `DEV_REMOTE_PATH`
- `PROD_SFTP_HOST`, `PROD_SFTP_USER`, `PROD_SFTP_PASS`, `PROD_REMOTE_PATH`
