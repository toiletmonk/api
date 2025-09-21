<?php

namespace App;

use App\Models\File;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService
{
    public function getFilteredPosts(array $filters): LengthAwarePaginator
    {
        $query = Post::query();

        if(!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if(!empty($filters['search'])) {
            $query->where('title', 'LIKE', '%' . $filters['search'] . '%');
        }

        return $query->paginate(10);
    }
}
