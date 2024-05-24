<?php
namespace Repositories\Comment;

use Class\Comment;

class CommentRepository implements ICommentRepository
{
    public Comment $model;
    private array $comments = [];
    public function __construct()
    {
        /*
         * Create the instance once of News class
         * */
        $this->model = new Comment();
    }

    public function listComments(): array
    {
        $rows = $this->model->select('SELECT * FROM `comment`');

        foreach($rows as $comment) {
            $result = new Comment();
            $this->comments[] = $result->setId($comment['id'])
                ->setBody($comment['body'])
                ->setCreatedAt($comment['created_at'])
                ->setNewsId($comment['news_id']);
        }

        return $this->comments;
    }

    public function getComments(int $newsID): array|false
    {
        return $this->model->select('SELECT * FROM `comment` WHERE `news_id` = '.$newsID);
    }
    public function addCommentForNews(string $body, int $newsId): bool|int
    {
        $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES('". $body . "','" . date('Y-m-d') . "','" . $newsId . "')";
        $this->model->exec($sql);
        return $this->model->lastInsertId();
    }

    public function deleteComment(int $id): bool|int
    {
        $sql = "DELETE FROM `comment` WHERE `id`=" . $id;
        return $this->model->exec($sql);
    }

    public function deleteComments(int $newsID): bool|int
    {
        $sql = "DELETE FROM `comment` WHERE `news_id`=" . $newsID;
        return $this->model->exec($sql);
    }
}