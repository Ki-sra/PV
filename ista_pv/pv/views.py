from rest_framework import viewsets, permissions, status
from rest_framework.decorators import action
from rest_framework.response import Response
from django.shortcuts import get_object_or_404
from .models import PV, PVDocument, StudentCopy, AuditLog
from .serializers import PVSerializer, PVDocumentSerializer, StudentCopySerializer
from django.db import transaction
import pandas as pd
from django.core.files.base import ContentFile


class IsAdminOrManager(permissions.BasePermission):
    def has_permission(self, request, view):
        return request.user.is_authenticated and request.user.role in ['admin', 'manager']


class PVViewSet(viewsets.ModelViewSet):
    queryset = PV.objects.all()
    serializer_class = PVSerializer

    def get_permissions(self):
        if self.action in ['create', 'update', 'partial_update', 'destroy', 'bulk_import']:
            permission_classes = [IsAdminOrManager]
        else:
            permission_classes = [permissions.IsAuthenticated]
        return [p() for p in permission_classes]

    def perform_create(self, serializer):
        pv = serializer.save(created_by=self.request.user)
        AuditLog.objects.create(user=self.request.user, action=f"created PV {pv.id}")

    @action(detail=False, methods=['post'])
    def bulk_import(self, request):
        # Accept CSV or Excel file and create PVs in bulk
        file = request.FILES.get('file')
        if not file:
            return Response({'detail': 'No file uploaded.'}, status=status.HTTP_400_BAD_REQUEST)
        try:
            if file.name.endswith('.csv'):
                df = pd.read_csv(file)
            else:
                df = pd.read_excel(file)
        except Exception as e:
            return Response({'detail': str(e)}, status=status.HTTP_400_BAD_REQUEST)

        created = []
        with transaction.atomic():
            for _, row in df.iterrows():
                pv = PV.objects.create(
                    year=int(row.get('year', 0)),
                    level=row.get('level', ''),
                    department=row.get('department', ''),
                    group=row.get('group', ''),
                    title=row.get('title', '') or 'PV',
                    description=row.get('description', ''),
                    created_by=request.user
                )
                created.append(pv.id)
        AuditLog.objects.create(user=request.user, action=f"bulk imported {len(created)} PVs")
        return Response({'created': created}, status=status.HTTP_201_CREATED)


class PVDocumentViewSet(viewsets.ModelViewSet):
    queryset = PVDocument.objects.all()
    serializer_class = PVDocumentSerializer

    def perform_create(self, serializer):
        doc = serializer.save(uploaded_by=self.request.user)
        AuditLog.objects.create(user=self.request.user, action=f"uploaded document {doc.id} for PV {doc.pv.id}")


class StudentCopyViewSet(viewsets.ModelViewSet):
    queryset = StudentCopy.objects.all()
    serializer_class = StudentCopySerializer

    def perform_create(self, serializer):
        copy = serializer.save(uploaded_by=self.request.user)
        AuditLog.objects.create(user=self.request.user, action=f"uploaded student copy {copy.id} for PV {copy.pv.id}")
