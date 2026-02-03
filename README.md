# Clientes Service

Microservice API RESTful para controle de clientes (scaffold).

Comandos rápidos:

```bash
git clone <repo>
cd clientes-service
chmod +x docker-up.sh docker-down.sh
./docker-up.sh
```

API (expectativa): http://localhost:8080
Swagger: http://localhost:8080/api/docs

Publicar no GitHub:

1. Exporte as variáveis de ambiente `GITHUB_TOKEN` e `GITHUB_REPO` (formato `owner/repo`).
2. Execute (Linux/macOS):

```bash
GITHUB_TOKEN=ghp_xxx GITHUB_REPO=youruser/yourrepo ./scripts/publish.sh
```

Ou no PowerShell (Windows):

```powershell
$env:GITHUB_TOKEN = 'ghp_xxx'
$env:GITHUB_REPO = 'youruser/yourrepo'
.\scripts\publish.ps1
```

Observação: o token precisa ter escopo `repo` para criar e pushar repos privados. O script usa o token para autenticar o push (token aparece na URL remota durante o push).
