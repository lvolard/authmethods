<?php
// src/Security/OAuthUserProvider.php
namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class OAuthUserProvider implements OAuthAwareUserProviderInterface
{
    private EntityManagerInterface $em;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepository)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response): UserInterface
    {
        $email = $response->getEmail();
        $nickname = $response->getNickname(); // fallback if you want to set a username

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            $user = new User();
            $user->setEmail($email);
            $user->setUsername($nickname ?? $email);
            $user->setFullName($response->getRealName() ?? $nickname ?? $email);
            $user->setRoles([User::ROLE_USER]);

            // Password isn't used for OAuth users, set something safe
            $user->setPassword('oauth-google-no-password');

            $this->em->persist($user);
            $this->em->flush();
        }

        return $user;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->userRepository->findOneBy(['username' => $identifier]);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }
}
