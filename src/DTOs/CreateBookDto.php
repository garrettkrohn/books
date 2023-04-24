<?php

namespace App\DTOs;

class CreateBookDto
{

    private string $author;
    private string $title;
    private int $user_rating;

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getUserRating(): int
    {
        return $this->user_rating;
    }

    /**
     * @param int $user_rating
     */
    public function setUserRating(int $user_rating): void
    {
        $this->user_rating = $user_rating;
    }



}