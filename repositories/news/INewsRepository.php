<?php
namespace Repositories\News;

interface INewsRepository {
    public function singleInsert(string $title, string $body): bool|int;
    public function getLists(): array;
    public function deleteNewsWithComments(int $id): bool|int;
}
