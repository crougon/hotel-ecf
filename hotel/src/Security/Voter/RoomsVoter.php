<?php

namespace App\Security\Voter;

use App\Entity\Room;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RoomsVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    //public const VIEW = 'POST_VIEW';
    public const DELETE = 'POST_DELETE';

    
    protected function supports(string $attribute, $room): bool
    {


        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE ])
            && $room instanceof \App\Entity\Room;
    }

    protected function voteOnAttribute(string $attribute, $room, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // verify if the room has a owner
        if(null === $room->getUser()) return false;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // we verify if we can edit
                return $this->canEdit($room, $user);

                break;
            case self::DELETE:
                // we verify if we can delete
                return $this->canDelete($room, $user);
                break;
        }

        return false;
    }

    private function canEdit(Room $room, User $user){
        // Room owner can modify it
        return $user == $room->getUser();
    }

    private function canDelete(Room $room, User $user){
        // Room owner can delete it
        return $user === $room->getUser();
    }
}
