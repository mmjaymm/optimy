<?php
namespace Controllers;

use Repositories\News\INewsRepository;

class NewsManager
{
	private static ?self $instance = null;
    private INewsRepository $newsRepository;
    /*
     * Use Dependency Injection
     * */
    public function __construct(INewsRepository $newsRepository)
    {
        /*
         * Create the instance once of News class
         * */
        $this->newsRepository = $newsRepository;
	}

	public static function getInstance(...$dependency): ?self
	{
		if (self::$instance === null) {
			self::$instance = new self(...$dependency);
		}
		return self::$instance;
	}

	/**
	* list all news
	*/
	public function list(): array
	{
		return $this->newsRepository->getLists();
	}

	/**
	* add a record in news table
	*/
	public function addNews(string $title, string $body): bool|int
    {
		return $this->newsRepository->singleInsert($title, $body);
	}

	/**
     * deletes a news, and also linked comments
     * implement a db transactions
	*/
	public function deleteNews(int $id): bool|int
    {
        return $this->newsRepository->deleteNewsWithComments($id);
	}
}