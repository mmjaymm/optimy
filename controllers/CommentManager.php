<?php
namespace Controllers;

use Class\Comment;
use Repositories\Comment\ICommentRepository;

class CommentManager
{
    private static ?self $instance = null;
    private Comment $model;
    private array $comments = [];
    private ICommentRepository $commentRepository;
    public function __construct(ICommentRepository $commentRepository)
	{
        $this->model = new Comment();
        $this->commentRepository = $commentRepository;
	}

    public static function getInstance(ICommentRepository $commentRepo): ?self
    {
        if (self::$instance === null) {
            self::$instance = new self($commentRepo);
        }
        return self::$instance;
    }
	public function list(): array
	{
		return $this->commentRepository->listComments();
	}

    public function getComments(int $newsID): array
    {
        return $this->commentRepository->getComments($newsID);
    }

	public function addCommentForNews(string $body, int $newsId): bool|int
    {
		return $this->commentRepository->addCommentForNews($body,$newsId);
	}

	public function deleteComment(int $id): bool|int
    {
		return $this->commentRepository->deleteComment($id);
	}

    public function deleteComments(int $newsID): bool|int
    {
        return $this->commentRepository->deleteComments($newsID);
    }
}