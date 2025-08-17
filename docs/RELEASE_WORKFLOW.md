# 🚀 Release Workflow
This document outlines the steps to follow when preparing a new theme release.

## 🎯 Goals
- Ensure consistent quality across releases
- Automate zipping and publishing of theme via GitHub Actions
- Track features and fixes with clear changelogs

## 🧭 Step-by-Step Workflow

### . 📝 Create an Issue
Create an issue to describe the planned release or feature set.

- Title it like: Release: v1.2.0
- Use the issue to track PRs, discussion, or outstanding tasks
- Label it with release if desired

### 2. 🌿 Create a Feature or Fix Branch

```bash
git checkout -b feature/amazing-new-feature
```

Make your changes in `src/`, commit and push as usual.

### 3. 📦 Add or Update Release Notes
In the release-notes/ folder, create a file matching the version you plan to release:

```bash
release-notes/v1.2.0.md
```

```markdown
# What's New in v1.2.0

- ✨ Added shiny new features
- 🐛 Fixed some delightful bugs
- 🚂 Improved train speed by 42%
```

### 4. 🔁 Create a Pull Request
Open a PR to merge your branch into main or your release branch

- Link the issue (e.g. Closes #123)
- Request review from another dev
- Ensure checks and PHPCS pass

### 5. 🏷️ Tag the Release
Once approved and merged:

```bash
git checkout main
git pull
git tag v1.2.0
git push origin v1.2.0
```

The GitHub Action will now:

- Zip the src/ folder
- Read release-notes/v1.2.0.md
- Create a release and attach the zip

### 6. 🎉 Verify the Release

Go to the GitHub Releases page and confirm:

- ✅ The release is there
- ✅ The changelog is accurate
- ✅ The theme zip is downloadable

### 🔁 Example Workflow Summary

```bash
Issue → Branch → Code → Release Notes → PR → Merge → Tag → Zip & Release 🚀
```