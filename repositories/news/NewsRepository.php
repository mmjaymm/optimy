<?php
namespace Repositories\News;

use Class\News;
use Controllers\CommentManager;
use Repositories\Comment\ICommentRepository;

class NewsRepository implements INewsRepository
{
    public News $model;
    private array $newsArray = [];
    private ICommentRepository $commentRepository;
    public function __construct(
        ICommentRepository $commentRepository
    )
    {
        /*
         * Create the instance once of News class
         * */
        $this->model = new News();
        $this->commentRepository = $commentRepository;
    }
    public function singleInsert(string $title, string $body): bool|int
    {
        $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES('". $title . "','" . $body . "','" . date('Y-m-d') . "')";
        $this->model->exec($sql);
        return $this->model->lastInsertId($sql);
    }
    public function getLists(): array
    {
        $rows = $this->model->select('SELECT * FROM `news`');
        foreach($rows as $news) {
            $result = new News();
            $this->newsArray[] = $result->setId($news['id'])
                ->setTitle($news['title'])
                ->setBody($news['body'])
                ->setCreatedAt($news['created_at']);
        }

        return $this->newsArray;
    }

    public function deleteNewsWithComments(int $id): bool|int
    {
        try {
            $this->model->pdo->beginTransaction();

            $sql = "DELETE FROM `news` WHERE `id`=" . $id;
            $this->commentRepository->deleteComments($id);
            $this->model->exec($sql);

            if ($this->model->pdo->commit()){
                return true;
            };

            $this->model->pdo->rollback();
            return false;

        }catch (\PDOException $ex) {
            if ($this->model->pdo->inTransaction()) {
                $this->model->pdo->rollback();
            }
            echo "Database Error: " . $ex->getMessage();
            return false;
        }
    }
}