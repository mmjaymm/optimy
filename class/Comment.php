<?php
namespace Class;

/*
 * extends ModelProperties
 * to inherit the method and properties
 * from ModelProperties
 * DRY principles
 * */
class Comment extends ModelProperties
{
    protected int $newsId;

    public function __construct()
    {
        parent::__construct();
    }

	public function getNewsId(): int
	{
		return $this->newsId;
	}

	public function setNewsId(int $newsId): self
	{
		$this->newsId = $newsId;

		return $this;
	}
}