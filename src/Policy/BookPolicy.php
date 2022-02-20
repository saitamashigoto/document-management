<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Book;
use Authorization\IdentityInterface;

/**
 * Book policy
 */
class BookPolicy
{
    /**
     * Check if $user can add Book
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Book $book
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Book $book)
    {
        return $this->isAllowed($user, $book);
    }

    /**
     * Check if $user can edit Book
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Book $book
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Book $book)
    {
        return $this->isAllowed($user, $book);
    }

    /**
     * Check if $user can delete Book
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Book $book
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Book $book)
    {
        return $this->isAllowed($user, $book);
    }

    /**
     * Check if $user can view Book
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Book $book
     * @return bool
     */
    public function canView(IdentityInterface $user, Book $book)
    {
        return $this->isAllowed($user, $book);
    }

    protected function isAllowed(IdentityInterface $user, Book $book)
    {
        return true;
    }
}
