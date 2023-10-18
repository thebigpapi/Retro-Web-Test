<?php

namespace App\Audit\Security;


use DH\Auditor\Provider\Doctrine\Configuration;
use DH\Auditor\Provider\Doctrine\DoctrineProvider;
use DH\Auditor\Security\RoleCheckerInterface;
use DH\Auditor\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RoleChecker implements RoleCheckerInterface
{
    private AuthorizationCheckerInterface $authorizationChecker;

    private DoctrineProvider $provider;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, DoctrineProvider $doctrineProvider)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->provider = $doctrineProvider;
    }
    public function __invoke(string $entity, string $scope): bool
    {
        // whoever made this pack is a bit stupid, so this gets reimplemented
        $userProvider = $this->provider->getAuditor()->getConfiguration()->getUserProvider();
        $authorizationChecker = null !== $userProvider ? $this->authorizationChecker : null;

        if($scope != "view"){
            //if the scope is not view, deny access
            return false;
        }

        \assert($this->provider->getConfiguration() instanceof Configuration);
        $entities = $this->provider->getConfiguration()->getEntities();
        $roles = $entities[$entity]['roles'] ?? null;

        if (null === $roles) {
            // If no roles are configured on an entity, consider access granted
            return true;
        }

        // roles are defined for the give scope
        foreach ($roles[$scope] as $role) {
            if ($authorizationChecker->isGranted($role)) {
                return true;
            }
        }

        // access denied
        return false;
    }
}