<?php
namespace Utils;

use Class\News;

class NewsManager
{
	private static ?self $instance = null;
    private News $model;
    private CommentManager $comment;
    private array $newsArray = [];
    public function __construct()
    {
        /*
         * Create the instance once of News class
         * */
        $this->model = new News();
        $this->comment = new CommentManager();
	}

	public static function getInstance(): ?self
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	* list all news
	*/
	public function listNews(): array
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

	/**
	* add a record in news table
	*/
	public function addNews(string $title, string $body): bool|int
    {
		$sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES('". $title . "','" . $body . "','" . date('Y-m-d') . "')";
		$this->model->exec($sql);
		return $this->model->lastInsertId($sql);
	}

	/**
     * deletes a news, and also linked comments
     * implement a db transactions
	*/
	public function deleteNews(int $id): bool|int
    {
        try {
            $this->model->pdo->beginTransaction();

            $sql = "DELETE FROM `news` WHERE `id`=" . $id;
            $this->comment->deleteComments($id);
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