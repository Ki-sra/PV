from rest_framework import serializers
from .models import PV, PVDocument, StudentCopy


class PVDocumentSerializer(serializers.ModelSerializer):
    class Meta:
        model = PVDocument
        fields = ['id', 'name', 'file', 'uploaded_by', 'uploaded_at']


class StudentCopySerializer(serializers.ModelSerializer):
    class Meta:
        model = StudentCopy
        fields = ['id', 'student_identifier', 'file', 'copy_type', 'uploaded_by', 'uploaded_at']


class PVSerializer(serializers.ModelSerializer):
    documents = PVDocumentSerializer(many=True, read_only=True)
    student_copies = StudentCopySerializer(many=True, read_only=True)

    class Meta:
        model = PV
        fields = ['id', 'year', 'level', 'department', 'group', 'title', 'description', 'archived', 'documents', 'student_copies']
