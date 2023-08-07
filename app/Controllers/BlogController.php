<?php

namespace App\Controllers;

use App\Models\BlogModel;
use CodeIgniter\Controller;

class BlogController extends Controller
{
    protected $request;

    public function __construct()
    {
        $this->request = service('request');
    }

    public function index()
    {
        // Load the BlogModel
        $blogModel = new BlogModel();

        // Get all articles from the database
        $data['blogPosts'] = $blogModel->findAll();

        // Load the view and pass the data to it
        return view('blog/index', $data);
    }

    public function create()
    {
        // Check ID exist or not
        $editBlogId = $this->request->getGet('edit');
        if (!empty($editBlogId)) {
            // Load blog data
            $blogModel = new BlogModel();
            $post = $blogModel->find($editBlogId);
            if ($post) {
                // Populate the form fields with the blog post data
                $data['post'] = $post;
            }
        }
        
        $data['errors'] = session('errors');
        $data['success'] = session('success');
        return view('blog/create', $data);
    }

    public function store()
    {
        // Validation form data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|min_length[3]',
            'slug' => 'required|min_length[3]',
            'short_description' => 'required|min_length[5]',
            'full_description' => 'required|min_length[6]',
            'date' => 'required|valid_date',
            'author_nickname' => 'required|min_length[3]'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            // If validation faild
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $blogModel = new BlogModel();
        // Image Validate
        $articleImage = $this->request->getFile('article_image');
        $newName = '';

        if ($articleImage->isValid() && !$articleImage->hasMoved()) {
            // Generate a new random name for the uploaded image
            $newName = $articleImage->getRandomName();

            // Move the original image to the 'public/uploads/original' folder
            try {
                $articleImage->move(ROOTPATH . 'public/uploads/original/', $newName);
            } catch (FileNotFoundException $e) {
                // Handle the file not found exception if needed
                $error = "Image format not supported: " . $e->getMessage();
            }
            if (isset($error)) {
                // If an error occurred, show an error message and redirect back to the form
                return redirect()->back()->withInput()->with('error', $error);
            }

            // Resize the image (optional, adjust dimensions as needed)
            $resizedImage = \Config\Services::image()
            ->withFile(ROOTPATH . 'public/uploads/original/' . $newName)
            ->fit(800, 600, 'center') // Resize to 800x600 with the 'center' focus
            ->save(ROOTPATH . 'public/uploads/articleImages/' . $newName);
        }
        
        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'short_description' => $this->request->getPost('short_description'),
            'full_description' => $this->request->getPost('full_description'),
            'date' => $this->request->getPost('date'),
            'article_image' => $newName,
            'author_nickname' => $this->request->getPost('author_nickname'),
            'created_at' => date('Y-m-d'),
        ];
        $blogModel->insert($data);
        return redirect()->to(site_url('blog'))->with('success', 'Blog data inserted successfully!');
    }

    public function update($id)
    {
        // Validation form data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|min_length[3]',
            'slug' => 'required|min_length[3]',
            'short_description' => 'required|min_length[5]',
            'full_description' => 'required|min_length[6]',
            'date' => 'required|valid_date',
            'article_image' => 'required',
            'author_nickname' => 'required|min_length[3]'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            // If validation faild
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // If form data is valid, update the blog post in the database
        $blogModel = new BlogModel();
        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'short_description' => $this->request->getPost('short_description'),
            'full_description' => $this->request->getPost('full_description'),
            'date' => $this->request->getPost('date'),
            'article_image' => $this->request->getPost('article_image'),
            'author_nickname' => $this->request->getPost('author_nickname'),
        ];
        $blogModel->update($id, $data);

        // Redirect to the blog post listing page after updating the post
        return redirect()->to(site_url('blog'))->with('success', 'Blog data updated successfully!');
    }

    public function showArticle($slug)
    {
        $blogModel = new BlogModel();

        // Get Articales
        $article = $blogModel->where('slug', $slug)->first();

        if(!$article){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('blog/article', ['article' => $article]);
    }
    

}
