from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import UserViewSet, LugarViewSet, ResenaViewSet

router = DefaultRouter()
router.register(r'usuarios', UserViewSet)
router.register(r'lugares', LugarViewSet)
router.register(r'resenas', ResenaViewSet)

urlpatterns = [
    path('', include(router.urls)),
]