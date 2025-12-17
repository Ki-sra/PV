from rest_framework import routers
from .views import PVViewSet, PVDocumentViewSet, StudentCopyViewSet
from django.urls import path, include

router = routers.DefaultRouter()
router.register('pvs', PVViewSet)
router.register('documents', PVDocumentViewSet)
router.register('copies', StudentCopyViewSet)

urlpatterns = [
    path('', include(router.urls)),
]
