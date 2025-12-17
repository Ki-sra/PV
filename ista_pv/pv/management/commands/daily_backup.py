from django.core.management.base import BaseCommand
from django.conf import settings
import os
import shutil
from datetime import datetime

class Command(BaseCommand):
    help = 'Perform a daily backup of the media directory (simple local backup).'

    def handle(self, *args, **options):
        media_root = settings.MEDIA_ROOT
        backup_dir = os.path.join(os.path.dirname(media_root), 'backups')
        os.makedirs(backup_dir, exist_ok=True)
        timestamp = datetime.utcnow().strftime('%Y%m%dT%H%M%SZ')
        dest = os.path.join(backup_dir, f'media_backup_{timestamp}.zip')
        shutil.make_archive(dest.replace('.zip', ''), 'zip', media_root)
        self.stdout.write(self.style.SUCCESS(f'Backup created at {dest}'))
