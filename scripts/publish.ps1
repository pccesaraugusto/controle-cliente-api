param(
  [string]$GitHubToken = $env:GITHUB_TOKEN,
  [string]$GitHubRepo  = $env:GITHUB_REPO
)

if (-not $GitHubToken -or -not $GitHubRepo) {
  Write-Error "Set environment variables GITHUB_TOKEN and GITHUB_REPO (owner/repo)."
  exit 1
}

$parts = $GitHubRepo -split '/'
$owner = $parts[0]
$repo = $parts[1]

Write-Host "Initializing git repo if needed..."
if (-not (Test-Path .git)) { git init }

git add -A
try { git commit -m "chore: initial commit" } catch { Write-Host "No changes to commit" }

Write-Host "Checking repository existence..."
$resp = Invoke-WebRequest -UseBasicParsing -Headers @{ Authorization = "token $GitHubToken" } -Uri "https://api.github.com/repos/$owner/$repo" -Method GET -ErrorAction SilentlyContinue
if ($resp.StatusCode -eq 404 -or -not $resp) {
  Write-Host "Repository not found. Creating under authenticated user..."
  $body = @{ name = $repo } | ConvertTo-Json
  $create = Invoke-WebRequest -UseBasicParsing -Headers @{ Authorization = "token $GitHubToken" } -Uri "https://api.github.com/user/repos" -Method POST -Body $body -ContentType "application/json" -ErrorAction SilentlyContinue
  if ($create.StatusCode -lt 300) { Write-Host "Repository created." } else { Write-Error "Failed to create repo. Ensure token has repo scope."; exit 1 }
} else { Write-Host "Repository exists." }

$remote = "https://$GitHubToken@github.com/$owner/$repo.git"
git remote remove origin 2>$null; git remote add origin $remote
git branch -M main
git push -u origin main --force
Write-Host "Publish complete: https://github.com/$owner/$repo"
