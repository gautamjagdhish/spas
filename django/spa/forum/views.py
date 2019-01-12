from django.shortcuts import render, get_object_or_404
from django.utils import timezone
from .models import Post,User
from django.contrib.auth.models import User
from django.contrib.auth.mixins import LoginRequiredMixin
from django.views.generic import (ListView,
                                DetailView,
                                CreateView,
                                UpdateView,
                                DeleteView)

class PostListView(ListView):
    model=Post
    template_name='forum/home.html'
    context_object_name='posts'
    ordering=['-date_posted']
    paginate_by=5

class UserPostListView(ListView):
    model=Post
    template_name='forum/user_posts.html'
    context_object_name='posts'
    paginate_by=5
    def get_queryset(self):
        user=get_object_or_404(User,username=self.kwargs.get('username'))
        return Post.objects.filter(author=user).order_by('-date_posted')

class PostDetailView(DetailView):
    model=Post

class PostCreateView(LoginRequiredMixin,CreateView):
    model=Post
    fields=['train_no','platform_no','expected_arrival','content']
    def form_valid(self,form):
        form.instance.author=self.request.user
        return super().form_valid(form)

class PostUpdateView(LoginRequiredMixin, UpdateView):
    model=Post
    fields=['train_no','platform_no','expected_arrival','content']
    def form_valid(self,form):
        form.instance.author=self.request.user
        self.date_posted = timezone.now()
        return super().form_valid(form)

class PostDeleteView(LoginRequiredMixin, DeleteView):
    model=Post
    success_url='/'

def about(request):
    return render(request,'forum/about.html',{'title':'About'})