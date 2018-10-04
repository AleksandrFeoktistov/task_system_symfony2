<?php
// src/Security/PostVoter.php
namespace App\Security;
use App\Entity\Comments;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;


class CommentVoter extends Voter
{
    // these strings are just invented: you can use anything
    const EDITCOMMENTS = 'editcomments';
    private $decisionManager;
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::EDITCOMMENTS))) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof Comments) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to supports
        /** @var Post $post */
        $post = $subject;

        switch ($attribute) {
            case self::EDITCOMMENTS:
                return $this->canEdit($post, $user);
        }

        throw new \LogicException('This code should not be reached!');
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }
    }

    private function canView(Post $post, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($post, $user)) {
            return true;
        }

        // the Post object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        return !$post->isPrivate();
    }

    private function canEdit(Comments $comment, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object


        //$repository = $this->getDoctrine()->getRepository(Tickets::class);
        //$tic = $repository->findAll();
        return $user->getId() === $comment->getUserId();
    }
}
