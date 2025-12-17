# ISTA PV Manager (Django)

This repository contains a Django-based scaffold for managing Procès-Verbaux de Fin de Formation (PV) and related documents.

Quick start (development):

1. Create and activate a Python virtual environment (Windows PowerShell):

```powershell
python -m venv .venv
.\.venv\Scripts\Activate.ps1
pip install -r requirements.txt
```

2. Copy `.env.example` to `.env` and edit database credentials.

3. Run migrations and create a superuser:

```powershell
python manage.py migrate
python manage.py createsuperuser
python manage.py runserver
```

4. Access admin at `http://127.0.0.1:8000/admin/` and the API at `http://127.0.0.1:8000/api/`.

Notes:
- For production, configure secure settings, use Postgres, set `DEBUG=False`, and configure HTTPS.
- The project includes a simple `daily_backup` management command that zips the `MEDIA_ROOT`.
