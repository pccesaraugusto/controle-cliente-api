#!/usr/bin/env bash
set -euo pipefail

# Usage:
# GITHUB_TOKEN=ghp_xxx GITHUB_REPO=owner/repo ./scripts/publish.sh

if [ -z "${GITHUB_TOKEN:-}" ] || [ -z "${GITHUB_REPO:-}" ]; then
  echo "Environment variables required: GITHUB_TOKEN and GITHUB_REPO (owner/repo)"
  exit 1
fi

OWNER="${GITHUB_REPO%%/*}"
REPO="${GITHUB_REPO##*/}"

echo "Preparing git repo..."
if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
  git init
fi

git add --all
git commit -m "chore: initial commit" || echo "No changes to commit"

echo "Checking if remote repository exists..."
STATUS=$(curl -s -o /dev/null -w "%{http_code}" -H "Authorization: token ${GITHUB_TOKEN}" https://api.github.com/repos/${OWNER}/${REPO})
if [ "$STATUS" -eq 404 ]; then
  echo "Repository not found on GitHub. Creating repository ${OWNER}/${REPO} for authenticated user..."
  # Try to create repo under authenticated user
  CREATE_STATUS=$(curl -s -o /dev/null -w "%{http_code}" -H "Authorization: token ${GITHUB_TOKEN}" -d "{\"name\": \"${REPO}\"}" https://api.github.com/user/repos)
  if [ "$CREATE_STATUS" -ge 200 ] && [ "$CREATE_STATUS" -lt 300 ]; then
    echo "Repository created."
  else
    echo "Could not create repository automatically (status $CREATE_STATUS). Create it manually or ensure the token has repo scope." && exit 1
  fi
else
  echo "Repository already exists or is accessible (status $STATUS)."
fi

REMOTE_URL="https://
${GITHUB_TOKEN}@github.com/${OWNER}/${REPO}.git"
git remote remove origin >/dev/null 2>&1 || true
git remote add origin "${REMOTE_URL}"
git branch -M main || true

echo "Pushing to GitHub (origin/main)..."
git push -u origin main --force

echo "Publish complete: https://github.com/${OWNER}/${REPO}"
