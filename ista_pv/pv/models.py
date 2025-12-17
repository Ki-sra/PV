from django.db import models
from django.contrib.auth.models import AbstractUser
from django.conf import settings
from fernet_fields import EncryptedTextField


class User(AbstractUser):
    ROLE_CHOICES = (
        ('admin', 'Admin'),
        ('manager', 'Manager'),
        ('consultant', 'Consultant'),
        ('archivist', 'Archivist'),
    )
    role = models.CharField(max_length=20, choices=ROLE_CHOICES, default='consultant')


def upload_to_pv(instance, filename):
    # Organize by Year/Level/Department/Group
    parts = [str(instance.year), instance.level or 'unknown', instance.department or 'general', instance.group or 'all']
    return '/'.join(parts) + '/' + filename


class PV(models.Model):
    year = models.PositiveSmallIntegerField()
    level = models.CharField(max_length=100)
    department = models.CharField(max_length=200)
    group = models.CharField(max_length=100, blank=True, null=True)
    title = models.CharField(max_length=255)
    description = models.TextField(blank=True)
    created_by = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.SET_NULL, null=True, related_name='pvs_created')
    created_at = models.DateTimeField(auto_now_add=True)
    archived = models.BooleanField(default=False)

    class Meta:
        ordering = ['-year', 'department', 'level']

    def __str__(self):
        return f"PV {self.title} ({self.year})"


class PVDocument(models.Model):
    pv = models.ForeignKey(PV, on_delete=models.CASCADE, related_name='documents')
    file = models.FileField(upload_to=upload_to_pv)
    name = models.CharField(max_length=255, blank=True)
    uploaded_by = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.SET_NULL, null=True)
    uploaded_at = models.DateTimeField(auto_now_add=True)

    def save(self, *args, **kwargs):
        if not self.name:
            self.name = getattr(self.file, 'name', '')
        super().save(*args, **kwargs)


class StudentCopy(models.Model):
    pv = models.ForeignKey(PV, on_delete=models.CASCADE, related_name='student_copies')
    student_identifier = models.CharField(max_length=128)
    file = models.FileField(upload_to=upload_to_pv)
    copy_type = models.CharField(max_length=50, choices=(('control','Control'),('efm','EFM')))
    uploaded_by = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.SET_NULL, null=True)
    uploaded_at = models.DateTimeField(auto_now_add=True)


class AuditLog(models.Model):
    user = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.SET_NULL, null=True)
    action = models.CharField(max_length=255)
    timestamp = models.DateTimeField(auto_now_add=True)
    details = EncryptedTextField(blank=True, null=True)

    class Meta:
        ordering = ['-timestamp']
