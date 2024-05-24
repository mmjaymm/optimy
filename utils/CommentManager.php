<?php
namespace Utils;

use Class\Comment;

class CommentManager
{
    private static ?self $instance = null;
    private Comment $model;
    private array $comments = [];
    public function __construct()
	{
        $this->model = new Comment();
	}

    public static function getInstance(): ?self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
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