<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table = 'blog_posts'; // Replace 'blog_posts' with your table name
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'short_description', 'full_description', 'date', 'article_image', 'author_nickname'];
    protected $useTimestamps = true;
    
}
