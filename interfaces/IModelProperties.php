<?php
namespace Interfaces;

/*
 * create IModelProperties
 * to use in other class (polymorphism)
 * */
interface IModelProperties {
    public function setId(int $id): self;
    public function getId(): int;

    public function setBody(string $body): self;
    public function getBody(): string;

    public function setCreatedAt(string $createdAt): self;
    public function getCreatedAt(): string;

    public function setTitle(string $title) : self;
    public function getTitle() : string;
}