from django.db import models
from django.utils import timezone
from django.contrib.auth.models import User
from django.urls import reverse
from django.core.validators import MaxValueValidator

class Post(models.Model):
    train_no=models.PositiveIntegerField(unique=True,validators=[MaxValueValidator(100000)])
    platform_no=models.PositiveIntegerField(validators=[MaxValueValidator(100)])
    expected_arrival=models.CharField(max_length=4)
    content=models.TextField(default='No Delay')
    date_posted=models.DateTimeField(auto_now=True)
    author=models.ForeignKey(User,on_delete=models.CASCADE)

    def  __str__(self):
        return self.train_no
    def get_absolute_url(self):
        return reverse('post-detail',kwargs={'pk':self.pk})