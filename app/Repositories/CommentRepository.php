<?php

namespace App\Repositories;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Round;

class CommentRepository
{
    public Comment $commentModel;

    public function __construct(Comment $commentModel)
    {
        $this->commentModel = $commentModel;
    }

    public function storeComment(Array $validatedData): Comment
    {
        return $this->commentModel->create($validatedData);
    }
}
