<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Author;
use Authorization\IdentityInterface;

/**
 * Author policy
 */
class AuthorPolicy
{
    /**
     * Check if $user can add Author
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Author $author
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Author $author)
    {
        return $this->isAllowed($user, $author);
    }

    /**
     * Check if $user can edit Author
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Author $author
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Author $author)
    {
        return $this->isAllowed($user, $author);
    }

    /**
     * Check if $user can delete Author
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Author $author
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Author $author)
    {
        return $this->isAllowed($user, $author);
    }

    /**
     * Check if $user can view Author
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Author $author
     * @return bool
     */
    public function canView(IdentityInterface $user, Author $author)
    {
        return $this->isAllowed($user, $author);
    }

    protected function isAllowed(IdentityInterface $user, Author $author)
    {
        return true;
    }
}
