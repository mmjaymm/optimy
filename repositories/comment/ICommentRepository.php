<?php
namespace Repositories\Comment;

interface ICommentRepository {
    public function listComments(): array;
    public function addCommentForNews(string $body, int $newsId): bool|int;
    public function deleteComment(int $id): bool|int;
    public function deleteComments(int $newsID): bool|int;
    public function getComments(int $newsID): array|false;

}
