<?php

namespace App\Policies;

use App\Models\DocumentComment;
use App\Models\ReportDocument;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class DocumentCommentPolicy
{
    public function create(User $user, ReportDocument $document): bool
    {
        return Gate::forUser($user)->allows('comment', $document);
    }

    public function update(User $user, DocumentComment $documentComment): bool
    {
        return Gate::forUser($user)->allows('view', $documentComment->document)
            && ($documentComment->user_id === $user->id || $user->hasAnyRole(['manager', 'super-admin']));
    }

    public function delete(User $user, DocumentComment $documentComment): bool
    {
        return $this->update($user, $documentComment);
    }
}
