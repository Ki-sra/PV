from django.contrib import admin
from django.contrib.auth.admin import UserAdmin as BaseUserAdmin
from .models import User, PV, PVDocument, StudentCopy, AuditLog


@admin.register(User)
class UserAdmin(BaseUserAdmin):
    fieldsets = BaseUserAdmin.fieldsets + ((None, {'fields': ('role',)}),)


@admin.register(PV)
class PVAdmin(admin.ModelAdmin):
    list_display = ('title', 'year', 'department', 'level', 'group', 'archived')
    search_fields = ('title', 'department', 'level')
    list_filter = ('year', 'department', 'level', 'archived')


@admin.register(PVDocument)
class PVDocumentAdmin(admin.ModelAdmin):
    list_display = ('pv', 'name', 'uploaded_by', 'uploaded_at')


@admin.register(StudentCopy)
class StudentCopyAdmin(admin.ModelAdmin):
    list_display = ('pv', 'student_identifier', 'copy_type', 'uploaded_at')


@admin.register(AuditLog)
class AuditLogAdmin(admin.ModelAdmin):
    list_display = ('user', 'action', 'timestamp')
    readonly_fields = ('user', 'action', 'timestamp', 'details')
