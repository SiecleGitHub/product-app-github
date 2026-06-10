<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $password_field = TextField::new('plainPassword', 'Password')
                            ->setFormType(PasswordType::class)
                            ->onlyOnForms()
                            ->setRequired(true);

        return [
            TextField::new('name'),
            EmailField::new('email'),
            BooleanField::new('is_verified'),
            $password_field
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager,
                                  $entityInstance): void
    {
        $entityInstance->setPassword(
            $this->hasher->hashPassword(
                $entityInstance,
                $entityInstance->getPlainPassword()
            )
        );

        parent::persistEntity($entityManager, $entityInstance);
    }
}
